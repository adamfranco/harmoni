<?php
/**
 * @since 2/24/06
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CASGroup.class.php,v 1.6 2008/04/02 13:57:05 adamfranco Exp $
 */ 

require_once(OKI2."/osid/agent/Group.php");

/**
 * <##>
 * 
 * @since 2/24/06
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CASGroup.class.php,v 1.6 2008/04/02 13:57:05 adamfranco Exp $
 */
class CASGroup
	implements Group
{
	
	/**
	 * Constructor.
	 * 
	 * @param object Id $id
	 * @param object CASAuthNMethod $authNMethod
	 * @return object
	 * @access public
	 * @since 2/24/06
	 */
	function __construct (Id $id, CASAuthNMethod $authNMethod ) {
		$this->_id = $id;
		$this->_authNMethod = $authNMethod;
	}
		
	/**
	 * Update the Description of this Group.
	 * 
	 * @param string $description
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		throw new UnimplementedException();
	} 

	/**
	 * Get the Description of this Group.
	 *	
	 * @return string
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDescription () { 
		return "";
	} 

	/**
	 * Get the unique Id of this Group.
	 *	
	 * @return object Id
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getId () { 
		return $this->_id;
	} 

	/**
	 * Get the DisplayName of this Group.
	 *	
	 * @return string
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDisplayName () { 
		if (!isset($this->displayName)) {
			$this->displayName = $this->dnToName($this->_id->getIdString());
		}
		return $this->displayName;
	} 
	
	/**
	 * Answer a string name for a DN
	 *
	 * @param string $dn
	 * @return string
	 * @access public
	 * @since 8/31/09
	 */
	function dnToName ($dn) {
		$levels = ldap_explode_dn($dn, 1);
		unset($levels['count']);
	
	// 	if (preg_match('/Miles/i', $dn)) {
	// 		var_dump($dn);
	// 		var_dump($levels);
	// 		exit;
	// 	}
	
		if (count($levels) <= 2) {
			return implode('.', $levels);
		} else {
			return str_replace('\2C', ',', $levels[0]);
		}
	}

	/**
	 * Get the Type of this Group.
	 *	
	 * @return object Type
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getType () { 
		return new Type('edu.middlebury', 'Groups', 'CAS_Group');
	} 

	/**
	 * Add an Agent or a Group to this Group.  The Agent or Group will not be
	 * added if it already exists in the group.
	 * 
	 * @param object Agent $memberOrGroup
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#ALREADY_ADDED
	 *		   ALREADY_ADDED}, {@link
	 *		   org.osid.agent.AgentException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function add ( Agent $memberOrGroup ) { 
		throw new UnimplementedException();
	} 

	/**
	 * Remove an Agent member or a Group from this Group. If the Agent or Group
	 * is not in this group no action is taken and no exception is thrown.
	 * 
	 * @param object Agent $memberOrGroup
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#UNKNOWN_ID UNKNOWN_ID},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function remove ( Agent $memberOrGroup ) { 
		throw new UnimplementedException();
	} 

	/**
	 * Get all the Members of this group and optionally all the Members from
	 * all subgroups. Duplicates are not returned.
	 * 
	 * @param boolean $includeSubgroups
	 *	
	 * @return object AgentIterator
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getMembers ( $includeSubgroups ) {
		if (!isset($this->_myMembers)) {
				
			$results = $this->_authNMethod->_queryDirectory('get_group_members', array('id' => $this->_id->getIdString()));
			
// 		printpre($results);
			
			$authenticationManager = Services::getService("AuthN");
			$agentManager = Services::getService("AgentManager");
			
			$this->_myMembers = array();
			foreach ($results->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'entry') as $element) {
				if ($element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'user')->length) {
					$idString = $element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'user')->item(0)->nodeValue;
					
					$tokens = $this->_authNMethod->createTokensForIdentifier($idString);
					$agentId = $authenticationManager->_getAgentIdForAuthNTokens($tokens, $this->_authNMethod->getType());
					$this->_myMembers[] = $agentManager->getAgent($agentId);
				}
			}
		}
		
		return new HarmoniIterator($this->_myMembers);
	}
	
	/**
	 * Get all the Groups in this group and optionally all the subgroups in
	 * this group. Note since Groups subclass Agents, we are returning an
	 * AgentIterator and there is no GroupIterator.
	 * 
	 * @param boolean $includeSubgroups
	 *	
	 * @return object AgentIterator
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getGroups ( $includeSubgroups ) {
		if (!isset($this->_myGroups)) {
			$results = $this->_authNMethod->_queryDirectory('get_group_members', array('id' => $this->_id->getIdString()));
			
// 		printpre($results);
			
			$this->_myGroups = array();
			foreach ($results->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'entry') as $element) {
				if ($element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'group')->length) {
					$idString = $element->getElementsByTagNameNS('http://www.yale.edu/tp/cas', 'group')->item(0)->nodeValue;
					
					$this->_myGroups[] = new CASGroup(new HarmoniId($idString), $this->_authNMethod);
				}
			}
			
		}
        return new HarmoniIterator($this->_myGroups);
	}

	/**
	 * Return <code>true</code> if the Member or Group is in the Group,
	 * optionally including subgroups, <code>false</code> otherwise.
	 * 
	 * @param object Agent $memberOrGroup
	 * @param boolean $searchSubgroups
	 *	
	 * @return boolean
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function contains ( Agent $memberOrGroup, $searchSubgroups ) {
		$id = $memberOrGroup->getId();
		$myMembers = $this->getMembers(false);
		while ($myMembers->hasNext()) {
			if ($id->isEqual($myMembers->next()->getId())) {
				return true;
			}
		}
		
		$myGroups = $this->getGroups(false);
		while ($myGroups->hasNext()) {
			if ($id->isEqual($myGroups->next()->getId())) {
				return true;
			}
		}
		
		if ($searchSubgroups) {
			$myGroups = $this->getGroups();
			while ($myGroups->hasNext()) {
				if ($myGroups->next()->contains($memberOrGroup, true)) {
					return true;
				}
			}
		}
		
		return false;
	} 

	/**
	 * Get the Properties of this Type associated with this Group.
	 * 
	 * @param object Type $propertiesType
	 *	
	 * @return object Properties
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getPropertiesByType ( Type $propertiesType ) {
		if (!$propertiesType->isEqual(new Type('GroupProperties', 'edu.middlebury', 'CAS Properties')))
			throw new UnknownTypeException("Unsupported Properties type.");
		
		if (!isset($_SESSION['CAS_GROUP_PROPERTIES'][$this->_idString])) {
			$properties = new HarmoniProperties(new Type('GroupProperties', 'edu.middlebury', 'CAS Properties'));
			$properties->addProperty('identifier', $this->_idString);
			
			$propertiesFields = $this->_configuration->getProperty('group_properties_fields');
			
			if (is_array($propertiesFields)) {
				$fieldsToFetch = array();
				foreach ($propertiesFields as $propertyKey => $fieldName) {
					$fieldsToFetch[] = $fieldName;
				}
				
				$info = $this->_authNMethod->_connector->getInfo($this->_idString, $fieldsToFetch);
				
				if (!$info) {
					// store a null so that we won't keep trying to fetch data.
					$_SESSION['CAS_GROUP_PROPERTIES'][$this->_idString] = null;
					throw new OperationFailedException("Could not fetch CAS group info.");
				}
				
				foreach ($propertiesFields as $propertyKey => $fieldName) {
					if (isset($info[$fieldName])) {
						if (count($info[$fieldName]) <= 1)
							$properties->addProperty($propertyKey, $info[$fieldName][0]);
						else
							$properties->addProperty($propertyKey, $info[$fieldName]);
					}
				}
			}
			$_SESSION['CAS_GROUP_PROPERTIES'][$this->_idString] = $properties;
		}
		
		if (is_null($_SESSION['CAS_GROUP_PROPERTIES'][$this->_idString]))
			throw new OperationFailedException("Could not fetch CAS group info.");
			
		return $_SESSION['CAS_GROUP_PROPERTIES'][$this->_idString];
	} 

	/**
	 * Get all the property Types.	The returned iterator provides access to
	 * the property Types from this implementation one at a time.  Iterators
	 * have a method hasNextType() which returns true if there is another
	 * property Type available and a method nextType() which returns the next
	 * property Type. Group.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getPropertyTypes () { 
		return new HarmoniIterator(array(new Type('GroupProperties', 'edu.middlebury', 'CAS Properties')));
	} 

	/**
	 * Get the Properties associated with this Group.
	 *	
	 * @return object PropertiesIterator
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getProperties () {
		return new HarmoniPropertiesIterator(array($this->getPropertiesByType(new Type('GroupProperties', 'edu.middlebury', 'CAS Properties'))));
	}	
	
	/**
	 * Answer true if this Agent is an Agent, not a group
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return boolean
	 * @access public
	 * @since 12/7/06
	 */
	function isAgent () {
		return !$this->isGroup();
	}
	
	/**
	 * Answer true if this Agent is an Group
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return boolean
	 * @access public
	 * @since 12/7/06
	 */
	function isGroup () {
		return true;
	}
}

?>