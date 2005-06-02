<?php

/**
 * This class is responsible for maintaining contextual and request data to be accessed
 * by the program. It is also responsible for the creation of new URLs (see {@link URLWriter}),
 * and keeping all contextual/request variables within the namespace (or scope) of the
 * program that uses them. 
 *
 * @package harmoni.architecture.request
 * @abstract
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RequestContext.class.php,v 1.7 2005/06/02 20:10:36 gabeschine Exp $
 */

define("REQUEST_HANDLER_CONTEXT_DELIMETER", "!");

class RequestContext {
	/**
	 * @access private
	 * @var array $_namespaces
	 */
	var $_namespaces;
	/**
	 * @access private
	 * @var string $_currentNamespace
	 */
	var $_currentNamespace;
	/**
	 * @access private
	 * @var array $_contextData
	 */
	var $_contextData;
	/**
	 * @access private
	 * @var array $_requestData
	 */
	var $_requestData;
	/**
	 * @access private
	 * @var object RequestHandler $_requestHandler
	 */
	var $_requestHandler;
	
	/**
	 * Constructor.
	 * @access public
	 */
	function RequestContext() {
		$this->_namespaces = array(); // normal
		$this->_contextData = array(); // associative
		$this->_requestData = array(); // associative
		$this->_currentNamespace = null;
	}
	
	/**
	 * Assigns a {@link RequestHandler} to this RequestContext object. The RequestHandler
	 * provides the bridge between the browser and the data driving requests.
	 * @param ref object RequestHandler $handler
	 * @return void
	 * @access public
	 */
	function assignRequestHandler(&$handler) {
		$this->_requestHandler =& $handler;
	}
	
	/**
	 * Tells the {@link RequestHandler} to retrieve any request variables from
	 * the browser and updates the internal context and request data to match.
	 * @return void
	 * @access public
	 */
	function update() {
		// get from the RequestHandler any new request variables, etc
		// ... update any "persistent" values we may have
		$this->_checkForHandler();
		
		$newValues = $this->_requestHandler->getRequestVariables();
		foreach ($newValues as $key=>$value) {
			if (isset($this->_contextData[$key])) {
				$this->_contextData[$key] = $value;
			} else {
				$this->_requestData[$key] = $value;
			}
		}
	}
	
