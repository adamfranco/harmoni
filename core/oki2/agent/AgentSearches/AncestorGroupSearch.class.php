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
 * @version $Id: AncestorGroupSearch.class.php,v 1.17 2007/09/04 20:25:36 adamfranco Exp $
 */

class AncestorGroupSearch
	extends AgentSearchInterface {
	
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
		$everyoneId =$idManager->getId("edu.middlebury.agents.everyone");
		$usersId =$idManager->getId("edu.middlebury.agents.users");
		
	// :: Special case for Users group, parents are:
	//		Everyone
		if ($searchCriteria->isEqual($usersId)) {
			$groups = array();
			$groups[] =$agentManager->getGroup($everyoneId);
			
			$iterator = new HarmoniAgentIterator($groups);
			return $iterator;
		}
		
		
		$groupIds = array();
		
	// :: Load Groups from the Hierarchy
		if ($this->_hierarchy->nodeExists($searchCriteria)) {
			$traversalIterator =$this->_hierarchy->traverse($searchCriteria,
					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), 
					Hierarchy::TRAVERSE_DIRECTION_UP(), 
					Hierarchy::TRAVERSE_LEVELS_ALL());
			
			$levelToReturnTo = NULL;
			
			while ($traversalIterator->hasNext()) {
				$traversalInfo =$traversalIterator->next();
				$nodeId =$traversalInfo->getNodeId();
				
				// if we are within the agent/groups tree...
				if ($levelToReturnTo == null
					|| $traversalInfo->getLevel() > $levelToReturnTo) 
				{
					// Do not continue above the root of the agent/group tree, 'everyone'
					if ($levelToReturnTo == null 
						&& $everyoneId->isEqual($nodeId)) 
					{
						$levelToReturnTo = $traversalInfo->getLevel();
					} else if ($traversalInfo->getLevel() > $levelToReturnTo) {
						$levelToReturnTo = null;
					}
					
					// Add the group id to our list.
					if (!$searchCriteria->isEqual($nodeId)
						&& $agentManager->isGroup($nodeId))
					{
						$groupIds[$nodeId->getIdString()] =$nodeId;
					}
				}			
			}
		}
		
		$isAgent = $agentManager->isAgent($searchCriteria) ;
		
	// :: Add Special Users group
		if ($isAgent && !$searchCriteria->isEqual(
				$idManager->getId("edu.middlebury.agents.anonymous")))
		{
			$groupIds[$usersId->getIdString()] =$usersId;
		}
	
	// :: Build Group Objects
	// now create an array of the group objects to add to the iterator.
		$groups = array();
		foreach ($groupIds as $groupId) {
			$groups[] =$agentManager->getGroup($groupId);
		}
		
	
	// :: Add External Groups
		$authNMethodManager = Services::getService("AuthNMethodManager");
		$mappingManager = Services::getService("AgentTokenMapping");
		// If we have an agent, get the AuthN systems for it and search our 
		// directories for it there
		if ($isAgent) {
			$mappings =$mappingManager->getMappingsForAgentId($searchCriteria);
			while ($mappings->hasNext()) {
				$mapping =$mappings->next();
				$authNMethod =$authNMethodManager->getAuthNMethodForType(
										$mapping->getAuthenticationType());
				if ($authNMethod->supportsDirectory()) {
					$groupIterator =$authNMethod->getGroupsContainingTokens(
										$mapping->getTokens(), true);
					while ($groupIterator->hasNext()) {
						$groups[] =$groupIterator->next();
					}
				}
			}
			
		}
		// assume that the search criteria is a group and search our directories for it.
		else {		
			$types =$authNMethodManager->getAuthNTypes();
			while ($types->hasNext()) {
				$type =$types->next();
				$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
				
				if ($authNMethod->supportsDirectory() 
					&& $authNMethod->isGroup($searchCriteria)) 
				{
					$groupIterator =$authNMethod->getGroupsContainingGroup(
										$searchCriteria, true);
					while ($groupIterator->hasNext()) {
						$groups[] =$groupIterator->next();
					}
				}
			}
		}
		
	// :: Return our iterator
		$iterator = new HarmoniIterator($groups);
		return $iterator;
	}
}

?>