<?php
//require_once(HARMONI."architecture/harmoni/Harmoni.interface.php");
if (LOAD_AUTHENTICATION) require_once(HARMONI."architecture/harmoni/login/LoginHandler.class.php");
require_once(HARMONI."actionHandler/ActionHandler.class.php");
require_once(HARMONI."utilities/FieldSetValidator/ReferencedFieldSet.class.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");
if (LOAD_AUTHENTICATION) require_once(HARMONI."architecture/harmoni/login/LoginState.class.php");
require_once(HARMONI."languageLocalizer/LanguageLocalizer.class.php");
require_once(HARMONI."architecture/harmoni/HarmoniConfig.class.php");
require_once(HARMONI."architecture/harmoni/Context.class.php");
require_once(HARMONI."actionHandler/DottedPairValidatorRule.class.php");

require_once(HARMONI."architecture/harmoni/login/LoginState.class.php");

/**
 * The Harmoni class combines the functionality of login, authentication, 
 * action-handling and theme-output. It makes use of the {@link LoginHandler}, {@link AuthenticationHandler} and
 * the {@link ActionHandler} classes.
 * 
 * @package harmoni.architecture
 * @version $Id: Harmoni.class.php,v 1.27 2004/08/08 19:43:20 gabeschine Exp $
 * @copyright 2003 
 **/
class Harmoni {
	
	/**
	 * @access private
	 * @var string $_actionCallbackFunction The name of a function that gets the current
	 * action from the user.
	 **/
	var $_actionCallbackFunction;

	/**
	 * @access public
	 * @var array $_httpVars
	 **/
	var $HTTPVars;

	/**
	 * @access private
	 * @var string $_currentAction A dotted-pair module.action
	 **/
	var $_currentAction;
	
	/**
	 * @access public
	 * @var object $theme The theme we are using for output.
	 **/
	var $theme;
	
	/**
	 * @access public
	 * @var object $LoginHandler The {@link LoginHandler} object.
	 **/
	var $LoginHandler;

	/**
	 * @access public
	 * @var object $LoginState A {@link LoginState} object, representing current login state.
	 **/
	var $LoginState;
	
	/**
	 * @access public
	 * @var object $ActionHandler The {@link ActionHandler} object.
	 **/
	var $ActionHandler;
	
	/**
	 * @access public
	 * @var object $config A {@link HarmoniConfig} {@link DataContainer} for Harmoni-specific options.
	 **/
	var $config;
	
	var $_attachedData;
	
	var $_preExecActions;
	var $_postExecActions;
	var $_postProcessAction;
	var $_postProcessIgnoreList;
	
	var $result;
	
	/**
	 * @access public
	 * @var array $pathInfoParts An array of split PATH_INFO elements.
	 */
	var $pathInfoParts;
	
	/**
	 * The constructor.
	 * @param optional array A hash table of http variables. Default = $_REQUEST (combination of GET and POST vars).
	 * @access public
	 * @return void
	 **/
	function Harmoni($httpVars = null) {
		// set up the variables we are going to pass to actions
		if ($httpVars) $this->HTTPVars =& new FieldSet($httpVars);
		else $this->HTTPVars =& new ReferencedFieldSet($_REQUEST);
		
		// set up the LoginHandler and the ActionHandler
		if (LOAD_AUTHENTICATION) {
			$this->LoginHandler =& new LoginHandler($this);
			$this->LoginState =& new LoginState();
		}
		$this->ActionHandler =& new ActionHandler($this);
		
		// set up config options
		$this->config =& new HarmoniConfig;
		$this->config->set("useAuthentication",true); // default
		$this->config->set("charset","utf-8"); // default
		
		// set up the default action callback function
		$this->setActionCallbackFunction("httpTwoVarsActionCallback");
		
		$this->_attachedData =& new ReferencedFieldSet;
		$this->_preExecActions = array();
		$this->_postExecActions = array();
			
		// set up pathInfoParts
		$pathInfo = $_SERVER['PATH_INFO'];
		$this->pathInfoParts = explode("/",ereg_replace("^/","",$pathInfo));
		
		// set up the language localizer :: BROKEN?
//		$this->language =& new LanguageLocalizer(HARMONI."languages");
	}
	
	/**
	 * Adds an action, or multiple, (see the {@link ActionHandler}) to execute before executing the action requested by the end user.
	 * @param string $action,... A number of actions (module.action) to execute.
	 * @access public
	 * @return void
	 */
	function addPreExecActions($actions)
	{
		$args = func_get_args();
		$rule =& new DottedPairValidatorRule();
		foreach ($args as $arg) {
			if ($rule->check($arg)) $this->_preExecActions[] = $arg;
		}
	}
	
