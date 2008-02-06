<?php

require_once(dirname(__FILE__)."/HarmoniGroup.class.php");

/**
 * The Everyone Group contains all other Agents and Groups in the system, 
 * including the Anonymous Agent. Agents and Groups cannot be added or removed 
 * from this group as they are always in it.
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
 * @version $Id: EveryoneGroup.class.php,v 1.8 2008/02/06 15:37:46 adamfranco Exp $
 */
class EveryoneGroup
	extends HarmoniGroup
{
		
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"EveryoneGroup",true));
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"EveryoneGroup",true));
	}

	/**
	 * An implementation-specific public method that does exactly the same as add(),
	 * but does not insert into the database.
	 * @access public
	 * @param object memberOrGroup
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
	 */
	function attach( Agent $memberOrGroup) {
		throwError(new Error(AgentException::PERMISSION_DENIED(),"EveryoneGroup",true));
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"EveryoneGroup",true));
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
		$agentManager = Services::getService("Agent");
		
		$agents=$agentManager->getAgents();
		
		return $agents;
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
		$agentManager = Services::getService("Agent");
		$myId = $this->getId();
		
		//Filter out ourself
		if ($includeSubgroups)
			$groupIterator = $agentManager->getGroups();
		else
			$groupIterator = $agentManager->getGroupsBySearch($null = null, 
												new Type("Agent & Group Search",
												"edu.middlebury.harmoni", 
												"RootGroups"));
		$groups = array();
		while ($groupIterator->hasNext()) {
			$group = $groupIterator->next();
			if (!$myId->isEqual($group->getId()))
				$groups[] = $group;
		}
		
		$obj = new HarmoniAgentIterator($groups);
		
		return $obj;
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
		return true;
	}
}

?>