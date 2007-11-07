<?php

require_once(dirname(__FILE__)."/GroupsOnlyFromTraversalIterator.class.php");
require_once(OKI2."/osid/agent/Group.php");

/**
 * Group contains members that are either Agents or other Groups.  There are
 * management methods for adding, removing, and getting members and Groups.
 * There are also methods for testing if a Group or member is contained in a
 * Group, and returning all members in a Group, all Groups in a Group, or all
 * Groups containing a specific member. Many methods include an argument that
 * specifies whether to include all subgroups or not.  This allows for more
 * flexible maintenance and interrogation of the structure. Note that there is
 * no specification for persisting the Group or its content -- this detail is
 * left to the implementation.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniGroup.class.php,v 1.24 2007/11/07 19:09:50 adamfranco Exp $
 */
class HarmoniGroup
	extends HarmoniAgent
	implements Group
{

		
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
		return $this->getNode()->getDescription();
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
		$this->getNode()->updateDescription($description);
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
	function add ( $memberOrGroup ) { 
		// ** parameter validation
		ArgumentValidator::validate($memberOrGroup, ExtendsValidatorRule::getRule("Agent"), true);
		// ** end of parameter validation
		
		// For Groups stored in our hierarchy, simply add this node as a parent.
		if (method_exists($memberOrGroup, 'getNode')) {
			$memberOrGroup->getNode()->addParent($this->getId());
		} 
		// Add the group using the AgentManager's special mapping
		else {
			$agentMgr = Services::getService('Agent');
			$agentMgr->addExternalChildGroup($this->getId(), $memberOrGroup->getId());
		}
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
	function remove ( $memberOrGroup ) {
		// ** parameter validation
		ArgumentValidator::validate($memberOrGroup, ExtendsValidatorRule::getRule("Agent"), true);
		// ** end of parameter validation
		
		// For Groups stored in our hierarchy, simply remove this node as a parent.
		if (method_exists($memberOrGroup, 'getNode')) {
			$memberOrGroup->getNode()->removeParent($this->getId());
		// Remove the group using the AgentManager's special mapping
		} else {
			$agentMgr = Services::getService('Agent');
			$agentMgr->removeExternalChildGroup($this->getId(), $memberOrGroup->getId());
		}
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
		// ** parameter validation
		ArgumentValidator::validate($includeSubgroups, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$agentManager = Services::getService("Agent");
		
		$myMembers = array();
		$subgroupIterators = array();
		$children = $this->getNode()->getChildren();
		while ($children->hasNext()) {
			$child = $children->next();
			// Add the agents of this group
			if ($agentManager->isAgent($child->getId())) {
				$myMembers[] = $agentManager->getAgent($child->getId());
			} 
			// Add agents from subgroups if needed
			else if ($includeSubgroups) {
				$subgroup = $agentManager->getGroup($child->getId());
				$subgroupIterators[] = $subgroup->getMembers($includeSubgroups);
			}
		}
		
		$members = new MultiIteratorIterator();
		$members->addIterator(new HarmoniIterator($myMembers));
		foreach ($subgroupIterators as $iterator)
			$members->addIterator($iterator);
		
		return $members;
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
		// ** parameter validation
		ArgumentValidator::validate($includeSubgroups, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$agentManager = Services::getService("Agent");
		
		$myGroups = array();
		$subgroupIterators = array();
		$children = $this->getNode()->getChildren();
		while ($children->hasNext()) {
			$child = $children->next();
			if ($agentManager->isGroup($child->getId())) {
				$subgroup = $agentManager->getGroup($child->getId());
				$myGroups[] = $subgroup;
				if ($includeSubgroups)
					$subgroupIterators[] = $subgroup->getGroups($includeSubgroups);
			}
		}
		
		// Add any External Groups
		foreach ($agentManager->getExternalChildGroupIds($this->getId()) as $subgroupId) {
			$subgroup = $agentManager->getGroup($subgroupId);
			$myGroups[] = $subgroup;
			if ($includeSubgroups)
				$subgroupIterators[] = $subgroup->getGroups($includeSubgroups);
		}
		
		$groups = new MultiIteratorIterator();
		$groups->addIterator(new HarmoniIterator($myGroups));
		foreach ($subgroupIterators as $iterator)
			$groups->addIterator($iterator);
		
		return $groups;
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
	function contains ( $memberOrGroup, $searchSubgroups ) { 
		// ** parameter validation
		ArgumentValidator::validate($memberOrGroup, ExtendsValidatorRule::getRule("Agent"), true);
		ArgumentValidator::validate($searchSubgroups, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$id = $memberOrGroup->getId();

		$children = $this->getMembers($searchSubgroups);
		while ($children->hasNext()) {
			if ($id->isEqual($children->next()->getId()))
				return true;
		}
		
		$children = $this->getGroups($searchSubgroups);
		while ($children->hasNext()) {
			if ($id->isEqual($children->next()->getId()))
				return true;
		}
		
		return FALSE;
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