	/**
	 * Returns a string ("module.action" format) of the requested module and
	 * action. 
	 * @return string
	 * @access public
	 */
	function getRequestedModuleAction() {
		$this->_checkForHandler();
		return $this->_requestHandler->getRequestedModuleAction();
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action.
	 * @param optional string $module
	 * @param optional string $action
	 * @return ref object URLWriter
	 * @access public
	 */
	function &mkURL($module = null, $action = null) {
		// create a new URLWriter from the RequestHandler
		$this->_checkForHandler();
		$url =& $this->_requestHandler->createURLWriter();
		if ($module != null && $action != null) {
			$url->setModuleAction($module, $action);
		} else {
			$harmoni =& Harmoni::instance();
			list($module, $action) = explode(".",$harmoni->getCurrentAction());
			if (!$module) list($module, $action) = explode(".",$this->getRequestedModuleAction());

			$url->setModuleAction($module, $action);
		}
		
		$url->batchSetValues($this->_contextData);
		
		return $url;
	}
	
	/**
	 * Quickly generates a URL string from the optional passed module/action and the
	 * optional array of values to replace in the URL request data. The function can
	 * take any of the following forms:
	 * 
	 * quickURL(string $module, string $action)
	 * quickURL(string $module, string $action, array $variables)
	 * quickURL(array $variables)
	 * quickURL()
	 *
	 * if the module/action are omitted, the last requested module/action is used.
	 * @return string
	 * @access public
	 */
	function quickURL(/* variable-length argument list */) {
		$num = func_num_args();
		$args = func_get_args();
		$url =& $this->mkURL();
		if ($num == 2) {
			$url->setModuleAction($args[0], $args[1]);
		}
		
		if ($num == 3 && is_array($args[2])) {
			$url->setModuleAction($args[0], $args[1]);
			$url->setValues($args[2]);
		}
		
		if ($num == 1 && is_array($args[0])) {
			$url->setValues($args[0]);
		}
		
		if ($num == 0) { /* do nothing */ }
		
		return $url->write();
	}
	
	/**
	 * Returns the full contextual name of a field or variable. If passed "test",
	 * it may return something like "context1.context2.test". This function is useful
	 * when creating HTML forms. 
	 * @param string $name
	 * @return string
	 * @access public
	 */
	function getName($name) {
		return $this->_mkFullName($name);
	}
	
	/**
	 * Starts a new namespace below the current namespace. This allows for the
	 * separation of context/request variables. Namespaces can be embedded, so
	 * it is important to call {@link RequestContext::endNamespace()}.
	 * @param string $name The name of the new namespace.
	 * @return void
	 * @access public
	 */
	function startNamespace($name) {
		$this->_checkName($name);
		if ($this->_currentNamespace) $this->_namespaces[] = $this->_currentNamespace;
		$this->_currentNamespace = $name;
	}
	
	/**
	 * Ends a namespace started previously. The last-started namespace is ended.
	 * @return string The name of the namespace just ended.
	 * @access public
	 */
	function endNamespace() {
		if ($this->_currentNamespace == null) return;
		$curr = $this->_currentNamespace;
		$n = count($this->_namespaces);
		if ($n == 0) { 
			$this->_currentNamespace = null;
			return $curr;
		}
		
		$this->_currentNamespace = array_pop($this->_namespaces);
		
		return $curr;
	}
	
	/**
	 * Sets $key to $value in the context-data (this data is included automatically
	 * when building new URLs). If you pass a name like "context1/context2/name",
	 * the RequestContext uses it as a context-insensitive name (ie, you are specifying
	 * the absolute namespace). 
	 * @param string $key
	 * @param string $value
	 * @return void
	 * @access public
	 */
	function set($key, $value) {
		$this->_checkName($key);
		$nKey = $this->_mkFullName($key);
		$this->_contextData[$nKey] = $value;
	}
	
	/**
	 * Ensures that $key is removed from the context-data (and not included in URLs
	 * generated later). If you pass a name like "context1/context2/name",
	 * the RequestContext uses it as a context-insensitive name (ie, you are specifying
	 * the absolute namespace). 
	 * @param string $key the key to forget.
	 * @return void
	 * @access public
	 */
	function forget($key) {
		// makes sure that the key is not present in the saved context any more
		$nKey = $this->_mkFullName($key);
		unset($this->_contextData[$nKey]);
	}
	
	/**
	 * Copies the value(s) of keys passed from the request-data to the context
	 * data. This is useful when request variables will be re-used later as contextual
	 * variables. If you pass a name like "context1/context2/name",
	 * the RequestContext uses it as a context-insensitive name (ie, you are specifying
	 * the absolute namespace). If no parameters are passed, all variables in the
	 * current namespaced are passed through.
	 * @param optional string $key1,...
	 * @return void
	 * @access public
	 */
	function passthrough(/* variable-length argument list */) {
		// copy the request data for each key passed into the context data
		// (ensures its transfer in the next URL request)
		if (func_num_args() == 0) $args = $this->getKeys();
		else $args = func_get_args();
		foreach ($args as $arg) {
			$this->_checkName($arg);
			$nKey = $this->_mkFullName($arg);
			if (isset($this->_requestData[$nKey])) $this->_contextData[$nKey] = $this->_requestData[$nKey];
		}
	}
	
	/**
	 * Returns the string-value of the $key passsed. It will first check for request
	 * data under that name, then context data. The key passed will be located
	 * within the current namespace. If you pass a name like "context1/context2/name",
	 * the RequestContext uses it as a context-insensitive name (ie, you are specifying
	 * the absolute namespace). 
	 * @return string
	 * @param string $key
	 * @access public
	 */
	function get($key) {
		// first check if we have a request variable appropriately named,
		// then check our context data, lastly return NULL
		$nKey = $this->_mkFullName($key);
		if (isset($this->_requestData[$nKey])) return $this->_requestData[$nKey];
		if (isset($this->_contextData[$nKey])) return $this->_contextData[$nKey];
		return null;
	}
	
	/**
	 * Returns a list of keys within the current context.
	 * @return array
	 * @access public
	 */
	function getKeys() {
		$pre = $this->_currentNamespace;
		$array = array();
		$keys = array_unique(array_merge(array_keys($this->_requestData), array_keys($this->_contextData)));
		foreach ($keys as $key) {
			if (ereg("^$pre\\".REQUEST_HANDLER_CONTEXT_DELIMETER."([^".REQUEST_HANDLER_CONTEXT_DELIMETER."]+)", $key, $r)) {
				$array[] = $r[1];
			}
		}
		
		return $array;
	}
	
	/**
	 * @access private
	 * @return void
	 */
	function _checkForHandler() {
		if (!isset($this->_requestHandler)) {
			throwError( new Error("RequestContext requires a RequestHandler for proper functionality! Please set one by calling RequestContext::assignRequestHandler()", "RequestContext", true));
		}
	}
			
	/**
	 * @access private
	 * @return string
	 */
	function _mkFullName($key) {
		$pre = $this->_currentNamespace==null?"":$this->_currentNamespace.REQUEST_HANDLER_CONTEXT_DELIMETER;
		return $pre.$key;
	}
	
	/**
	 * @access private
	 * @return void
	 */
	function _checkName($name) {
		if (ereg("\\".REQUEST_HANDLER_CONTEXT_DELIMETER, $name)) {
			throwError( new Error("Namespaces and field names cannot contain \"".REQUEST_HANDLER_CONTEXT_DELIMETER."\"s!", "RequestHandler", true));
		}
	}
}

/**
 * A quick shortcut function to get the expanded contextual name for a form
 * field or request variable. Calls {@link RequestContext::getName()} with the
 * passed $name.
 * @package harmoni.architecture.request
 * @access public
 */
function _n($name) {
	$harmoni =& Harmoni::instance();
	return $harmoni->request->getName($name);
}

/**
 * A quick shortcut function to get the value of the variable in the current context. Calls {@link RequestContext::get()} with the
 * passed $name.
 * @package harmoni.architecture.request
 * @access public
 */
function _v($name) {
	$harmoni =& Harmoni::instance();
	return $harmoni->request->get($name);
}

?>