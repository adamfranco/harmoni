<?php
require_once(HARMONI."architecture/harmoni/Harmoni.interface.php");
require_once(HARMONI."architecture/harmoni/login/LoginHandler.class.php");
require_once(HARMONI."actionHandler/ActionHandler.class.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");
require_once(HARMONI."architecture/harmoni/login/LoginState.class.php");
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
 * @version $Id: Harmoni.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003 
 **/
class Harmoni extends HarmoniInterface {
	/**
	 * @access private
	 * @var object $_startWithLayout A {@link Layout} object.
	 */ 
	var $_startWithLayout;
	
	/**
	 * @access private
	 * @var integer $_startWithLayoutIndex The index where the layout from actions should go in $_startWithLayout
	 */ 
	var $_startWithLayoutIndex;
	
	/**
	 * @access private
	 * @var string $_actionCallbackFunction The name of a function that gets the current
	 * action from the user.
	 **/
	var $_actionCallbackFunction;

	/**
	 * @access private
	 * @var array $_httpVars
	 **/
	var $_httpVars;

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
	 * @var object $ActionHandler The {@link ActionHandler} object.
	 **/
	var $ActionHandler;
	
	/**
	 * @access public
	 * @var object $config A {@link HarmoniConfig} {@link DataContainer} for Harmoni-specific options.
	 **/
	var $config;
	
	/**
	 * @access public
	 * @var object $language A {@link LanguageLocalizer} object.
	 **/
	var $language;
	
	/**
	 * The constructor.
	 * @param optional array A hash table of http variables. Default = $_REQUEST (combination of GET and POST vars).
	 * @access public
	 * @return void
	 **/
	function Harmoni($httpVars = null) {
		// set up the variables we are going to pass to actions
		if ($httpVars) $this->_httpVars =& new FieldSet($httpVars);
		else $this->_httpVars =& new FieldSet($_REQUEST);
		
		// set up the LoginHandler and the ActionHandler
		$this->LoginHandler =& new LoginHandler($this);
		$this->ActionHandler =& new ActionHandler($this->_httpVars,$this);
		
		// set up config options
		$this->config =& new HarmoniConfig;
		$this->config->set("useAuthentication",true); // default
		$this->config->set("charset","utf-8"); // default
		
		// set up the default action callback function
		$this->setActionCallbackFunction("httpTwoVarsActionCallback");
		
		// set up the language localizer
		$this->language =& new LanguageLocalizer(HARMONI."languages");
	}
	
	
	/**
	 * Sets the callback function to find out what module and action the end-user
	 * would like to view. The function needs to return a dotted pair ("module.action") string
	 * specifying which module and action to use. The default is to look for an HTTP
	 * variable called "module" and one called "action".
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
		if (!$this->theme) throwError(new Error("Harmoni::execute() - You must 
							specify a theme to use before calling execute()!","Harmoni",true));
		
		// find what action we are trying to execute
		$callback = $this->_actionCallbackFunction;
		$pair = $callback();
		
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
		
		// process the login information
		if ($this->config->get("useAuthentication")) {
			$loginState =& $this->LoginHandler->execute();
		} else $loginState =& new LoginState; // "blank" loginState
		
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
		header("Content-type: text/html; charset=".$this->config->get("charset"));
		
		// set up a context object.
		$context =& new Context($module, $action);
		
		// ok, call the action handler
		$this->ActionHandler->useLoginState($loginState);
		$this->ActionHandler->useContext($context);
		$result =& $this->ActionHandler->execute($module, $action);
		
		// we only need to print anything out if config->outputHTML is set.
		if ($this->config->get("outputHTML")) {
			// alright, if what we got back was a layout, let's print it out!
			$rule = new ExtendsValidatorRule("LayoutInterface");
			if ($rule->check($result)) {
				// indeed!
				// now check if we have a "startWithLayout" layout
				if ($this->_startWithLayout) {
					$this->_startWithLayout->setComponent($this->_startWithLayoutIndex,$result);
					$this->theme->printPageWithLayout($this->_startWithLayout);
				} else
					$this->theme->printPageWithLayout($result);
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
		session_name($this->config->get("sessionName"));
		if (!$_COOKIE[$this->config->get("sessionName")] && !$_REQUEST[$this->config->get("sessionName")])
			session_id(uniqid(str_replace(".","",$_SERVER['REMOTE_ADDR']))); // make new session id.
		$path = $this->config->get("sessionCookiePath");
		if ($path[strlen($path) - 1] != '/') $path .= '/';
		session_set_cookie_params(0,$path,$this->config->get("sessionCookieDomain"));
		ini_set("session.use_cookies",($this->config->get("sessionUseCookies")?1:0));
		session_start(); // yay!
	}
	
	/**
	 * Tells Harmoni to "start" with the given layout object. Instead of taking the layout from an action
	 * and passing that directly to the theme, harmoni will take this layout object and add the one it gets
	 * from the theme to it at index $index, and pass that to the theme.
	 * @param ref object $layoutObject A {@link Layout} object. 
	 * @param integer $index The index where the layout returned from actions should go in $layoutObject.
	 * @access public
	 * @return void 
	 **/
	function startWithLayout(&$layoutObject, $index) {
		ArgumentValidator::validate($layoutObject, new ExtendsValidatorRule("LayoutInterface"));
		$this->_startWithLayout =& $layoutObject;
		$this->_startWithLayoutIndex = $index;
	}
}

/**
 * This function is an actionCallback function for the {@link Harmoni} class. It returns
 * a "module.action" pair from HTTP GET variables "module" and "action".
 * @access public
 * @package harmoni.architecture
 * @return void
 **/
function httpTwoVarsActionCallback() {
	$module = $_REQUEST['module'];
	$action = $_REQUEST['action'];
	return "$module.$action";
}


?>