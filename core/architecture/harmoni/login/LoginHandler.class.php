<?php

require_once(HARMONI."architecture/harmoni/login/LoginHandler.interface.php");

/**
 * The LoginHandler essentially creates an interface between the web browser and
 * the {@link AuthenticationHandler}. It expects a session to have been started, 
 * and processes saved session-variables, while interfacing with the {@link ActionHandler} if
 * login fails.
 * 
 * The LoginHandler also handles the process of forwarding a user to the site they
 * were trying to access if they are forwarded to the login page. The action to be
 * executed if login either fails or has not yet occured can be specified.
 * 
 * If no action is specified, the LoginHandler uses standard HTTP clear-text authentication.
 *
 * @package harmoni.architecture.login
 * @version $Id: LoginHandler.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginHandler extends LoginHandlerInterface {
	/**
	 * @access private
	 * @var string $_failedLoginAction The action to execute if login fails.
	 **/
	var $_failedLoginAction;

	/**
	 * @access private
	 * @var array $_noAuthActions An array of actions for which an agent does not
	 * need to be authenticated.
	 **/
	var $_noAuthActions;
	
	/**
	 * @access private
	 * @var object $_harmoni The {@Harmoni} object using this LoginHandler.
	 **/
	var $_harmoni;
	
	/**
	 * @access private
	 * @var string $_usernamePasswordCallbackFunction The name of a user-defined
	 * function to fetch the username/password pair from the browser.
	 **/
	var $_usernamePasswordCallbackFunction;
	
	/**
	 * The constructor.
	 * @param ref object $harmoniObject
	 * @access public
	 * @return void
	 **/
	function LoginHandler(&$harmoniObject) {
		$this->_harmoni =& $harmoniObject;
		$this->_usernamePasswordCallbackFunction = "basicHTTPAuthenticationCallback";
	}
	
	
	/**
	 * Executes the LoginHandler. The process followed goes: Check the session
	 * for a saved LoginState and load it if found, otherwise check the HTTP
	 * variables for a login/passwd and execute those with the {@link AuthenticationHandler}. If
	 * this fails, FALSE is returned.
	 * @access public
	 * @return object|false Returns a {@link LoginState} object or FALSE on failure.
	 **/
	function & execute() {
		// do we have a failedLoginAction?
		if (!$this->_failedLoginAction) {
			throwError(new Error("LoginHandler::execute() - could not proceed 
					because no failedLoginAction has been set!","Login",true));
			return false;
		}
		
		// first let's check if a LoginState has been saved in the session
		if ($_SESSION['__LoginState']) {
			$state =& $_SESSION['__LoginState'];
		}
		else {// create one
			$state =& new LoginState;
			$_SESSION['__LoginState'] =& $state;
		}
			
		// if they are logged in and valid, just return
		if ($state->isValid()) {return $state;}
					
		// first, we need to somehow get the username/passwd pair from the browser,
		// and we're also going to store the URL they were trying to access
		// in the session so we can send them there later.
		
		// first try getting the username/pass from a callback function first.
		if ($this->_usernamePasswordCallbackFunction) {
			$function = $this->_usernamePasswordCallbackFunction;
			$result = $function();
			if (!$result) {
				// if the current action is in the noAuthActions array, return as well.
				if (in_array($this->_harmoni->getCurrentAction(),$this->_noAuthActions))
					return $state;

				// the user didn't enter any info yet -- execute the failed login action
				// first save the current URL in the session
				// @todo -cLoginHandler Implement LoginHandler.execute replace old ID with a new one.
				$_SESSION['__afterLoginURL'] = $_SERVER['REQUEST_URI'];
				$this->_harmoni->setCurrentAction($this->_failedLoginAction);
				return $state;
			}
			$username = $result[0];
			$password = $result[1];

			// pass these values to the AuthenticationHandler
			Services::requireService("Authentication");
			$authHandler =& Services::getService("Authentication");
			$authResult =& $authHandler->authenticateAllMethods($username,$password);

			// save the new LoginState in the session
			$state =& new LoginState($username,$authResult);
			$_SESSION['__LoginState'] =& $state;
			
			// now, if they were valid, everything is honky-dory
			// -- send them to the saved url if its defined
			if ($authResult->isValid()) {
				if ($url = $_SESSION['__afterLoginURL']) {
					unset($_SESSION['__afterLoginURL']);
					$url .= ereg("\?",$url)?"":"?".SID;
					header("Location: $url");
				}
				return $state;
			}
			
			// hmm, they're still not valid. too bad.
			// send them to the failed login action
			
			// but first throw a little error, for kicks... or not.
			$error =& new Error(_("Login failed. Most likely your username or password is incorrect."),"Login",false);
			Services::requireService("UserError");
			$errHandler =& Services::getService("UserError");
			$errHandler->addError($error);

			$this->_harmoni->setCurrentAction($this->_failedLoginAction);
			return $state;
		}
		
		// if we're here, something's very very wrong
		throwError(new Error("LoginHandler::execute() - Could not proceed. 
				There is a configuration problem. No callback function is defined.","Login",true));
	}
	
	/**
	 * Clears all the required session variables so that no login information is
	 * stored any more. Essentially de-authenticates the user from the system.
	 * @access public
	 * @return void
	 **/
	function logout() {
		// essentially, unset the session vars
		unset($_SESSION['__LoginState'],$_SESSION['__afterLoginURL']);
		
		// in case register_globals is on... this is a hack
		if (ini_get("register_globals")) { session_unregister("__LoginState"); session_unregister("__afterLoginURL");}
		
		// if the callback function used HTTP Authentication, we need to
		// tell the browser to clear its username/password cache!
		if ($this->_usernamePasswordCallbackFunction == 'basicHTTPAuthenticationCallback') {
	//		header("HTTP/1.0 401");
		}
		// done;
	}
	
	/**
	 * Sets what action to forward the user to if login fails or they have not yet
	 * logged in and need to.
	 * @param string $action A dotted-pair module.action.
	 * @access public
	 * @return void
	 **/
	function setFailedLoginAction($action) {
		ArgumentValidator::validate($action,new DottedPairValidatorRule);
		$this->_failedLoginAction = $action;
	}
	
	/**
	 * Adds actions to the list of actions for which a user is not REQUIRED to be
	 * authenticated. If authentication is required and the user has not yet logged
	 * in, they are forwarded to the failed login action.
	 * @param string $action1,... A list of actions.
	 * @access public
	 * @return void
	 **/
	function addNoAuthActions($action) {
		if (func_num_args()) {
			for ($i=0; $i<func_num_args(); $i++) {
				$arg = func_get_arg($i);
				ArgumentValidator::validate($arg,new DottedPairValidatorRule);
				$this->_noAuthActions[] = $arg;
			}
		}
	}
	
	/**
	 * Sets the callback function for the LoginHandler to fetch a username/password
	 * pair from the browser. It could, for example, check some $_POST/_GET fields
	 * for the information. The function should either: 1) return FALSE if the user
	 * has not entered anything yet or 2) return a two element array containing first the
	 * username, then the password.
	 * @access public
	 * @return void
	 **/
	function setUsernamePasswordCallbackFunction($functionName) {
		$this->_usernamePasswordCallbackFunction = $functionName;
	}
}

/**
 * This is a call-back function for the {@link LoginHandler}. Essentially, it checks
 * to see if a user has entered HTTP authentication data and returns it if set, 
 * otherwise sends headers to the browser to tell it we need authentication.
 * @package harmoni.architecture.login
 * @access public
 * @return array|false An array containing 0=>username, 1=>password, or false if the user
 * hasn't entered anything yet.
 **/
function basicHTTPAuthenticationCallback() {
	if (!isset($_SERVER['PHP_AUTH_USER'])) {
		header("WWW-Authenticate: Basic realm=\"Harmoni-protected Realm\"");
		header('HTTP/1.0 401 Unauthorized');
		return false;
	} else {
		return array($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);
	}
}


?>