<?php

/**
 * The Harmoni interface defines what methods are required of an Harmoni class.
 *
 * The Harmoni class combines the functionality of login, authentication, 
 * action-handling and theme-output. It makes use of the {@link LoginHandler}, {@link AuthenticationHandler} and
 * the {@link ActionHandler} classes.
 * 
 * @package harmoni.architecture
 * @version $Id: Harmoni.interface.php,v 1.1 2003/07/22 14:41:40 gabeschine Exp $
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
	 * Sets the {@link Theme} to use for output to the browser. $themeObject can
	 * be any Theme object that follows the {@link ThemeInterface}.
	 * @access public
	 * @return void
	 **/
	function setTheme($themeObject) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>