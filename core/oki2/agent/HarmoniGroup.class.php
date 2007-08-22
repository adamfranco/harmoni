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
 * @version $Id: HarmoniGroup.class.php,v 1.23 2007/08/22 14:45:44 adamfranco Exp $
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
		return $this->_node->getDescription();
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
		$this->_node->updateDescription($description);
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
		
		// The way groups are currently implemented, it isn't possible to
		// add an LdapGroup to a HarmoniGroup. That should be updated to
		// make this work.
		if (!isset($memberOrGroup->_node)) {
			throw new Exception("The way groups are currently implemented, it isn't possible to add an LdapGroup to a HarmoniGroup. That should be updated to make this work.");
		}
		
// 		print "<div style='border: 1px dotted;, margin: 10px; padding: 10px; background-color: #faa;'>";
// 		printpre("<strong>Adding agent, ".$memberOrGroup->getDisplayName().", to group, ".$this->getDisplayName().".</strong>");
		$memberOrGroup->_node->addParent($this->getId());
// 		print "</div>";
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
		
		
		$memberOrGroup->_node->removeParent($this->getId());
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
		
		if ($includeSubgroups)
			$levels = Hierarchy::TRAVERSE_LEVELS_ALL();
		else
			$levels = 1;
			
		$traversalIterator = $this->_hierarchy->traverse($this->getId(),
			Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), Hierarchy::TRAVERSE_DIRECTION_DOWN(), 
			$levels);
			
		$members = new MembersOnlyFromTraversalIterator($traversalIterator);
		
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
		
		if ($includeSubgroups)
			$levels = Hierarchy::TRAVERSE_LEVELS_ALL();
		else
			$levels = 1;
			
		$traversalIterator = $this->_hierarchy->traverse($this->getId(),
			Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), Hierarchy::TRAVERSE_DIRECTION_DOWN(), 
			$levels);
		
		$groups = new GroupsOnlyFromTraversalIterator($traversalIterator, $this->getId());
		
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

		if ($includeSubgroups)
			$levels = Hierarchy::TRAVERSE_LEVELS_ALL();
		else
			$levels = 1;
			
		$traversalIterator = $this->_hierarchy->traverse($this->getId(),
			Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), Hierarchy::TRAVERSE_DIRECTION_DOWN(), 
			$levels);
		
		while ($traversalIterator->hasNext()) {
			$info = $traversalIterator->next();
			if ($id->isEqual($info->getNodeId()))
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