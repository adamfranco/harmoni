<?php

require_once(OKI2."/osid/agent/AgentManager.php");

/**
 * <p>
 * AgentManager handles creating, deleting, and getting Agents and Groups.
 * Group is a subclass of Agent. Groups contain members. Group members are
 * Agents or other Groups.
 * </p>
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p></p>
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
 * @version $Id: JavaPOCAgentManager.class.php,v 1.5 2005/01/19 22:28:13 adamfranco Exp $
 * 
 */
class JavaPOCAgentManager
	extends AgentManager {
	var $_javaClassName;
	var $_javaClass;
	
	function JavaPOCAgentManager( $className ) {
		$this->_javaClassName = $className;
		$testClass = new Java($className);
		$ex = java_last_exception_get();
		if ($ex) die("Could not instantiate '$className' (Java): ".$ex->toString);
		java_last_exception_clear();
		
		$this->_javaClass =& $testClass;
	}
	
	/**
	 * Create an Agent with the display name, Type, and Properties specified.
	 * All are immutable.
	 * 
	 * @param string $displayName
	 * @param object Type $agentType
	 * @param object Properties $properties
	 *	
	 * @return object Agent
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
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createAgent ( $displayName, &$agentType, &$properties ) { 
		$result = $this->_javaClass->createAgent($displayName, $agentType, $properties);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Delete the Agent with the specified unique Id.
	 * 
	 * @param object Id $id
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
	 *		   NULL_ARGUMENT}, {@link org.osid.agent.AgentException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteAgent ( &$id ) { 
		$this->_javaClass->deleteAgent($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
	}

	/**
	 * Get the Agent with the specified unique Id. Getting an Agent by name is
	 * not supported since names are not guaranteed to be unique.
	 * 
	 * @param object Id $id
	 *	
	 * @return object Agent
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
	 *		   NULL_ARGUMENT}, {@link org.osid.agent.AgentException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getAgent ( &$id ) { 
		$result = $this->_javaClass->getAgent($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Get all the Agents.	The returned iterator provides access to the Agents
	 * one at a time.  Iterators have a method hasNextAgent() which returns
	 * <code>true</code> if there is an Agent available and a method
	 * nextAgent() which returns the next Agent.
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
	function &getAgents () { 
		$result = $this->_javaClass->getAgents();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Get all the agent Types.	 The returned iterator provides access to the
	 * agent Types from this implementation one at a time.	Iterators have a
	 * method hasNextType() which returns true if there is an agent Type
	 * available and a method nextType() which returns the next agent Type.
	 *	
	 * @return object TypeIterator
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
	function &getAgentTypes () { 
		$result = $this->_javaClass->getAgentTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}
	
	/**
	 * Get all the property Types.	The returned iterator provides access to
	 * the property Types from this implementation one at a time.  Iterators
	 * have a method hasNextType() which returns true if there is another
	 * property Type available and a method nextType() which returns the next
	 * property Type.
	 *	
	 * @return object TypeIterator
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
	function &getPropertyTypes () { 
	   $result = $this->_javaClass->getPropertyTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Create a Group with the display name, Type, description, and Properties
	 * specified.  All but description are immutable.
	 * 
	 * @param string $displayName
	 * @param object Type $groupType
	 * @param string $description
	 * @param object Properties $properties
	 *	
	 * @return object Group
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
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createGroup ( $displayName, &$groupType, $description, &$properties ) { 
		$result = $this->_javaClass->createGroup( $displayName, $groupType, $description, $properties );
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Delete the Group with the specified unique Id.
	 * 
	 * @param object Id $id
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
	 *		   NULL_ARGUMENT}, {@link org.osid.agent.AgentException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteGroup ( &$id ) { 
		$this->_javaClass->deleteGroup($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
	}

	/**
	 * Gets the Group with the specified unique Id. Getting a Group by name is
	 * not supported since names are not guaranteed to be unique.
	 * 
	 * @param object Id $id
	 *	
	 * @return object Group
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
	 *		   NULL_ARGUMENT}, {@link org.osid.agent.AgentException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getGroup ( &$id ) { 
		$result = $this->_javaClass->getGroup($id);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Get all the Groups.	Note since Groups subclass Agents, we are returning
	 * an AgentIterator and there is no GroupIterator. the returned iterator
	 * provides access to the Groups one at a time.	 Iterators have a method
	 * hasNextAgent() which returns true if there is a Group available and a
	 * method nextAgent() which returns the next Group.
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
	function &getGroups () { 
		$result = $this->_javaClass->getGroups();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Get all the group Types.	 The returned iterator provides access to the
	 * group Types from this implementation one at a time.	Iterators have a
	 * method hasNextType() which returns true if there is a group Type
	 * available and a method nextType() which returns the next group Type.
	 *	
	 * @return object TypeIterator
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
	function &getGroupTypes () { 
		$result = $this->_javaClass->getGroupTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

	/**
	 * Get all the Agents of the specified Type.
	 * 
	 * @param object Type $agentType
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
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAgentsByType ( &$agentType ) { 
		$result = $this->_javaClass->getAgentsByType($agentType);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Get all the Groups of the specified Type.
	 * 
	 * @param object Type $groupType
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
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getGroupsByType ( &$groupType ) { 
		$result = $this->_javaClass->getGroupsByType($groupType);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Get all the agent search Types supported by this implementation.
	 *	
	 * @return object TypeIterator
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
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAgentSearchTypes () { 
		$result = $this->_javaClass->getAgentSearchTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Get all the Agents with the specified search criteria and search Type.
	 * 
	 * @param object mixed $searchCriteria (original type: java.io.Serializable)
	 * @param object Type $agentSearchType
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
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAgentsBySearch ( &$searchCriteria, &$agentSearchType ) { 
		$result = $this->_javaClass->getAgentsBySearch($searchCriteria, $agentSearchType);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Get all the group search types supported by this implementation.
	 *	
	 * @return object TypeIterator
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
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getGroupSearchTypes () { 
		$result = $this->_javaClass->getGroupSearchTypes();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 

	/**
	 * Get all the groups with the specified search criteria and search Type.
	 * 
	 * @param object mixed $searchCriteria (original type: java.io.Serializable)
	 * @param object Type $groupSearchType
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
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getGroupsBySearch ( &$searchCriteria, &$groupSearchType ) { 
		$result = $this->_javaClass->getGroupsBySearch($searchCriteria, $groupSearchType);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	} 
}

?>