<?

require_once(OKI."/shared.interface.php");

require_once(HARMONI."oki/shared/HarmoniType.class.php");
require_once(HARMONI."oki/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."oki/shared/HarmoniAgent.class.php");
require_once(HARMONI."oki/shared/HarmoniAgentIterator.class.php");
require_once(HARMONI."oki/shared/HarmoniGroup.class.php");
require_once(HARMONI."oki/shared/HarmoniTestId.class.php");
require_once(HARMONI."oki/shared/HarmoniId.class.php");
require_once(HARMONI."oki/shared/HarmoniStringId.class.php");

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
 * @version $Id: HarmoniSharedManager.class.php,v 1.28 2004/04/23 19:29:21 dobomode Exp $
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
		
		$this->_allAgentsCached = false;
		$this->_allGroupsCached = false;
	}

    /**
     * Create an Agent with the display name and Type specified.  Both are
     * immutable. Implemented with 1 SELECT and 1 INSERT queries for a total of
	 * 2 SQL queries.
     *
     * @param String displayName
     * @param object osid.shared.Type agentType
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
	function & createAgent($displayName, & $agentType) { 
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("HarmoniType");
		ArgumentValidator::validate($agentType, $extendsRule, true);
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
		
		$domain = $agentType->getDomain();
		$authority = $agentType->getAuthority();
		$keyword = $agentType->getKeyword();
		$description = $agentType->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query =& new SelectQuery();
		$query->addTable($db."type");
		$query->addColumn("type_id", "id", $db."type");
		$where = $db."type.type_domain = '".$domain."'";
		$where .= " AND {$db}type.type_authority = '".$authority."'";
		$where .= " AND {$db}type.type_keyword = '".$keyword."'";
		$where .= " AND {$db}type.type_description = '".$description."'";
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
			$values[] = "'".$domain."'";
			$values[] = "'".$authority."'";
			$values[] = "'".$keyword."'";
			$values[] = "'".$description."'";
			$query->setValues($values);

			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			$typeIdValue = $queryResult->getLastAutoIncrementValue();
		}
		
		// 2. Now that we know the id of the type, insert the agent itself
		$query =& new InsertQuery();
		$query->setTable($db."agent");
		$columns = array();
		$columns[] = "agent_id";
		$columns[] = "agent_display_name";
		$columns[] = "fk_type";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".$agentIdValue."'";
		$values[] = "'".$displayName."'";
		$values[] = "'".$typeIdValue."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// create the agent object to return
		$agent =& new HarmoniAgent($displayName, $agentId, $agentType, $this->_dbIndex, $this->_sharedDB);
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
		$query->addWhere($db."agent.agent_id = '".$idValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The agent with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple agents with Id: ".$idValue." exist in the database." ,"SharedManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Now delete the agent
		$query =& new DeleteQuery();
		$query->setTable($db."agent");
		$query->addWhere($db."agent.agent_id = '".$idValue."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		// 3. Now see if any other agents have the same type
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."agent");
		// count the number of agents using the same type
		$query->addColumn("COUNT({$db}agent.fk_type)", "num");
		$query->addWhere($db."agent.fk_type = '".$typeIdValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { // if no other agents use this type, then delete the type
			$query =& new DeleteQuery();
			$query->setTable($db."type");
			$query->addWhere($db."type.type_id = '".$typeIdValue."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

		// clear the cache
		if (isset($this->_agentsCache[$idValue])) {
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
	function & getAgent(& $id) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_agentsCache[$idValue]))
			return $this->_agentsCache[$idValue];
			
		$where = $db."agent.agent_id = '".$idValue."'";

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
	function & getAgents() {
		if (!$this->_allAgentsCached)
			$this->_loadAgents();
		
		$result =& new HarmoniAgentIterator($this->_agentsCache);
		return $result;
	}
	
	
	/**
	 * A private function that can be used by either getAgent or getAgents. Loads
	 * agents in the internal cache.
	 * @access public
	 * @param string where An optional where clause.
	 **/
	function & _loadAgents($where = null) {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		$query->addTable($db."agent");
		$joinc = $db."agent.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->addColumn("agent_id", "id", $db."agent");
		$query->addColumn("agent_display_name", "display_name", $db."agent");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		if ($where)
		    $query->addWhere($where);
			
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);

		while ($queryResult->hasMoreRows()) {
			// fetch current row
			$arr = $queryResult->getCurrentRow();
			
			// cache it, if not cached
			if (!isset($this->_agentsCache[$arr[id]])) {
				// create agent object
				$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
				$agent =& new HarmoniAgent($arr['display_name'], new HarmoniId($arr['id']), $type, $this->_dbIndex, $this->_sharedDB);
				
				$this->_agentsCache[$arr['id']] =& $agent;
			}

			$queryResult->advanceRow();
		}
		
		$this->_allAgentsCached = true;
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
	function & getAgentTypes() {
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
	function & createGroup($displayName, & $groupType, $description) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("HarmoniType");
		ArgumentValidator::validate($groupType, $extendsRule, true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
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
		$where = $db."type.type_domain = '".$domain."'";
		$where .= " AND ".$db."type.type_authority = '".$authority."'";
		$where .= " AND ".$db."type.type_keyword = '".$keyword."'";
		$where .= " AND ".$db."type.type_description = '".$desc."'";
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
			$values[] = "'".$domain."'";
			$values[] = "'".$authority."'";
			$values[] = "'".$keyword."'";
			$values[] = "'".$desc."'";
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
		$values[] = "'".$groupIdValue."'";
		$values[] = "'".$displayName."'";
		$values[] = "'".$description."'";
		$values[] = "'".$typeIdValue."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// create the group object to return
		$group =& new HarmoniGroup($displayName, $groupId, $groupType, $description, $this->_dbIndex, $this->_sharedDB);
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
		$query->addWhere($db."groups.groups_id = '".$idValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The group with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple groups with Id: ".$idValue." exist in the database." ,"SharedManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Now delete the agent
		$query =& new DeleteQuery();
		$query->setTable($db."groups");
		$query->addWhere($db."groups.groups_id = '".$idValue."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		// 3. Now see if any other groups have the same type
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db."groups");
		// count the number of groups using the same type
		$query->addColumn("COUNT({$db}groups.fk_type)", "num");
		$query->addWhere($db."groups.fk_type = '".$typeIdValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { // if no other groups use this type, then delete the type
			$query =& new DeleteQuery();
			$query->setTable($db."type");
			$query->addWhere($db."type.type_id = '".$typeIdValue."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

		// clear the cache
		if (isset($this->_groupsCache[$idValue])) {
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
	function & getGroup(& $id) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("Id");
		ArgumentValidator::validate($id, $extendsRule, true);
		// ** end of parameter validation

		// get the id
		$idValue = $id->getIdString();
		
		// check the cache
		if (isset($this->_groupsCache[$idValue]))
			return $this->_groupsCache[$idValue];

		$where = $db."subgroup0.groups_id = '".$idValue."'";

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
	function & getGroups() {
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
	function & _loadGroups($where = null) {
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

		// set the tables
		$query->addTable($db."groups", NO_JOIN, "", "subgroup0");
		$joinc = $db."subgroup0.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		$joinc = $db."subgroup0.groups_id = ".$db."subgroup1.fk_parent";
		$query->addTable($db."j_groups_groups", LEFT_JOIN, $joinc, "subgroup1");
		$query->addColumn("fk_child", "subgroup".($level+1)."_id", "subgroup1");
		
		// now left join with itself.
		// maximum number of joins is 31, we've used 3 already, so there are 28 left
		// bottom line: a maximum group hierarchy of 29 levels
		for ($level = 1; $level <= 28; $level++) {
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
			return array();

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

		// prepare two query objects that we will use in the loop
		// we do so in order to avoid continuous initialization of the objects
		// (the only thing that will change is the WHERE clause)
		// --- 1st QUERY
		$subquery1 =& new SelectQuery();
		$subquery1->addColumn("groups_display_name", "g_display_name", $db."groups");
		$subquery1->addColumn("groups_description", "g_description", $db."groups");
		$subquery1->addColumn("type_domain", "gt_domain", $db."type");
		$subquery1->addColumn("type_authority", "gt_authority", $db."type");
		$subquery1->addColumn("type_keyword", "gt_keyword", $db."type");
		$subquery1->addColumn("type_description", "gt_description", $db."type");

		// set the tables
		$subquery1->addTable($db."groups");
		$joinc = $db."groups.fk_type = ".$db."type.type_id";
		$subquery1->addTable($db."type", INNER_JOIN, $joinc);

		// --- 2nd QUERY
		$subquery2 =& new SelectQuery();
		$subquery2->addColumn("agent_id", "a_id", $db."agent");
		$subquery2->addColumn("agent_display_name", "a_display_name", $db."agent");
		$subquery2->addColumn("type_domain", "at_domain", $db."type");
		$subquery2->addColumn("type_authority", "at_authority", $db."type");
		$subquery2->addColumn("type_keyword", "at_keyword", $db."type");
		$subquery2->addColumn("type_description", "at_description", $db."type");
		// set the tables
		$subquery2->addTable($db."groups");
		$joinc = $db."groups.groups_id = ".$db."j_groups_agent.fk_groups";
		$subquery2->addTable($db."j_groups_agent", LEFT_JOIN, $joinc);
		$joinc = $db."j_groups_agent.fk_agent = ".$db."agent.agent_id";
		$subquery2->addTable($db."agent", LEFT_JOIN, $joinc);
		$joinc = $db."agent.fk_type = ".$db."type.type_id";
		$subquery2->addTable($db."type", INNER_JOIN, $joinc);
		
		$groups = array();

		// for all rows returned by the query
		while($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
			// check all non-null values in current row
			// see if it is cached, if not create a group object and cache it
			
			// this will store the previously fetched group id from the current row
			$prev = null;
			
			for ($level = 29; $level >= 0; $level--) {
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

				// create the group object if necessary
				if (!isset($this->_groupsCache[$value])) {
					// now fetch the info and all agents for this group
					// set the columns to select
					$subquery1->resetWhere();
					$subquery1->addWhere($db."groups.groups_id = '".$value."'");

					$subqueryResult =& $dbHandler->query($subquery1, $this->_dbIndex);
					if ($subqueryResult->getNumberOfRows() == 0)
						throwError(new Error("No rows returned.","SharedManager",true));
					
					$subrow = $subqueryResult->getCurrentRow();
					$type =& new HarmoniType($subrow['gt_domain'],$subrow['gt_authority'],$subrow['gt_keyword'],$subrow['gt_description']);
					$group =& new HarmoniGroup($subrow['g_display_name'], new HarmoniId($value), $type, $subrow['g_description'], $this->_dbIndex, $this->_sharedDB);
					// set cache

					// now fetch all agents in this subgroup
					$subquery2->resetWhere();
					$subquery2->addWhere($db."groups.groups_id = '".$value."'");
					
					$subqueryResult =& $dbHandler->query($subquery2, $this->_dbIndex);

					while ($subqueryResult->hasMoreRows()) {
						$subrow = $subqueryResult->getCurrentRow();
						// if agent has not been cached, do so:
						$aid = $subrow['a_id'];
						if (!isset($this->_agentsCache[$aid])) {
							$type =& new HarmoniType($subrow['at_domain'],$subrow['at_authority'],$subrow['at_keyword'],$subrow['at_description']);
							$agent =& new HarmoniAgent($subrow['a_display_name'], new HarmoniId($aid), $type, $this->_dbIndex, $this->_sharedDB);
							$this->_agentsCache[$aid] =& $agent;
						}
						$group->attach($this->_agentsCache[$aid]);
						$subqueryResult->advanceRow();
					}

					// finally, cache the group
					$this->_groupsCache[$value] =& $group;
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
	function & getGroupTypes() {
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
	function & createId() {
		debug::output("Attempting to generate new id.",20,"SharedManager");
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
		
		debug::output("Successfully created new id '$newID'.",DEBUG_SYS5,"IDManager");
		
		return new HarmoniId($newID);
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
	function & getId($idString) {
	
		// Make sure that we have a non-zero integer
		if (ereg("^[1-9][0-9]*$",$idString)) {
			$id =& new HarmoniId($idString);
			
		// We generally want to use the numeric ids as those
		// we create uniquely, but some things need to pass around
		// an arbitrary string Id, so we will let them.
		} else if ((is_string($idString) || is_numeric($idString)) && $idString !== NULL && $idString !== "") {
			$id =& new HarmoniStringId($idString);
		} else {
			throwError(new Error(OPERATION_FAILED.": Unknown ID type for requested id-string, '".(($idString == NULL)?"NULL":$idString)."'.","HarmoniSharedManager",true));
		}
		
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
	

} // end SharedManager