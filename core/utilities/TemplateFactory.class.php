<?php

require_once(HARMONI."utilities/Template.class.php");

class TemplateFactory {
	var $_paths;
	var $_ext="";
	function TemplateFactory($searchPath1) {
		if (!func_num_args()) {
			throwError(new Error("TemplateFactory - you must specify at least one search path.","TemplateFactory",true));
		}
		foreach (func_get_args() as $arg) {
			$this->_paths[] = $arg;
		}
	}
	
	function setExtension($ext) {
		$this->_ext = "." . ereg_replace("^\.","",$ext);
	}
	
	function &newTemplate($name) {
		return new Template($name.$this->_ext, $this->_paths);
	}
}

?>