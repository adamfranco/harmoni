<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNMethod.abstract.php,v 1.3 2005/03/04 22:22:45 adamfranco Exp $
 */ 

/**
 * An AuthNMethod is an abstract class that corresponds to a method of 
 * authenticating Agents. It deals with verifying the tokens passed to it and
 * authenticating them. AuthNMethods do not keep track of any authentication
 * state information. They simply provide a means of querying stores of information
 * to determine if tokens are valid or not.
 *
 * AuthNMethods deal with two types of tokens. The first are arbitrary data that
 * is passed by the user trying to authenticate. This data may be an array with
 * elements for 'username' and 'password', it might be a string operated on by a
 * private key, it might be a Kerberos Ticket, or pretty much anything else. It is
 * up to a given AuthNMethod to pass the tokens passed to it to appropriate 
 * AuthNTokens objects for the handling of this data. AuthNTokens objects provide
 * access to a string 'identifier' for given tokens data that can be used by
 * other systems to identify this set of tokens. Additionally, the AuthNTokens
 * objects can be initialized with an identifier and then passed to the authentication
 * method for querying on the existance or associated properties of the user
 * that corresponds to the identifier.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNMethod.abstract.php,v 1.3 2005/03/04 22:22:45 adamfranco Exp $
 */
class AuthNMethod {
	
	/**
	 * Constructor. Stores the configuration.
	 * 
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 3/1/05
	 */
	function AuthNMethod ( &$configuration ) {
		$this->_configuration =& $configuration;
	}
	
	/**
	 * Set the Type of this AuthNMethod. This should only be used by the 
	 * AuthNMethod manager, not classes outside of this package.
	 * 
	 * @param object Type
	 * @return void
	 * @access protected
	 * @since 3/2/05
	 */
	function setType ( &$type ) {
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"));
		$this->_type =& $type;
	}
	
	/**
	 * Return the Type of this AuthNMethod
	 * 
	 * @return object Type
	 * @access public
	 * @since 3/1/05
	 */
	function getType () {
		return $this->_type;
	}
	
	
	/**
	 * Create a Tokens Object
	 * 
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function createTokensObject () {
		$tokensClass = $this->_configuration->getProperty('tokens_class');
		$newTokens =& new $tokensClass($this->_configuration);
		
		$validatorRule = new ExtendsValidatorRule('AuthNTokens');
		if ($validatorRule->check($newTokens))
			return $newTokens;
		else
			throwError( new Error("Configuration Error: tokens_class, '".$tokensClass."' does not extend AuthNTokens.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Create a Tokens object that provides common access to the contents
	 * of the tokens passed to the system by the user or returned from the
	 * underlying system.
	 * 
	 * @param mixed $tokens
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function &createTokens ($tokens) {
		$tokensObject =& $this->createTokensObject();
		$tokensObject->initializeForTokens($tokens);
		return $tokensObject;
	}
	
	/**
	 * Create a Tokens object for a given identifier. An identifier is often a
	 * username, but does not have to be as long as it is a string unique within this 
	 * authentication method.
	 * 
	 * @param string $identifier
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function &createTokensForIdentifier ( $identifier ) {
		$tokensObject =& $this->createTokensObject();
		$tokensObject->initializeForIdentifier($identifier);
		return $tokensObject;
	}
	
	/**
	 * Authenticate a agent tokens
	 * 
	 * @param mixed $tokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticate ( $tokens ) {
		return $this->authenticateTokens($this->createTokens($tokens));
	}
	
	/**
	 * Authenticate a Tokens object
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticateTokens ( &$authNTokens ) {
		throwError( new Error("AuthNMethod::authenticate() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return true if the tokens can be matched in the system.
	 * 
	 * @param mixed $tokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function exists ( &$tokens ) {
		return $this->tokensExist($this->createTokens($tokens));
	}
	
	/**
	 * Return true if the AuthNTokens can be matched in the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function tokensExist ( &$authNTokens ) {
		throwError( new Error("AuthNMethod::authenticate() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return Properties associated with the tokens. The properties will have
	 * the AuthNMethod Type as their Type. One Property that should always be
	 * included is 'identifier' which corresponds to the identifier for the tokens.
	 * 
	 * @param mixed $tokens
	 * @return object Properties
	 * @access public
	 * @since 3/1/05
	 */
	function &getProperties ( $tokens ) {
		return $this->getPropertiesForTokens($this->createTokens($tokens));
	}
	
	/**
	 * Return Properties associated with the Tokens. The properties will have
	 * the AuthNMethod Type as their Type. One Property that should always be
	 * included is 'identifier' which corresponds to the identifier for the tokens
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return object Properties
	 * @access public
	 * @since 3/1/05
	 */
	function &getPropertiesForTokens ( &$authNTokens ) {
		ArgumentValidator::validate($authNTokens, new ExtendsValidatorRule("AuthNTokens"));
		$properties =& new HarmoniProperties($this->getType());

		// Properties take values by reference, so we have to work around
		// that by creating/unsetting variables.
		$value = $authNTokens->getIdentifier();
		$properties->addProperty('identifier', $value);
		unset($value);
		
		$this->_populateProperties( $authNTokens, $properties );
		return $properties;
	}
	
	/**
	 * A private method used to populate the Properties that correspond to the
	 * given AuthNTokens
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Properties $properties
	 * @return void
	 * @access private
	 * @since 3/1/05
	 */
	function _populateProperties ( &$authNTokens, &$properties ) {
		throwError( new Error("AuthNMethod::_populateProperties() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Get an iterator of the AuthNTokens that match the search string passed.
	 * The '*' wildcard character can be present in the string and will be
	 * converted to the system wildcard for the AuthNMethod if wildcards are
	 * supported or removed (and the exact string searched for) if they are not
	 * supported.
	 *
	 * When multiple fields are searched on an OR search is performed, i.e.
	 * '*ach*' would match username/fullname 'achapin'/'Chapin, Alex' as well as
	 *  'zsmith'/'Smith, Zach'.
	 * 
	 * @param string $searchString
	 * @return object ObjectIterator
	 * @access public
	 * @since 3/3/05
	 */
	function &getTokensBySearch ( $searchString ) {
		throwError( new Error("AuthNMethod::getTokensBySearch() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return TRUE if this method supports token addition.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenAddition () {
		// Override if implementing
		return FALSE;
	}
	
	/**
	 * Add tokens to the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function addTokens ( &$authNTokens ) {
		throwError( new Error("AuthNMethod::addTokens() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return TRUE if this method supports token deletion.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenDeletion () {
		// Override if implementing
		return FALSE;
	}
	
	/**
	 * Add tokens and associated Properties to the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function deleteTokens ( &$authNTokens ) {
		throwError( new Error("AuthNMethod::deleteTokens() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return TRUE if this method supports token updates.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsTokenUpdates () {
		// Override if implementing
		return FALSE;
	}
	
	/**
	 * Update old tokens to new tokens in the system.
	 * 
	 * @param object AuthNTokens $oldAuthNTokens
	 * @param object AuthNTokens $newAuthNTokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function updateTokens ( &$oldAuthNTokens, &$newAuthNTokens ) {
		throwError( new Error("AuthNMethod::updateTokens() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
	
	/**
	 * Return TRUE if this method supports property updates.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function supportsPropertyUpdates () {
		// Override if implementing
		return FALSE;
	}
	
	/**
	 * Update the properties for the given tokens
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Properties $newProperties
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function updatePropertiesForTokens ( &$authNTokens, &$newProperties ) {
		throwError( new Error("AuthNMethod::updateTokens() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
}

?>