	/**
	 * Adds an action, or multiple, (see the {@link ActionHandler}) to execute after executing the action requested by the end user.
	 * @param string $action,... A number of actions (module.action) to execute.
	 * @access public
	 * @return void
	 */
	function addPostExecActions($actions)
	{
		$args = func_get_args();
		$rule =& new DottedPairValidatorRule();
		foreach ($args as $arg) {
			if ($rule->check($arg)) $this->_postExecActions[] = $arg;
		}
	}
	
	/**
	 * Sets the action to call after the browser-requested action has executed but before the output from that action is processed. The result from the previous action can be accessed as Harmoni::result.
	 * @param string $action A dotted-pair action (module.action) to use for post processing.
	 * @param optional array $ignore An array of dotted-pair actions for which we will NOT execute the post-process action.
	 * @access public
	 * @return void
	 */
	function setPostProcessAction($action, $ignore=null)
	{
		$rule1 =& new DottedPairValidatorRule();
		$rule2 =& new ArrayValidatorRuleWithRule($rule1);
		ArgumentValidator::validate($action, $rule1);
		if ($ignore) ArgumentValidator::validate($ignore, $rule2);
		
		$this->_postProcessIgnoreList = $ignore?$ignore:array();
		$this->_postProcessAction = $action;
	}
	
	/**
	 * Returns TRUE if $action is contained somewhere within the array of actions: $array.
	 * @param string $action
	 * @param array $array
	 * @access private
	 * @return bool
	 */
	function _isActionInArray($action, $array)
	{
		if (in_array($action, $array)) return true;
		
		ereg("(.+)\.(.+)",$action,$r);
		$reqMod = $r[1];
		$reqAct = $r[2];
		
		foreach ($array as $pair) {
			ereg("(.+)\.(.+)",$pair,$r);
			$mod = $r[1];
			$act = $r[2];
			
			if ($mod == $reqMod && $act == "*") return true;
		}
		return false;
	}
	
	/**
	 * Returns a pretty version string of our running Harmoni framework version.
	 * @param optional string $versionStr An optional harmoni version string. If it is a partial string, we will return a full three-part version string.
	 * @access public
	 * @return string
	 */
	function getVersionStr($versionStr=null) {
		if ($versionStr) $harmoniVersion = $versionStr;
		else include HARMONI."version.inc.php";
		$ar = $this->_getVersionParts($harmoniVersion);
		
		return $ar[0] . "." . $ar[1] . "." . $ar[2];
	}
	
	/**
	 * Returns the numeric representation of our framework version. The format is XXMMRR, two digits for each of the major, minor and release numbers. NOTE: leading 0's are omitted.
	 * @param optional string $versionStr An optional harmoni version string "M[.m[.r]]" to turn into a number. Otherwise, the actual running Harmoni version number will be used.
	 * @access public
	 * @return integer
	 */
	function getVersionNumber($versionStr=null)
	{
		if ($versionStr) $harmoniVersion = $versionStr;
		else include HARMONI."version.inc.php";
		
		$ar = $this->_getVersionParts($harmoniVersion);
		
		$num = (integer) ereg_replace("^0+","",sprintf("%02d%02d%02d",$ar[0],$ar[1], $ar[2]));
		return $num;
	}
	
	/**
	 * Returns an array of the Harmoni version string containing the major, minor and release numbers, in that order.
	 * @param string $string
	 * @access public
	 * @return array
	 */
	function _getVersionParts($string)
	{
		ereg("([0-9]+)(\.([0-9]+))?(\.([0-9]+))?", $string, $matches);
		$major = (integer) $matches[1];
		$minor = (integer) $matches[3]?$matches[3]:0;
		$release = (integer) $matches[5]?$matches[5]:0;
		
		return array($major, $minor, $release);
	}
	
	/**
	* @return void
	* @param string $key
	* @param mixed $value
	* Attaches some arbitrary data to the Harmoni object so that actions or later
	* functions can make use of it.
	*/
	function attachData($key, & $value) {
		$this->_attachedData->set($key,$value);
	}
	
	/**
	* *Deprecated* 
	* @return mixed
	* @param string $key
	* Returns the data attached by {@link Harmoni::attachData} referenced by $key.
	* @deprecated 12/27/03 See getAttachedData()
	*/
	function &getData($key) {
		return $this->_attachedData->get($key);
	}
	
