#! /usr/bin/perl -s
# finds instances of invalid private variable referencing
# in PHP scripts located in the file provided.

# print  out help if requested.
if ( $h || $help ) {
	print "Usage:\n";
	print "\tshowPrivateReferences < -f | -d | -s > [ options ] [ file list ]\n";
	
	print "\nPaths:\n";
	print "\t< path > Can be a file or list of files\n";
	print "\tOR a directory (with -d specified),\n";
	print "\tOR a list of file names can be piped to the script with one filename per line (with -s specified).\n";
	
	print "\nOptions:\n";
	print "\t-d=< path >\tSearch all php files inside < path >.\n";
	print "\t-exclude_paths=\'< string > [ string... ]\'\n";
	print "\t\tUsed with -d to exclude	files with name or path matching the strings.\n";
	print "\t\t(Puts each string in a '! -path \"< string >\"' option in find.\n";
	
	print "\nExample:\n";
	print "\t./showPrivateReferences.pl -d=../../ -exclude_paths='*tests* *test*'\n";
	
	exit;
}

# input Files is for lists of file paths passed
my @inputFiles;

# Define a variable for the total count of bad references.
my $totalCount = 0;
my $fileCount = 0;
my $lastFileName = "";
my $resetCount = 0;
my $countToPrint = 0;


# if we want to specify a file list.
if ( $f ) {
	# Do nothing.

# If the input path is a directory, get all PHP files within it.
} elsif ( $d ) {
	#build our exclude options
	my $excludeString = "";
	if ($exclude_paths) {
		my @paths = split(" ", $exclude_paths);
		foreach $path (@paths) {
			$excludeString .= "! -ipath \"".$path."\" ";
		}
	}
	
	#print "find $d -iname \"*.php\" $excludeString";
	
	@inputFiles = `find $d -iname "*.php" $excludeString`;
	chomp(@inputFiles);

# if we have specified -s (or not -f or -d), then take from the standard input
} else {
	@inputFiles = <STDIN>;
	chomp(@inputFiles);
}

if($#inputFiles > 0) {
	print "Going through stdin input files.\n";
	# Go through each of the Standard input files list.
	while ($i <= $#inputFiles) {
		$fileCount = 0;
		$filePath = $inputFiles[$i];
		
		open (FH, "<$filePath") or die "Can't open $filePath: $!";
		
		my $linenum = 1;
		while ($line = <FH>) {
			if ($line =~ m/(?<!this)->_/) {
				print $filePath . ": " . $linenum .": " . $line;
				
				$totalCount++;
				$fileCount++;
			}
			$linenum++;
		}
		
		close (FH);
		
		if ($fileCount) {
			# print out the count of bad references in this file
			print "References to Private Variables: $fileCount\n\n";
		}
		
		$i++;
	}
 
} else {	
	print "Going through file list.\n";
	# foreach file, print the filename and line number where there are bad
	# references.
	
	while (<>) {
		# reset the counter if we have a new file.
		if (not $ARGV =~ /$lastFileName/) {
			$resetCount = 1;
			$countToPrint = $fileCount;
			$fileCount = 0;
		}
		$lastFileName = $ARGV;
		
		# $ARGV is the filename
		# $_ is the line
		# $. is the line number
		if ($_ =~ m/(?<!this)->_/) {
			print $ARGV . ": " . $. .": " . $_;
			
			$totalCount++;
			$fileCount++;
		}
		
		if ($resetCount && $countToPrint) {
			# print out the count of bad references in this file
			print "References to Private Variables: $countToPrint\n\n";
			$countToPrint = 0;
			$resetCount = 0;
		}
	}
	
	if ($fileCount) {
		# print out the count of bad references in this last file
		print "References to Private Variables: $fileCount\n\n";
	}
	
}

print "Total References to Private Variables: $totalCount\n";