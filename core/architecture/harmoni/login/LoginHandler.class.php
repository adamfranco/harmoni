<?php

//require_once(HARMONI."architecture/harmoni/login/LoginHandler.interface.php");

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
 * @version $Id: LoginHandler.class.php,v 1.18 2004/08/06 14:23:56 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginHandler {
	/**
	 * @access private
	 * @var string $_failedLoginAction The action to execute if login fails.
	 **/
	var $_failedLoginAction;
	
	/**
	 * @access private
	 * @var object $_failedLoginError The to throw if login fails.
	 **/
	var $_failedLoginError;

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
	 * @var string $_promptCallbackFunction The name of a user-defined
	 * function to prompt the browser for a username/password pair.
	 **/
	var $_promptCallbackFunction;
	
	/**
	 * @access private
	 * @var string $_collectionCallbackFunction The name of a user-defined
	 * function to collect a username/password pair from the environment.
	 **/
	var $_collectionCallbackFunction;
	
	/**
	 * @access private
	 * @var boolean $_failedLogin specifies if the login process failed or not
	 */
	var $_failedLogin;
	
	/**
	 * The constructor.
	 * @param ref object $harmoniObject
	 * @access public
	 * @return void
	 **/
	function LoginHandler(&$harmoniObject) {
		$this->_harmoni =& $harmoniObject;
		$this->_promptCallbackFunction = "basicHTTPAuthPromptCallback";
		$this->_collectionCallbackFunction = "basicHTTPAuthCollectionCallback";
		$this->_failedLogin = false;
		$this->_failedLoginError = null;
	}
	
	/**
	 * Checks the action passed to see if it requires authentication or not.
	 * @return boolean
	 * @access public
	 */
	function actionRequiresAuthentication($pair) {
		if (in_array($pair, $this->_noAuthActions)) return false;
		if (!$pair) return false;
		// this checks if we have a noAuthAction set to "module.*", meaning any action
		// within it is a-OK.
		if (in_array(ereg_replace("\..*$","\.\*",$pair), $this->_noAuthActions)) return false;
		return true;
	}
	
	/**
	 * Returns the failedLoginAction.
	 * @return string
	 */
	function getFailedLoginAction() { return $this->_failedLoginAction; }
	
	/**
	 * Sets the error to throw on login failure. If none is specified, none will be thrown.
	 * @return void
	 */
	function setFailedLoginError(&$error) {
		ArgumentValidator::validate($error, new ExtendsValidatorRule("ErrorInterface"));
		$this->_failedLoginError =& $error;
	}
	
	/**
	 * Executes the LoginHandler. The process followed goes: Check the session
	 * for a saved LoginState and load it if found, otherwise check the HTTP
	 * variables for a login/passwd and execute those with the {@link AuthenticationHandler}. If
	 * this fails, FALSE is returned.
	 * @access public
	 * @return object|false Returns a {@link LoginState} object or FALSE on failure.
	 **/
	function & execute($forceAuthCheck = FALSE) {
		// do we have a failedLoginAction?
		if (!$this->_failedLoginAction) {
			throwError(new Error("LoginHandler::execute() - could not proceed 
					because no failedLoginAction has been set!","Login",true));
			return false;
		}
		
		// first let's check if a LoginState has been saved in the session
		if (isset($_SESSION['__LoginState'])) {
			$state =& $_SESSION['__LoginState'];
		}
		else {// create one
			$state =& new LoginState;
			$_SESSION['__LoginState'] =& $state;
		}
		
		// if they are logged in and valid, or we've already executed, just return
		if ($state->isValid()) {
			debug::output("Returning valid login state.",8,"LoginHandler");
			return $state;
		}
					
		//-----------------------------------------------------
		// If they are not already logged in, do the login sequence if needed
		
		
		//---------------
		// Collect any auth tokens from the browser.
		$collectionFunction = $this->_collectionCallbackFunction;
		
		debug::output("Executing Collection callback function",8,"LoginHandler");
		
		$result = $collectionFunction($this->_harmoni);
		
		//---------------
		// If we don't have tokens and we need them (AuthReq action, forceAuthCheck, etc), prompt for login
		if ( !$result && ($this->actionRequiresAuthentication($this->_harmoni->getCurrentAction()) || $forceAuthCheck)) {
			$promptFunction = $this->_promptCallbackFunction;
			
			debug::output("Executing Prompt callback function",8,"LoginHandler");
			
			$promptFunction($this->_harmoni);
			
			// Try grabbing the result incase the prompt function hasn't
			// halted the execution of this method.
			$result = $collectionFunction($this->_harmoni);
		

		//---------------
		// Otherwise (if we don't have and don't need tokens) return the current state.
		} else if (!$result) {
			return $state;
		}
		
		//---------------
		// If we have tokens, authenticate with them whether or not 
		// we need to force an auth check.
		if ($result) {
			
			$username = $result[0];
			$password = $result[1];

			// pass these values to the AuthenticationHandler
			$authHandler =& Services::requireService("Authentication");
			$authResult =& $authHandler->authenticateAllMethods($username,$password);

// 			debug::output("Authenticating with username/password, '$username'/'$password'.
// 			AuthResult: ".printpre($authResult, TRUE)."
// 			AuthResultValid? ".(($authResult->isValid())?"TRUE":"FALSE"),8,"LoginHandler");

			// save the new LoginState in the session
			$state =& new LoginState($username,$authResult);
			$_SESSION['__LoginState'] =& $state;

			//---------------
			// If the tokens authenticate, send the user on their way
			if ($authResult->isValid()) {
			
				debug::output("LoginHandler authentication succeeded.",8,"LoginHandler");
			
				// If they want to leave, send them
				if ($url = $_SESSION['__afterLoginURL']) {
					debug::output("Forwarding to url: $url",8,"LoginHandler");
					
					unset($_SESSION['__afterLoginURL']);
					
					if (!$this->_harmoni->config->get("sessionUseCookies")) 
						$url .= (ereg("\?",$url)?"&":"?").SID;
						
					header("Location: $url");
				
				// otherwise, let them stay
				} else {	
					return $state;
				}
			
			
			//---------------
			// If the tokens don't authenticate, send the user to the failed-login action
			} else {
				
				debug::output("LoginHandler authentication failed. Sending to Failed-Login-Action, ".$this->_failedLoginAction,8,"LoginHandler");
				
				$_SESSION['__afterLoginURL'] = $_SERVER['REQUEST_URI'];
				
				$this->_failedLogin = true;
				$this->_harmoni->setCurrentAction($this->_failedLoginAction);
				return $state;
			}
		
		
		// If we don't have tokens at this point, it is because the user was
		// prompted, but didn't submit any tokens.
		} else {
// 			$this->_harmoni->setCurrentAction($this->_failedLoginAction);
// 			$this->_harmoni->ActionHandler->executePair();
 			throwError(new Error("LoginHandler::execute() - Could not proceed. 
 				it is probably because the user was prompted, but didn't submit 
 				any tokens.","Login",true));
		}
	}
	
	/**
	 * Returns TRUE if the login process failed. FALSE otherwise.
	 * @return boolean
	 * @access public
	 */
	function loginFailed() { return $this->_failedLogin; }
	
	/**
	 * Clears all the required session variables so that no login information is
	 * stored any more. Essentially de-authenticates the user from the system.
	 * @access public
	 * @return void
	 **/
	function logout() {
		// first invalidated the current state.
		$state =& $_SESSION['__LoginState'];
		if ($state)
			$state->nullify();
		unset($state);
		
		// essentially, unset the session vars
		unset($_SESSION['__LoginState'],$_SESSION['__afterLoginURL']);
		
		// in case register_globals is on... this is a hack
		if (ini_get("register_globals")) { session_unregister("__LoginState"); session_unregister("__afterLoginURL");}
		
		// if the callback function used HTTP Authentication, we need to
		// tell the browser to clear its username/password cache!
		if ($this->_promptCallbackFunction == 'basicHTTPAuthPromptCallback') {
			header("HTTP/1.0 401");		
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
	 * Sets the callback function for the LoginHandler to prompt for a username/password
	 * pair from the browser. It could, for example, send a 401 HTTP headers to prompt
	 * for an HTTP Login
	 * @access public
	 * @return void
	 **/
	function setPromptCallbackFunction($functionName) {
		$this->_promptCallbackFunction = $functionName;
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
	function setCollectionCallbackFunction($functionName) {
		$this->_collectionCallbackFunction = $functionName;
	}
}

/**
 * This is a LoginPrompt call-back function for the {@link LoginHandler}. Essentially it
 * sends headers to the browser to tell it we need authentication.
 * @package harmoni.architecture.login
 * @param ref object $harmoni A reference to the governing {@link Harmoni} object.
 * @access public
 * @return void
 */
function basicHTTPAuthPromptCallback(&$harmoni) {
		debug::output("Asking for user credentials.",8,"basicHTTPAuthPromptCallback");

		header("WWW-Authenticate: Basic realm=\"Harmoni-protected Realm\"");
		header('HTTP/1.0 401 Unauthorized');
}

/**
 * This is a LoginCollection call-back function for the {@link LoginHandler}. Essentially, it checks
 * to see if a user has entered HTTP authentication data and returns it if set.
 * @package harmoni.architecture.login
 * @param ref object $harmoni A reference to the governing {@link Harmoni} object.
 * @access public
 * @return array|false An array containing 0=>username, 1=>password, or false if the user
 * hasn't entered anything yet.
 **/
function basicHTTPAuthCollectionCallback(&$harmoni) {
		debug::output("Checking for user credentials.",8,"basicHTTPAuthCollectionCallback");

	if (isset($_SERVER['PHP_AUTH_USER'])) {
 		debug::output("Using stored user credentials.", 8, "basicHTTPAuthenticationCallback");

 		return array($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);
 	} else {
 		debug::output("No user credentials availible.", 8, "basicHTTPAuthenticationCallback");

 		return FALSE;
 	}
}


?>