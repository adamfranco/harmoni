<?php

/**
 * This AuthenticationMethod is an "always true" wrapper for another method.
 * 
 * This AuthenticationMethod is an "always true" wrapper for another method.
 * Upon instantiation, the method is passed another authentication method. All
 * method calls *except* authenticate() are passed through to that method. 
 * authenticate() will return true if the Agent exists on the targeted system.
 * This method is useful almost SOLELY for demo site purposes. BE CAREFUL USING IT!!!
 *
 * @version $Id: AlwaysTrueAuthenticationMethod.class.php,v 1.2 2003/06/26 21:05:42 adamfranco Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class AlwaysTrueAuthenticationMethod extends AuthenticationMethodInterface {
	/**
	 * @access private
	 * @var object AuthenticationMethod $_methodObject The method being wrapped.
	 **/
	var $_methodObject;
	
	/**
	 * The constructor.
	 * @param object AuthenticationMethod The AuthenticationMethod to wrap.
	 * @access public
	 * @return void
	 **/
	function AlwaysFalseAuthenticationMethod( & $methodObject ) {
		$rule =& new ExtendsValidatorRule("AuthenticationMethodInterface");
		if (!$rule->check($methodObject))
			throw(new Error("AlwaysFalseAuthenticationMethod - could not initialize - the object to be wrapped does not appear to be an AuthenticationMethod.","system",true));
		
		$this->_methodObject =& $methodObject;
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
		return $this->_methodObject->agentExists($systemName);
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
		$this->_methodObject->setPriority($priority);
	}
	
	/**
	 * Returns the priority of this method.
	 * @access public
	 * @see setPriority()
	 * @return integer The priority.
	 **/
	function getPriority() {
		return $this->_methodObject->getPriority();
	}
	
	/**
	 * Set's the authoritative flag for this module.
	 * @param boolean $authoritative If the authoritative flag should be TRUE or FALSE.
	 * @access public
	 * @return void 
	 **/
	function setAuthoritative( $authoritative ) {
		$this->_methodObject->setAuthoritative($authoritative);
	}
	
	/**
	 * Returns if this method is authoritative or not.
	 * @access public
	 * @see setAuthoritative()
	 * @return boolean If the method is authoritative.
	 **/
	function getAuthoritative() {
		return $this->_methodObject->getAuthoritative();
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc)
	 * 
	 * @param string $systemName The system name to get info for.
	 * @access public
	 * @return array An associative array of [key]=>value pairs.  
	 **/
	function getAgentInformation( $systemName ) {
		return $this->_methodObject->getAgentInformation($systemName);
	}
	
	/**
	 * Checks to see if $systemName exists in this method.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		return $this->_methodObject->agentExists($systemName);
	}
	
}

?>