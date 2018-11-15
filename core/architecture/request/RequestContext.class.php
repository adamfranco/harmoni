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
 * @version $Id: RequestContext.class.php,v 1.32 2008/04/10 17:34:09 adamfranco Exp $
 */

define("REQUEST_HANDLER_CONTEXT_DELIMETER", "___");

class RequestContext {

/*********************************************************
 * Class Methods
 *********************************************************/

	/**
	 * A quick shortcut function to get the expanded contextual name for a form
	 * field or request variable. Calls {@link RequestContext::getName()} with the
	 * passed $key.
	 *
 	 * Returns the full contextual name of a field or variable. If passed "test",
	 * it may return something like "context1.context2.test". This function is useful
	 * when creating HTML forms. 
	 *
	 * @param string $key
	 * @return string
	 * @static
	 * @access public
	 */
	static function name($key) {
		$harmoni = Harmoni::instance();
		return $harmoni->request->getName($key);
	}
	
	/**
	 * A quick shortcut function to get the value of the variable in the current context.
	 * Calls {@link RequestContext::get()} with the passed $key.
	 *
	 * Returns the string-value of the $key passsed. It will first check for request
	 * data under that name, then context data. The key passed will be located
	 * within the current namespace. If you pass a name like "context1/context2/name",
	 * the RequestContext uses it as a context-insensitive name (ie, you are specifying
	 * the absolute namespace). 
	 *
	 * @return string
	 * @param string $key
	 * @static
	 * @access public
	 */
	static function value($key) {
		$harmoni = Harmoni::instance();
		return $harmoni->request->get($key);
	}
	
	/**
	 * Send a properly formatted location header. XHTML specifies that the 
	 * ampersand character, '&' be replaced with '&amp;'. Location headers however
	 * fail to redirect with '&amp;'. This method properly formats location headers.
	 * 
	 * @param string $url
	 * @return void
	 * @access public
	 * @static
	 * @since 7/19/05
	 */
	static function locationHeader ( $url ) {
		header("Location: ".str_replace("&amp;", "&", $url));
		exit;
	}
	
	/**
	 * Send the browser to the url specified. Location headers will be sent if
	 * possible, otherwise a javascript redirect will be printed outside of 
	 * all output buffers
	 * 
	 * @param string $url
	 * @return void
	 * @access public
	 * @static
	 * @since 6/14/06
	 */
	static function sendTo ( $url ) {
		// use headers if possible
		if (!headers_sent())
			RequestContext::locationHeader($url);
			
		// Use javascript
		else {
			$harmoni = Harmoni::instance();
			// get rid of all output buffers;
			$harmoni->request->ob_jump();
			
			$unescapedurl = preg_replace("/&amp;/", "&", $url);
			$label = _("You should be automatically redirected. If not, click here to continue.");
			print <<< END
	<script type='text/javascript'>
	/* <![CDATA[ */
		
		window.location = '$unescapedurl';
		
	/* ]]> */
	</script>
	<a href='$url'>$label</a>
	
END;
			$harmoni->request->ob_land();
			exit;
		}
	}
	

/*********************************************************
 * Instance Vars
 *********************************************************/
 
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
	 * @var array $_fileData
	 */
	var $_fileData;
	/**
	 * @access private
	 * @var object RequestHandler $_requestHandler
	 */
	var $_requestHandler;
	
	
/*********************************************************
 * Instance Methods
 *********************************************************/
	
