<?php
/**
 * @since 1/8/07
 * @package harmoni.architecture.request
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PathInfoRequestHandler.class.php,v 1.1 2007/01/08 21:04:34 adamfranco Exp $
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
 * @version $Id: PathInfoRequestHandler.class.php,v 1.1 2007/01/08 21:04:34 adamfranco Exp $
 */
class PathInfoRequestHandler
	extends RequestHandler
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
	function &createURLWriter() {
		$writer =& new PathInfoURLWriter();
		return $writer;
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
					$this->_request['action'] = $pathInfoParts[1];
					
					// Add the rest of the path as name => value pairs
					for ($i = 2; $i < count ($pathInfoParts); $i = $i + 2) {
						$this->_request[$pathInfoParts[$i]] = $pathInfoParts[$i+1];
					}
				}
			}
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
 * @version $Id: PathInfoRequestHandler.class.php,v 1.1 2007/01/08 21:04:34 adamfranco Exp $
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
		
		$url = MYURL;
		$pairs = array();
		$harmoni =& Harmoni::instance();
		if (!$harmoni->config->get("sessionUseOnlyCookies") && defined("SID") && SID) 
			$pairs[] = strip_tags(SID);
		$pairs[] = $this->_module;
		$pairs[] = $this->_action;
		foreach ($this->_vars as $key=>$val) {
			if (is_object($val)) {
				throwError( new Error("Expecting string for key '$key', got '$val'.", "GETMethodRequestHandler", true));
			}
			$pairs[] = $key . "/" . urlencode($val);
		}
		
		$url .= "/" . implode("/", $pairs);
		
		return $url;
	}
}

?>