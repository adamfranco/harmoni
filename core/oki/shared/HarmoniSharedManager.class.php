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
require_once(HARMONI."oki/shared/HarmoniDatabaseId.class.php");
require_once(HARMONI."oki/shared/HarmoniSharedManagerDataContainer.class.php");

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
 * <p>
 * Licensed under the {@link osid.SidLicense MIT O.K.I SID Definition License}.
 * </p>
 * 
 * <p></p>
 *
 * @version $Revision: 1.20 $ / $Date: 2004/04/12 22:58:12 $  Note that this implementation uses a serialization approach that is simple rather than scalable.  Agents, Groups, and Ids are all lumped together into a single Vector that gets serialized.
 * 
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniSharedManager
	extends SharedManager
//	impliments ServicesInterface	// start() and stop() methods are provided
{ // begin SharedManager

	/**
	 * @var integer $_idDBIndex The index of the database from which to pull the ids.
	 */
	var $_idDBIndex = 0;
	

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
	 * Constructor. Set up any database connections needed.
	 *
	 */
	function HarmoniSharedManager( $dataContainer ) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("HarmoniSharedManagerDataContainer");
		ArgumentValidator::validate($dataContainer, $extendsRule, true);
		// ** end of parameter validation
		
		// now, validate the data container
		$dataContainer->checkAll();
		
		$this->_dbIndex = $dataContainer->get("dbIndex");
		$this->_sharedDB = $dataContainer->get("sharedDB");
		
		$this->_idTable = $dataContainer->get("idTable");
		$this->_idTable_valueColumn = $dataContainer->get("idTable_valueColumn");
		$this->_idTable_sequenceName = $dataContainer->get("idTable_sequenceName");
		
		$this->_typeTable = $dataContainer->get("typeTable");
		$this->_typeTable_idColumn = $dataContainer->get("typeTable_idColumn");
		$this->_typeTable_domainColumn = $dataContainer->get("typeTable_domainColumn");
		$this->_typeTable_authorityColumn = $dataContainer->get("typeTable_authorityColumn");
		$this->_typeTable_keywordColumn = $dataContainer->get("typeTable_keywordColumn");
		$this->_typeTable_descriptionColumn = $dataContainer->get("typeTable_descriptionColumn");

		$this->_agentTable = $dataContainer->get("agentTable");
		$this->_agentTable_idColumn = $dataContainer->get("agentTable_idColumn");
		$this->_agentTable_displayNameColumn = $dataContainer->get("agentTable_displayNameColumn");
		$this->_agentTable_fkTypeColumn = $dataContainer->get("agentTable_fkTypeColumn");
		
		$this->_groupTable = $dataContainer->get("groupTable");
		$this->_groupTable_idColumn = $dataContainer->get("groupTable_idColumn");
		$this->_groupTable_displayNameColumn = $dataContainer->get("groupTable_displayNameColumn");
		$this->_groupTable_fkTypeColumn = $dataContainer->get("groupTable_fkTypeColumn");
		$this->_groupTable_description = $dataContainer->get("groupTable_description");
		$this->_agentGroupJoinTable = $dataContainer->get("agentGroupJoinTable");
		
		// initialize cache
		$this->_agentsCache = array();
		$this->_groupsCache = array();
	}

    /**
     * Create an Agent with the display name and Type specified.  Both are
     * immutable. Implemented with 1 SELECT and 1 INSERT queries for a total of
	 * 2 SQL queries.
     *
     * @param String displayName
     * @param osid.shared.Type agentType
     *
     * @return osid.shared.Agent with its unique Id set
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
		$query->addTable($db.$this->_typeTable);
		$query->addColumn($this->_typeTable_idColumn, "id", $db.$this->_typeTable);
		$where = $db.$this->_typeTable.".".$this->_typeTable_domainColumn." = '".$domain."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_authorityColumn." = '".$authority."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_keywordColumn." = '".$keyword."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_descriptionColumn." = '".$description."'";
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) // if the type is already in the database
			$typeIdValue = $queryResult->field("id"); // get the id
		else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db.$this->_typeTable);
			$columns = array();
			$columns[] = $this->_typeTable_domainColumn;
			$columns[] = $this->_typeTable_authorityColumn;
			$columns[] = $this->_typeTable_keywordColumn;
			$columns[] = $this->_typeTable_descriptionColumn;
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
		$query->setTable($db.$this->_agentTable);
		$columns = array();
		$columns[] = $this->_agentTable_idColumn;
		$columns[] = $this->_agentTable_displayNameColumn;
		$columns[] = $this->_agentTable_fkTypeColumn;
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".$agentIdValue."'";
		$values[] = "'".$displayName."'";
		$values[] = "'".$typeIdValue."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// create the agent object to return
		$agent =& new HarmoniAgent($displayName, $agentId, $agentType);
		// then cache it
		$this->_agentsCache[$agentIdValue] =& $agent;
		
		return $agent;
	}

	/**
	 * Delete the Agent with the specified unique Id.
	 *
	 * @param osid.shared.Id agentId
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
		$query->addTable($db.$this->_agentTable);
		$query->addColumn($this->_agentTable_fkTypeColumn, "type_id", $db.$this->_agentTable);
		$query->addWhere($db.$this->_agentTable.".".$this->_agentTable_idColumn." = '".$idValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The agent with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple agents with Id: ".$idValue." exist in the database." ,"SharedManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Now delete the agent
		$query =& new DeleteQuery();
		$query->setTable($db.$this->_agentTable);
		$query->addWhere($db.$this->_agentTable.".".$this->_agentTable_idColumn." = '".$idValue."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		// 3. Now see if any other agents have the same type
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		$query->addTable($db.$this->_agentTable);
		// count the number of agents using the same type
		$query->addColumn("COUNT(".$db.$this->_agentTable.".".$this->_agentTable_fkTypeColumn.")", "num");
		$query->addWhere($db.$this->_agentTable.".".$this->_agentTable_fkTypeColumn." = '".$typeIdValue."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { // if no other agents use this type, then delete the type
			$query =& new DeleteQuery();
			$query->setTable($db.$this->_typeTable);
			$query->addWhere($db.$this->_typeTable.".".$this->_typeTable_idColumn." = '".$typeIdValue."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

		// clear the cache
		if (isset($this->_agentsCache[$idValue]))
			unset ($this->_agentsCache[$idValue]);
	}

	/**
	 * Get the Agent with the specified unique Id. Implemented with 1 SELECT query.
	 *
	 * @param osid.shared.Id agentId
	 *
	 * @return osid.shared.Agent
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

			
		// now just select the agent from the agent table
		
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		$query->addTable($db.$this->_agentTable);
		$joinc = $db.$this->_agentTable.".".$this->_agentTable_fkTypeColumn." = ".$db.$this->_typeTable.".".$this->_typeTable_idColumn;
		$query->addTable($db.$this->_typeTable, INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->addColumn($this->_agentTable_displayNameColumn, "display_name", $db.$this->_agentTable);
		$query->addColumn($this->_typeTable_domainColumn, "domain", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_authorityColumn, "authority", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_keywordColumn, "keyword", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_descriptionColumn, "description", $db.$this->_typeTable);

		// set the where clause
		$query->addWhere($db.$this->_agentTable.".".$this->_agentTable_idColumn." = '".$idValue."'");
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The agent with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple agents with Id: ".$idValue." exist in the database." ,"SharedManager",true));
		
		$arr = $queryResult->getCurrentRow();
		$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
		$agent =& new HarmoniAgent($arr['display_name'], new HarmoniId($idValue), $type);
		
		// set cache
		$this->_agentsCache[$idValue] =& $agent;
		
		return $agent;
	}

	/**
	 * Get all the Agents.
	 *
	 * @return osid.shared.AgentIterator.  Iterators return a set, one at a
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
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_sharedDB.".";
		
		// set the tables
		$query->addTable($db.$this->_agentTable);
		$joinc = $db.$this->_agentTable.".".$this->_agentTable_fkTypeColumn." = ".$db.$this->_typeTable.".".$this->_typeTable_idColumn;
		$query->addTable($db.$this->_typeTable, INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->addColumn($this->_agentTable_idColumn, "id", $db.$this->_agentTable);
		$query->addColumn($this->_agentTable_displayNameColumn, "display_name", $db.$this->_agentTable);
		$query->addColumn($this->_typeTable_domainColumn, "domain", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_authorityColumn, "authority", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_keywordColumn, "keyword", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_descriptionColumn, "description", $db.$this->_typeTable);
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);

		$agents = array();
		while ($queryResult->hasMoreRows()) {
			// fetch current row
			$arr = $queryResult->getCurrentRow();
			
			// create agent object
			$type =& new HarmoniType($arr['domain'],$arr['authority'],$arr['keyword'],$arr['description']);
			$agent =& new HarmoniAgent($arr['display_name'], new HarmoniId($arr['id']), $type);
			
			// add it to array
			$agents[] =& $agent;

			// cache it
			$this->_agentsCache[$idValue] =& $agent;

			$queryResult->advanceRow();
		}
		
		$result =& new HarmoniAgentIterator($agents);
		return $result;
	}

	/**
	 * Get all the Types of Agent.
	 *
	 * @return osid.shared.TypeIterator.  Iterators return a set, one at a
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
		$query->addTable($db.$this->_agentTable);
		$joinc = $db.$this->_agentTable.".".$this->_agentTable_fkTypeColumn." = ".$db.$this->_typeTable.".".$this->_typeTable_idColumn;
		$query->addTable($db.$this->_typeTable, INNER_JOIN, $joinc);
		
		// set the columns to select
		$query->setDistinct(true);
		$query->addColumn($this->_typeTable_idColumn, "id", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_domainColumn, "domain", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_authorityColumn, "authority", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_keywordColumn, "keyword", $db.$this->_typeTable);
		$query->addColumn($this->_typeTable_descriptionColumn, "description", $db.$this->_typeTable);
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
	 * @param osid.shared.Type groupType
	 * @param String description
	 *
	 * @return osid.shared.Group with its unique Id set
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
		$description = $groupType->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query =& new SelectQuery();
		$query->addTable($db.$this->_typeTable);
		$query->addColumn($this->_typeTable_idColumn, "id", $db.$this->_typeTable);
		$where = $db.$this->_typeTable.".".$this->_typeTable_domainColumn." = '".$domain."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_authorityColumn." = '".$authority."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_keywordColumn." = '".$keyword."'";
		$where .= " AND ".$db.$this->_typeTable.".".$this->_typeTable_descriptionColumn." = '".$description."'";
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) // if the type is already in the database
			$typeIdValue = $queryResult->field("id"); // get the id
		else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db.$this->_typeTable);
			$columns = array();
			$columns[] = $this->_typeTable_domainColumn;
			$columns[] = $this->_typeTable_authorityColumn;
			$columns[] = $this->_typeTable_keywordColumn;
			$columns[] = $this->_typeTable_descriptionColumn;
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
		
		// 2. Now that we know the id of the type, insert the group itself
		$query =& new InsertQuery();
		$query->setTable($db.$this->_groupTable);
		$columns = array();
		$columns[] = $this->_groupTable_idColumn;
		$columns[] = $this->_groupTable_displayNameColumn;
		$columns[] = $this->_groupTable_description;
		$columns[] = $this->_groupTable_fkTypeColumn;
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".$groupIdValue."'";
		$values[] = "'".$displayName."'";
		$values[] = "'".$description."'";
		$values[] = "'".$typeIdValue."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// create the group object to return
		$group =& new HarmoniGroup($displayName, $groupId, $groupType, $description);
		// then cache it
		$this->_groupsCache[$groupIdValue] =& $group;
		
		return $group;
	}

	/**
	 * Deletes the Group with the specified unique Id.
	 *
	 * @param osid.shared.Id groupId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteGroup(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Gets the Group with the specified unique Id.
	 *
	 * @param osid.shared.Id groupId
	 *
	 * @return osid.shared.Group
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.shared.SharedException may be thrown: OPERATION_FAILED,
	 *		 PERMISSION_DENIED, CONFIGURATION_ERROR NULL_ARGUMENT,
	 *		 UNKNOWN_ID
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getGroup(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Get all the Groups.  Note since Groups subclass Agents, we are returning
	 * an AgentIterator and there is no GroupIterator.
	 *
	 * @return osid.shared.AgentIterator.  Iterators return a set, one at a
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Get all the Types of Group.
	 *
	 * @return osid.shared.TypeIterator.  Iterators return a set, one at a
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Create a new unique identifier.
	 *
	 * @return osid.shared.Id A unique Id that is usually set by a create
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
		$query->setAutoIncrementColumn($this->_idTable_valueColumn, $this->_idTable_sequenceName);
		$query->setTable($this->_sharedDB.".".$this->_idTable);
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
	 * @param String idString
	 *
	 * @return osid.shared.Id A unique Id that is usually set by a create
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

} // end SharedManager