	/**
	 * Constructor.
	 * @access public
	 */
	function __construct() {
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
	function assignRequestHandler($handler) {
		$this->_requestHandler =$handler;
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
		
		$this->_fileData = $this->_requestHandler->getFileVariables();
	}
	
	/**
	 * Returns a string ("module.action" format) of the requested module and
	 * action. 
	 * @return string
	 * @access public
	 */
	function getRequestedModuleAction() {
		if (isset($this->moduleActionOverride))
			return $this->moduleActionOverride;
		
		$this->_checkForHandler();
		return $this->_requestHandler->getRequestedModuleAction();
	}
	
	/**
	 * Answer the currently requested module
	 * 
	 * @return string
	 * @access public
	 * @since 5/23/07
	 */
	function getRequestedModule () {
		$parts = explode(".", $this->getRequestedModuleAction());
		return $parts[0];
	}
	
	/**
	 * Answer the currently requested action
	 * 
	 * @return string
	 * @access public
	 * @since 5/23/07
	 */
	function getRequestedAction () {
		$parts = explode(".", $this->getRequestedModuleAction());
		return $parts[1];
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action.
	 * @param optional string $module
	 * @param optional string $action
	 * @param optional array $variables
	 * @return ref object URLWriter
	 * @access public
	 */
	function mkURL($module = null, $action = null, $variables = null ) {
		$harmoni = Harmoni::instance();
		
		// create a new URLWriter from the RequestHandler
		$this->_checkForHandler();
		$url =$this->_requestHandler->createURLWriter();
		
		// Set the Module and Action
		if ($module != null && $action != null) {
			$url->setModuleAction($module, $action);
		} else {
			list($module, $action) = explode(".",$harmoni->getCurrentAction());
			if (!$module) 
				list($module, $action) = explode(".",$this->getRequestedModuleAction());

			$url->setModuleAction($module, $action);
		}
		
		// Add the current context data.
		$url->batchSetValues($this->_contextData);
		
		// Addition $variables passed
		if (is_array($variables)) {
			$url->setValues($variables);
		}
		
		// If the requested action requires a user request token to prevent
		// cross-site request forgeries, add the token.
		if ($harmoni->ActionHandler->requiresRequestToken($module, $action)) {
			$this->startNamespace('request');
			$url->setValue('token', $harmoni->ActionHandler->getRequestToken());
			$this->endNamespace();
		}
		
		return $url;
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action. The new url
	 * will have the base specified rather than MYURL
	 *
	 * @param optional string $module
	 * @param optional string $action
	 * @param optional array $variables
	 * @return ref object URLWriter
	 * @access public
	 */
	function mkUrlWithBase($base, $module = null, $action = null, $variables = null ) {
		ArgumentValidator::validate($base, NonzeroLengthStringValidatorRule::getRule());
		
		// create a new URLWriter from the RequestHandler
		$this->_checkForHandler();
		$url =$this->_requestHandler->createURLWriter($base);
		
		
		// Set the Module and Action
		if ($module != null && $action != null) {
			$url->setModuleAction($module, $action);
		} else {
			$harmoni = Harmoni::instance();
			list($module, $action) = explode(".",$harmoni->getCurrentAction());
			if (!$module) 
				list($module, $action) = explode(".",$this->getRequestedModuleAction());

			$url->setModuleAction($module, $action);
		}
		
		// Add the current context data.
		$url->batchSetValues($this->_contextData);
		
		// Addition $variables passed
		if (is_array($variables)) {
			$url->setValues($variables);
		}
		
		// If the requested action requires a user request token to prevent
		// cross-site request forgeries, add the token.
		$harmoni = Harmoni::instance();
		if ($harmoni->ActionHandler->requiresRequestToken($module, $action)) {
			$this->startNamespace('request');
			$url->setValue('token', $harmoni->ActionHandler->getRequestToken());
			$this->endNamespace();
		}
		
		return $url;
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action. The new url
	 * will have the base specified rather than MYURL
	 * This method will return a url with no context data, only the variables passed.
	 *
	 * @param optional string $module
	 * @param optional string $action
	 * @param optional array $variables
	 * @return ref object URLWriter
	 * @access public
	 */
	function mkURLWithoutContextWithBase($base, $module = null, $action = null, $variables = null ) {
		ArgumentValidator::validate($base, NonzeroLengthStringValidatorRule::getRule());
		
		// create a new URLWriter from the RequestHandler
		$this->_checkForHandler();
		$url =$this->_requestHandler->createURLWriter($base);
		
		
		// Set the Module and Action
		if ($module != null && $action != null) {
			$url->setModuleAction($module, $action);
		} else {
			$harmoni = Harmoni::instance();
			list($module, $action) = explode(".",$harmoni->getCurrentAction());
			if (!$module) 
				list($module, $action) = explode(".",$this->getRequestedModuleAction());

			$url->setModuleAction($module, $action);
		}
		
		// Addition $variables passed
		if (is_array($variables)) {
			$url->setValues($variables);
		}
		
		// If the requested action requires a user request token to prevent
		// cross-site request forgeries, add the token.
		$harmoni = Harmoni::instance();
		if ($harmoni->ActionHandler->requiresRequestToken($module, $action)) {
			$this->startNamespace('request');
			$url->setValue('token', $harmoni->ActionHandler->getRequestToken());
			$this->endNamespace();
		}
		
		return $url;
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action.
	 * This method will return a url with no context data, only the variables passed.
	 *
	 * @param optional string $module
	 * @param optional string $action
	 * @param optional array $variables
	 * @return ref object URLWriter
	 * @access public
	 */
	function mkURLWithoutContext($module = null, $action = null, $variables = null ) {
		
		// create a new URLWriter from the RequestHandler
		$this->_checkForHandler();
		$url =$this->_requestHandler->createURLWriter();
		
		
		// Set the Module and Action
		if ($module != null && $action != null) {
			$url->setModuleAction($module, $action);
		} else {
			$harmoni = Harmoni::instance();
			list($module, $action) = explode(".",$harmoni->getCurrentAction());
			if (!$module) 
				list($module, $action) = explode(".",$this->getRequestedModuleAction());

			$url->setModuleAction($module, $action);
		}
		
		// Addition $variables passed
		if (is_array($variables)) {
			$url->setValues($variables);
		}
		
		return $url;
	}
	
	/**
	 * Returns a new {@link URLWriter} from the {@link RequestHandler}, assigning
	 * the module/action passed or keeping the current module/action. As well, 
	 * mkFullURL passes through all Request and Context data through to the resulting
	 * Url.
	 *
	 * @param optional string $module
	 * @param optional string $action
	 * @param optional array $variables
	 * @return ref object URLWriter
	 * @since 6/7/05
	 */
	function mkURLWithPassthrough ( $module = null, $action = null, $variables = null ) {
		$url =$this->mkURL($module, $action);
		$url->batchSetValues($this->_requestData);
		
		// Addition $variables passed
		if (is_array($variables)) {
			$url->setValues($variables);
		}
		
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
		
		// Special Case, only an array of variables is passed
		if ($num == 1 && is_array($args[0])) {
			$url =$this->mkURL();
			$url->setValues($args[0]);
		} 
		
		// Normal Case
		else {
			if (!isset($args[0]))
				$args[0] = NULL;

			if (!isset($args[1]))
				$args[1] = NULL;

			if (!isset($args[2]))
				$args[2] = NULL;
			
			$url = $this->mkURL($args[0], $args[1], $args[2]);
		}
		
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
		if (!is_null($name))
			$this->_checkName($name);
		$this->_namespaces[] = $this->_currentNamespace;
		$this->_currentNamespace = $name;
	}
	
	/**
	 * Ends a namespace started previously. The last-started namespace is ended.
	 * @return string The name of the namespace just ended.
	 * @access public
	 */
	function endNamespace() {
		if ($this->_currentNamespace == null && !count($this->_namespaces))
			return;
		
		$curr = $this->_currentNamespace;
		if (!count($this->_namespaces)) { 
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
	 * Set a value in the request data array, overriding any existing value with
	 * that key.
	 * 
	 * @param string $key
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 4/10/08
	 */
	public function setRequestParam ($key, $value) {
		$this->_checkName($key);
		$nKey = $this->_mkFullName($key);
		$this->_requestData[$nKey] = $value;
	}
	
	/**
	 * Override the requested module and action with those passed. This must be
	 * called before Harmoni::execute() in order to have the specified action executed.
	 * 
	 * @param string $module
	 * @param string $action
	 * @return void
	 * @access public
	 * @since 3/20/08
	 */
	public function setModuleAction ($module, $action) {
		$this->moduleActionOverride = $module.'.'.$action;
	}
	
	/**
	 * @var string $moduleActionOverride;  A module and action to override the ones passed.
	 * @access private
	 * @since 3/20/08
	 */
	private $moduleActionOverride;
	
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
	 * @return mixed Either a string, in the case of a regular key, or an array in the case of a file.
	 * @param string $key
	 * @access public
	 */
	function get($key) {
		// first check if we have a request variable appropriately named,
		// then check our context data, lastly return NULL
		$nKey = $this->_mkFullName($key);
		if (isset($this->_requestData[$nKey])) return $this->_requestData[$nKey];
		if (isset($this->_fileData[$nKey])) return $this->_fileData[$nKey];
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
		if ($pre) {
			$keys = array_unique(array_merge(array_keys($this->_fileData), array_merge(array_keys($this->_requestData), array_keys($this->_contextData))));
			foreach ($keys as $key) {
				if (preg_match("/^$pre\\".REQUEST_HANDLER_CONTEXT_DELIMETER."(.+)/", $key, $r)) {
					$array[] = $r[1];
				}
			}
		} else {
			$skip = array('module', 'action');
			foreach ($this->_requestData as $key => $val) {
				if (!in_array($key, $skip))
					$array[] = $key;
			}
		}
		
		return $array;
	}
	/**
	 * Answer an array of context information that is currently set to be passed through.
	 * Each element of the array will be an object with the following properties:
	 *		name		- the non-namespaced name
	 *		fullName	- the name with namespace added
	 *		namespace	- the namespace
	 *		value		- the value of the context info
	 * 
	 * @return array
	 * @access public
	 * @since 9/30/08
	 */
	public function getContextInfo () {
		$all = array();
		
		foreach ($this->_contextData as $key => $val) {
			$info = new stdClass();
			$info->fullName = $key;
			$info->value = $val;
			
			if (preg_match("/^(.+)".REQUEST_HANDLER_CONTEXT_DELIMETER."(.+)$/", $key, $r)) {
				$info->name = $r[2];
				$info->namespace = $r[1];
			} else {
				$info->name = $key;
				$info->namespace = null;
			}
			
			$all[] = $info;
		}
		
		return $all;
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
	 */
	public function getParameterListFromUrl ($inputUrl) {
		$this->_checkForHandler();
		try {
			return $this->_requestHandler->getParameterListFromUrl($inputUrl);
		} catch (UnimplementedException $e) {
			return false;
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
	 * @return mixed string URL-encoded parameter list or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 */
	public function getParameterListFromUrlWithBase ($base, $inputUrl) {
		$this->_checkForHandler();
		try {
			return $this->_requestHandler->getParameterListFromUrl($inputUrl, $base);
		} catch (UnimplementedException $e) {
			return false;
		}
	}
	
	/**
	 * Given an input url written by the current handler, return an associative array
	 * of parameters and values excluding the module and action.
	 * 
	 * For instance, the PathInfo handler would for the following input
	 *		http://www.example.edu/basedir/moduleName/actionName/parm1/value1/param2/value2
	 * would return
	 *		Array (
	 *			param1 => value1,
	 *			param2 => value2
	 *		)
	 * 
	 * @param string $inputUrl
	 * @return mixed array or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 */
	public function getParameterArrayFromUrl ($inputUrl) {
		$urlString = $this->getParameterListFromUrl($inputUrl);
		if ($urlString === false)
			return false;
		
		preg_match_all('/(&(amp;)?)?([^&=]+)=([^&=]+)/', $urlString, $paramMatches);
		$args = array();
		for ($i = 0; $i < count($paramMatches[1]); $i++) {
			$key = $paramMatches[3][$i];
			$value = $paramMatches[4][$i];
			
			if ($key != 'module' && $key != 'action')
				$args[$key] = $value;
		}
		
		return $args;
	}
	
	/**
	 * Given an input url written by the current handler, return an associative array
	 * of parameters and values excluding the module and action.
	 * 
	 * For instance, the PathInfo handler would for the following input
	 *		http://www.example.edu/basedir/moduleName/actionName/parm1/value1/param2/value2
	 * would return
	 *		Array (
	 *			param1 => value1,
	 *			param2 => value2
	 *		)
	 * 
	 * @param string $inputUrl
	 * @return mixed array or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 */
	public function getParameterArrayFromUrlWithBase ($base, $inputUrl) {
		$urlString = $this->getParameterListFromUrlWithBase($base, $inputUrl);
		if ($urlString === false)
			return false;
		
		preg_match_all('/(&(amp;)?)?([^&=]+)=([^&=]+)/', $urlString, $paramMatches);
		$args = array();
		for ($i = 0; $i < count($paramMatches[1]); $i++) {
			$key = $paramMatches[3][$i];
			$value = $paramMatches[4][$i];
			
			if ($key != 'module' && $key != 'action')
				$args[$key] = $value;
		}
		
		return $args;
	}
	
	/**
	 * Given an input url written by the current handler, return an associative array
	 * of parameters and values that are in the namespace specified.
	 * 
	 * For instance, the PathInfo handler would for the following input
	 *		http://www.example.edu/basedir/moduleName/actionName/parm1/value1/namespaceX_param2/value2
	 * with a namespace of 'namespaceX'
	 * would return
	 *		Array (
	 *			param2 => value2
	 *		)
	 * 
	 * @param string $namespace
	 * @param string $inputUrl
	 * @return mixed array or FALSE if unmatched
	 * @access public
	 * @since 1/25/08
	 */
	public function getNamespaceParameterArrayFromUrl ($namespace, $inputUrl) {
		$params = $this->getParameterArrayFromUrl($inputUrl);
		if ($params === false)
			return false;
		
		$namespaceParams = array();
		foreach ($params as $key => $value) {
			if (preg_match('/^'.$namespace.REQUEST_HANDLER_CONTEXT_DELIMETER.'(.+)$/', $key, $matches))
				$namespaceParams[$matches[1]] = $value;
		}
		
		return $namespaceParams;
	}
	
	/**
	 * Answer the module specified in a url written by the current handler.
	 * Return false if not can be found.
	 * 
	 * @param string $url
	 * @return string
	 * @access public
	 * @since 2/15/08
	 */
	public function getModuleFromUrl ($inputUrl) {
		$paramList = $this->getParameterListFromUrl($inputUrl);
		if (!$paramList)
			return false;
		
		parse_str(str_replace('&amp;', '&', $paramList), $params);
		
		if (isset($params['module']) && strlen($params['module']))
			return $params['module'];
		
		return false;
	}
	
	/**
	 * Answer the module specified in a url written by the current handler.
	 * Return false if not can be found.
	 * 
	 * @param string $base
	 * @param string $url
	 * @return string
	 * @access public
	 * @since 2/15/08
	 */
	public function getModuleFromUrlWithBase ($base, $inputUrl) {
		$paramList = $this->getParameterListFromUrlWithBase($base, $inputUrl);
		if (!$paramList)
			return false;
		
		parse_str(str_replace('&amp;', '&', $paramList), $params);
		
		if (isset($params['module']) && strlen($params['module']))
			return $params['module'];
		
		return false;
	}
	
	/**
	 * Answer the action specified in a url written by the current handler.
	 * Return false if not can be found.
	 * 
	 * @param string $url
	 * @return string
	 * @access public
	 * @since 2/15/08
	 */
	public function getActionFromUrl ($inputUrl) {
		$paramList = $this->getParameterListFromUrl($inputUrl);
		if (!$paramList)
			return false;
		
		parse_str(str_replace('&amp;', '&', $paramList), $params);
		
		if (isset($params['action']) && strlen($params['action']))
			return $params['action'];
		
		return false;
	}
	
	/**
	 * Answer the action specified in a url written by the current handler.
	 * Return false if not can be found.
	 * 
	 * @param string $base
	 * @param string $url
	 * @return string
	 * @access public
	 * @since 2/15/08
	 */
	public function getActionFromUrlWithBase ($base, $inputUrl) {
		$paramList = $this->getParameterListFromUrlWithBase($base, $inputUrl);
		if (!$paramList)
			return false;
		
		parse_str(str_replace('&amp;', '&', $paramList), $params);
		
		if (isset($params['action']) && strlen($params['action']))
			return $params['action'];
		
		return false;
	}
	
	/**
	 * @access private
	 * @return void
	 */
	function _checkForHandler() {
		if (!isset($this->_requestHandler)) {
			throwError( new HarmoniError("RequestContext requires a RequestHandler for proper functionality! Please set one by calling RequestContext::assignRequestHandler()", "RequestContext", true));
		}
	}
			
	/**
	 * @access private
	 * @return string
	 */
	function _mkFullName($key) {
		// in the request, periods and spaces will get converted to '_'s, so 
		// do that preemptively
		$key = preg_replace('/[\.\s\n\r\t]/', '_', $key);
		
		if ($this->_currentNamespace == null) 	
			return $key;
		else
			return $this->_currentNamespace.REQUEST_HANDLER_CONTEXT_DELIMETER.$key;
	}
	
	/**
	 * @access private
	 * @return void
	 */
	function _checkName($name) {
		if (preg_match("/\\".REQUEST_HANDLER_CONTEXT_DELIMETER.'/', $name)) {
			throwError( new HarmoniError("Namespaces and field names cannot contain \"".REQUEST_HANDLER_CONTEXT_DELIMETER."\"s!", "RequestHandler", true));
		}
	}
	
	/**
	 * Climbs down the ob ladder and saves the data to put back later
	 * 
	 * @access public
	 * @return void
	 * @since 6/14/06
	 */
	function ob_jump () {
		if (!isset($this->_ob_data))
			$this->_ob_data = array();
		
		$level = ob_get_level();
		while ($level > 0) {
			$this->_ob_data[$level] = ob_get_clean();
			$level = ob_get_level();
		}
	}

	/**
	 * Climps back up the ob ladder adding back the data that was there
	 * 
	 * @access public
	 * @return void
	 * @since 6/14/06
	 */
	function ob_land() {
		if (!isset($this->_ob_data))
			return;
		
		foreach ($this->_ob_data as $level => $data) {
			ob_start();
			print $data;
			unset($this->_ob_data[$level]);
		}
	}
}

?>