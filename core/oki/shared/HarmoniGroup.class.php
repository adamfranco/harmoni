<?php

/**
 * The Group may contain Members (Agents) as well as other Groups.  There are management methods for adding, removing, and getting members and Groups.  There are also methods for testing if a Group or member is contained in a Group, and returning all Members in a Group, all Groups in a Group, or all Groups containing a specific Member. Many methods include an argument that specifies whether to include all subgroups or not.  This allows for more flexible maintenance and interrogation of the structure. Note that there is no specification for persisting the Group or its content -- this detail is left to the implementation. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
 * @package osid.shared
 */
class HarmoniGroup // :: API interface
	extends HarmoniAgent // implements Group OSID interface
{


	/**
	 * The description of this Group.
	 * @attribute private string _description
	 */
	var $_description;
	
	
	/**
	 * An array storing groups that are members of this group.
	 * @attribute private array _groups
	 */
	var $_groups;
	
	
	/**
	 * An array storing agents that are members of this group.
	 * @attribute private array _agents
	 */
	var $_agents;
	
	
	/**
	 * The constructor.
	 * @param string displayName The display name.
	 * @param object id The id.
	 * @param object type The type.
	 * @param string description The description.
	 * @access public
	 */
	function HarmoniGroup($displayName, & $id, & $type, $description) {
		$this->HarmoniAgent($displayName, & $id, & $type);
		
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		$this->_description = $description;
		$this->_groups = array();
		$this->_agents = array();
	}	
	
	
	/**
	 * Get the Description of this Group as stored.
	 * @return String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getDescription() {
		return $this->_description;
	}

	/**
	 * Update the Description of this Group as stored.
	 * @param description
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function updateDescription($description) {
	
	// ***********************************************
	// ***********************************************
	// ***********************************************
	// ***********************************************
	// IMPLEMENT IMPLEMENT IMPLEMENT IMPLEMENT IMPLEMENT
	// ***********************************************
	// ***********************************************
	// ***********************************************
	// ***********************************************
	
	}


	/**
	 * Add an Agent member or a Group to this Group.  The Member or Group will not be added if it already exists in the group.
	 * IMPORTANT: There is no check for cycles, i.e. if group A is a subgroup of group B, which is a subgroup of group A.
	 * The user should be the one to be looking to avoid cycles. In the case that a cycle appears, then the recursive version of getMembers will
	 * not work and in fact will terminate the script.
	 * @param memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#ALREADY_ADDED ALREADY_ADDED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function add(& $memberOrGroup) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		// ** end of parameter validation

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
		$id =& $memberOrGroup->getId();
		if ($isGroup)
		    $this->_groups[$id->getIdString()] =& $memberOrGroup;
		else
			$this->_agents[$id->getIdString()] =& $memberOrGroup;
	}

	
	/**
	 * Remove an Agent member or a Group from this Group. If the Member or Group is not in the group no action is taken and no exception is thrown.
	 * @param memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function remove(& $memberOrGroup) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		// ** end of parameter validation

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
		$id =& $memberOrGroup->getId();
		
		if ($isGroup) {
			if (isset($this->_groups[$id->getIdString()]))
		    	unset($this->_groups[$id->getIdString()]);
		}
		else
			if (isset($this->_agents[$id->getIdString()]))
		    	unset($this->_agents[$id->getIdString()]);
	}

	
	/**
	 * Get all the Members of this group and optionally all the Members from all subgroups. Duplicates are not returned.
	 * @param boolean includeSubgroups If True, will execute recursively.
	 * @return AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getMembers($includeSubgroups) {
		// ** parameter validation
		ArgumentValidator::validate($includeSubgroups, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$result = new HarmoniAgentIterator($this->_getMembers($includeSubgroups, true));
		return $result;
	}
	
	/**
	 * A private recursive auxiliary function for the getMembers method.
	 * @access private
	 * @param includeSubgroups
	 * @param boolean agents If TRUE will return groups, if FALSE will return agents. 
	 * @return array 
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & _getMembers($recursive, $agents = TRUE) {
		if ($agents)
			$result = $this->_agents;
		else
			$result = $this->_groups;
		
		if ($recursive)
			foreach (array_keys($this->_groups) as $i => $key)
				$result += $this->_groups[$key]->_getMembers($recursive, $agents);
				
		return $result;
	}

	/**
	 * Get all the Groups in this group and optionally all the subgroups in this group. Note since Groups subclass Agents, we are returning an AgentIterator and there is no GroupIterator.
	 * @param includeSubgroups
	 * @return AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function & getGroups($includeSubgroups) {
		// ** parameter validation
		ArgumentValidator::validate($includeSubgroups, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$result = new HarmoniAgentIterator($this->_getMembers($includeSubgroups, false));
		return $result;
	}
	
	/**
	 * Get all the Groups, including subgroups, containing the Member. Note since Groups subclass Agents, we are returning an AgentIterator and there is no GroupIterator.
	 * @param member
	 * @return AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function & getGroupsContainingMember(& $member) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getGroupsContainingMember(Agent member)

	/**
	 * Return <code>true</code> if the Member or Group is in the Group, optionally including subgroups, <code>false</code> otherwise.
	 * @param memberOrGroup
	 * @param searchSubgroups
	 * @return boolean
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function contains(& $memberOrGroup, $searchSubgroups = false) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		ArgumentValidator::validate($searchSubgroups, new BooleanValidatorRule(), true);
		// ** end of parameter validation

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
	    $id =& $memberOrGroup->getId();

		// check if $memberOrGroup is in this group
		if ($isGroup && ($this->_groups[$id->getIdString()] == $memberOrGroup))
			return true;
		elseif ($this->_agents[$id->getIdString()] == $memberOrGroup)
			return true;
			
		// search recursively
		if ($searchSubgroups)
			foreach (array_keys($this->_groups) as $i => $key)
				if ($this->_groups[$key]->contains($memberOrGroup, $searchSubgroups))
					return true;

		return false;
	}

	
}

?>