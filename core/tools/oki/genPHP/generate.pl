#!/usr/bin/perl

# :: this file uses OKI token files for input :: #

%seenTokens = %declaredMethods = %declaredClasses = %globalConstants = ();

if ($ARGV[0]) {
	open(FILE,"<".$ARGV[0]);
} else {
	print STDERR "Usage: perl generate.pl <filename> [global package]\n\n";
	exit(1);
}

$packageForced=0;

if ($ARGV[1] && !$packageForced) { $globalPackage = $ARGV[1]; }
else {
	$globalPackage = "osid";
}

print STDERR "\n\nStarting new generate session for '".$ARGV[0]."'.\n";
print "<?php\n\n";

# :: start going through and look for a BEGIN token :: #

$allContent = "";
$inBlock = 0;
$inComment = 0;
$totalBlocks = 0;
while(<FILE>) {
	$allContent .= $_;
	# :: set the global package
	/\[java\] 870 ALWAYS_PACKAGE \d (\w+(\.\w+)*)/ && do { 
		print STDERR "Using global package: $1\n"; 
		$globalPackage = $1; $packageForced = 1;
		$seenTokens{"ALWAYS_PACKAGE"}++;
	};
	
	# :: begin a block
	/\[java\] 822 BEGIN \d null/ && do { 
		$inBlock = 1; $totalBlocks++; &doBegin; $inBlock = 0;
		$seenTokens{"BEGIN"}++;
	};
}

print "?>\n";

print STDERR "Seen tokens=num:\n";
foreach (sort keys %seenTokens) {
	print STDERR "\t";print STDERR ;print STDERR "=";print STDERR $seenTokens{$_};print STDERR "\n";
} print STDERR "\n";

print STDERR "Declared methods=num:\n";
foreach (sort keys %declaredMethods) {
	print STDERR "\t";print STDERR;print STDERR "=";print STDERR $declaredMethods{$_};print STDERR "\n";
} print STDERR "\n";

	
print STDERR "Finishing run. Processed $totalBlocks blocks.\n\n";

