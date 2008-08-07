<?php

/**
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GETMethodRequestHandler.class.php,v 1.19 2008/01/28 18:30:05 adamfranco Exp $
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
 * @version $Id: GETMethodRequestHandler.class.php,v 1.19 2008/01/28 18:30:05 adamfranco Exp $
 */

class GETMethodRequestHandler 
	implements RequestHandler 
{
	
	/**
	 * Returns an associative array of key=value pairs corresponding to the request
	 * data from the browser. This could just be the data from $_REQUEST, in the
	 * simplest case.
	 *
	 * @return array
	 * @access public
	 */
	function getRequestVariables() {
		return array_merge($_GET, $_POST);
	}
	
	/**
	 * Returns an associative array of file upload data. This will usually come from
	 * the $_FILES superglobal.
	 * 
	 * @return array
	 * @access public
	 */
	function getFileVariables() {
		return $_FILES;
	}
	
	/**
	 * Returns a new {@link URLWriter} object corresponding to this RequestHandler.
	 *
	 * @return ref object URLWriter
	 * @access public
	 */
	function createURLWriter($base = null) {
		if (!is_null($base))
			return new GETMethodURLWriter($base);
		else
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
			$mod = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $_REQUEST["module"]);
		else
			$mod = NULL;
		
		if (isset($_REQUEST["action"]))
			$act = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $_REQUEST["action"]);
		else
			$act = NULL;
		
		return $mod .".". $act;
	}
	
	/**
	 * Given an input url written by the current handler, return a url-encoded
	 * string of parameters and values. Ampersands separating parameters should
	 * use the XML entity representation, '&amp;'.
	 * 
	 * For instance, the PathInfo handler would for the following input
	 *		http://www.example.edu/basedir/moduleName/actionName/parm1/value1/param2/value2
	 * would return
	 *		module=moduleName&amp;action=actionName&amp;param1=value1&amp;param2=value2
	 * 
	 * @param string $inputUrl
	 * @return mixed string URL-encoded parameter list or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 * @static
	 */
	public static function getParameterListFromUrl ($inputUrl) {
		$pattern = "/^".str_replace('/', '\/', $this->_base).'\?(.*)$/i';
		$replacement = '\1';
		if (!preg_match($pattern, $inputUrl))
			return FALSE;
		else
			return preg_replace($pattern, $replacement, $inputUrl);
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
 * @version $Id: GETMethodRequestHandler.class.php,v 1.19 2008/01/28 18:30:05 adamfranco Exp $
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
		
		$url = $this->_base;
		$pairs = array();
		$harmoni = Harmoni::instance();
		if (!$harmoni->config->get("sessionUseOnlyCookies") && defined("SID") && SID) 
			$pairs[] = strip_tags(SID);
		$pairs[] = "module=".$this->_module;
		$pairs[] = "action=".$this->_action;
		foreach ($this->_vars as $key=>$val) {
			if (is_object($val)) {
				throwError( new Error("Expecting string for key '$key', got '$val'.", "GETMethodRequestHandler", true));
			}
			
			// For multi-select form elements
			if (is_array($val)) {
				foreach ($val as $arrayVal)
					$pairs[] = $key . "=" . urlencode($arrayVal);
			} 
			// normal single-string values
			else {
				$pairs[] = $key . "=" . urlencode($val);
			}
		}
		
		$url .= "?" . implode("&amp;", $pairs);
		
		return $url;
	}
}

?>