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
 * @version $Id: AncestorGroupSearch.class.php,v 1.5 2005/02/08 17:21:10 adamfranco Exp $
 */

class AncestorGroupSearch
	extends AgentSearchInterface {
	
	/**
	 * Constructor
	 * 
	 * @param integer $dbIndex The database index to use
	 * @return object
	 * @access public
	 * @since 12/1/04
	 */
	function AncestorGroupSearch ($dbIndex) {
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule);
		$this->_dbIndex = $dbIndex;
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
	function &getAgentsBySearch ( & $searchCriteria, & $agentSearchType ) {
		$agents = array();
		
		return new HarmoniIterator($agents);
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
	function &getGroupsBySearch ( & $searchCriteria, & $groupSearchType ) {
		ArgumentValidator::validate($searchCriteria, new ExtendsValidatorRule("Id"));
		
		$groupOrAgentId = $searchCriteria->getIdString();
		
		$groupIds = array();
		
		// Add the Everyone Group
		$groupIds[] = "-1";
		
		// first look in the group_agent table to see if our requested Id is
		// an agent and if so what groups it is a member of. If these exist,
		// add these to our final list and use these to start our join clause
		$groupsToCheck = array();
		
		$dbHandler =& Services::getService("DBHandler");
		
		$query =& new SelectQuery();
		$query->addColumn("fk_groups", "group_id");
		$query->addTable("j_groups_agent");
		$query->addWhere("fk_agent = '".addslashes($groupOrAgentId)."'");
		
		$result =& $dbHandler->query($query, $this->_dbIndex);
		// if we have results, then our original Id was an agent,
		// add the found Ids to our result list as well as to our
		// list of groups to check.
		if ($result->getNumberOfRows()) {
			while ($row =& $result->getCurrentRow()) {
				$groupIds[] = $row['group_id'];
				$groupsToCheck[] = addslashes($row['group_id']);
				$result->advanceRow();
			}
		}
		// If we don't have any rows returned, then the Id is that of
		// a group or is unknown. Just add the passed Id as the one to check.
		else {
			$groupsToCheck[] = addslashes($groupOrAgentId);
		}
		
		// Now go through join the possible ancestors onto our starting groups.
		// These ancestors will then be added to our final list.
		$query =& new SelectQuery();
		$query->addColumn("fk_child", "starting_group_id", "subgroup1");
		$query->addColumn("fk_parent", "subgroup1_id", "subgroup1");
		$query->addTable("j_groups_groups", NO_JOIN, "", "subgroup1");
		
		$list = implode("','", $groupsToCheck);
		$list = "'".$list."'";
		$query->addWhere("subgroup1.fk_child IN ($list)");
		
		// now left join with itself.
		// maximum number of joins is 31, we've used 7 already, so there are 24 left
		// bottom line: a maximum group hierarchy of 25 levels
		for ($level = 1; $level <= 29; $level++) {
			$joinc = "subgroup".($level).".fk_parent = subgroup".($level+1).".fk_child";
			$query->addTable("j_groups_groups", LEFT_JOIN, $joinc, "subgroup".($level+1));
			$query->addColumn("fk_child", "subgroup".($level+1)."_id", "subgroup".($level+1));
		}
		
// 		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		// Go through each ancestor path and add the ancestor Ids to our groupIds
		// array.
		while ($row =& $result->getCurrentRow()) {
			// Go up the Ancestory path until we hit null.
			$level = 1;
			while ($row['subgroup'.$level."_id"] 
					&& $row['subgroup'.$level."_id"] != "NULL"
					&& $level < 29)
			{
				$groupIds[] = $row['subgroup'.$level."_id"];
				$level++;
			}
			
			$result->advanceRow();
		}
		
		// Filter out duplicates and our starting id
		$groupIds = array_unique($groupIds);
		$groupIds = array_diff($groupIds, array($groupOrAgentId));
		
		// now create an array of the group objects to add to the iterator.
		$agentManager =& Services::getService("Agent");
		$idManager =& Services::getService("Id");
		$groups = array();
		foreach ($groupIds as $id) {
			$groupId =& $idManager->getId($id);
			$groups[] =& $agentManager->getGroup($groupId);
		}
				
		return new HarmoniIterator($groups);
	}
}

?>