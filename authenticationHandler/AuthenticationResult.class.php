<?php

require_once(HARMONI.'authenticationHandler/AuthenticationResult.interface.php');

/**
 * The AuthenticationResult holds a list of valid AuthenticationMethods from an AuthenticationHandler.
 * 
 * The AuthenticationResult is passed a list of valid AuthenticationMethod names
 * and stores it for user retreival.
 * @package harmoni.authentication
 * @version $Id: AuthenticationResult.class.php,v 1.6 2003/07/15 16:12:18 gabeschine Exp $
 * @copyright 2003 
 **/
class AuthenticationResult extends AuthenticationResultInterface {
	/**
	 * @access private
	 * @var array $_validMethods A list of valid methods.
	 **/
	var $_validMethods;
	
	/**
	 * @access private
	 * @var boolean $_isValid If we have at least one valid method.
	 **/
	var $_isValid;

	/**
	 * @access private
	 * @var string $_systemName The system name to whom this result applies.
	 **/
	var $_systemName;
		
	/**
	 * Returns if this result holds any valid AuthenticationMethods.
	 * @access public
	 * @return boolean If we have valid methods.
	 **/
	function isValid() {
		return $this->_isValid;
	}
	
	/**
	 * The constructor.
	 * @param array $validMethods An array of method names that validated successfully.
	 * @access public
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationHandlerInterface}
	 * @return void
	 **/
	function AuthenticationResult( $systemName, $validMethods ) {
		$this->_systemName = $systemName;
		if (!is_array($validMethods)) $validMethods = array();
		$this->_validMethods = $validMethods;
		$this->_isValid = (count($validMethods))? true : false ;
	}
	
	
	/**
	 * Returns if the authentication was valid in $methodName.
	 * @access public
	 * @return boolean True if valid.
	 **/
	function validInMethod( $methodName ) {
		return in_array($methodName,$this->_validMethods);
	}
	
	/**
	 * Returns the number of methods where authentication was successful.
	 * @access public
	 * @return integer The number of valid methods.
	 **/
	function getValidMethodCount() {
		return count($this->_validMethods);
	}
	
	/**
	 * Returns an array of the names of all valid AuthenticationMethods.
	 * @access public
	 * @return array An array of valid methods.
	 **/
	function getValidMethods() {
		return $this->_validMethods;
	}
	
	/**
	 * Returns the system name of the agent for whom this result applies.
	 * @access public
	 * @return string The system name (eg, user name).
	 **/
	function getSystemName() {
		return $this->_systemName;
	}
}

?>