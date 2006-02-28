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
 * @version $Id: RootGroupSearch.class.php,v 1.1 2006/02/28 21:32:43 adamfranco Exp $
 */

class RootGroupSearch
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
	function RootGroupSearch ( &$hierarchy) {
		$this->_hierarchy =& $hierarchy;
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
	function &getAgentsBySearch ( & $searchCriteria) {
		$agents = array();
		
		$obj =& new HarmoniIterator($agents);
		
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
	function &getGroupsBySearch ( & $searchCriteria) {
		ArgumentValidator::validate($searchCriteria, AlwaysTrueValidatorRule::getRule());
		
		$agentManager =& Services::getService("Agent");
		$idManager =& Services::getService("Id");
		$everyoneId =& $idManager->getId("edu.middlebury.agents.everyone");
		$usersId =& $idManager->getId("edu.middlebury.agents.users");
		$allGroupsId =& $idManager->getId("edu.middlebury.agents.all_groups");

		$groupIds = array();
		$groupIds[$everyoneId->getIdString()] =& $everyoneId;
		$groupIds[$usersId->getIdString()] =& $usersId;
		
	// :: Load Groups from the Hierarchy
		$allGroups =& $this->_hierarchy->getNode($allGroupsId);
		$allGroupNodes =& $allGroups->getChildren();
		$childGroups = array();
		while ($allGroupNodes->hasNext()) {
			$node =& $allGroupNodes->next();
			$nodeId =& $node->getId();
			
			$isRoot = TRUE;
			$parents =& $node->getParents();
			while ($parents->hasNext()) {
				$parent =& $parents->next();
				if (!$allGroupsId->isEqual($parent->getId())) {
					$isRoot = FALSE;
					break;
				}
			}
			if ($isRoot)
				$groupIds[$nodeId->getIdString()] =& $nodeId;
		}
			
	// :: Build Group Objects
	// now create an array of the group objects to add to the iterator.
		$groups = array();
		foreach ($groupIds as $groupId) {
			$groups[] =& $agentManager->getGroup($groupId);
		}
		
	
	// :: Add External Groups
		$authNMethodManager =& Services::getService("AuthNMethodManager");
		$types =& $authNMethodManager->getAuthNTypes();
		while ($types->hasNextType()) {
			$type =& $types->nextType();
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($type);
			
			if ($authNMethod->supportsDirectory()) {
				$groupIterator =& $authNMethod->getRootGroups();
				while ($groupIterator->hasNext()) {
					$groups[] =& $groupIterator->next();
				}
			}
		}
		
	// :: Return our iterator
		$iterator =& new HarmoniIterator($groups);
		return $iterator;
	}
}

?>