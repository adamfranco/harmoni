<?php

/**
 * The purpose of a URLWriter is to generate URLs from contextual data. This
 * data would be the current/target module and action, any contextual name=value
 * pairs specified by the code, and any additional query data.
 * 
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: URLWriter.abstract.php,v 1.4 2005/06/07 14:42:23 adamfranco Exp $
 */

class URLWriter {

	var $_module;
	var $_action;
	var $_vars;
	
	function URLWriter() {
		$this->_vars = array();
		$this->_module = "";
		$this->_action = "";
	}

	/**
	 * Sets the module and action to request in this URL.
	 * @param string $module
	 * @param string $action
	 * @return void
	 * @access public
	 */
	function setModuleAction($module, $action) {
		$this->_module = $module;
		$this->_action = $action;
	}	
	
	/**
	 * Takes an associative array of name/value pairs and sets the internal data
	 * to those values. The method is used internally by the {@link RequestContext}
	 * only and should not be called otherwise.
	 * @param array $array
	 * @access private
	 * @return void
	 */
	function batchSetValues($array) {
		foreach ($array as $key=>$val) {
			if (!in_array($key, array("module", "action")))
				$this->_vars[$key] = $val;
		}	
	}

	/**
	 * Takes an associative array of name/value pairs and sets the internal
	 * data to those values, replacing any values that already exist.
	 * @param array $array An associative array.
	 * @return void
	 * @access public
	 */
	function setValues($array) {
		foreach ($array as $key=>$val) {
			$this->setValue($key, $val);
		}
	}
	
	/**
	 * Sets a single value in the internal data.
	 * @param string $key
	 * @param string $value
	 * @return void
	 * @access public
	 */
	function setValue($key, $value) {
		$key = RequestContext::name($key);
		$this->_vars[$key] = $value;
	}
	
	/** 
	 * The following function has many forms, and due to PHP's lack of
	 * method overloading they are all contained within the same class
	 * method. Any keys/names for paremeters should be translated into
	 * their contextual equivalents by contacting the {@link RequestContext}
	 * object.
	 * 
	 * write()
	 * write(array $vars)
	 * write(string $key1, string $value1, [string $key2, string $value2, [...]])
	 * 
	 * @access public
	 * @return string The URL. 
	 */
	function write(/* variable-length argument list*/) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","RequestHandler",true));
	}
	
}

?>