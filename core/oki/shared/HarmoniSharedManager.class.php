<?

require_once(OKI."/shared.interface.php");

require_once(HARMONI."oki/shared/HarmoniType.class.php");
require_once(HARMONI."oki/shared/HarmoniTypeIterator.class.php");
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
 * @version $Revision: 1.17 $ / $Date: 2004/03/30 23:38:43 $  Note that this implementation uses a serialization approach that is simple rather than scalable.  Agents, Groups, and Ids are all lumped together into a single Vector that gets serialized.
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
		
		$this->_agentTable = $dataContainer->get("agentTable");
		$this->_groupTable = $dataContainer->get("groupTable");
		$this->_agentGroupJoinTable = $dataContainer->get("agentGroupJoinTable");
	}

    /**
     * Create an Agent with the display name and Type specified.  Both are
     * immutable.
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
	function & createAgent(& $agentType, $name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Get the Agent with the specified unique Id.
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	function & createGroup($description, $name, & $groupType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		
		debug::output("Successfully created new id '$newID'",DEBUG_SYS5,"IDManager");
		
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