<?php
/**
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.10 2005/04/07 19:42:13 adamfranco Exp $
 */ 
 
require_once(dirname(__FILE__)."/AuthNMethod.abstract.php");
require_once(dirname(__FILE__)."/LDAPConnector.class.php");

/**
 * The LDAPAuthNMethod is used to authenticate against an LDAP system.
 * 
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.10 2005/04/07 19:42:13 adamfranco Exp $
 */
class LDAPAuthNMethod
	extends AuthNMethod
{

	/**
	 * Stores the configuration. Calls the parent configuration first,
	 * then does additional operations.
	 * 
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 3/24/05
	 */
	function assignConfiguration ( &$configuration ) {
		parent::assignConfiguration($configuration);
		
		$this->_connector =& new LDAPConnector($configuration);
		$this->_configuration->addProperty('connector', $this->_connector);
		
		// Validate the configuration options we use:
		ArgumentValidator::validate (
			$this->_configuration->getProperty('properties_fields'), 
			ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule()));
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
		
		$validatorRule = ExtendsValidatorRule::getRule('LDAPAuthNTokens');
		if ($validatorRule->check($newTokens))
			return $newTokens;
		else
			throwError( new Error("Configuration Error: tokens_class, '".$tokensClass."' does not extend UsernamePasswordAuthNTokens.",
									 "LDAPAuthNMethod", true));
		
	}
	
	/**
	 * Authenticate an AuthNTokens object
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticateTokens ( &$authNTokens ) {
		ArgumentValidator::validate ($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		return $this->_connector->authenticateDN($authNTokens->getUsername(), 
			$authNTokens->getPassword());
	}
	
	/**
	 * Return true if the tokens can be matched in the system.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function tokensExist ( &$authNTokens ) {
		ArgumentValidator::validate ($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		return $this->_connector->dnExists($authNTokens->getUsername());
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
		ArgumentValidator::validate ($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		ArgumentValidator::validate ($properties, ExtendsValidatorRule::getRule("Properties"));
		
		$propertiesFields =& $this->_configuration->getProperty('properties_fields');
		
		if (!is_array($propertiesFields) || !count($propertiesFields))
			return;
		
		$fieldsToFetch = array();
		foreach ($propertiesFields as $propertyKey => $fieldName) {
			$fieldsToFetch[] = $fieldName;
		}
		
		$info = $this->_connector->getInfo($authNTokens->getUsername(), $fieldsToFetch);
		
		if ($info) {
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$properties->addProperty($propertyKey, $info[$fieldName]);
			}	
		} else
			return;
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
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());
		$propertiesFields =& $this->_configuration->getProperty('properties_fields');
				
		if (is_array($propertiesFields) && count($propertiesFields)) {
					
			$filter = "(|";
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$filter .= " (".$fieldName."=".$searchString.")";
			}
			$filter .= ")";
			
			$dns = $this->_connector->getDNsBySearch($filter);
		} else 
			$dns = array();

		$tokens = array();
		foreach ($dns as $dn) {
			$tokens[] =& $this->createTokensForIdentifier($dn);
		}
		
		return new HarmoniObjectIterator($tokens);
	}
}

?>