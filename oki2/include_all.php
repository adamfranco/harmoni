<?php

/**
 * This file will include all of the OSID class definitions in the org/osid/
 * subdirectory.
 * You may fine it more useful to include_once any given interface directly
 * from classes extending it.
 * 
 * @version $Id: include_all.php,v 1.1 2005/01/11 16:46:47 adamfranco Exp $
 * @date $Date: 2005/01/11 16:46:47 $
 * @copyright 2004 Middlebury College
 * @author Adam Franco <afranco AT middlebury DOT edu>
 */



$osidDir = realpath(dirname(__FILE__)."/org/osid");

includePHPFiles ($osidDir);

/**
 * Recursively include_once all php files in the target directory.
 * 
 * @param string $dir The target directory
 * @return void
 * @access public
 * @date 1/7/05
 */
function includePHPFiles ( $dir ) {
	if ($handle = opendir($dir)) {

		while (false !== ($fileName = readdir($handle))) {
			$file = realpath($dir."/".$fileName);
			
			// If the child is a directory, recuse into it
			if (is_dir($file) && $fileName != "." && $fileName != "..") {
				includePHPFiles($file);
			}
			
			// If it is a php file, include it.
			else if (ereg(".php$", $file)) {
				include_once($file);
			}
			
			// Otherwise, just ignore the file.
		}
		
		closedir($handle);
		
	} else {
		die ("Could not open $dir");
	}
}
?>