#!/usr/local/bin/php
<?php

/*
	manualproc.php
		Process XML formatted manuals/user guides. See DTDs in ../dtds
		
	Copyright 2003, Gabe Schine
	gabeschine@sourceforge.net
*/

if (!function_exists("domxml_open_file")) {
	print <<<END_ERROR

	+-------------------------------------------+
	|             ! ERROR !                     |
	| DOM XML extension does not seem to be     |
	| installed in PHP. Did you compile with    |
	| --with-dom?                               |
	+-------------------------------------------+
	
END_ERROR;
}

define("MYDIR", dirname(__FILE__));
include("../../../harmoni.inc.php");
include(MYDIR."/core/functions.inc.php");

$myProg = shift($argv);
$cfg =& new FieldSet;
if ($argc > 1) {
	while ($arg = shift($argv)) {
		switch ($arg) {
			case "--source":
				$cfg->set("source",shift($argv));
				break;
			case "--target":
				$cfg->set("target",shift($argv));
				break;
		}
	}
} else doUsage();

if (!$cfg->get("source") || !$cfg->get("target")) {
	doUsage("Either the source or the target weren't specified.");
}

/* :: make sure that source is a file and target is a dir :: */
if (!file_exists($cfg->get("source")) || !is_file($cfg->get("source"))) {
	doError("The specified source does not seem to be a file.");
}

if (!file_exists($cfg->get("target")) || !is_dir($cfg->get("target"))) {
	doError("The specified target is not a directory.");
}

$sourceFile = $cfg->get("source");
$targetDir = $cfg->get("target");

$templates =& new TemplateFactory(MYDIR."/core/templates");
$templates->setExtension("tpl");

// try to read the source file
$dom = @domxml_open_file($sourceFile);
if (!$dom) doError("Could not open '$sourceFile' or it is not a valid XML document.");

$dir = @opendir($targetDir);
while ($f = @readdir($dir)) {
	if (!ereg("(\.){1,2}",$f)) {
		fputs(STDOUT,"\nThe target directory does not seem to be empty.\n\n");
		fputs(STDOUT,"Do you want me to empty it? (yes/no) [no] ");
		fflush(STDOUT);
		$answer = fgets(STDIN, 10);
		if (ereg("^yes",$answer)) {
			emptyDir($targetDir);
		} else
			doError("Target directory not empty. Can't continue.");
	}
}
unset($dir,$f,$answer);

if (!@touch($targetDir.DIRECTORY_SEPARATOR."manual_created_stamp"))
	doUsage("I do not seem to have write access to target directory.");

/*:: set up the handler classes ::*/
$handlerClasses = array(
	"section"		=>		"Section",
	"chapterfile"	=>		"ChapterFile",
	"subchapterfile"=>		"SubChapterFile",
	"chapter"		=>		"Chapter",
	"p"				=>		"TextBlock",
	"termdef"		=>		"Term",
	"example"		=>		"Example",
	"block"			=>		"FormattedTextBlock",
	"subchapter"	=>		"SubChapter",
	"note"			=>		"Note",
	"heading"		=>		"Heading",
	"#text"			=>		"InlineText",
	"#comment"		=>		"NullMe"
	);

/* :: include all the class files :: */

include(MYDIR."/core/handlers.inc.php");

$root = $dom->get_root();
if ($root->name() != "manual")
	doError("The supplied XML file is not a 'manual' file: found '".$root->name()."'");
	
$children = $root->children();

if (!count($children)) doError("Empty manual.");

$rootNode =& new RootDisplayNode($dom, $root, $sourceFile);
$rootNode->process();

$toc = $rootNode->tocNode;
print "\n\nTOC:\n";
$toc->txtTOC();

/*$node =& $toc;
while ($node) {
	print $node->toString() . "\n";
	$node =& $node->nextPageChange();
}*/

$rootNode->output();
