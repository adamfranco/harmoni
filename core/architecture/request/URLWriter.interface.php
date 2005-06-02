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
 * @version $Id: URLWriter.interface.php,v 1.2 2005/06/02 18:07:41 gabeschine Exp $
 */

class URLWriter {

	/**
	 * Sets the module and action to request in this URL.
	 * @param string $module
	 * @param string $action
	 * @return void
	 * @access public
	 */
	function setModuleAction($module, $action) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","RequestHandler",true));
	}
	
//	function setContextData($data);
	
	/**
	 * Takes an associative array of name/value pairs and sets the internal data
	 * to those values. The method is used internally by the {@link RequestContext}
	 * only and should not be called otherwise.
	 * @param array $array
	 * @access public
	 * @return void
	 */
	function batchSetValues($array) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","RequestHandler",true));	
	}
	
	/**
	 * Takes an associative array of name/value pairs and sets the internal
	 * data to those values, replacing any values that already exist.
	 * @param array $array An associative array. Contacts the {@link RequestContext}
	 * to find the current context and sets the appropriate value.
	 * @return void
	 * @access public
	 */
	function setValues($array) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","RequestHandler",true));
	}
	
	/**
	 * Sets a single value in the internal data. Contacts the {@link RequestContext}
	 * to find the current context and sets the appropriate value.
	 * @param string $key
	 * @param string $value
	 * @return void
	 * @access public
	 */
	function setValue($key, $value) {
		throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in abstract class <b> ".__CLASS__."</b> has not been overloaded in a child class.","RequestHandler",true));
	}
	
	/** 
	 * The following function has many forms, and due to PHP's lack of
	 * method overloading they are all contained within the same class
	 * method. 
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