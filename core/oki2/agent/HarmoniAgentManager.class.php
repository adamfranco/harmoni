<?php

require_once(OKI2."/osid/agent/AgentManager.php");
require_once(OKI2."/osid/agent/AgentException.php");

require_once(HARMONI."oki2/agent/HarmoniAgent.class.php");
require_once(HARMONI."oki2/agent/HarmoniEditableAgent.class.php");
require_once(HARMONI."oki2/agent/HarmoniAgentIterator.class.php");
require_once(HARMONI."oki2/agent/GroupsFromNodesIterator.class.php");
require_once(HARMONI."oki2/agent/MembersOnlyFromTraversalIterator.class.php");
require_once(HARMONI."oki2/agent/HarmoniGroup.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/TokenSearch.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/AncestorGroupSearch.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/RootGroupSearch.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/AgentPropertiesSearch.class.php");

require_once(HARMONI."oki2/shared/HarmoniType.class.php");
require_once(HARMONI."oki2/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."oki2/shared/HarmoniId.class.php");
require_once(HARMONI."oki2/shared/HarmoniTestId.class.php");
require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");
require_once(HARMONI."oki2/agent/UsersGroup.class.php");
require_once(HARMONI."oki2/agent/EveryoneGroup.class.php");

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
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAgentManager.class.php,v 1.54 2008/04/04 17:55:21 achapin Exp $
 *
 * @author Adam Franco
 * @author Dobromir Radichkov
 */
class HarmoniAgentManager
	implements AgentManager
{
	
	/**
	 * Whether to use plain agents or editable agents. 'Flavor' is used because
	 * it would be confusing to use the word 'type' because of the specific use 
	 * of the OSID Type concept
	 * @var string _agentFlavor
	 * @access private
	 */
	
	var $_agentFlavor;
	
	/**
	 * Constructor. Set up any database connections needed.
	 */
	function __construct() {
		$idManager = Services::getService("Id");
		
		$this->_everyoneId = $idManager->getId("edu.middlebury.agents.everyone");
		$this->_allGroupsId = $idManager->getId("edu.middlebury.agents.all_groups");
		$this->_allAgentsId = $idManager->getId("edu.middlebury.agents.all_agents");
		$this->_usersId = $idManager->getId("edu.middlebury.agents.users");
		$this->_anonymousId = $idManager->getId("edu.middlebury.agents.anonymous");
		
		$this->_usersGroup = new UsersGroup();
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( Properties $configuration ) { 
		$this->_configuration =$configuration;
		
		$hierarchyId =$configuration->getProperty('hierarchy_id');
		$agentFlavor =$configuration->getProperty('defaultAgentFlavor');
		
		// ** parameter validation
		ArgumentValidator::validate($hierarchyId, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($agentFlavor, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$idManager = Services::getService("Id");
		$this->_hierarchyId = $idManager->getId($hierarchyId);
		$this->_agentFlavor = $agentFlavor;
		
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		
		
		// initialize our Agent Search Types
		$this->_agentSearches = array ();
		$this->_agentSearches["Agent & Group Search::edu.middlebury.harmoni::TokenSearch"] =
			new TokenSearch;
		$this->_agentSearches["Agent & Group Search::edu.middlebury.harmoni::AgentPropertiesSearch"] =
			new AgentPropertiesSearch($this->_configuration->getProperty('database_index'));
		
		// initialize our Group Search Types
		$this->_groupSearches = array ();
		$this->_groupSearches["Agent & Group Search::edu.middlebury.harmoni::AncestorGroups"] =
			new AncestorGroupSearch ($hierarchy);
		$this->_groupSearches["Agent & Group Search::edu.middlebury.harmoni::RootGroups"] =
			new RootGroupSearch ($hierarchy);
		$this->_groupSearches["Agent & Group Search::edu.middlebury.harmoni::TokenSearch"] =$this->_agentSearches["Agent & Group Search::edu.middlebury.harmoni::TokenSearch"];
		$this->_groupSearches["Agent & Group Search::edu.middlebury.harmoni::AgentPropertiesSearch"] =$this->_agentSearches["Agent & Group Search::edu.middlebury.harmoni::AgentPropertiesSearch"];
		
		$this->_everyoneGroup = new EveryoneGroup($hierarchy, $hierarchy->getNode($this->_everyoneId));
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext =$context;
	} 


	/***
	 * WARNING: NOT IN OSID -- USE AT YOUR OWN RISK
	 * Change the flavor between editable agent and non editable agent
	 *
	 * @return boolean
	 *
	 * @param string $agentFlavor
	 *
	 * @access public
	 */
	 function changeAgentFlavor($agentFlavor){
	 	if($agentFlavor!="HarmoniAgent" && $agentFlavor!="HarmoniEditableAgent"){
			return false;
		}
		
		$this->_agentFlavor = $agentFlavor;
		return true;
	  }
	  
	  /***
	   * WARNING: NOT IN OSID -- USE AT YOUR OWN RISK
	   * Returns the agent flavor
	   *
	   * @return string
	   * @access public
	   */
	   
	  function getAgentFlavor(){
	  	return $this->_agentFlavor;
	  }
	

	/**
	 * Create an Agent with the display name, Type, and Properties specified.
	 * Whether a HarmoniAgent or HarmoniEditableAgent is created depends on the
	 * flavor.
	 * 
	 * @param string $displayName
	 * @param object Type $agentType
	 * @param object Properties $properties
	 * @param optional object Id $id WARNING: NOT IN OSID -- USE AT YOUR OWN RISK
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
	function createAgent ( $displayName, Type $agentType, Properties $properties, Id $agentId = null ) { 
		
		// ** parameter validation
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		$propertiesArray[] =$properties;
		// ** end of parameter validation
		
		// create a new unique id for the agent
		if ($agentId == null) {
			$idManager = Services::getService("Id");
			$agentId =$idManager->createId();
		}
		
		// Create a node for the agent
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$agentNode =$hierarchy->createNode($agentId, $this->_allAgentsId, $agentType, 
			$displayName, "");


		// 3. Store the properties of the agent.
		$propertyManager = Services::getService("Property");
		//properties are grouped by type into typed properties objects which contain all key/value pairs of that type.  That's why there's an array of properties objects
		foreach($propertiesArray as $property){
			$propertyManager->storeProperties($agentId->getIdString(), $property);
		}
				
		// create the agent object to return
		$agent = new $this->_agentFlavor($hierarchy, $agentNode);
		
		return $agent;
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
	function deleteAgent ( Id $id ) {
		// ** parameter validation
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		//remove the properties of the agent from the database
		$propertyManager = Services::getService("Property");
		$propertyManager->deleteAllProperties($id->getIdString());
		
		// Get the node for the agent
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$hierarchy->deleteNode($id);
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
	function getAgent ( Id $id ) { 
		// ** parameter validation
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		// Get the node for the agent
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		if (!$hierarchy->nodeExists($id)) {
			throw new UnknownIdException("'".$id->getIdString()."'");
		}
		$agentNode = new $this->_agentFlavor($hierarchy, $hierarchy->getNode($id));
		
		return $agentNode;
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
	function getAgents () {
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$traversalIterator =$hierarchy->traverse($this->_allAgentsId,
			Hierarchy::TRAVERSE_MODE_DEPTH_FIRST, Hierarchy::TRAVERSE_DIRECTION_DOWN, 
			Hierarchy::TRAVERSE_LEVELS_ALL);
			
		$agentIterator = new MembersOnlyFromTraversalIterator($traversalIterator);
		return $agentIterator;
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
	function getAgentsBySearch ( $searchCriteria, Type $agentSearchType ) { 
		$typeString = $agentSearchType->getDomain()
						."::".$agentSearchType->getAuthority()
						."::".$agentSearchType->getKeyword();
		
		// get the Agent Search object
		$agentSearch =$this->_agentSearches[$typeString];
		if (!is_object($agentSearch))
			throwError(new Error(AgentException::UNKNOWN_TYPE(),"AgentManager",true));
		
		return $agentSearch->getAgentsBySearch($searchCriteria); 
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
	function getAgentSearchTypes () { 
		$types = array();
		// Break our search type keys on "::" and create type objects
		// to return.
		foreach (array_keys($this->_agentSearches) as $typeString) {
			$parts = explode("::", $typeString);
			$types[] = new HarmoniType($parts[0], $parts[1], $parts[2]);
		}
		
		$obj = new HarmoniIterator($types);
		
		return $obj;
	}
	
	/**
	 * Get all the agent Types.	 The returned iterator provides access to the
	 * agent Types from this implementation one at a time.	Iterators have a
	 * method hasNext() which returns true if there is an agent Type
	 * available and a method next() which returns the next agent Type.
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
	function getAgentTypes () { 		
		$agents =$this->getAgents();
	}
	
	/**
	 * Get all the property Types.	The returned iterator provides access to
	 * the property Types from this implementation one at a time.  Iterators
	 * have a method hasNext() which returns true if there is another
	 * property Type available and a method next() which returns the next
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
	function getPropertyTypes () { 
		throw new UnimplementedException;
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
	function createGroup ( $displayName, Type $groupType, $description, Properties $properties, Id $id = null ) { 
		// ** parameter validation
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		// ensure that we aren't using the type of one of the AuthNTypes
		// which would confict with external directories.
		// :: Add External Groups
		$authNMethodManager = Services::getService("AuthNMethodManager");		
		$types =$authNMethodManager->getAuthNTypes();
		while ($types->hasNext()) {
			if ($groupType->isEqual($types->next()))
				throwError(new Error(AgentException::PERMISSION_DENIED(),"GroupManager",true));
		}
		
		// ** end of parameter validation
		
		// create a new unique id for the group
		if (is_object($id) && method_exists($id, 'getIdString')) {
			$groupId = $id;
		} else {
			$idManager = Services::getService("Id");
			$groupId =$idManager->createId();
		}
		
		// 1. Create the node
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$groupNode =$hierarchy->createNode($groupId, $this->_allGroupsId, $groupType, 
			$displayName, $description);
		
				
		// 2. Store the properties of the group.
		$propertyManager = Services::getService("Property");
		$propertiesId = $propertyManager->storeProperties($groupId->getIdString(), $properties);
						
		// create the group object to return
		$group = new HarmoniGroup($hierarchy, $groupNode);
		
		// update our cache for isGroup
		if (isset($this->_groupTreeIds) && is_array($this->_groupTreeIds)) {
			$this->_groupTreeIds[$groupId->getIdString()] =$groupId;
		}
		
		return $group;
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
	 
	function deleteGroup ( Id $id ) {
		
		//remove the properties of the agent from the database
		$propertyManager = Services::getService("Property");
		$propertyManager->deleteAllProperties($id->getIdString());
		
		// Get the node for the agent
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		if (!$hierarchy->nodeExists($id)) {
			throwError(new Error(AgentException::PERMISSION_DENIED(),"GroupManager",true));
		}
		
		
		$hierarchy->deleteNode($id);
		
		// update our cache for isGroup
		if (is_array($this->_groupTreeIds)) {
			unset($this->_groupTreeIds[$id->getIdString()]);
		}
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
	function getGroup ( Id $id ) {
		
		if ($id->isEqual($this->_usersId)) {
			return $this->_usersGroup;
		} else if ($id->isEqual($this->_everyoneId)) {
			return $this->_everyoneGroup;
		} else {
			// Get the node for the agent
			$hierarchyManager = Services::getService("Hierarchy");
			$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
			$group = false;
			
			if ($hierarchy->nodeExists($id)) {
				$group = new HarmoniGroup($hierarchy, $hierarchy->getNode($id));
			} else {
				// Check external directories
				$authNMethodManager = Services::getService("AuthNMethodManager");		
				$types =$authNMethodManager->getAuthNTypes();
				while ($types->hasNext()) {
					$type =$types->next();
					$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
					if ($authNMethod->supportsDirectory() && $authNMethod->isGroup($id)) {
						$group = $authNMethod->getGroup($id);
						break;
					}
				}
			}
			
			if ($group === false)
				throw new UnknownIdException("Could not get Group for Id, '$id'");
			
			return $group;
		}
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
	function getGroups () { 
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$node =$hierarchy->getNode($this->_allGroupsId);
		$children =$node->getChildren();
		
		$groups = array();
		
		$groups[] =$this->getGroup($this->_everyoneId);
		$groups[] =$this->getGroup($this->_usersId);
		
		$nodeGroups = new GroupsFromNodesIterator($children);
		while ($nodeGroups->hasNext()) {
			$groups[] =$nodeGroups->next();
		}
		
		// :: Add External Groups
		$authNMethodManager = Services::getService("AuthNMethodManager");		
		$types =$authNMethodManager->getAuthNTypes();
		while ($types->hasNext()) {
			$type =$types->next();
			$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
			if ($authNMethod->supportsDirectory()) {
				$groupsIterator =$authNMethod->getAllGroups();
				
				while ($groupsIterator->hasNext()) {
					$groups[] =$groupsIterator->next();
				}
			}
		}
		
		$i = new HarmoniAgentIterator($groups);
		return $i;
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
	function getGroupsBySearch ( $searchCriteria, Type $groupSearchType ) { 
		$typeString = $groupSearchType->getDomain()
						."::".$groupSearchType->getAuthority()
						."::".$groupSearchType->getKeyword();
		
		// get the Group Search object
		$groupSearch = $this->_groupSearches[$typeString];
		if (!is_object($groupSearch))
			throwError(new Error(AgentException::UNKNOWN_TYPE().", ".$groupSearchType->asString(),"GroupManager",true));
		
		return $groupSearch->getGroupsBySearch($searchCriteria); 
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
	function getGroupSearchTypes () { 
		$types = array();
		// Break our search type keys on "::" and create type objects
		// to return.
		foreach (array_keys($this->_groupSearches) as $typeString) {
			$parts = explode("::", $typeString);
			$types[] = new HarmoniType($parts[0], $parts[1], $parts[2]);
		}
		
		$obj = new HarmoniIterator($types);
		
		return $obj;
	}
	
	/**
	 * Get all the group Types.	 The returned iterator provides access to the
	 * group Types from this implementation one at a time.	Iterators have a
	 * method hasNext() which returns true if there is a group Type
	 * available and a method next() which returns the next group Type.
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
	function getGroupTypes () { 
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		$node =$hierarchy->getNode($this->_allGroupsId);
		$groups =$node->getChildren();
		
		$types = array();
		$seen = array();
		while($groups->hasNext()) {
			$group =$groups->next();
			$typeString = $group->getType()->asString();
			if (in_array($typeString, $seen)) continue;
			$seen[] = $typeString;
			$types[] =$group->getType();
		}
		
		// Add external directory types
		$authNMethodManager = Services::getService("AuthNMethodManager");		
		$authNTypes =$authNMethodManager->getAuthNTypes();
		while ($authNTypes->hasNext()) {
			$type =$authNTypes->next();
			$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
			if ($authNMethod->supportsDirectory())
				$types[] =$type;
		}
		
		$i = new HarmoniIterator($types);
		return $i;
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
	function getAgentsByType ( Type $agentType ) { 
		throw new UnimplementedException;
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
	function getGroupsByType ( Type $groupType ) {
	} 
	
	/**
	 * Return TRUE if the Id specified corresponds to an agent.
	 * 
	 * WARNING: NOT IN OSID - This method is not part of the OSIDs as of Version 2.0
	 *
	 * @param object Id agentId
	 *
	 * @return boolean
	 */
	function isAgent( Id $id) {
		if ($id->isEqual($this->_usersId))
			return false;
		
		$hierarchyManager = Services::getService("Hierarchy");
		$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
		
		if ($hierarchy->nodeExists($id)) {
			$agentNode =$hierarchy->getNode($id);
			$parents =$agentNode->getParents();
			while($parents->hasNext()) {
				$parent =$parents->next();
				if ($this->_allAgentsId->isEqual($parent->getId()))
					return true;
			}
		}
		
		return FALSE;
	}


	/**
	 * Returns an {@link Agent} or {@link Group} object, depending on what type of agent the passed id refers to.
	 *
	 * WARNING: NOT IN OSID - This method is not part of the OSIDs as of Version 2.0
	 *
	 * @param ref object Id
	 * @return ref object
	 **/
	function getAgentOrGroup(Id $id)
	{
		if ($this->isAgent($id)) return $this->getAgent($id);
		if ($this->isGroup($id)) return $this->getGroup($id);
		
		throw new UnknownIdException("Could not find an Agent or Group with Id '$id'.");
	}
	
	/**
	 * Return TRUE if the Id specified corresponds to an group.
	 * 
	 * WARNING: NOT IN OSID - This method is not part of the OSIDs as of Version 2.0
	 *
	 * @param object Id agentId
	 *
	 * @return boolean
	 */
	function isGroup(Id $id) {
		// Agents are determined by being children of the "All Agents" node.
		// Check this first as Agents are also listed under the group tree.
		if ($this->isAgent($id)) {
			return false;
		}
		
		if ($id->isEqual($this->_usersId))
			return true;
		
		// If the Id does not correspond to an agent and it is a decendent of the
		// groups tree, then it must be a group. 
		if (!isset($this->_groupTreeIds)) {
			$this->_groupTreeIds = array();
		
			$this->_groupTreeIds[$this->_everyoneId->getIdString()] =$this->_everyoneId;
			$this->_groupTreeIds[$this->_allGroupsId->getIdString()] =$this->_allGroupsId;
			$this->_groupTreeIds[$this->_allAgentsId->getIdString()] =$this->_allAgentsId;
			$this->_groupTreeIds[$this->_usersId->getIdString()] =$this->_usersId;


			$hierarchyManager = Services::getService("Hierarchy");
			$hierarchy =$hierarchyManager->getHierarchy($this->_hierarchyId);
			$traversalIterator =$hierarchy->traverse($this->_allGroupsId,
					Hierarchy::TRAVERSE_MODE_DEPTH_FIRST, Hierarchy::TRAVERSE_DIRECTION_DOWN, 
					Hierarchy::TRAVERSE_LEVELS_ALL);
			
			while ($traversalIterator->hasNext()) {
				$traversalInfo =$traversalIterator->next();
				$nodeId =$traversalInfo->getNodeId();
				$this->_groupTreeIds[$nodeId->getIdString()] =$nodeId;
			}
		}
		if (array_key_exists($id->getIdString(), $this->_groupTreeIds))
			return true;
		
		// Check external directories
		$authNMethodManager = Services::getService("AuthNMethodManager");		
		$types =$authNMethodManager->getAuthNTypes();
		while ($types->hasNext()) {
			$type =$types->next();
			$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
			if ($authNMethod->supportsDirectory() && $authNMethod->isGroup($id))
				return true;
		}
		
		return false;
	}
	
	
	/*********************************************************
	 * The methods below deal with attaching externally-defined
	 * groups to our hierarchy-based groups
	 *********************************************************/
	
	/**
	 * Add an External group to a Hierarchy-based group.
	 * 
	 * @param object Id $hierarchyParentId
	 * @param object Id $externalChildId
	 * @return void
	 * @access public
	 * @since 11/6/07
	 */
	public function addExternalChildGroup (Id $hierarchyParentId, Id $externalChildId) {
		// Check to see that it hasn't been added.
		$children = $this->getExternalChildGroupIds($hierarchyParentId);
		foreach ($children as $child) {
			if ($externalChildId->isEqual($child))
				throw new HarmoniException("Child group '".$externalChildId->getIdString()."' has already been added to group '".$hierarchyParentId->getIdString()."'.");
		}
		
		// Insert the row.
		$query = new InsertQuery;
		$query->setTable('agent_external_children');
		$query->addValue('fk_parent', $hierarchyParentId->getIdString());
		$query->addValue('fk_child', $externalChildId->getIdString());
		
		$dbc = Services::getService("DBHandler");
		$dbc->query($query, $this->_configuration->getProperty('database_index'));
	}
	
	/**
	 * Remove an External group from a Hierarchy-based group.
	 * 
	 * @param object Id $hierarchyParentId
	 * @param object Id $externalChildId
	 * @return void
	 * @access public
	 * @since 11/6/07
	 */
	public function removeExternalChildGroup (Id $hierarchyParentId, Id $externalChildId) {
		// Remove the row.
		$query = new DeleteQuery;
		$query->setTable('agent_external_children');
		$query->addWhereEqual('fk_parent', $hierarchyParentId->getIdString());
		$query->addWhereEqual('fk_child', $externalChildId->getIdString());
		
		$dbc = Services::getService("DBHandler");
		$dbc->query($query, $this->_configuration->getProperty('database_index'));
	}
	
	/**
	 * Answer the Externally-defined group Ids that are the children of the group id passed.
	 * 
	 * @param object Id $hierarchyParentId
	 * @return array
	 * @access public
	 * @since 11/6/07
	 */
	public function getExternalChildGroupIds (Id $hierarchyParentId) {
		$query = new SelectQuery;
		$query->addTable('agent_external_children');
		$query->addColumn('fk_child');
		$query->addWhereEqual('fk_parent', $hierarchyParentId->getIdString());
		
		$dbc = Services::getService("DBHandler");
		$result = $dbc->query($query, $this->_configuration->getProperty('database_index'));
		
		$idMgr = Services::getService("Id");
		$children = array();
		while ($result->hasMoreRows()) {
			$children[] = $idMgr->getId($result->field('fk_child'));
			$result->advanceRow();
		}
		return $children;
	}
	
	/**
	 * Answer the Hierarchy-based parent-group for an external group Id.
	 * 
	 * @param array $groupIds An array of Ids
	 * @return array an array of parent group Ids
	 * @access public
	 * @since 11/6/07
	 */
	public function getHierarchyParentIdsForExternalGroups (array $groupIds) {
		if (!count($groupIds))
			return array();
		
		$query = new SelectQuery;
		$query->addTable('agent_external_children');
		$query->addColumn('DISTINCT fk_parent', 'parent');
		$query->addWhereIn('fk_child', $groupIds);
		
		$dbc = Services::getService("DBHandler");
		$result = $dbc->query($query, $this->_configuration->getProperty('database_index'));
		
		$idMgr = Services::getService("Id");
		$parents = array();
		while ($result->hasMoreRows()) {
			$parents[] = $idMgr->getId($result->field('parent'));
			$result->advanceRow();
		}
		return $parents;
	}
	
	/**
     * Verify to OsidLoader that it is loading
     * 
     * <p>
     * OSID Version: 2.0
     * </p>
     * .
     * 
     * @throws object OsidException 
     * 
     * @access public
     */
    public function osidVersion_2_0 () {}
}

?>