<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");

/**
 * This {@link AuthenticationMethod} is an "always true" wrapper for another method.
 * Upon instantiation, the method is passed another authentication method. All
 * method calls *except* authenticate() are passed through to that method. 
 * {@link AlwaysTrueAuthenticationMethod::authenticate()} will return true if the Agent exists on the targeted system.
 * This method is useful almost SOLELY for demo site purposes. BE CAREFUL USING IT!!!
 *
 * @package harmoni.authentication.methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AlwaysTrueAuthenticationMethod.class.php,v 1.5 2005/02/04 15:58:59 adamfranco Exp $
 **/
 
class AlwaysTrueAuthenticationMethod extends AuthenticationMethod {
	/**
	 * The constructor.
	 * @param object AuthenticationMethod The AuthenticationMethod to wrap.
	 * @access public
	 * @return void
	 **/
	function AlwaysTrueAuthenticationMethod() {
		return;
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
		return true;
	}
	
	/**
	 * Sets this method's priority to $priority.
	 * 
	 * The priority is an integer value, the lower the value the *higher* the priority.
	 * It is referenced in order to decide which methods are used to authenticate first,
	 * and then which methods have override others when fetching agent information,
	 * such as a user's email or full name. Authoritative methods override the priority setting,
	 * however if more than one method is authoritative, the priority setting 
	 * will be checked to see which to use first.
	 * @param integer $priority The priority setting - lower is high priority.
	 * @access public
	 * @return void 
	 **/
	function setPriority( $priority ) {
		return;
	}
	
	/**
	 * Returns the priority of this method.
	 * @access public
	 * @see AlwaysTrueAuthenticationMethod::setPriority()
	 * @return integer The priority.
	 **/
	function getPriority() {
		return 100;
	}
	
	/**
	 * Set's the authoritative flag for this module.
	 * @param boolean $authoritative If the authoritative flag should be TRUE or FALSE.
	 * @access public
	 * @return void 
	 **/
	function setAuthoritative( $authoritative ) {
		return;
	}
	
	/**
	 * Returns if this method is authoritative or not.
	 * @access public
	 * @see AlwaysTrueAuthenticationMethod::setAuthoritative()
	 * @return boolean If the method is authoritative.
	 **/
	function getAuthoritative() {
		return false;
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
		return true;
	}
	
}

?>