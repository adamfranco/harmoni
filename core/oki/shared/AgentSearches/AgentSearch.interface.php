<?php

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 *
 * @package harmoni.osid_v1.shared.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentSearch.interface.php,v 1.3 2005/01/19 22:28:12 adamfranco Exp $
 */

class AgentSearchInterface {
		
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>