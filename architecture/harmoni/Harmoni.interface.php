<?php

/**
 * The Harmoni interface defines what methods are required of an Harmoni class.
 *
 * The Harmoni class combines the functionality of login, authentication, 
 * action-handling and theme-output. It makes use of the {@link LoginHandler}, {@link AuthenticationHandler} and
 * the {@link ActionHandler} classes.
 * 
 * @package harmoni.architecture
 * @version $Id: Harmoni.interface.php,v 1.4 2003/07/25 00:53:43 gabeschine Exp $
 * @copyright 2003 
 **/
class HarmoniInterface {
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Executes the Harmoni procedures: login handling and authenticating, action
	 * processing and themed output to the browser. Certain options must be 
	 * set before execute() can be called.
	 * @access public
	 * @return void
	 **/
	function execute() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets the {@link ThemeInterface Theme} to use for output to the browser. $themeObject can
	 * be any Theme object that follows the {@link ThemeInterface}.
	 * @param ref object A {@link ThemeInterface Theme} object.
	 * @access public
	 * @return void
	 **/
	function setTheme(&$themeObject) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the current theme object.
	 * @access public
	 * @return ref object A {@link ThemeInterface Theme} object.
	 **/
	function &getTheme() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	
	/**
	 * Returns the current action.
	 * @access public
	 * @return string A dotted-pair action.
	 **/
	function getCurrentAction() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets the current Harmoni action.
	 * @param string $action A dotted-pair action string.
	 * @access public
	 * @return void
	 **/
	function setCurrentAction($action) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Starts the session.
	 * @access public
	 * @return void
	 **/
	function startSession() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	
}

?>