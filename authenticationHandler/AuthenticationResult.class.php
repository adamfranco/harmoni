<?php

require_once(HARMONI.'authenticationHandler/AuthenticationResult.interface.php');

/**
 * The AuthenticationResult holds a list of valid AuthenticationMethods from an AuthenticationHandler.
 * 
 * The AuthenticationResult is passed a list of valid AuthenticationMethod names
 * and stores it for user retreival.
 * @see AuthenticationMethodInterface
 * @see AuthenticationHandlerInterface
 * @package harmoni.authenticationHandler
 * @version $Id: AuthenticationResult.class.php,v 1.2 2003/06/26 20:47:26 adamfranco Exp $
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
	 * @return void
	 **/
	function AuthenticationResult( $validMethods ) {
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
	
}

?>