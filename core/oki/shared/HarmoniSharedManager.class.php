<?

require_once(OKI."/shared.interface.php");

require_once(HARMONI."oki/shared/HarmoniType.class.php");
require_once(HARMONI."oki/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."oki/shared/HarmoniAgent.class.php");
require_once(HARMONI."oki/shared/HarmoniAgentIterator.class.php");
require_once(HARMONI."oki/shared/HarmoniGroup.class.php");
require_once(HARMONI."oki/shared/HarmoniTestId.class.php");
require_once(HARMONI."oki/shared/HarmoniId.class.php");
require_once(HARMONI."oki/shared/HarmoniProperties.class.php");
require_once(HARMONI."oki/shared/AgentSearches/HarmoniAgentExistsSearch.class.php");

/**
 * Properties is a mechanism for returning read-only data about an Agent.  Each
 * Agent can have data associated with a PropertiesType.  For each
 * PropertiesType, there are Properties which are Serializable values
 * identified by a key.
 * 
 * <p>
 * SharedManager creates, deletes, and gets Agents and Groups and creates and
 * gets Ids.  Group subclasses Agent and Groups may contains other Groups as
 * well as Agents.  All implementors of OsidManager provide create, delete,
 * and get methods for the various objects defined in the package.  Most
 * managers also include methods for returning Types.  We use create methods
 * in place of the new operator.  Create method implementations should both
 * instantiate and persist objects.  The reason we avoid the new operator is
 * that it makes the name of the implementating package explicit and requires
 * a source code change in order to use a different package name. In
 * combination with OsidLoader, applications developed using managers permit
 * implementation substitution without source code changes.
 * </p>
 * 
 * 
 * <p></p>
 * @package harmoni.osid.shared
 * @author Adam Franco, Dobromir Radichkov
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: HarmoniSharedManager.class.php,v 1.51 2004/11/23 17:22:49 adamfranco Exp $
 * 
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniSharedManager
	extends SharedManager
{ // begin SharedManager

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
	function HarmoniSharedManager($dbIndex, $sharedDB) {
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
	}

    /**
     * Create an Agent with the display name and Type specified.  Both are
     * immutable. Implemented with 1 SELECT and 1 INSERT queries for a total of
	 * 2 SQL queries.
     *
     * @param string $displayName
     * @param object osid.shared.Type $agentType
     * @param object Properties $properties This parameter was added as of version 2
     *		of the osids and is required for being able to manage properties of
     *		the agents
     *
     * @return object osid.shared.Agent with its unique Id set
     *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR UNKNOWN_TYPE,
	 *		 NULL_ARGUMENT
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createAgent($displayName, & $agentType, & $properties) { 
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
	 * @param object osid.shared.Id agentId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteAgent(& $id) {
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
			throwError(new Error("The agent with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple agents with Id: ".$idValue." exist in the database." ,"SharedManager",true));
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
//					echo "<b>unsetting the agent # {$idValue} in group # ".$groupId."</b><br>";
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
	 * Get the Agent with the specified unique Id. Implemented with 1 SELECT query.
	 *
	 * @param object osid.shared.Id agentId
	 *
	 * @return object osid.shared.Agent
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAgent(& $id) {
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
			throwError(new Error("The agent with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		
		return $this->_agentsCache[$idValue];
	}

	/**
	 * Get all the Agents.
	 *
	 * @return object osid.shared.AgentIterator.  Iterators return a set, one at a
	 *		 time.  The Iterator's hasNext method returns true if there are
	 *		 additional objects available; false otherwise.  The Iterator's
	 *		 next method returns the next object.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAgents() {
		if (!$this->_allAgentsCached)
			$this->_loadAgents();
		
		$result =& new HarmoniAgentIterator($this->_agentsCache);
		return $result;
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
	 * @date 11/10/04
	 */
	function &getAgentsBySearch ( & $searchCriteria, & $agentSearchType ) {
		$typeString = $agentSearchType->getDomain()
						."::".$agentSearchType->getAuthority()
						."::".$agentSearchType->getKeyword();
		
		// get the Agent Search object
		$agentSearch =& $this->_agentSearches[$typeString];
		if (!is_object($agentSearch))
			throwError(new Error("Unknown AgentSearchType, '".$typeString."'.","AgentManager",true));
		
		return $agentSearch->getAgentsBySearch($searchCriteria); 
	}
	
	/**
	 * Get all the agent search Types supported by this implementation.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @return object TypeIterator
	 * @access public
	 * @date 11/10/04
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
	 * A private function that can be used by either getAgent or getAgents. Loads
	 * agents in the internal cache.
	 * @access protected
	 * @param string $where An optional where clause.
	 * @param string $fromGroup An optional group id string to limit the resulting
	 * 		agents to.
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
		$query->addColumn("key", "property_key", $db."shared_property");
		$query->addColumn("value", "property_value", $db."shared_property");
		
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
	 * Get all the Types of Agent.
	 *
	 * @return object osid.shared.TypeIterator.  Iterators return a set, one at a
	 *		 time.  The Iterator's hasNext method returns true if there are
	 *		 additional objects available; false otherwise.  The Iterator's
	 *		 next method returns the next object.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAgentTypes() {
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
	 * Creates an Group with the display name and Type specified.  Both are
	 * immutable.
	 *
	 * @param String displayName
	 * @param object osid.shared.Type groupType
	 * @param String description
	 * @param object Properties $properties As of version 2 of the OSIDs, this
	 *		parameter exists.
	 *
	 * @return object osid.shared.Group with its unique Id set
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR UNKNOWN_TYPE,
	 *		 NULL_ARGUMENT
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createGroup($displayName, & $groupType, $description, & $properties) {
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
	 * Deletes the Group with the specified unique Id.
	 *
	 * @param object osid.shared.Id groupId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteGroup(& $id) {
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
			throwError(new Error("The group with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple groups with Id: ".$idValue." exist in the database." ,"SharedManager",true));
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
//					echo "<b>unsetting the group # {$idValue} in group # ".$groupId."</b><br>";
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
	 * Gets the Group with the specified unique Id.
	 *
	 * @param object osid.shared.Id groupId
	 *
	 * @return object osid.shared.Group
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getGroup(& $id) {
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
			throwError(new Error("The group with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		
		return $this->_groupsCache[$idValue];
	}
	
	
	/**
	 * Get all the Groups.  Note since Groups subclass Agents, we are returning
	 * an AgentIterator and there is no GroupIterator.
	 *
	 * @return object osid.shared.AgentIterator.  Iterators return a set, one at a
	 *		 time.  The Iterator's hasNext method returns true if there are
	 *		 additional objects available; false otherwise.  The Iterator's
	 *		 next method returns the next object.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getGroups() {
		if (!$this->_allGroupsCached)
			$this->_loadGroups();
		
		$result =& new HarmoniAgentIterator($this->_groupsCache);
		return $result;
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
		$query->addColumn("key", "property_key", $db."shared_property");
		$query->addColumn("value", "property_value", $db."shared_property");

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
		
// 		echo "<pre>\n";
// 		echo MySQL_SQLGenerator::generateSQLQuery($query);
// 		echo "</pre>\n";

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
		$subquery1->addColumn("key", "property_key", $db."shared_property");
		$subquery1->addColumn("value", "property_value", $db."shared_property");

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
						throwError(new Error("No rows returned.","SharedManager",true));
					
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
	 * Get all the Types of Group.
	 *
	 * @return object osid.shared.TypeIterator.  Iterators return a set, one at a
	 *		 time.  The Iterator's hasNext method returns true if there are
	 *		 additional objects available; false otherwise.  The Iterator's
	 *		 next method returns the next object.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getGroupTypes() {
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
	 * Create a new unique identifier.
	 *
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createId() {
		debug::output("Attempting to generate new id.", 20, "SharedManager");
		$dbHandler =& Services::requireService("DBHandler");
		
		$query =& new InsertQuery();
		$query->setAutoIncrementColumn("id_value", "id_sequence");
		$query->setTable($this->_sharedDB.".id");
		$query->addRowOfValues(array());
		
		$result =& $dbHandler->query($query,$this->_dbIndex);
		if ($result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("SharedManager"));
		}
		
		$newID = $result->getLastAutoIncrementValue();
		$newID = strval($newID);
		
		debug::output("Successfully created new id '$newID'.",DEBUG_SYS5,"IDManager");
		
		$id =& new HarmoniId($newID);
		
		// cache the id
		$this->_ids[$newId];
		
		return $id;
	}

	/**
	 * Get the unique Id with this String representation or create a new unique
	 * Id with this representation.
	 *
	 * @param string idString
	 *
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getId($idString) {
		if (isset($this->_ids[$idString]))
			return $this->_ids[$idString];
	
		$id =& new HarmoniId($idString);
			
		// cache the id
		$this->_ids[$idString] =& $id;

		return $id;
	}

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 */
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 */
	function stop() {
	}
	
	
	/**
	 * Clears the agent and groups caches.
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
				"shared_property.key",
				"shared_property.value"
			
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

} // end SharedManager