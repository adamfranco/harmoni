<?php

/**
 * The Group may contain Members (Agents) as well as other Groups.  There are management methods for adding, removing, and getting members and Groups.  There are also methods for testing if a Group or member is contained in a Group, and returning all Members in a Group, all Groups in a Group, or all Groups containing a specific Member. Many methods include an argument that specifies whether to include all subgroups or not.  This allows for more flexible maintenance and interrogation of the structure. Note that there is no specification for persisting the Group or its content -- this detail is left to the implementation. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
 * @package harmoni.osid.shared
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
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
	 * @access public
	 */
	function HarmoniGroup($displayName, & $id, & $type, $description, $dbIndex, $sharedDB) {
		// ** parameter validation
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->HarmoniAgent($displayName, $id, $type, $dbIndex, $sharedDB);
		
		$this->_description = $description;

		$this->_groups = array();
		$this->_agents = array();
	}
	
	
	/**
	 * Get the Description of this Group as stored.
	 * @return String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.shared
	 */
	function getDescription() {
		return $this->_description;
	}

	/**
	 * Update the Description of this Group as stored.
	 * @param string description
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
	 */
	function updateDescription($description) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
		    return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_sharedDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."groups");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}groups.groups_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}groups.groups_description"));
		$query->setValues(array("'$description'"));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The group with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple groups with Id: ".$idValue." exist in the database. Note: their descriptions have been updated." ,"SharedManager",true));
	}



	/**
	 * An implementation-specific public method that does exactly the same as add(),
	 * but does not insert into the database.
	 * @access public
	 * @param object memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#ALREADY_ADDED ALREADY_ADDED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
	 **/
	function attach(& $memberOrGroup) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		// ** end of parameter validation

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
		$id =& $memberOrGroup->getId();
		$idValue = $id->getIdString();
		
		if ($isGroup && !isset($this->_groups[$idValue]))
			// add in the object
		    $this->_groups[$id->getIdString()] =& $memberOrGroup;
		elseif (!isset($this->_agents[$idValue]))
			// add in the object
			$this->_agents[$id->getIdString()] =& $memberOrGroup;
	}
	
		

	/**
	 * Add an Agent member or a Group to this Group.  The Member or Group will not be added if it already exists in the group.
	 * IMPORTANT: There is no check for cycles, i.e. if group A is a subgroup of group B, which is a subgroup of group A.
	 * The user should be the one to be looking to avoid cycles. In the case that a cycle appears, then the recursive version of getMembers will
	 * not work and in fact will terminate the script.
	 * @param object memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#ALREADY_ADDED ALREADY_ADDED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
	 */
	function add(& $memberOrGroup) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		// ** end of parameter validation

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_sharedDB.".";

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
		$id =& $memberOrGroup->getId();
		$idValue = $id->getIdString();
		if ($isGroup && !isset($this->_groups[$idValue])) {
			// check to see for existence in database
			// if the agent does not exist, then we are in trouble
			// NOTE: this check is not really needed because
			// all groups or agents must have been gotten either trough
			// the create or get methods, which ensure database existence.
//			if (!HarmoniGroup::exist($memberOrGroup))
//			    throwError(new Error("Cannot add the group, because it does not exist in the database.",
//							 		 "SharedManager", true));
//	
			// update the join table
			$query =& new InsertQuery();
			$query->setTable($db."j_groups_groups");
			$columns = array();
			$columns[] = $db."j_groups_groups.fk_parent";
			$columns[] = $db."j_groups_groups.fk_child";
			$query->setColumns($columns);
			$values = array();
			$parentId =& $this->getId();
			$childId =& $memberOrGroup->getId();
			$values[] = "'".$parentId->getIdString()."'";
			$values[] = "'".$childId->getIdString()."'";
			$query->setValues($values);
	
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() != 1)
				throwError(new Error("Insert failed.","SharedManager",true));

			// add in the object
		    $this->_groups[$id->getIdString()] =& $memberOrGroup;
		}
		elseif (!isset($this->_agents[$idValue])) {
			// check to see for existence in database
			// if the agent does not exist, then we are in trouble
			// NOTE: this check is not really needed because
			// all groups or agents must have been gotten either trough
			// the create or get methods, which ensure database existence.
//			if (!HarmoniAgent::exist($memberOrGroup))
//			    throwError(new Error("Cannot add the agent, because it does not exist in the database.",
//							 		 "SharedManager", true));
//
			// update the join table
			$query =& new InsertQuery();
			$query->setTable($db."j_groups_agent");
			$columns = array();
			$columns[] = $db."j_groups_agent.fk_groups";
			$columns[] = $db."j_groups_agent.fk_agent";
			$query->setColumns($columns);
			$values = array();
			$parentId =& $this->getId();
			$childId =& $memberOrGroup->getId();
			$values[] = "'".$parentId->getIdString()."'";
			$values[] = "'".$childId->getIdString()."'";
			$query->setValues($values);
	
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() != 1)
				throwError(new Error("Insert failed.","SharedManager",true));

			// add in the object
			$this->_agents[$id->getIdString()] =& $memberOrGroup;
		}
	}

	
	/**
	 * Remove an Agent member or a Group from this Group. If the Member or Group is not in the group no action is taken and no exception is thrown.
	 * @param object memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
	 */
	function remove(& $memberOrGroup) {
		// ** parameter validation
		$extend =& new ExtendsValidatorRule("Agent"); // Group objects extend Agent
		ArgumentValidator::validate($memberOrGroup, $extend, true);
		// ** end of parameter validation

		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_sharedDB.".";

		// we have to figure out whether the argument is an agent or a group
		$isGroup = is_a($memberOrGroup, get_class($this));
		
		$id =& $memberOrGroup->getId();
		
		if ($isGroup) {
			if (isset($this->_groups[$id->getIdString()])) {
				// remove from join table
				$parentId =& $this->getId();
				$childId =& $memberOrGroup->getId();
				$query =& new DeleteQuery();
				$query->setTable($db."j_groups_groups");
				$query->addWhere($db."j_groups_groups.fk_parent = '".$parentId->getIdString()."'");
				$query->addWhere($db."j_groups_groups.fk_child = '".$childId->getIdString()."'");
				$queryResult =& $dbHandler->query($query, $this->_dbIndex);
				if ($queryResult->getNumberOfRows() != 1)
					throwError(new Error("Delete failed.","SharedManager",true));
				
				// remove from object
				// DO NOT SET TO NULL
		    	unset($this->_groups[$id->getIdString()]);
			}
		}
		else
			if (isset($this->_agents[$id->getIdString()])) {
				// remove from join table
				$parentId =& $this->getId();
				$childId =& $memberOrGroup->getId();
				$query =& new DeleteQuery();
				$query->setTable($db."j_groups_agent");
				$query->addWhere($db."j_groups_agent.fk_groups = '".$parentId->getIdString()."'");
				$query->addWhere($db."j_groups_agent.fk_agent = '".$childId->getIdString()."'");
				$queryResult =& $dbHandler->query($query, $this->_dbIndex);
				if ($queryResult->getNumberOfRows() != 1)
					throwError(new Error("Delete failed.","SharedManager",true));
				
				// remove from object
		    	unset($this->_agents[$id->getIdString()]);
			}
	}

	
	/**
	 * Get all the Members of this group and optionally all the Members from all subgroups. Duplicates are not returned.
	 * @param boolean includeSubgroups If True, will execute recursively.
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.shared
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
	 * @param boolean includeSubgroups
	 * @param boolean agents If TRUE will return groups, if FALSE will return agents. 
	 * @return array 
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.shared
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
	 * @param boolean includeSubgroups
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.shared
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
	 * @param object member
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
	 */
	function & getGroupsContainingMember(& $member) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getGroupsContainingMember(Agent member)

	/**
	 * Return <code>true</code> if the Member or Group is in the Group, optionally including subgroups, <code>false</code> otherwise.
	 * @param object memberOrGroup
	 * @param boolean searchSubgroups
	 * @return boolean
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.shared
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
	
	/**
	 * A method checking whether the specified group exist in the database.
	 * @access public
	 * @static
	 * @param boolean agentOrGroup TRUE, if <code>$memberOrGroup</code> is an agent; FALSE, if it is a group.
	 * @return boolean <code>tru</code> if it exists; <code>false</code> otherwise.
	 **/
	function exist(& $group, $agentOrGroup) {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		// get the id
		$id =& $group->getId();
		$idValue = $id->getIdString();

		// string prefix
		$db = $group->_sharedDB.".";
		
		// set the tables
		$query->addTable($db."groups");
		// set the columns to select
		$query->addColumn("groups_id", "id");
		// set where
		$where = "groups_id = '".$idValue."' AND ";
		$where .= "groups_display_name = '".$group->getDisplayName()."' AND ";
	    $where .= "groups_description = '".$group->getDescription()."'";
		$query->addWhere($where);

		echo "<pre>\n";
		echo MySQL_SQLGenerator::generateSQLQuery($query);
		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $group->getDBIndex());
		if ($queryResult->getNumberOfRows() == 1)
			return true;
		else
			return false;
	}


}

?>