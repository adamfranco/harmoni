<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.interface.php");

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: AuthenticationMethod.abstract.php,v 1.3 2003/06/25 14:41:00 gabeschine Exp $
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
	function authenticate( $systemName, $password ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * @access public
	 * @return string returns the user-defined name/ID of the module
	 **/
	function getName () {
		return $this->_name;
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc)
	 * 
	 * @param string $systemName The system name to get info for.
	 * @access public
	 * @return array An associative array of [key]=>value pairs. 
	 **/
	function getAgentInformation( $systemName ) {
		return array();
	}
	
	/**
	 * Checks to see if $systemName exists in this method.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		return false;
	}
}

?>