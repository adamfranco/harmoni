<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.interface.php");

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: AuthenticationMethod.abstract.php,v 1.6 2003/06/27 02:59:37 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class AuthenticationMethod
	extends AuthenticationMethodInterface 
{
	/**
	 * @access private
	 * @var string $_name the AuthenticationMethod's unique identifyer string
	 */
	var $_name;

	/**
	 * The method's priority setting.
	 * @see setPriority()
	 * @access private
	 * @var integer $_priority
	 **/
	var $_priority;
	
	/**
	 * A boolean defining if this method is an authoritative method.
	 * @see setAuthoritative()
	 * @access private
	 * @var boolean $_authoritative
	 **/
	var $_authoritative = false;
	
	/**
	 * Sets this method's priority to $priority.
	 * 
	 * The priority is an integer value, the lower the value the *higher* the priority.
	 * It is referenced in order to decide which methods are used to authenticate first,
	 * and then which methods have override others when fetching agent information,
	 * such as a user's email or full name. Authoritative methods override the priority setting,
	 * however if more than one method is authoritative, the priority setting 
	 * will be checked to see which to use first.
	 * @see AuthenticationHandler
	 * @see AgentInformationHandler
	 * @param integer $priority The priority setting - lower is high priority.
	 * @access public
	 * @return void 
	 **/
	function setPriority( $priority ) {
		if (is_integer($priority)) $this->_priority = $priority;
	}
	
	/**
	 * Returns the priority of this method.
	 * @access public
	 * @see setPriority()
	 * @return integer The priority.
	 **/
	function getPriority() {
		return $this->_priority;
	}
	
	/**
	 * Set's the authoritative flag for this module.
	 * @param boolean $authoritative If the authoritative flag should be TRUE or FALSE.
	 * @access public
	 * @return void 
	 **/
	function setAuthoritative( $authoritative ) {
		if (is_bool($authoritative)) $this->_authoritative = $authoritative;
	}
	
	/**
	 * Returns if this method is authoritative or not.
	 * @access public
	 * @see setAuthoritative()
	 * @return boolean If the method is authoritative.
	 **/
	function getAuthoritative() {
		return $this->_authoritative;
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