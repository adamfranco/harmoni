<?php
/**
 * @since 2/24/06
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPGroup.class.php,v 1.4 2008/02/06 15:37:47 adamfranco Exp $
 */ 

require_once(OKI2."/osid/agent/Group.php");
require_once(dirname(__FILE__)."/LDAPAgentIterator.class.php");

/**
 * <##>
 * 
 * @since 2/24/06
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPGroup.class.php,v 1.4 2008/02/06 15:37:47 adamfranco Exp $
 */
class LDAPGroup
	implements Group
{
	
	/**
	 * Constructor.
	 * 
	 * @param string $idString
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 2/24/06
	 */
	function LDAPGroup ( $idString, $type, $configuration, $authNMethod ) {
		ArgumentValidator::validate($idString, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($type, 
			ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($configuration, 
			ExtendsValidatorRule::getRule("Properties"), true);
		ArgumentValidator::validate($authNMethod, 
			ExtendsValidatorRule::getRule("LDAPAuthNMethod"), true);
		
		$this->_type = $type;
		$this->_idString = $idString;
		$this->_configuration = $configuration;
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
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
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
		if (!isset($this->_id)) {
			$idManager = Services::getService("Id");
			$this->_id = $idManager->getId($this->_idString);
		}
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
		$connector = $this->_configuration->getProperty('connector');
		$fields = array("name");
		$results = $connector->getInfo($this->_idString, $fields);
		return $results['name'][0];
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
		return $this->_type;
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
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
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
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
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
		if ($includeSubgroups) {
			return $this->_getSubgroupMembers();
		} else {
			return $this->_getMyMembers();
		}
	}
	
	/**
	 * Answer the direct members of this group
	 * 
	 * @return object AgentIterator
	 * @access private
	 * @since 2/27/06
	 */
	function _getMyMembers () {		
		if (!isset($this->_myMembers)) {
				
			$connector = $this->_configuration->getProperty('connector');
			
			$fields = array("member");
			$results = $connector->getInfo($this->_idString, $fields);
// 		printpre($results);
			
			$this->_myMembers = array();
			$this->_myMembersDNs = array();
			if (isset($results['member']) && is_array($results['member'])) {
				$this->_myMembersDNs = $results['member'];
			}
		}
		
		if (count($this->_myMembers) || count($this->_myMembersDNs))
			$iterator = new LDAPAgentIterator($this->_authNMethod, $this->_myMembers,
												$this->_myMembersDNs);
		else
			$iterator = new HarmoniIterator($this->_myMembers);
		return $iterator;
	}
	
	/**
	 * Answer the members of this group both directly and in subgroups
	 * 
	 * @return object AgentIterator
	 * @access private
	 * @since 2/27/06
	 */
	function _getSubgroupMembers () {
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
		
		if (!isset($this->_subgroupMembers)) {
				
			$connector = $this->_configuration->getProperty('connector');
			
			$fields = array("member");
			$results = $connector->getInfo($this->_idString, $fields);
	//		printpre($results);
			
			$this->_subgroupMembers = array();
			if (isset($results['member']) && is_array($results['member'])) {
				$authenticationManager = Services::getService("AuthN");
				$agentManager = Services::getService("AgentManager");
				foreach ($results['member'] as $dn) {
					$tokens = $this->_authNMethod->createTokensForIdentifier($dn);
					$agentId = $authenticationManager->_getAgentIdForAuthNTokens($tokens, $this->_type);
					$this->_subgroupMembers[] = $agentManager->getAgent($agentId);
				}
			}
		}
		$iterator = new HarmoniIterator($this->_subgroupMembers);
		return $iterator;
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
		if ($includeSubgroups) {
			return $this->_getSubgroupGroups();
		} else {
			return $this->_getMyGroups();
		}
	}
	
	/**
	 * Answer the direct child groups of this group
	 * 
	 * @return object AgentIterator
	 * @access private
	 * @since 2/27/06
	 */
	function _getMyGroups () {
		if (!isset($this->_myGroups)) {
			$connector = $this->_configuration->getProperty('connector');
			
			$filter = "(objectclass=*)";
			$dns = $connector->getDNsByList($filter, $this->_idString);
			
			$this->_myGroups = array();
			foreach ($dns as $dn) {
				if ($dn != $this->_idString)
					$this->_myGroups[] = new LDAPGroup($dn, $this->_type, 
										$this->_configuration, 
										$this->_authNMethod);
			}
		}
        $iterator = new HarmoniIterator($this->_myGroups);
        return $iterator;
	}
	
	/**
	 * Answer the descendent groups of this group
	 * 
	 * @return object AgentIterator
	 * @access private
	 * @since 2/27/06
	 */
	function _getSubgroupGroups () {
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
									 
		if (!isset($this->_subgroupGroups)) {
			$connector = $this->_configuration->getProperty('connector');
			
			$filter = "(objectclass=*)";
			$dns = $connector->getDNsBySearch($filter, $this->_idString);
			
			$this->_subgroupGroups = array();
			foreach ($dns as $dn) {
				if ($dn != $this->_idString)
					$this->_subgroupGroups[] = new LDAPGroup($dn, $this->_type, 
										$this->_configuration, 
										$this->_authNMethod);
			}
		}
        $iterator = new HarmoniIterator($this->_subgroupGroups);
        return $iterator;
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
		$myMembers = $this->getMembers(false);
		while ($myMembers->hasNext()) {
			if ($memberOrGroup->isEqual($myMembers->next()->getId())) {
				return true;
			}
		}
		
		$myGroups = $this->getGroups(false);
		while ($myGroups->hasNext()) {
			if ($memberOrGroup->isEqual($myGroups->next()->getId())) {
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
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
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
		throwError(new Error(AgentException::UNIMPLEMENTED(), "LDAPGroup", true));
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
		$a = array();
		$i = new HarmoniIterator($a);
		return $i;
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