	/**
	* @return mixed
	* @param string $key
	* Returns the data attached by {@link Harmoni::attachData} referenced by $key.
	*/
	function &getAttachedData($key) {
		return $this->_attachedData->get($key);
	}	
	
	/**
	* @return void
	* @param string $module
	* @param string $action
	* An alias for {@link ActionHandler::forward()}. Purely for convenience.
	*/
	function &forward($module, $action) {
		$this->ActionHandler->forward($module, $action);
	}
	
	/**
	 * Sets the callback function to find out what module and action the end-user
	 * would like to view. The function needs to return a dotted pair ("module.action") string
	 * specifying which module and action to use. The default is to look for an HTTP
	 * variable called "module" and one called "action". The function is passed a reference to the
	 * Harmoni object.
	 * @param string $functionName The name of the function to call to get
	 * the module.action string.
	 * @access public
	 * @return void
	 **/
	function setActionCallbackFunction($functionName) {
		if (!function_exists($functionName)) {
			// come on, people! define yer darned functions!
			throwError(new Error("Harmoni::setActionCallbackFunction($functionName) - Umm, the function '$functionName'
								isn't defined yet. Try defining it... or something.","Harmoni",true));
			return false;
		}
		$this->_actionCallbackFunction = $functionName;
	}
	
	function _detectCurrentAction() {
		// if we've already run, get out
		if ($this->_currentAction) return;
		
		// find what action we are trying to execute
		$callback = $this->_actionCallbackFunction;
		$pair = $callback($this);
		
		// now, let's find out what we got handed. could be any of:
		// 1) module.action <-- great
		// 2) module.	<-- ok, we'll use default action
		// 3) module	<-- same as above
		// 3) .action <-- no good!
		// 4) .		<-- ok, we'll use defaults
		if (ereg("^[[:alnum:]_-]+\.[[:alnum:]_-]+$",$pair))
			list ($module, $action) = explode(".",$pair);
		else if (ereg("^[[:alnum:]_-]+\.?$",$pair)) {
			$module = str_replace(".","",$pair);
			$action = $this->config->get("defaultAction");
		} else if (ereg("^\.[[:alnum:]_-]+$",$pair)) {
			// no good! throw an error
			throwError(new Error("Harmoni::execute() - Could not execute action '$pair' - a module needs to be specified!","Harmoni",true));
			return false;
		} else if (ereg("^\.?$",$pair)) {
			$module = $this->config->get("defaultModule");
			$action = $this->config->get("defaultAction");
		}
		// that should cover it -- we now have a module and action to work with!
		$pair = "$module.$action";
		$this->setCurrentAction($pair);
	}
	
	/**
	 * Executes the {@link LoginHandler} functionality and stores the result.
	 * @access public
	 * @return ref object
	 */
	function &executeLogin()
	{
		if ($this->config->get("useAuthentication")) {
			$loginState =& $this->LoginHandler->execute();
		} else $loginState =& new LoginState; // "blank" loginState
		
		$this->LoginState =& $loginState;
		
		return $loginState;
	}
	
	/**
	 * Executes the Harmoni procedures: login handling and authenticating, action
	 * processing and themed output to the browser. Certain options must be 
	 * set before execute() can be called.
	 * @access public
	 * @return void
	 **/
	function execute() {
		$this->config->checkAll();
		
		// check to make sure we have a theme object set!
		if ($this->config->get("outputHTML") && !$this->theme) throwError(new Error("Harmoni::execute() - You must 
							specify a theme to use before calling execute()!","Harmoni",true));
		
		// detect the current action
		$this->_detectCurrentAction();
		
		// process the login information
		$loginState =& $this->executeLogin();
		
		// check if we have any pre-exec actions. if so, execute them
		if (count($this->_preExecActions)) {
			foreach ($this->_preExecActions as $pair) {
				$this->ActionHandler->executePair($pair);
			}
		}
		
		// check if we've still got the same action
		$pair = $this->getCurrentAction();
		list($module,$action) = explode(".",$pair);
		
		// ok, now we execute the action
		// 1) call the action, get the return result
		// 2) Take whatever it returns (true, false, or Layout)
		// 3) Pass that on to the theme (which should be set by now)
		// 4) and that's it! program finished!
		
		// output a content-type header with specified charset. this can be
		// overridden at any later time.
		if ($this->config->get("outputHTML"))
			header("Content-type: text/html; charset=".$this->config->get("charset"));
		
		// we want to catch all the output in case we need to go to the failedLoginAction
		ob_start();
		
		$result =& $this->ActionHandler->execute($module, $action);
		$lastExecutedAction = $this->ActionHandler->lastExecutedAction();
		// ask the LoginHandler if the current user was allowed to see this action
		if ($this->LoginHandler && $this->LoginHandler->loginFailed() &&
		$this->LoginHandler->actionRequiresAuthentication($lastExecutedAction)) {
			$failedLoginAction = $this->LoginHandler->getFailedLoginAction();
			// clean out our buffer.
			debug::output("cleaning ".ob_get_length()." bytes before executing failedLoginAction.",DEBUG_SYS5,"Harmoni");
			ob_end_clean();
			// execute the failed login action.
			$result =& $this->ActionHandler->executePair($failedLoginAction);
		} else {
			// looks like they're just fine
			ob_end_flush();
		}

		$this->result =& $result;

		// if we have a post-process action, let's try executing it.
		if (isset($this->_postProcessAction) && !$this->_isActionInArray($lastExecutedAction, $this->_postProcessIgnoreList)) {
			$newResult =& $this->ActionHandler->executePair($this->_postProcessAction);
			$this->result =& $newResult;
			$result =& $newResult;
		}
		
		// check if we have any post-exec actions. if so, execute them
		if (count($this->_postExecActions)) {
			foreach ($this->_postExecActions as $pair) {
				$this->ActionHandler->executePair($pair);
			}
		}
		
		// we only need to print anything out if config->outputHTML is set.
		if ($this->config->get("outputHTML")) {
			// alright, if what we got back was a layout, let's print it out!
			$rule = new ExtendsValidatorRule("LayoutInterface");
			if ($rule->check($result)) {
				// indeed!
				$this->theme->printPage($result);
			} else {
				// we got something else back... well, let's print out an error
				// explaining what happened.
				$type = gettype($result);
				throwError(new Error("Harmoni::execute() - The result returned from action '$pair' was unexpected. Expecting a Layout
						object, but got a variable of type '$type'.","Harmoni",true));
			}
		} else {
			// otherwise return the result
			return $result;
		}
	}
	
	/**
	 * Sets the {@link ThemeInterface Theme} to use for output to the browser. $themeObject can
	 * be any Theme object that follows the {@link ThemeInterface}.
	 * @param ref object A {@link ThemeInterface Theme} object.
	 * @access public
	 * @return void
	 **/
	function setTheme(&$themeObject) {
		ArgumentValidator::validate($themeObject, new ExtendsValidatorRule("ThemeInterface"));
		$this->theme =& $themeObject;
	}
	
	/**
	 * Returns the current theme object.
	 * @access public
	 * @return ref object A {@link ThemeInterface Theme} object.
	 **/
	function &getTheme() {
		return $this->theme;
	}
	
	/**
	 * Returns true if there is a current theme.
	 * @access public
	 * @return boolean TRUE if there is a theme.
	 **/
	function hasTheme() {
		if (is_object($this->theme))
			return TRUE;
		else
			return FALSE;
	}
	
	
	/**
	 * Returns the current action.
	 * @access public
	 * @return string A dotted-pair action.
	 **/
	function getCurrentAction() {
		return $this->_currentAction;
	}
	
	/**
	 * Sets the current Harmoni action.
	 * @param string $action A dotted-pair action string.
	 * @access public
	 * @return void
	 **/
	function setCurrentAction($action) {
		ArgumentValidator::validate($action, new DottedPairValidatorRule);
		$this->_currentAction = $action;
	}
	
	/**
	 * Starts the session.
	 * @access public
	 * @return void
	 **/
	function startSession() {
		// let's start the session
		if (session_id()) return;
		session_name($this->config->get("sessionName"));
		if (!$_COOKIE[$this->config->get("sessionName")] && !$_REQUEST[$this->config->get("sessionName")])
			session_id(uniqid(str_replace(".","",$_SERVER['REMOTE_ADDR']))); // make new session id.
		$path = $this->config->get("sessionCookiePath");
		if ($path[strlen($path) - 1] != '/') $path .= '/';
		session_set_cookie_params(0,$path,$this->config->get("sessionCookieDomain"));
		ini_set("session.use_cookies",($this->config->get("sessionUseCookies")?1:0));
		session_start(); // yay!
	}

}

/**
 * This function is an actionCallback function for the {@link Harmoni} class. It returns
 * a "module.action" pair from HTTP GET variables "module" and "action".
 * @access public
 * @param ref object $harmoni The Harmoni object.
 * @package harmoni.architecture
 * @return void
 **/
function httpTwoVarsActionCallback(&$harmoni) {
	$module = $harmoni->HTTPVars->get('module');
	$action = $harmoni->HTTPVars->get('action');
	return "$module.$action";
}


?>