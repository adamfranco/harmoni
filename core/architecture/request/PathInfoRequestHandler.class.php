<?php
/**
 * @since 1/8/07
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PathInfoRequestHandler.class.php,v 1.9 2008/03/06 14:23:31 adamfranco Exp $
 */ 

require_once(HARMONI."architecture/request/RequestHandler.interface.php");
require_once(HARMONI."architecture/request/URLWriter.abstract.php");

/**
 * <##>
 * 
 * @since 1/8/07
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PathInfoRequestHandler.class.php,v 1.9 2008/03/06 14:23:31 adamfranco Exp $
 */
class PathInfoRequestHandler
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
		$this->_loadRequest();
		return $this->_request;
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
			return new PathInfoURLWriter($base);
		else
			return new PathInfoURLWriter();
	}
	
	/**
	 * Returns a dotted-pair string representing the module and action requested
	 * by the end user ("module.action" format).
	 * 
	 * @return string
	 * @access public
	 */
	function getRequestedModuleAction() {
		$this->_loadRequest();
		if (isset($this->_request["module"]))
			$mod = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $this->_request["module"]);
		else
			$mod = NULL;
		
		if (isset($this->_request["action"]))
			$act = preg_replace('/[^a-zA-Z0-9_\-]/i', '', $this->_request["action"]);
		else
			$act = NULL;
		
		return $mod .".". $act;
	}
	
	/**
	 * build an array of all request parameters including those from the path info
	 * 
	 * @return void
	 * @access public
	 * @since 1/8/07
	 */
	function _loadRequest () {
		if (!isset($this->_request)) {
			// Add on other vars that may be pass in get or post
			$this->_request = $_REQUEST;
			
			
			if (isset($_SERVER['PATH_INFO'])) {
				$pathInfo = trim($_SERVER['PATH_INFO'], "/");
				if ($pathInfo) {
					$pathInfoParts = explode('/', $pathInfo);
// 					printpre($pathInfoParts);
// 					exit;
					
					// Set the module and Action to the first two pathinfo parts
					$this->_request['module'] = $pathInfoParts[0];
					if (isset($pathInfoParts[1]))
						$this->_request['action'] = $pathInfoParts[1];
					else
						$this->_request['action'] = null;
					
					// Add the rest of the path as name => value pairs
					for ($i = 2; $i < count ($pathInfoParts); $i = $i + 2) {
						$key = $pathInfoParts[$i];
						if (isset($pathInfoParts[$i+1])) {
							$val = $pathInfoParts[$i+1];
							$val = str_replace('_slash_', '/', $val);
							$val = str_replace('_quest_', '?', $val);
						} else
							$val = null;
						
						// Normal case (and multiple copies of the same value)
						if (!isset($this->_request[$key]) || $val === $this->_request[$key])
							$this->_request[$key] = $val;
						
						// Second value (i.e. from a multi-select form)
						else if (!is_array($this->_request[$key])) {
							$tmp = $this->_request[$key];
							$this->_request[$key] = array();
							$this->_request[$key][] = $tmp;
							$this->_request[$key][] = $val;
						}
						// Third or later value for the key
						else {
							$this->_request[$key][] = $val;
						}
					}
				}
			}
		}
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
	 * @param optional string $base Defaults to MYURL
	 * @return mixed string URL-encoded parameter list or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 * @static
	 */
	public static function getParameterListFromUrl ($inputUrl, $base = null) {
		if (is_null($base))
			$base = MYURL;
		
		$pattern = "/^".str_replace('/', '\/', $base).'([^?]*)\??(.*)$/i';
		if (!preg_match($pattern, $inputUrl, $matches))
			return FALSE;
		else {
			$pathInfo = trim($matches[1], "/");
			$pathInfoParts = explode('/', $pathInfo);
			
			$params = array();
			if (isset($pathInfoParts[0]))
				$params[] = 'module='.$pathInfoParts[0];
			if (isset($pathInfoParts[1]))
				$params[] = 'action='.$pathInfoParts[1];
					
			// Add the rest of the path as name => value pairs
			for ($i = 2; $i < count ($pathInfoParts); $i = $i + 2) {
				$params[] = $pathInfoParts[$i].'='.$pathInfoParts[$i+1];
			}
			
			// If there is also a get component to the request add that on.
			if ($matches[2]) {
				$getParams = explode("&amp;", $matches[2]);
				if (!$getParams[0])
					array_shift($getParms);
				$params = array_merge($params, $getParams);
			}
			
			return implode("&amp;", $params);
		}
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
 * @version $Id: PathInfoRequestHandler.class.php,v 1.9 2008/03/06 14:23:31 adamfranco Exp $
 */

class PathInfoURLWriter 
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
			throwError( new Error("PathInfoURLWriter requires that 'MYURL' is defined and set to the full URL of the main index PHP script of this Harmoni program!", "PathInfoURLWriter", true));
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
		$pairs[] = $this->_module;
		$pairs[] = $this->_action;
		foreach ($this->_vars as $key=>$val) {
			if (is_object($val)) {
				throw new InvalidArgumentException("Expecting string for key '$key', got '$val' of class ".get_class($val).".");
			}
			
			// For multi-select form elements
			if (is_array($val)) {
				foreach ($val as $arrayVal)
					$arrayVal = rawurlencode($arrayVal);
					$arrayVal = str_replace('%2F', '_slash_', $arrayVal);
					$arrayVal = str_replace('%3F', '_quest_', $arrayVal);
					
					$pairs[] = $key . "/" . $arrayVal;
			} 
			// normal single-string values
			else {
				$val = rawurlencode($val);
				$val = str_replace('%2F', '_slash_', $val);
				$val = str_replace('%3F', '_quest_', $val);
				
				$pairs[] = $key . "/" . $val;
			}
		}
		
		$url .= "/" . implode("/", $pairs);
		
		return $url;
	}
}

?>