<?php

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: DBAuthenticationMethod.class.php,v 1.1 2003/06/23 13:22:53 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class DBAuthenticationMethod
	extends AuthenticationMethod 
{
	
	/**
	 * the constructor
	 *
	 * @param string $name the unique name for this module
	 * @param object FieldSet $options a FieldSet object with all the necessary options for this module
	 * @access public
	 * @return void
	 **/
	function DBAuthenticationMethod ( $name, & $options ) {
		$this->_name = $name;
		
		// parse the options
		// @todo -cDBAuthenticationMethod constructor - parse the options
	}

	/**
	 * authenticate will check a systemName/password pair against the defined method
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) {
		// @todo -cDBAuthenticationMethod implement authenticate to contact the DB, etc
	}
	
}

?>