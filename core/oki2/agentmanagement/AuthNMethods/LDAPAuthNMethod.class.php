<?php
/**
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.20 2008/02/06 15:37:47 adamfranco Exp $
 */ 
 
require_once(dirname(__FILE__)."/AuthNMethod.abstract.php");
require_once(dirname(__FILE__)."/LDAPConnector.class.php");
require_once(dirname(__FILE__)."/LDAPGroup.class.php");

/**
 * The LDAPAuthNMethod is used to authenticate against an LDAP system.
 * 
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.20 2008/02/06 15:37:47 adamfranco Exp $
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
	function assignConfiguration ( Properties $configuration ) {
		parent::assignConfiguration($configuration);
		
		$this->_connector = new LDAPConnector($configuration);
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
		$newTokens = new $tokensClass($this->_configuration);
		
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
	function authenticateTokens ( $authNTokens ) {
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
	function tokensExist ( $authNTokens ) {
		ArgumentValidator::validate ($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		return $this->_connector->userDNExists($authNTokens->getUsername());
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
	function _populateProperties ( $authNTokens, $properties ) {
		ArgumentValidator::validate ($authNTokens, ExtendsValidatorRule::getRule("AuthNTokens"));
		ArgumentValidator::validate ($properties, ExtendsValidatorRule::getRule("Properties"));
		
		$propertiesFields =$this->_configuration->getProperty('properties_fields');
		
		if (!is_array($propertiesFields) || !count($propertiesFields))
			return;
		
		$fieldsToFetch = array();
		foreach ($propertiesFields as $propertyKey => $fieldName) {
			$fieldsToFetch[] = $fieldName;
		}
		
		$info = $this->_connector->getInfo($authNTokens->getUsername(), $fieldsToFetch);
		
		if ($info) {
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				if (isset($info[$fieldName])) {
					if (count($info[$fieldName]) <= 1)
						$properties->addProperty($propertyKey, $info[$fieldName][0]);
					else
						$properties->addProperty($propertyKey, $info[$fieldName]);
				}
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
	function getTokensBySearch ( $searchString ) {
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());
		$propertiesFields =$this->_configuration->getProperty('properties_fields');
				
		if (is_array($propertiesFields) && count($propertiesFields)) {
					
			$filter = "(|";
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$filter .= " (".$fieldName."=".$searchString.")";
			}
			$filter .= ")";
			
			$dns = $this->_connector->getUserDNsBySearch($filter);
		} else 
			$dns = array();

		$tokens = array();
		foreach ($dns as $dn) {
			$tokens[] =$this->createTokensForIdentifier($dn);
		}
		
		$obj = new HarmoniObjectIterator($tokens);
		
		return $obj;
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
	function getGroupTokensBySearch ( $searchString ) {
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());
		$propertiesFields =$this->_configuration->getProperty('properties_fields');
				
		if (is_array($propertiesFields) && count($propertiesFields)) {
					
			$filter = "(|";
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$filter .= " (".$fieldName."=".$searchString.")";
			}
			$filter .= ")";
			
			$dns = $this->_connector->getGroupDNsBySearch($filter);
		} else 
			$dns = array();

		$tokens = array();
		foreach ($dns as $dn) {
			$tokens[] =$this->createTokensForIdentifier($dn);
		}
		
		$obj = new HarmoniObjectIterator($tokens);
		
		return $obj;
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
	function getClassTokensBySearch ( $searchString ) {
		ArgumentValidator::validate ($searchString, StringValidatorRule::getRule());
		$propertiesFields =$this->_configuration->getProperty('properties_fields');
				
		if (is_array($propertiesFields) && count($propertiesFields)) {
					
			$filter = "(|";
			foreach ($propertiesFields as $propertyKey => $fieldName) {
				$filter .= " (".$fieldName."=".$searchString.")";
			}
			$filter .= ")";
			
			$dns = $this->_connector->getClassesDNsBySearch($filter);
		} else 
			$dns = array();

		$tokens = array();
		foreach ($dns as $dn) {
			$tokens[] =$this->createTokensForIdentifier($dn);
		}
		
		$obj = new HarmoniObjectIterator($tokens);
		
		return $obj;
	}
		

	
		
	
/*********************************************************
 * 	Directory methods
 *********************************************************/
	
	/**
	 * Answer TRUE if this AuthN method supports directory functionality
	 * 
	 * @return boolean
	 * @access public
	 * @since 2/23/06
	 */
	function supportsDirectory () {
		// Override if implementing
		return TRUE;
	}
	
	/**
	 * Answer an iterator of all groups
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getAllGroups () {
		return $this->getRootGroups();
	}
	
	/**
	 * Answer an iterator of the top-level groups, may be equivalent to 
	 * getAllGroups() if this directory is not hierarchically organized.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getRootGroups () {
		if (!isset($this->_rootGroups)) {
			$connector =$this->_configuration->getProperty('connector');
			$groupDN = $this->_configuration->getProperty("GroupBaseDN");
			
			$filter = "(objectclass=*)";
			$dns = $connector->getDNsByList($filter, $groupDN);
			
			$this->_rootGroups = array();
			foreach ($dns as $dn) {
				if ($dn != $groupDN)
					$this->_rootGroups[] = new LDAPGroup($dn, $this->getType(), 
										$this->_configuration, 
										$this);
			}
		}
        $iterator = new HarmoniIterator($this->_rootGroups);
        return $iterator;
	}
	
	/**
	 * Answer a group by Id
	 * 
	 * @param object Id $id
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getGroup ( $id ) {
		$group = new LDAPGroup($id->getIdString(), $this->getType(), 
										$this->_configuration, 
										$this);
		return $group;					
	}
	
	/**
	 * Answer a true if the Id corresponds to a valid group.
	 *
	 * @todo search on DN and ObjectClass
	 * 
	 * @param object Id $id
	 * @return boolean
	 * @access public
	 * @since 2/23/06
	 */
	function isGroup ( $id ) {
		$idString = str_replace(' ', '', $id->getIdString());
		$baseDN = str_replace(' ', '', $this->_configuration->getProperty("GroupBaseDN"));
		return preg_match('/.+'.$baseDN.'$/i', $idString);
	}
	
	/**
	 * Answer an iterator of groups that contain the tokens. If $includeSubgroups
	 * is true then groups will be returned if any descendent group contains
	 * the tokens.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return object AgentIterator
	 * @access public
	 * @since 2/23/06
	 */
	function getGroupsContainingTokens ( $authNTokens, $includeSubgroups ) {
		$connector =$this->_configuration->getProperty('connector');
		$groupDN = $this->_configuration->getProperty("GroupBaseDN");

		// Parent Groups of Agents
		try {
			$info = $this->_connector->getInfo($authNTokens->getUsername(), array('memberof'));
		} catch (LDAPException $e) {
			return new HarmoniIterator($groups);
		}

		$groups = array();
		
		if (isset($info['memberof'])) {
			$dns = $info['memberof'];	
			foreach ($dns as $dn) {
				if ($dn != $groupDN && !isset($groups[$dn]))
					$groups[$dn] = new LDAPGroup($dn, $this->getType(), 
										$this->_configuration, 
										$this);
			}
		}
		
		if ($includeSubgroups && isset($dns)) {
			foreach ($dns as $dn) {
				if ($dn != $groupDN) {
					
					$parentGroups =$this->getGroupsContainingGroup($dn, true);
					
					while ($parentGroups->hasNext()) {
						$group = $parentGroups->next();
						$groupId =$group->getId();
						if (!isset($groups[$groupId->getIdString()]))
							$groups[$groupId->getIdString()] =$group;
					}
				}
			}
		}
		
		$iterator = new HarmoniIterator($groups);
        return $iterator;
	}
	
	/**
	 * Answer an iterator of groups that contain the Id. If $includeSubgroups
	 * is true then groups will be returned if any descendent group contains
	 * the Id.
	 * 
	 * @param object Id $id
	 * @return object AgentIteratorr
	 * @access public
	 * @since 2/23/06
	 */
	function getGroupsContainingGroup ( $id, $includeSubgroups ) {
		if (is_object($id))
			$idString = $id->getIdString();
		else
			$idString = $id;
		$groups = array();
		$baseDN = str_replace(' ', '', $this->_configuration->getProperty("GroupBaseDN"));
		$levels = 0;
				
		while (strlen($idString) && ($includeSubgroups || $levels < 1)) {
			$levels++;
			for ($i = 0; $i < strlen($idString); $i++) {
				if ($idString[$i] == ',' && $idString[$i-1] != '\\') {
					$idString = substr($idString, $i+1);
					break;
				}
			}
			if (preg_match('/^'.$baseDN.'$/i', str_replace(' ', '', $idString)))
				break;
			
			// Sometimes users end up being members of something outside of the
			// Group Base DN. To prevent runnaway looping, exit if there are
			// no more commas in the id.
			if (!preg_match('/,/', $idString))
				break;
			
			if (!isset($groups[$idString]))
				$groups[$idString] = new LDAPGroup($idString, $this->getType(), 
									$this->_configuration, 
									$this);
			
		}
		$iterator = new HarmoniIterator($groups);
        return $iterator;
	}
}

?>