# :: sub doBegin :: handles a block BEGIN..END
sub doBegin {
	my(@extendsList, $className, @declarations);
	my($package) = $globalPackage;
	my($classDeclaration) = 0;
	my($postDefinitionText) = "";
	
	# :: begin the loop
	
	while (<FILE>) {
		trim; chomp;
		s/\r//g;
		s/\n//g;
		
		/\[java\] (\d\d\d) (\w+)/ && do { $seenTokens{$2}++; };
		
		# :: handle END
		/\[java\] 823 END/ && do { 
			print "}\n\n"; 
			if ($postDefinitionText) {
				print "// :: post-declaration code ::\n";
				print $postDefinitionText;
			}
			last; 
		};
		
		# :: handle COMMENT
		/\[java\] 840 COMMENT \d (.+)$/ && do {
			if ($classDeclaration == 1) { $classDeclaration = 2; print "{\n"; }
			
			my ($line) = $1;
			if ($line =~ /\/\*\*/) { $inComment = 1; print "\n"; }
			if ($line =~ /\*\//) { $inComment = 0; print "\t * \@package $package\n"; }
			if ($line =~ /^\*/) { $line = " " . $line; }
			if ($line =~ /^\s*[\w\@]/) { $line = " * " . $line; }
			$line =~ s/\{\@link ((\w+)\.)*(\w+)/\{\@link $3/g; # :: fix {@link}
			print "\t" . $line . "\n";
		};
		
		# :: METHOD
		/\[java\] 220 METHOD 1 ((\w* )*([\w.]+) (\w+)(\(([^()]*)\))?)/ && do {
			if ($classDeclaration == 1) { $classDeclaration = 2; print "{\n"; }
			
			my($wholeString, $returnType, $methodName, $fullParams, $parameters) = ($1, $3, $4, $5, $6);
			my($fullMethodName) = $className . "::" . $methodName;
			my($hidden) = 0;
			my($lookForParams) = ($fullParams)?0:1;
			if ($declaredMethods{$fullMethodName}++) { $hidden = 1; }
			
			&doMethod($methodName, $returnType, $parameters, $lookForParams, $hidden);
			print "\t// :: full java declaration :: $wholeString\n";
		};
		
		# :: GET
		/\[java\] 230 GET 1 (\S+) (\S+)/ && do {
			my($type, $name) = ($1,$2);
			my($fullMethodName) = $className . "::get" . $name;
			my($hidden) = 0;
			if ($declaredMethods{$fullMethodName}++) { $hidden = 1; }
			&doMethod("get$name", $type, "",0,$hidden);
		};

		# :: UPDATE
		/\[java\] 234 UPDATE 1 (\S+) (\S+)/ && do {
			my($type, $name) = ($1,$2);
			my($fullMethodName) = $className . "::update" . $name;
			my($hidden) = 0;
			if ($declaredMethods{$fullMethodName}++) { $hidden = 1; }
			&doMethod("update$name", "void", "$type $name",0,$hidden);
		};

		# :: GETUPDATE
		/\[java\] 233 GET 1 (\S+) (\S+)/ && do {
			my($type, $name) = ($1,$2);
			my($fullMethodName) = $className . "::get" . $name;
			my($fullMethodName2) = $className . "::update" . $name;
			my($hidden) = 0;
			if ($declaredMethods{$fullMethodName}++) { $hidden = 1; }
			&doMethod("get$name", $type, "",0,$hidden);
			my($hidden) = 0;
			if ($declaredMethods{$fullMethodName2}++) { $hidden = 1; }
			&doMethod("update$name", void, "$type $name",0,$hidden);
		};

		# :: API_INTERFACE
		/\[java\] 111 API_INTERFACE 1 (\w+)/ && do {
			$className = $1;
			print "class $className // :: API interface\n";
			$classDeclaration = 1;
		};
		
		
		# :: INTERFACE
		/\[java\] 110 INTERFACE 1 (\w+)/ && do {
			$className = $1;
			print "class $className // :: interface\n";
			$classDeclaration = 1;
		};
		
		# :: ABSTRACT_CLASS
		/\[java\] 101 ABSTRACT_CLASS 1 (\w+)/ && do {
			$className = $1;
			print "class $className // :: abstract\n";
			$classDeclaration = 1;
		};

		# :: CLASS
		/\[java\] 100 CLASS 1 (\w+)/ && do {
			$className = $1;
			print "class $className // :: normal class\n";
			$classDeclaration = 1;
		};
		
		# :: EXTENDS
		/\[java\] 120 EXTENDS 1 (\S+)/ && do {
			my($modifiedExtends) = my($extends) = $extendsList[++$#extendsList] = $1;
			if ($#extendsList > 1) { print "//"; }
			elsif ($extends =~ /^java\./) { print "//"; }
			elsif ($extends =~ /\.?(\w+)$/) { $modifiedExtends = $1; }
			
			print "\textends $modifiedExtends\n";
		};
		
		# :: IMPLEMENTS
		/\[java\] 121 IMPLEMENTS 1 (\S+)/ && do {
			my($extends) = $1;
			
			print "//\timplements $extends\n";
		};
		
		# :: DECLARE
		/\[java\] 150 DECLARE 1 ((\w* )*([\w.]+) (\w+)(\s+=\s+(\S.*))?)$/ && do {
			if ($classDeclaration == 1) { $classDeclaration = 2; print "{\n"; }
			
			my($fullDeclare, $junk, $type, $name, $value) = ($1,$2,$3,$4,$6);
			my($isObject) = 0;
			# print STDERR "new declare: '$type'\n";
			if (!&knownType($type)) { $isObject = 1; }
			if ($junk =~ /static|final/) {
				# :: if we're static or final, create a "define()"
				if ($value =~ /^\s*java\./) {
					print STDERR "DEFINE: ignoring '$name'. Strange value: $value\n";
					next;
				}
				my ($string) = "/**\n * \@const ";
				if ($isObject) { $string .= "object"; }
				else { $string .= lc $type; }
				$string .= " $name $fullDeclare\n";
				$string .= " * \@package $package\n";
				$string .= " */\n";
				
				print "\t// :: defined globally :: define(\"$name\",$value);\n";
				$string .= "define(\"$name\", $value);\n";
				$string .= "\n";
				
				$postDefinitionText .= $string;
			} else {
				# :: otherwise, make a normal variable
				print "\t/**\n\t * \@var ";
				if ($isObject) { print "object"; }
				else { print lc $type; }
				print " \$$name $fullDeclare";
				print "\n\t */\n";
				print "\tvar \$$name;\n";
			}
			next;
		};

	}
}


# :: sub doMethod :: handles METHOD tokens, and optional METHOD_ARG tokens
sub doMethod {
	my($name, $return, $params, $noParams, $hidden) = @_;
	
	my(@argNames) = my(@argTypes) = ();
	my($numArgs) = 0;
	if ($noParams) { # :: we need to look for METHOD_ARG doobies
		while(<FILE>) {
			trim; chomp;
			/\[java\] 221 METHOD_ARG 1 (\S+) (\S+)/ || last; # anything but a method_arg means no more args
			$argNames[$numArgs] = $2;
			$argTypes[$numArgs++] = $1;
		}
	} else {
		# :: split up the $params list
		my(@list) = split(/,/,$params);
		foreach(@list) {
			chomp;trim;
			/(\S+) (\S+)/ && do {
				$argNames[$numArgs] = $2;
				$argTypes[$numArgs++] = $1;
			};
		}
	}
	
	
	# :: print out some stuff... y'know.
	my($returnKnown) = &knownType($return);
	
	my(@params) = ();
	for ($i = 0; $i<$numArgs; $i++) {
		my($known) = &knownType($argTypes[$i]);
		my($temp) = "\$" . $argNames[$i];
		if (!$known) { $temp = "& ".$temp; }
		$params[++$#params] = $temp;
	}
	
	my($temp) = $name;
	if (!$returnKnown) { $temp = "& ". $temp; }
	
	if ($hidden) { print "//\t :: this function hidden due to previous declaration\n//"; }
	print "\tfunction $temp(".join(", ",@params).") { /* :: interface :: */ }\n";
	if ($hidden) { print "//\t :: end\n"; }
	
	# :: end
}
		



sub knownType {
	$type = $_[0];
	# all other types will get & prepended so they are passed-by-reference
	@knownTypes = ("String","int","float","double","long","short","boolean","char","void");
#	print STDERR "trying '$type'\n";
	foreach $check (@knownTypes) {
		#print "$check ... ";
		if ($type eq $check) { return 1; }
		#print "nope; ";
	}
	#print "\n";
	return 0;
}










