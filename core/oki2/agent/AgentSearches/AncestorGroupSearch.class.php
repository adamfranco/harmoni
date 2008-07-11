<?php

require_once(dirname(__FILE__)."/AgentSearch.interface.php");

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 *
 * @package harmoni.osid_v2.agent.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AncestorGroupSearch.class.php,v 1.21 2008/02/06 15:37:46 adamfranco Exp $
 */

class AncestorGroupSearch
	implements AgentSearchInterface 
{
	
	/**
	 * @var object $_hierarchy;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_hierarchy;
	/**
	 * Constructor
	 * 
	 * @param integer $dbIndex The database index to use
	 * @return object
	 * @access public
	 * @since 12/1/04
	 */
	function AncestorGroupSearch ( $hierarchy) {
		$this->_hierarchy =$hierarchy;
		
		$idManager = Services::getService("Id");
		$this->everyoneId = $idManager->getId("edu.middlebury.agents.everyone");
		$this->usersId = $idManager->getId("edu.middlebury.agents.users");
	}
	
	
		
	/**
	 * Get all the Agents with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $agentSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function getAgentsBySearch ( $searchCriteria) {
		$agents = array();
		
		$obj = new HarmoniIterator($agents);
		
		return $obj;
	}
	
	/**
	 * Get all the Groups with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $groupSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function getGroupsBySearch ( $searchCriteria) {
		ArgumentValidator::validate($searchCriteria, ExtendsValidatorRule::getRule("Id"));
		
		$agentManager = Services::getService("Agent");
		$idManager = Services::getService("Id");
		
	// :: Special case for Everyone group, no parents
		if ($searchCriteria->isEqual($this->everyoneId)) {
			return new HarmoniAgentIterator(array());
		}
		
	// :: Special case for Users group, parents are:
	//		Everyone
		if ($searchCriteria->isEqual($this->usersId)) {
			return new HarmoniAgentIterator(array($agentManager->getGroup($this->everyoneId)));
		}
		
		$allGroups = array();
		$allGroups[] = $agentManager->getGroup($this->everyoneId);
		
		$isAgent = $agentManager->isAgent($searchCriteria) ;
		
	// :: Add Special Users group
		if (!$searchCriteria->isEqual(
				$idManager->getId("edu.middlebury.agents.anonymous")))
		{
			$allGroups[] = $agentManager->getGroup($this->usersId);
		}
		
	// :: Load Groups from the Hierarchy
		$allGroups = array_merge($allGroups, $this->getHierarchyGroups($searchCriteria));
	
	// :: Add External Groups
		$externalIdsToCheckForInternalParents = array();
		// If we have an agent, get the AuthN systems for it and search our 
		// directories for it there
		if ($isAgent) {
// 			printpre($searchCriteria->getIdString()." is an Agent.");
			$externalGroups = $this->getExternalGroupsForAgent($searchCriteria);
		}
		// assume that the search criteria is a group and search our directories for it.
		else {
// 			printpre($searchCriteria->getIdString()." is a Group.");
			$externalGroups = $this->getExternalGroupsForGroup($searchCriteria);
			$externalIdsToCheckForInternalParents[] = $searchCriteria;
		}
		
		foreach ($externalGroups as $group) {
			$allGroups[] = $group;
			$externalIdsToCheckForInternalParents[] = $group->getId();
		}
		$allGroups = array_merge($allGroups, $this->getHierarchyAncestorsForExternalGroups($externalIdsToCheckForInternalParents));
		
		$uniqueGroups = array();
		foreach ($allGroups as $group) {
			$added = false;
			$id = $group->getId();
			foreach ($uniqueGroups as $addedGroup) {
				if ($id->isEqual($addedGroup->getId())) {
					$added = true;
					break;
				}
			}
			
			if (!$added)
				$uniqueGroups[] = $group;
		}
		
	// :: Return our iterator
		return new HarmoniAgentIterator($uniqueGroups);
	}
	
	/**
	 * Answer the Hierarchy Groups that contain the agentOrGroup id passed.
	 * 
	 * @param object Id $agentOrGroupId
	 * @return array of Groups
	 * @access private
	 * @since 11/6/07
	 */
	private function getHierarchyGroups (Id $agentOrGroupId) {
		$agentManager = Services::getService("Agent");
		$groupIds = array();
		if ($this->_hierarchy->nodeExists($agentOrGroupId)) {
			$traversalIterator = $this->_hierarchy->traverse($agentOrGroupId,
					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST, 
					Hierarchy::TRAVERSE_DIRECTION_UP, 
					Hierarchy::TRAVERSE_LEVELS_ALL);
			
			$levelToReturnTo = NULL;
			
			while ($traversalIterator->hasNext()) {
				$traversalInfo = $traversalIterator->next();
				$nodeId =$traversalInfo->getNodeId();
								
				// if we are within the agent/groups tree...
				if ($levelToReturnTo == null
					|| $traversalInfo->getLevel() > $levelToReturnTo) 
				{
					// Do not continue above the root of the agent/group tree, 'everyone'
					if ($levelToReturnTo == null 
						&& $this->everyoneId->isEqual($nodeId)) 
					{
						$levelToReturnTo = $traversalInfo->getLevel();
					} else if ($traversalInfo->getLevel() > $levelToReturnTo) {
						$levelToReturnTo = null;
					}
					
					// Add the group id to our list.
					if (!$agentOrGroupId->isEqual($nodeId)
						&& $agentManager->isGroup($nodeId))
					{
						$groupIds[$nodeId->getIdString()] = $nodeId;
					}
				}			
			}
		}
		
	// :: Build Group Objects
	// now create an array of the group objects to add to the iterator.
		$groups = array();
		foreach ($groupIds as $groupId) {
			$groups[] = $agentManager->getGroup($groupId);
		}
		
		return $groups;
	}
	
	/**
	 * Answer the Hierarchy Groups that contain any of the external group ids passed.
	 * 
	 * @param array $externalGroupIds
	 * @return object Iterator
	 * @access private
	 * @since 11/6/07
	 */
	private function getHierarchyAncestorsForExternalGroups (array $groupIds) {
// 		printpre("<hr/><strong>Ancestors of</strong>");
// 		foreach ($groupIds as $groupId)
// 			printpre($groupId->getIdString());
		
		$agentManager = Services::getService("Agent");
		
		$groupParentIds = $agentManager->getHierarchyParentIdsForExternalGroups($groupIds);
		
		$groups = array();
		foreach ($groupParentIds as $id) {
			$groups[] = $agentManager->getGroup($id);
			$groups = array_merge($groups, $this->getHierarchyGroups($id));	
		}
// 		printpre("<strong>are</strong>");
// 		foreach ($groups as $group)
// 			printpre($group->getId()->getIdString());
		return $groups;
	}
	
	
	
	/**
	 * Answer an iterator of External groups wich contain the agent specified.
	 * 
	 * @param object Id $agentId
	 * @return array of Groups
	 * @access private
	 * @since 11/6/07
	 */
	private function getExternalGroupsForAgent (Id $agentId) {
		$authNMethodManager = Services::getService("AuthNMethodManager");
		$mappingManager = Services::getService("AgentTokenMapping");
		
		$groups = array();
		$mappings = $mappingManager->getMappingsForAgentId($agentId);
		while ($mappings->hasNext()) {
			$mapping = $mappings->next();
			$authNMethod = $authNMethodManager->getAuthNMethodForType(
									$mapping->getAuthenticationType());
			
			if ($authNMethod->supportsDirectory()) {
				$groupIterator = $authNMethod->getGroupsContainingTokens(
									$mapping->getTokens(), true);
				while ($groupIterator->hasNext()) {
					$groups[] = $groupIterator->next();
				}
			}			
		}
		
		return $groups;
	}
	
	/**
	 * Answer an iterator of the External groups which contain the group specified
	 * 
	 * @param object Id $groupId
	 * @return array of Groups
	 * @access private
	 * @since 11/6/07
	 */
	private function getExternalGroupsForGroup (Id $groupId) {
		$authNMethodManager = Services::getService("AuthNMethodManager");
		
		$groups = array();
		$types = $authNMethodManager->getAuthNTypes();
		while ($types->hasNext()) {
			$type = $types->next();
			$authNMethod = $authNMethodManager->getAuthNMethodForType($type);
			
			if ($authNMethod->supportsDirectory() && $authNMethod->isGroup($groupId)) {
				$groupIterator = $authNMethod->getGroupsContainingGroup($groupId, true);
				while ($groupIterator->hasNext()) {
					$groups[] = $groupIterator->next();
				}
			}
		}
		
		return $groups;
	}
}

?>