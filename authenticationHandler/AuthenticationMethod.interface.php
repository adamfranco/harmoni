<?php

/**
 * defines the methods that are required for any authenticationMethod
 *
 * @version $Id: AuthenticationMethod.interface.php,v 1.3 2003/06/23 20:42:34 adamfranco Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class AuthenticationMethodInterface {
	/**
	 * authenticate will check a systemName/password pair against the defined method
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * @access public
	 * @return string/int returns the user-defined name or ID of the module
	 **/
	function getName () { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
}

?>