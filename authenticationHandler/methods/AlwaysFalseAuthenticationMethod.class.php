<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");

/**
 * This {@link AuthenticationMethod} is an "always false" wrapper for another method.
 * Upon instantiation, the method is passed another authentication method. All
 * method calls *except* {@link AlwaysFalseAuthenticationMethod::authenticate()} are passed through to that method. 
 * authenticate() will always return false. This is useful if you want to use
 * a method for only fetching agent information and not authentication.
 *
 * @version $Id: AlwaysFalseAuthenticationMethod.class.php,v 1.5 2003/07/06 22:07:41 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler.methodwrappers
 **/
 
class AlwaysFalseAuthenticationMethod extends AuthenticationMethod {
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
		return false;
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
	 * @see {@link AlwaysFalseAuthenticationMethod::setPriority()}
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
	 * @see {@link AlwaysFalseAuthenticationMethod::setAuthoritative()}
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
	 * @see {@link AgentInformationHandlerInterface}
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