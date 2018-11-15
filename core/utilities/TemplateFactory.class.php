<?php

require_once(HARMONI."utilities/Template.class.php");

/**
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TemplateFactory.class.php,v 1.7 2007/09/04 20:25:54 adamfranco Exp $
 */
class TemplateFactory {
	var $_paths;
	var $_ext="";
	function TemplateFactory($searchPath1) {
		if (!func_num_args()) {
			throwError(new HarmoniError("TemplateFactory - you must specify at least one search path.","TemplateFactory",true));
		}
		foreach (func_get_args() as $arg) {
			$this->_paths[] = $arg;
		}
	}
	
	function setExtension($ext) {
		$this->_ext = "." . preg_replace("/^\./","",$ext);
	}
	
	function newTemplate($name) {
		$obj = new Template($name.$this->_ext, $this->_paths);
		return $obj;
	}
	
	function catchTemplateOutput($name, $vars=array()) {
		$template =$this->newTemplate($name);
		
		return $template->catchOutput($vars);
	}
}

?>