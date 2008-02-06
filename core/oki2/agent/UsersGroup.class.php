<?php

require_once(dirname(__FILE__)."/HarmoniGroup.class.php");
require_once(dirname(__FILE__)."/HarmoniAgentIterator.class.php");

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
 * @version $Id: UsersGroup.class.php,v 1.13 2008/02/06 15:37:46 adamfranco Exp $
 */
class UsersGroup
	extends HarmoniGroup
{

	/**
	 * The constructor.
	 *
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @access public
	 */
	function UsersGroup() {
		$idManager = Services::getService("Id");
		$this->_id = $idManager->getId("edu.middlebury.agents.users");
		$this->_idString = $this->_id->getIdString();
		$this->_type = new Type("Agents", "edu.middlebury.harmoni", "Any/Anonymous", 
			_("Special group for only users that can be authenticated."));
		$this->_displayName = _("Users");
		$this->_description = _("The Users group contains all Agents that can be authenticated. This may include self-registered visitors as well as centrally-defined users.");
		
// 		$this->_propertiesArray = array();
// 		$propertiesType = new HarmoniType('Agents', 'Harmoni', 'Agent Properties',
// 						'Properties known to the Harmoni Agents System.');
// 		$propertiesArray[0] = new HarmoniProperties($propertiesType);
		
	}
	
	/**
	 * Get the name of this Agent.
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
	function getDisplayName () { 
		return $this->_displayName;
	}
	
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
		return $this->_description;
	}

	/**
	 * Get the id of this Agent.
	 *	
	 * @return object Id
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
	function getId () { 
		return $this->_id;
	}

	/**
	 * Get the type of this Agent.
	 *	
	 * @return object Type
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
	function getType () { 
		return $this->_type;
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"UsersGroup",true));
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"UsersGroup",true));
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"UsersGroup",true));
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
		throwError(new Error(AgentException::PERMISSION_DENIED(),"UsersGroup",true));
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
		$ids = Services::getService("Id");
		$obj = new UsersGroupIterator($agentManager->getAgents());
		
		return $obj;
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
		$groups = array();		
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
		// we are going to ignore the Everyone group and the Anonymous agent
		// otherwise they are in the group
		$ids = Services::getService("Id");
		$ignore = array("edu.middlebury.agents.users","edu.middlebury.agents.everyone","edu.middlebury.agents.anonymous");
		foreach ($igonre as $id) {
			$rId = $ids->getId($id);
			if ($rId->isEqual($memberOrGroup->getId())) return false;
		}
		return true;
	}
}

/**
 * The UsersGroupIterator takes an AgentIterator and filters out the Anonymous user. 
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
 * @version $Id: UsersGroup.class.php,v 1.13 2008/02/06 15:37:46 adamfranco Exp $
 */

class UsersGroupIterator 
	extends HarmoniAgentIterator 
{
	var $_iterator;
	var $_next;
	var $_ignore;
	
	function UsersGroupIterator($agentIterator) {
		$this->_iterator = $agentIterator;
		$this->_next = null;
		$ids = Services::getService("Id");
		$this->_ignore = $ids->getId("edu.middlebury.agents.anonymous");
		
		$this->_getNext();
	}
	
	function _getNext() {
		if (!$this->_iterator->hasNext()) {
			$this->_next = null;
			return;
		}
		
		$this->_next = $this->_iterator->next();
		
		if ($this->_ignore->isEqual($this->_next->getId()))
			$this->_getNext();
	}
	
	function hasNext() {
		return $this->_next?true:false;
	}
	
	function next() {
		if ($this->_next) {
			$next = $this->_next;
			$this->_getNext();
			return $next;
		}
		return null;
	}
}

?>