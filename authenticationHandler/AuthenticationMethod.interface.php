<?php

/**
 * defines the methods that are required for any authenticationMethod
 *
 * @version $Id: AuthenticationMethod.interface.php,v 1.1 2003/06/22 23:06:56 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class AuthenticationMethodInterface {
	/**
	 * validate will check a systemName/password pair against the defined method
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return void 
	 **/
	function validate( $systemName, $password ) {}
	
}

?>