<?php

/* :: functions for use by manualproc.php :: */

function doUsage($msg = null) {
	global $myProg;
	print "Usage: $myProg --source <source.xml> --target <target dir>\n\n";
	if ($msg) print $msg . "\n";
	exit(1);
}

/**
 * @return void
 * @param $msg string
 * @desc Throw an error.
 */
function doError($msg) {
	print "\nERROR: $msg\n\n";
	exit(1);
}

/**
 * @return array
 * @param $array unknown
 * @desc alias to array_shift
 */
function shift(&$array) {
	return array_shift($array);
}

function mkFile(&$node, $relPath) {
	$base = dirname($node->filePath);
	return $base . DIRECTORY_SEPARATOR . $relPath;
}

function emptyDir($dir) {
	$d =@opendir($dir);
	if (!$d) doError("Can't open '$dir' for reading.");
	while ($f = @readdir($d)) {
		if (!ereg("\.{1,2}",$f) && $f != "CVS") {
			if (is_file($dir.DIRECTORY_SEPARATOR.$f)) {
				unlink($dir.DIRECTORY_SEPARATOR.$f);
				continue;
			}
			if (is_dir($dir.DIRECTORY_SEPARATOR.$f)) {
				emptyDir($dir.DIRECTORY_SEPARATOR.$f);
				continue;
			}
			doError("Don't know what to do with '$f'.");
		}
	}
}
