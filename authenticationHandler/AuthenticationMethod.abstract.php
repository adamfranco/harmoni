<?php

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: AuthenticationMethod.abstract.php,v 1.2 2003/06/24 18:27:46 dobomode Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class AuthenticationMethod
	extends AuthenticationMethodInterface 
{
	/**
	 * @var string $_name the AuthenticationMethod's unique identifyer string
	 */
	var $_name;

	/**
	 * authenticate will check a systemName/password pair against the defined method
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) {}
	
	/**
	 * @access public
	 * @return string returns the user-defined name/ID of the module
	 **/
	function getName () {
		return $this->_name;
	}
	
}

?>