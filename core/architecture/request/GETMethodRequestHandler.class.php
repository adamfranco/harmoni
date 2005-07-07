<?php

/**
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GETMethodRequestHandler.class.php,v 1.6 2005/07/07 21:29:04 adamfranco Exp $
 */ 
 
require_once(HARMONI."architecture/request/RequestHandler.interface.php");
require_once(HARMONI."architecture/request/URLWriter.abstract.php");

/**
 * The job of a RequestHandler is twofold:
 * 
 * 1) handle incoming request data -- could be from $_REQUEST-type arrays, 
 * could be from session variables, etc.
 * 2) handle the production of URLs with given contextual data/query using an 
 * associated URLWriter class.
 *
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GETMethodRequestHandler.class.php,v 1.6 2005/07/07 21:29:04 adamfranco Exp $
 */

class GETMethodRequestHandler extends RequestHandler {
	
	/**
	 * Returns an associative array of key=value pairs corresponding to the request
	 * data from the browser. This could just be the data from $_REQUEST, in the
	 * simplest case.
	 *
	 * @return array
	 * @access public
	 */
	function getRequestVariables() {
		return $_REQUEST;
	}
	
	/**
	 * Returns a new {@link URLWriter} object corresponding to this RequestHandler.
	 *
	 * @return ref object URLWriter
	 * @access public
	 */
	function &createURLWriter() {
		return new GETMethodURLWriter();
	}
	
	/**
	 * Returns a dotted-pair string representing the module and action requested
	 * by the end user ("module.action" format).
	 * 
	 * @return string
	 * @access public
	 */
	function getRequestedModuleAction() {
		if (isset($_REQUEST["module"]))
			$mod = $_REQUEST["module"];
		else
			$mod = NULL;
		
		if (isset($_REQUEST["action"]))
			$act = $_REQUEST["action"];
		else
			$act = NULL;
		
		return $mod .".". $act;
	}
	
}


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
 * @version $Id: GETMethodRequestHandler.class.php,v 1.6 2005/07/07 21:29:04 adamfranco Exp $
 */

class GETMethodURLWriter 
	extends URLWriter 
{
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
		if (!defined("MYURL")) {
			throwError( new Error("GETMethodURLWriter requires that 'MYURL' is defined and set to the full URL of the main index PHP script of this Harmoni program!", "GETMethodRequestHandler", true));
		}
		
		$num = func_num_args();
		$args = func_get_args();
		
		if ($num > 1 && $num % 2 == 0) {
			for($i = 0; $i < $num; $i+=2) {
				$this->_vars[RequestContext::name($args[$i])] = $args[$i+1];
			}
		} else if ($num == 1 && is_array($args[0])) {
			$this->setValues($args[0]);
		}
		
		$url = MYURL;
		$pairs = array();
		if (defined("SID") && SID) $pairs[] = SID;
		$pairs[] = "module=".$this->_module;
		$pairs[] = "action=".$this->_action;
		foreach ($this->_vars as $key=>$val) {
			$pairs[] = $key . "=" . urlencode($val);
		}
		
		$url .= "?" . implode("&", $pairs);
		
		return $url;
	}
}

?>