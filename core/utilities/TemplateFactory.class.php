<?php

require_once(HARMONI."utilities/Template.class.php");

/**
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TemplateFactory.class.php,v 1.6 2006/01/17 20:06:22 adamfranco Exp $
 */
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
		$obj =& new Template($name.$this->_ext, $this->_paths);
		return $obj;
	}
	
	function catchTemplateOutput($name, $vars=array()) {
		$template =& $this->newTemplate($name);
		
		return $template->catchOutput($vars);
	}
}

?>