<?php

$__files = array();

class files {
	function open($filename) {
		global $targetDir;
		$file = $targetDir . DIRECTORY_SEPARATOR . $filename;
		if ($GLOBALS['__files'][$file])
			return $GLOBALS['__files'][$file];
		
		$fp = fopen($file,"w");
		$GLOBALS['__files'][$file] = $fp;
		return $fp;
	}
	
	function openNode(&$node) {
		return files::open($node->tocNode->getFile());
	}
	
	function close($fp) {
		fclose($fp);
	}
}