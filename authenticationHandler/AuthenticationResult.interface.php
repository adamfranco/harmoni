<?php

/**
 * The AuthenticationResult interface defines the methods required for an AuthenticationResult class or child.
 * 
 * The AuthenticationResult is passed a list of valid AuthenticationMethod names
 * and stores it for user retreival.
 * @package harmoni.interfaces.authentication
 * @version $Id: AuthenticationResult.interface.php,v 1.6 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class AuthenticationResultInterface {
	/**
	 * Returns if this result holds any valid AuthenticationMethods.
	 * @access public
	 * @return boolean If we have valid methods.
	 **/
	function isValid() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if the authentication was valid in $methodName.
	 * @access public
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationHandlerInterface}
	 * @return boolean True if valid.
	 **/
	function validInMethod( $methodName ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the number of methods where authentication was successful.
	 * @access public
	 * @return integer The number of valid methods.
	 **/
	function getValidMethodCount() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an array of the names of all valid AuthenticationMethods.
	 * @access public
	 * @return array An array of valid methods.
	 **/
	function getValidMethods() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the system name of the agent for whom this result applies.
	 * @access public
	 * @return string The system name (eg, user name).
	 **/
	function getSystemName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>