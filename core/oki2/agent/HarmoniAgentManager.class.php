<?

require_once(OKI2."/osid/agent/AgentManager.php");

require_once(HARMONI."oki2/agent/HarmoniAgent.class.php");
require_once(HARMONI."oki2/agent/HarmoniAgentIterator.class.php");
require_once(HARMONI."oki2/agent/HarmoniGroup.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/HarmoniAgentExistsSearch.class.php");
require_once(HARMONI."oki2/agent/AgentSearches/AncestorGroupSearch.class.php");

require_once(HARMONI."oki2/shared/HarmoniType.class.php");
require_once(HARMONI."oki2/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."oki2/shared/HarmoniId.class.php");
require_once(HARMONI."oki2/shared/HarmoniTestId.class.php");
require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");

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
 * 
 * @package harmoni.osid.agent
 * @author Adam Franco, Dobromir Radichkov
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: HarmoniAgentManager.class.php,v 1.4 2005/01/17 17:00:20 adamfranco Exp $
 * 
 */
class HarmoniAgentManager
	extends AgentManager
{

	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the shared database.
	 * @attribute private string _sharedD
	 */
	var $_sharedDB;
	
	
	/**
	 * An array that will store the cached agent objects.
	 * @attribute private array _agentsCache
	 */
	var $_agentsCache;
	
	
	/**
	 * An array that will store the cached group objects.
	 * @attribute private array _groupsCache
	 */
	var $_groupsCache;
	
	
	/**
	 * Will be set to true if all agents have been cached;
	 * @attribute private boolean _allAgentsCached
	 */
	var $_allAgentsCached;
	
	
	/**
	 * Will be set to true if all groups have been cached;
	 * @attribute private boolean _allAgentsCached
	 */
	var $_allGroupsCached;
	
	
	/**
	 * An array of all cached Id objects.
	 * @attribute private array _ids
	 */
	var $_ids;
	
	
	/**
	 * Constructor. Set up any database connections needed.
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
	 */
	function HarmoniAgentManager($dbIndex, $sharedDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($sharedDB, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_sharedDB = $sharedDB;
		
		// initialize cache
		$this->_agentsCache = array();
		$this->_groupsCache = array();
		$this->_ids = array();
		
		$this->_allAgentsCached = false;
		$this->_allGroupsCached = false;
		
		// initialize our Agent Search Types
		$this->_agentSearches = array ();
		$this->_agentSearches["Agent & Group Search::Middlebury::HarmoniAgentExists"] =&
			new HarmoniAgentExistsSearch;
		
		// initialize our Group Search Types
		$this->_groupSearches = array ();
		$this->_groupSearches["Agent & Group Search::Middlebury::AncestorGroups"] =&
			new AncestorGroupSearch ($this->_dbIndex);
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
	 * @public
	 */
	function &createAgent ( $displayName, &$agentType, &$properties ) { 
		// ** parameter validation
		ArgumentValidator::validate($agentType, new ExtendsValidatorRule("HarmoniType"), true);
		ArgumentValidator::validate($properties, new ExtendsValidatorRule("Properties"), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		// create a new unique id for the agent
		$agentId =& $this->createId();
		// get the actual id
		$agentIdValue = $agentId->getIdString();
		
		// now insert the agent in the database

		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_sharedDB.".";

		// 1. Insert the type
		$typeIdValue = $this->_getTypeId($agentType);
		
		// 2. Now that we know the id of the type, insert the agent itself
		$query =& new InsertQuery();
		$query->setTable($db."agent");
		$columns = array();
		$columns[] = "agent_id";
		$columns[] = "agent_display_name";
		$columns[] = "fk_type";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($agentIdValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($typeIdValue)."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 3. Store the properties of the agent.
		$propertiesId = $this->_storeProperties($properties);
		
		// 4. Store the Mapping of the Properties to the Agent
		$query =& new InsertQuery;
		$query->setTable("agent_properties");
		$query->setColumns(array(
			"fk_agent",
			"fk_properties"
		));
		$query->setValues(array(
			"'".addslashes($agentIdValue)."'",
			"'".addslashes($propertiesId)."'"
		));
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		
		// create the agent object to return
		$propertiesArray = array();
		$propertiesArray[] =& $properties;
		$agent =& new HarmoniAgent($displayName, $agentId, $agentType, $propertiesArray, $this->_dbIndex, $this->_sharedDB);
		// then cache it
		$this->_agentsCache[$agentIdValue] =& $agent;
		
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
	 * @public
	 */
	function deleteAgent ( &$id ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		$dbHandler =& Services::requireService("DBHandler");

		// 1. Get the id of the type associated with the agent
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."agent");
		$query->addColumn("fk_type", "type_id", $db."agent");
		$query->addWhere($db."agent.agent_id = '".addslashes($idValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AgentException::UNKNOWN_ID(),"AgentManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AgentException::OPERATION_FAILED() ,"AgentManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Delete the Properties mapping of the agent
		// get the properties ids first
		$query =& new SelectQuery();
		$query->addTable($db."agent_properties");
		$query->addColumn("fk_properties");
		$query->addWhere($db."agent_properties.fk_agent = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$propertiesIdValues = array();
		while ($row =& $queryResult->getCurrentRow()) {
			$propertiesIdValues[] = $row['fk_properties'];
			$queryResult->advanceRow();
		}
		
		// Delete the mapping
		$query =& new DeleteQuery();
		$query->setTable($db."agent_properties");
		$query->addWhere($db."agent_properties.fk_agent = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 3. Delete the properties of the agent
		// Delete each Property entry.
		if (count($propertiesIdValues)) {
			$query =& new DeleteQuery();
			$query->setTable($db."shared_property");
			$where = array();
			foreach ($propertiesIdValues as $propertiesIdValue) {
				$where[] = "fk_properties = '".addslashes($propertiesIdValue)."'";
			}
			$query->addWhere(implode(" OR ", $where));
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			
			// Delete each Properties entry
			$query =& new DeleteQuery();
			$query->setTable($db."shared_properties");
			$where = array();
			foreach ($propertiesIdValues as $propertiesIdValue) {
				$where[] = "id = '".addslashes($propertiesIdValue)."'";
			}
			$query->addWhere(implode(" OR ", $where));
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}
		
		// 4. Now delete the agent
		$query =& new DeleteQuery();
		$query->setTable($db."agent");
		$query->addWhere($db."agent.agent_id = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 5. Now see if any other agents have the same type
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."agent");
		// count the number of agents using the same type
		$query->addColumn("COUNT({$db}agent.fk_type)", "num");
		$query->addWhere($db."agent.fk_type = '".addslashes($typeIdValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { 
			// if no other agents use this type, then delete the type
			
			// WARNING
			// This could pose a problem as other services use this same generic
			// types table. A separate agent_type table should be used instead.
			$query =& new DeleteQuery();
			$query->setTable($db."type");
			$query->addWhere($db."type.type_id = '".addslashes($typeIdValue)."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

		// 6. Now, we must remove this agent from all groups that include it
		// first select all such groups (we will need this to update the cache)
		$query =& new SelectQuery();
		$query->addColumn("fk_groups", "group_id", $db."j_groups_agent");
		$query->addTable($db."j_groups_agent");
		$query->addWhere($db."j_groups_agent.fk_agent = '".addslashes($idValue)."'");
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		$groupsResult =& $dbHandler->query($query, $this->_dbIndex);
		// now delete the entries in the database
		$query =& new DeleteQuery();
		$query->setTable($db."j_groups_agent");
		$query->addWhere($db."j_groups_agent.fk_agent = '".addslashes($idValue)."'");
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 7. Make sure that the AuthN system still isn't maintaining a
		// Mapping to this agent
		$authN =& Services::getService("AuthN");
		$authN->deleteMapping($id);
		
		// 8. Update the cache
		if (isset($this->_agentsCache[$idValue])) {
			while ($groupsResult->hasMoreRows()) {
				// fetch current row
				$arr = $groupsResult->getCurrentRow();
				$groupId = $arr['group_id'];
				// if the group has been fetched then get rid of the agent
				if (isset($this->_groupsCache[$groupId])) {
//					echo "<b>unsetting the agent # {$idValue} in group # ".$groupId."</b><br />";
					unset($this->_groupsCache[$groupId]->_agents[$idValue]);
				}

				$groupsResult->advanceRow();
			}
			
			$this->_agentsCache[$idValue] = null; // IMPORTANT: this will set to null all other
												  // vars pointing to this one
			unset($this->_agentsCache[$idValue]);
		}
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
	 * @public
	 */
	function &getAgent ( &$id ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_agentsCache[$idValue]))
			return $this->_agentsCache[$idValue];
			
		$where = $db."agent.agent_id = '".addslashes($idValue)."'";

		$this->_loadAgents($where);
		
		if (!isset($this->_agentsCache[$idValue]))
			throwError(new Error(AgentException::UNKNOWN_ID(),"AgentManager",true));
		
		return $this->_agentsCache[$idValue];
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
	 * @public
	 */
	function &getAgents () { 
		if (!$this->_allAgentsCached)
			$this->_loadAgents();
		
		$result =& new HarmoniAgentIterator($this->_agentsCache);
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
	 * @public
	 */
	function &getAgentsBySearch ( &$searchCriteria, &$agentSearchType ) { 
		$typeString = $agentSearchType->getDomain()
						."::".$agentSearchType->getAuthority()
						."::".$agentSearchType->getKeyword();
		
		// get the Agent Search object
		$agentSearch =& $this->_agentSearches[$typeString];
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
	 * @public
	 */
	function &getAgentSearchTypes () { 
		$types = array();
		// Break our search type keys on "::" and create type objects
		// to return.
		foreach (array_keys($this->_agentSearches) as $typeString) {
			$parts = explode("::", $typeString);
			$types[] =& new HarmoniType($parts[0], $parts[1], $parts[2]);
		}
		
		return new HarmoniIterator($types);
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
	 * @public
	 */
	function &getAgentTypes () { 
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		$query->addTable($db."agent");
		$joinc = $db."agent.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->setDistinct(true);
		$query->addColumn("type_id", "id", $db."type");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);

		$types = array();
		while ($queryResult->hasMoreRows()) {
			// fetch current row
			$arr = $queryResult->getCurrentRow();
			
			// create agent object
			$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
			
			// add it to array
			$types[] =& $type;

			$queryResult->advanceRow();
		}
		
		$result =& new HarmoniTypeIterator($types);
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
	 * @public
	 */
	function &getPropertyTypes () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
	 * @public
	 */
	function &createGroup ( $displayName, &$groupType, $description, &$properties ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("HarmoniType");
		ArgumentValidator::validate($groupType, $extendsRule, true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($properties, new ExtendsValidatorRule("Properties"), true);
		// ** end of parameter validation
		
		// create a new unique id for the group
		$groupId =& $this->createId();
		// get the actual id
		$groupIdValue = $groupId->getIdString();
		
		// now insert the group in the database

		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_sharedDB.".";

		// 1. Insert the type
		
		$domain = $groupType->getDomain();
		$authority = $groupType->getAuthority();
		$keyword = $groupType->getKeyword();
		$desc = $groupType->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query =& new SelectQuery();
		$query->addTable($db."type");
		$query->addColumn("type_id", "id", $db."type");
		$where = $db."type.type_domain = '".addslashes($domain)."'";
		$where .= " AND ".$db."type.type_authority = '".addslashes($authority)."'";
		$where .= " AND ".$db."type.type_keyword = '".addslashes($keyword)."'";
		$where .= " AND ".$db."type.type_description = '".addslashes($desc)."'";
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) // if the type is already in the database
			$typeIdValue = $queryResult->field("id"); // get the id
		else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db."type");
			$columns = array();
			$columns[] = "type_domain";
			$columns[] = "type_authority";
			$columns[] = "type_keyword";
			$columns[] = "type_description";
			$query->setColumns($columns);
			$values = array();
			$values[] = "'".addslashes($domain)."'";
			$values[] = "'".addslashes($authority)."'";
			$values[] = "'".addslashes($keyword)."'";
			$values[] = "'".addslashes($desc)."'";
			$query->setValues($values);

			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			$typeIdValue = $queryResult->getLastAutoIncrementValue();
		}
		
		// 2. Now that we know the id of the type, insert the group itself
		$query =& new InsertQuery();
		$query->setTable($db."groups");
		$columns = array();
		$columns[] = "groups_id";
		$columns[] = "groups_display_name";
		$columns[] = "groups_description";
		$columns[] = "fk_type";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($groupIdValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($description)."'";
		$values[] = "'".addslashes($typeIdValue)."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 3. Store the properties of the group.
		$propertiesId = $this->_storeProperties($properties);
		
		// 4. Store the Mapping of the Properties to the Agent
		$query =& new InsertQuery;
		$query->setTable("group_properties");
		$query->setColumns(array(
			"fk_group",
			"fk_properties"
		));
		$query->setValues(array(
			"'".addslashes($groupIdValue)."'",
			"'".addslashes($propertiesId)."'"
		));
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		// create the group object to return
		$propertiesArray = array();
		$propertiesArray[] =& $properties;
		$group =& new HarmoniGroup($displayName, $groupId, $groupType, $propertiesArray, $description, $this->_dbIndex, $this->_sharedDB);
		// then cache it
		$this->_groupsCache[$groupIdValue] =& $group;
		
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
	 * @public
	 */
	function deleteGroup ( &$id ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		$dbHandler =& Services::requireService("DBHandler");

		// 1. Get the id of the type associated with the agent
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."groups");
		$query->addColumn("fk_type", "type_id", $db."groups");
		$query->addWhere($db."groups.groups_id = '".addslashes($idValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error(AgentException::UNKNOWN_ID(),"AgentManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error(AgentException::OPERATION_FAILED() ,"AgentManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Delete the Properties mapping of the agent
		// get the properties ids first
		$query =& new SelectQuery();
		$query->addTable($db."agent_properties");
		$query->addColumn("fk_properties");
		$query->addWhere($db."agent_properties.fk_agent = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$propertiesIdValues = array();
		while ($row =& $queryResult->getCurrentRow()) {
			$propertiesIdValues[] = $row['fk_properties'];
			$queryResult->advanceRow();
		}
		
		// Delete the mapping
		$query =& new DeleteQuery();
		$query->setTable($db."group_properties");
		$query->addWhere($db."group_properties.fk_group = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 3. Delete the properties of the group
		// Delete each Property entry.
		if (count($propertiesIdValues)) {
			$query =& new DeleteQuery();
			$query->setTable($db."shared_property");
			$where = array();
			foreach ($propertiesIdValues as $propertiesIdValue) {
				$where[] = "fk_properties = '".addslashes($propertiesIdValue)."'";
			}
			$query->addWhere(implode(" OR ", $where));
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			
			// Delete each Properties entry
			$query =& new DeleteQuery();
			$query->setTable($db."shared_properties");
			$where = array();
			foreach ($propertiesIdValues as $propertiesIdValue) {
				$where[] = "id = '".addslashes($propertiesIdValue)."'";
			}
			$query->addWhere(implode(" OR ", $where));
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}
		
		// 4. Now delete the group
		$query =& new DeleteQuery();
		$query->setTable($db."groups");
		$query->addWhere($db."groups.groups_id = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		// 5. Now see if any other groups have the same type
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."groups");
		// count the number of groups using the same type
		$query->addColumn("COUNT({$db}groups.fk_type)", "num");
		$query->addWhere($db."groups.fk_type = '".addslashes($typeIdValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { // if no other groups use this type, then delete the type
			$query =& new DeleteQuery();
			$query->setTable($db."type");
			$query->addWhere($db."type.type_id = '".addslashes($typeIdValue)."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

		// 6. Now, we must remove any entry in the join table that reference
		// this group
		// first select all groups that are parents of this group
		$query =& new SelectQuery();
		$query->addColumn("fk_parent", "group_id", $db."j_groups_groups");
		$query->addTable($db."j_groups_groups");
		$query->addWhere($db."j_groups_groups.fk_child = '".addslashes($idValue)."'");
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		$groupsResult =& $dbHandler->query($query, $this->_dbIndex);
		// now delete the entries in the database
		$query =& new DeleteQuery();
		$query->setTable($db."j_groups_groups");
		$query->addWhere($db."j_groups_groups.fk_parent = '".addslashes($idValue)."'");
		$query->addWhere($db."j_groups_groups.fk_child = '".addslashes($idValue)."'", _OR);
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 7. Make sure that the AuthN system still isn't maintaining a
		// Mapping to this agent
		$authN =& Services::getService("AuthN");
		$authN->deleteMapping($id);
		
		// 8. Update the cache
		if (isset($this->_groupsCache[$idValue])) {
			while ($groupsResult->hasMoreRows()) {
				// fetch current row
				$arr = $groupsResult->getCurrentRow();
				$groupId = $arr['group_id'];
				// if the group has been fetched then get rid of the agent
				if (isset($this->_groupsCache[$groupId])) {
//					echo "<b>unsetting the group # {$idValue} in group # ".$groupId."</b><br />";
					unset($this->_groupsCache[$groupId]->_groups[$idValue]);
				}

				$groupsResult->advanceRow();
			}
			
			$this->_groupsCache[$idValue] = null; // IMPORTANT: this will set to null all other
												  // vars pointing to this one
			unset($this->_groupsCache[$idValue]);
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
	 * @public
	 */
	function &getGroup ( &$id ) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_groupsCache[$idValue]))
			return $this->_groupsCache[$idValue];

		$where = $db."subgroup0.groups_id = '".addslashes($idValue)."'";

		$this->_loadGroups($where);
		
		if (!isset($this->_groupsCache[$idValue]))
			throwError(new Error(AgentException::UNKNOWN_ID(),"AgentManager",true));
		
		return $this->_groupsCache[$idValue];
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
	 * @public
	 */
	function &getGroups () { 
		if (!$this->_allGroupsCached)
			$this->_loadGroups();
		
		$result =& new HarmoniAgentIterator($this->_groupsCache);
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
	 * @public
	 */
	function &getGroupsBySearch ( &$searchCriteria, &$groupSearchType ) { 
		ArgumentValidator::validate($groupSearchType, new ExtendsValidatorRule("HarmoniType"));
		$typeString = $groupSearchType->getDomain()
						."::".$groupSearchType->getAuthority()
						."::".$groupSearchType->getKeyword();
		
		// get the Group Search object
		$groupSearch =& $this->_groupSearches[$typeString];
		if (!is_object($groupSearch))
			throwError(new Error(AgentException::UNKNOWN_TYPE(),"GroupManager",true));
		
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
	 * @public
	 */
	function &getGroupSearchTypes () { 
		$types = array();
		// Break our search type keys on "::" and create type objects
		// to return.
		foreach (array_keys($this->_groupSearches) as $typeString) {
			$parts = explode("::", $typeString);
			$types[] =& new HarmoniType($parts[0], $parts[1], $parts[2]);
		}
		
		return new HarmoniIterator($types);
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
	 * @public
	 */
	function &getGroupTypes () { 
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		$query->addTable($db."groups");
		$joinc = $db."groups.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->setDistinct(true);
		$query->addColumn("type_id", "id", $db."type");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);

		$types = array();
		while ($queryResult->hasMoreRows()) {
			// fetch current row
			$arr = $queryResult->getCurrentRow();
			
			// create agent object
			$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
			
			// add it to array
			$types[] =& $type;

			$queryResult->advanceRow();
		}
		
		$result =& new HarmoniTypeIterator($types);
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
	 * @public
	 */
	function &getAgentsByType ( &$agentType ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
	 * @public
	 */
	function &getGroupsByType ( &$groupType ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
	function isAgent(& $id) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_agentsCache[$idValue]))
			return TRUE;
		
		$db = $this->_sharedDB.".";
		$where = $db."agent.agent_id = '".addslashes($idValue)."'";

		$this->_loadAgents($where);
		
		if (isset($this->_agentsCache[$idValue]))
			return TRUE;
		
		return FALSE;
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
	function isGroup(& $id) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_groupsCache[$idValue]))
			return TRUE;
		
		$db = $this->_sharedDB.".";
		$where = $db."subgroup0.groups_id = '".addslashes($idValue)."'";

		$this->_loadGroups($where);
		
		if (isset($this->_groupsCache[$idValue]))
			return TRUE;
		
		return FALSE;
	}


	/**
	 * A private function that can be used by either getAgent or getAgents. Loads
	 * agents in the internal cache.
	 * @access protected
	 * @param string $where An optional where clause.
	 * @param string $fromGroup An optional group id string to limit the resulting
	 *		agents to.
	 * @return array The agent ids found when limited by the where and fromGroup
	 *		parameters.
	 **/
	function _loadAgents($where = null, $fromGroup = null) {
		$foundIds = array();
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		// If we have a group that we wish to limit the results to,
		// join the agents to that group table.
		if ($fromGroup !== NULL) {
			// Add the group tables to join to.
			$query->addTable($db."groups");
			$joinc = $db."groups.groups_id = ".$db."j_groups_agent.fk_groups";
			$query->addTable($db."j_groups_agent", LEFT_JOIN, $joinc);
			$joinc = $db."j_groups_agent.fk_agent = ".$db."agent.agent_id";
			$query->addTable($db."agent", LEFT_JOIN, $joinc);
			
			// Add a where clause to limit to this group
			$query->addWhere($db."groups.groups_id = '".addslashes($fromGroup)."'");
		} 
		// If we want agents from any group, just start with the agent table
		else {
			$query->addTable($db."agent");
		}
		$joinc = $db."agent.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		// Join to the properties mapping table
		$joinc = $db."agent.agent_id = ".$db."agent_properties.fk_agent";
		$query->addTable($db."agent_properties", LEFT_JOIN, $joinc);
		// Join to the properties and each Property
		$joinc = $db."agent_properties.fk_properties = ".$db."shared_properties.id";
		$query->addTable($db."shared_properties", LEFT_JOIN, $joinc);
		$joinc = $db."shared_properties.fk_type = ".$db."properties_type.type_id";
		$query->addTable($db."type", LEFT_JOIN, $joinc, "properties_type");
		$joinc = $db."shared_properties.id = ".$db."shared_property.fk_properties";
		$query->addTable($db."shared_property", LEFT_JOIN, $joinc);
		
		// set the columns to select
		$query->addColumn("agent_id", "id", $db."agent");
		$query->addColumn("agent_display_name", "display_name", $db."agent");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		$query->addColumn("id", "properties_id", $db."shared_properties");
		$query->addColumn("type_domain", "properties_domain", $db."properties_type");
		$query->addColumn("type_authority", "properties_authority", $db."properties_type");
		$query->addColumn("type_keyword", "properties_keyword", $db."properties_type");
		$query->addColumn("type_description", "properties_description", $db."properties_type");
		$query->addColumn("property_key", "property_key", $db."shared_property");
		$query->addColumn("property_value", "property_value", $db."shared_property");
		
		if ($where)
			$query->addWhere($where);
		
//		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		while ($arr = $queryResult->getCurrentRow()) {
			// If we are out of rows or have moved on to the next agent, create our agent object
			if (!$queryResult->advanceRow() || $queryResult->field('id') != $arr['id']) {
				$instantiateAgent = TRUE;
				$foundIds[] = $arr['id'];
			} else {
				$instantiateAgent = FALSE;
			}
				
			// If we don't have a Agent in our cache, go through the steps to
			// create and cache it.
			if (!isset($this->_agentsCache[$arr['id']])) {
			
				// Create an array for this agent's properties if it doesn't exist
				// I was having reference problems when attempting to use one array
				// that got passed off and reset.
				$propertiesArrayName = "propertiesArray".$arr['id'];
				if (!is_array($$propertiesArrayName))
					$$propertiesArrayName = array();
				
				// Build our properties objects to add to the Agent.
				if ($arr['properties_id'] && $arr['properties_id'] != "NULL") {
				
					// Create a name for the Current Properties variable. I was 
					// having reference problems when attempting to use one variable name
					// that got passed off and reset.
					$currentPropertiesName = "currentProperties".$arr['properties_id'];
						
						
					// If we are starting on a new properties object, create a new object and add it to our array.
					if (!is_object($$currentPropertiesName) || $arr['properties_id'] != $currentPropertiesId) 
					{
						$propertiesType =& new HarmoniType(
											$arr['properties_domain'],
											$arr['properties_authority'],
											$arr['properties_keyword'],
											$arr['properties_description']);
						
						// Create the new Properties object
						$$currentPropertiesName =& new HarmoniProperties($propertiesType);
						$currentPropertiesId = $arr['properties_id'];
						
						// add the new Properties object to the Properties array for the
						// current Asset.
						$myArray =& $$propertiesArrayName;
						$myArray[] =& $$currentPropertiesName;
					}
					
					// Add the current Property row to the current Properties
					if ($arr['property_key']) {
						$$currentPropertiesName->addProperty(
									unserialize(base64_decode($arr['property_key'])), 
									unserialize(base64_decode($arr['property_value'])));
					}
				}
				
				if ($instantiateAgent) {
					// create agent object
					$type =& new HarmoniType($arr['domain'],
											$arr['authority'],
											$arr['keyword'],
											$arr['description']);
					// make sure that we aren't passing agents the same properties array.
					$agent =& new HarmoniAgent(
									$arr['display_name'], 
									$this->getId($arr['id']), 
									$type,
									$$propertiesArrayName,
									$this->_dbIndex, 
									$this->_sharedDB);
					
					$this->_agentsCache[$arr['id']] =& $agent;
				}
			}
		}
		
		// Only specify that we are fully cached if we didn't limit the
		// results
		if ($where === NULL)
			$this->_allAgentsCached = true;
		
		return $foundIds;
	}
	
	/**
	 * A private function that can be used by either getGroup or getGroups. Doesn't
	 * return anything because everything is stored internally in the cache.
	 * @access public
	 * @param string where An optional where clause.
	 **/
	function _loadGroups($where = null) {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the columns to select
		// these are columns related to the main group
		$query->addColumn("groups_id", "subgroup0_id", $db."subgroup0");
		$query->addColumn("groups_display_name", "display_name", $db."subgroup0");
		$query->addColumn("groups_description", "group_description", $db."subgroup0");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "type_description", $db."type");
		// Properties for the main group
		$query->addColumn("id", "properties_id", $db."shared_properties");
		$query->addColumn("type_domain", "properties_domain", $db."properties_type");
		$query->addColumn("type_authority", "properties_authority", $db."properties_type");
		$query->addColumn("type_keyword", "properties_keyword", $db."properties_type");
		$query->addColumn("type_description", "properties_description", $db."properties_type");
		$query->addColumn("property_key", "property_key", $db."shared_property");
		$query->addColumn("property_value", "property_value", $db."shared_property");

		// set the tables
		$query->addTable($db."groups", NO_JOIN, "", "subgroup0");
		$joinc = $db."subgroup0.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		// Join to the properties mapping table
		$joinc = $db."subgroup0.groups_id = ".$db."group_properties.fk_group";
		$query->addTable($db."group_properties", LEFT_JOIN, $joinc);
		// Join to the properties and each Property
		$joinc = $db."group_properties.fk_properties = ".$db."shared_properties.id";
		$query->addTable($db."shared_properties", LEFT_JOIN, $joinc);
		$joinc = $db."shared_properties.fk_type = ".$db."properties_type.type_id";
		$query->addTable($db."type", LEFT_JOIN, $joinc, "properties_type");
		$joinc = $db."shared_properties.id = ".$db."shared_property.fk_properties";
		$query->addTable($db."shared_property", LEFT_JOIN, $joinc);
		// The first part of the left join
		$joinc = $db."subgroup0.groups_id = ".$db."subgroup1.fk_parent";
		$query->addTable($db."j_groups_groups", LEFT_JOIN, $joinc, "subgroup1");
		$query->addColumn("fk_child", "subgroup".($level+1)."_id", "subgroup1");
		
		// now left join with itself.
		// maximum number of joins is 31, we've used 7 already, so there are 24 left
		// bottom line: a maximum group hierarchy of 25 levels
		for ($level = 1; $level <= 24; $level++) {
			$joinc = "subgroup".($level).".fk_child = subgroup".($level+1).".fk_parent";
			$query->addTable($db."j_groups_groups", LEFT_JOIN, $joinc, "subgroup".($level+1));
			$query->addColumn("fk_child", "subgroup".($level+1)."_id", "subgroup".($level+1));
		}
		
		// set the where clause
		if ($where)
			$query->addWhere($where);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() == 0)
			return;

		// Now, here is what we need to do.
		// First of all, in the end, we want to have a Group object, with all 
		// its Agent and sub Groups objects added appropriately. It should be then
		// cached by storing it into the $_groupsCache array. Moreover, all the
		// agent and subgroups should also be appropriately cached along the way.
		
		// In order to do so, we continuously fetch the subgroups, see if they have been cached, if not cache them.
		// We start from the leaves, so that as we go up, children would have already been cached, and
		// we can just add them to the current subgroup. Thus, we gradually build the subtree
		// rooted at the group which we are trying to get (let's mention once more, we do so
		// by building the group tree starting from the leaves).
		
		// an array of booleans specifying whether a group was originally cached
		$originallyCached = array();
		foreach (array_keys($this->_groupsCache) as $i => $key)
			$originallyCached[$key] = true;
			
//		echo "<pre>\n originallyCached: ";
//		print_r($originallyCached);
//		echo "</pre>\n";

		// prepare a query object that we will use in the loop
		// we do so in order to avoid continuous initialization of the objects
		// (the only thing that will change is the WHERE clause)
		// --- subgroup QUERY
		$subquery1 =& new SelectQuery();
		$subquery1->addColumn("groups_display_name", "g_display_name", $db."groups");
		$subquery1->addColumn("groups_description", "g_description", $db."groups");
		$subquery1->addColumn("type_domain", "gt_domain", $db."type");
		$subquery1->addColumn("type_authority", "gt_authority", $db."type");
		$subquery1->addColumn("type_keyword", "gt_keyword", $db."type");
		$subquery1->addColumn("type_description", "gt_description", $db."type");
		// Properties for the group
		$subquery1->addColumn("id", "properties_id", $db."shared_properties");
		$subquery1->addColumn("type_domain", "properties_domain", $db."properties_type");
		$subquery1->addColumn("type_authority", "properties_authority", $db."properties_type");
		$subquery1->addColumn("type_keyword", "properties_keyword", $db."properties_type");
		$subquery1->addColumn("type_description", "properties_description", $db."properties_type");
		$subquery1->addColumn("property_key", "property_key", $db."shared_property");
		$subquery1->addColumn("property_value", "property_value", $db."shared_property");

		// set the tables
		$subquery1->addTable($db."groups");
		$joinc = $db."groups.fk_type = ".$db."type.type_id";
		$subquery1->addTable($db."type", INNER_JOIN, $joinc);
		// Join to the properties mapping table
		$joinc = $db."groups.groups_id = ".$db."group_properties.fk_group";
		$subquery1->addTable($db."group_properties", LEFT_JOIN, $joinc);
		// Join to the properties and each Property
		$joinc = $db."group_properties.fk_properties = ".$db."shared_properties.id";
		$subquery1->addTable($db."shared_properties", LEFT_JOIN, $joinc);
		$joinc = $db."shared_properties.fk_type = ".$db."properties_type.type_id";
		$subquery1->addTable($db."type", LEFT_JOIN, $joinc, "properties_type");
		$joinc = $db."shared_properties.id = ".$db."shared_property.fk_properties";
		$subquery1->addTable($db."shared_property", LEFT_JOIN, $joinc);
		
		$groups = array();

		// for all rows returned by the query
		while($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
			// check all non-null values in current row
			// see if it is cached, if not create a group object and cache it
			
			// this will store the previously fetched group id from the current row
			$prev = null;
			
			for ($level = 25; $level >= 0; $level--) {
				$value = $row["subgroup{$level}_id"];

				// ignore null values
				if (is_null($value)) {
					$prev = $value;
					continue;
				}
				
				// ignore cached values
				if (isset($this->_groupsCache[$value]) && $originallyCached[$value]) {
					$prev = $value;
					continue;
				}
				
				//**************************************
				// create the group object if necessary
				//**************************************
				if (!isset($this->_groupsCache[$value])) {
					// now fetch the info and all agents for this group
					// set the columns to select
					$subquery1->resetWhere();
					$subquery1->addWhere($db."groups.groups_id = '".addslashes($value)."'");

					$subqueryResult =& $dbHandler->query($subquery1, $this->_dbIndex);
					if ($subqueryResult->getNumberOfRows() == 0)
						throwError(new Error(AgentException::OPERATION_FAILED(),"AgentManager",true));
					
					// Store our parameters for the constructor of the Group
					$type =& new HarmoniType($subqueryResult->field('gt_domain'),
											$subqueryResult->field('gt_authority'),
											$subqueryResult->field('gt_keyword'),
											$subqueryResult->field('gt_description'));
					$displayName = $subqueryResult->field('g_display_name');
					$description = $subqueryResult->field('g_description');
					
					// Go through the rows and build the Properties array
					// Create an array for this agent's properties if it doesn't exist
					// I was having reference problems when attempting to use one array
					// that got passed off and reset.
					$propertiesArrayName = "propertiesArray".$value;
					$$propertiesArrayName = array();
					while ($subrow = $subqueryResult->getCurrentRow()) {
						// Build our properties objects to add to the Agent.
						if ($subrow['properties_id'] && $subrow['properties_id'] != "NULL") {
							
							// Create a name for the Current Properties variable. I was 
							// having reference problems when attempting to use one variable name
							// that got passed off and reset.
							$currentPropertiesName = "currentProperties".$subrow['properties_id'];
								
								
							// If we are starting on a new properties object, create a new object and add it to our array.
							if (!is_object($$currentPropertiesName) || $subrow['properties_id'] != $currentPropertiesId) 
							{
								$propertiesType =& new HarmoniType(
													$subrow['properties_domain'],
													$subrow['properties_authority'],
													$subrow['properties_keyword'],
													$subrow['properties_description']);
								
								// Create the new Properties object
								$$currentPropertiesName =& new HarmoniProperties($propertiesType);
								$currentPropertiesId = $subrow['properties_id'];
								
								// add the new Properties object to the Properties array for the
								// current Asset.
								$myArray =& $$propertiesArrayName;
								$myArray[] =& $$currentPropertiesName;
							}
							
							// Add the current Property row to the current Properties
							if ($subrow['property_key']) {
								$$currentPropertiesName->addProperty(
											unserialize(base64_decode($subrow['property_key'])), 
											unserialize(base64_decode($subrow['property_value'])));
							}
						}
						
						$subqueryResult->advanceRow();
					}
					
//					printpre($$propertiesArrayName);
					
					// Instantiate the Group object
					$group =& new HarmoniGroup($displayName,
													$this->getId($value), 
													$type, 
													$$propertiesArrayName,
													$description,
													$this->_dbIndex, 
													$this->_sharedDB);
					
					// cache the group
					$this->_groupsCache[$value] =& $group;

					//**************************************
					// now fetch all agents in this subgroup
					//**************************************
					$agentIdsInSubgroup = $this->_loadAgents(NULL, $value);
					foreach($agentIdsInSubgroup as $agentIdString) {
						$group->attach($this->_agentsCache[$agentIdString]);
					}
				}

				// add the previous subgroup to this subgroup, if necessary
				if (isset($prev))
					$this->_groupsCache[$value]->attach($this->_groupsCache[$prev]);
	
				$prev = $value;
			}

			$queryResult->advanceRow();
		}

//		echo "<pre>\n";
//		print_r($this->_groupsCache);
//		print_r($this->_agentsCache);
//		echo "</pre>\n";
		if (!$where)
			$this->_allGroupsCached = true;
	}
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return void
	 */
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return void
	 */
	function stop() {
	}
	
	
	/**
	 * Clears the agent and groups caches.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 **/
	function clearCache() {
		unset($this->_agentsCache);
		unset($this->_groupsCache);
		$this->_allAgentsCached = false;
		$this->_allGroupsCached = false;
	}
	
	/**
	 * A private function for getting a type id (and insuring that it exists
	 * in the database)
	 * 
	 * @param object Type $type
	 * @return integer
	 * @access private
	 * @date 11/18/04
	 */
	function _getTypeId ( & $type ) {
		$dbc =& Services::getService("DBHandler");
		
		// Check to see if the type already exists in the DB
		$query =& new SelectQuery;
		$query->addColumn("type_id");
		$query->addTable("type");
		$query->addWhere("type_domain='".addslashes($type->getDomain())."'");
		$query->addWhere("type_authority='".addslashes($type->getAuthority())."'", _AND);
		$query->addWhere("type_keyword='".addslashes($type->getKeyword())."'", _AND);
		
		$result =& $dbc->query($query, $this->_dbIndex);
		
		// If we have a type id already, use that
		if ($result->getNumberOfRows()) {
			$typeId = $result->field("type_id");
		} 
		// otherwise insert a new one.
		else {
			$query =& new InsertQuery;
			$query->setTable("type");
			$query->setColumns(array(
								"type_domain",
								"type_authority",
								"type_keyword",
								"type_description"));
			$query->setValues(array(
								"'".addslashes($type->getDomain())."'",
								"'".addslashes($type->getAuthority())."'",
								"'".addslashes($type->getKeyword())."'",
								"'".addslashes($type->getDescription())."'"));
			
			$result =& $dbc->query($query, $this->_dbIndex);
			$typeId = $result->getLastAutoIncrementValue();
		}
		
		return $typeId;
	}
	
	/**
	 * Store a properties object and return its id
	 * 
	 * @param object Properties $properties
	 * @return integer
	 * @access public
	 * @date 11/18/04
	 */
	function _storeProperties (& $properties ) {
		$dbc =& Services::getService("DBHandler");
		
		// Store the Properties Type
		$type =& $properties->getType();
		$typeId = $this->_getTypeId($type);
		
		// Store the Properties row.
		$query =& new InsertQuery;
		$query->setTable("shared_properties");
		$query->setColumns(array("fk_type"));
		$query->setValues(array("'".addslashes($typeId)."'"));
		
		$result =& $dbc->query($query, $this->_dbIndex);
		$propertiesId = $result->getLastAutoIncrementValue();
		
		// Store the Property key/value pairs.
		$keys =& $properties->getKeys();
		if ($keys->hasNext()) {
			$query =& new InsertQuery;
			$query->setTable("shared_property");
			$query->setColumns(array(
				"shared_property.fk_properties",
				"shared_property.property_key",
				"shared_property.property_value"
			
			));
			
			while($keys->hasNext()) {
				$key =& $keys->next();
				$property =& $properties->getProperty($key);
				$query->addRowOfValues(array(
					"'".addslashes($propertiesId)."'",
					"'".addslashes(base64_encode(serialize($key)))."'",
					"'".addslashes(base64_encode(serialize($property)))."'"
				));
			}
			
			$result =& $dbc->query($query, $this->_dbIndex);
		}
		
		return $propertiesId;
	}

}

?>