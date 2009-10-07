<?php
/**
 * @package harmoni.osid_v2.agentmanagement.agent-token_mapping
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentTokenMappingManager.class.php,v 1.14 2008/04/08 20:02:42 adamfranco Exp $
 */ 
 
 require_once(dirname(__FILE__)."/AgentTokenMapping.class.php");

/**
 * The AgentTokenMappingManager manages the mappings between AgentIds and
 * one or more sets of authentication tokens per AgentId.
 *
 * AgentIds as recorded by the AgentManager OSID are essentially immutible and 
 * refer to all Agents that the system has seen, be (at a University) Faculty,
 * Students, or people who just bought concert tickets or used the golf course.
 * Additionally, since other records may persist that refer to the AgentId, the
 * AgentManager does not de-reference its Ids for Agents when said people leave
 * the institution (or die). Knowledge by the AgentManager thereby does not 
 * infer any status to an Agent.
 *
 * A small sub-set of all Agents are those who are 'authenticatable'. That is, they
 * have authentication tokens that allow them to be identified by the system when
 * they 'log in'. These users (at a University) would usually include current 
 * Faculty, Staff, and Students, official visitors (?), trustees, and possibly even
 * computer systems (such as an email server that logs into another information
 * database to populate its address-book tables). Having authentication ability
 * does not imply any authorization, but it does imply a 'current agent' status
 * to a person or thing.
 * 
 * @package harmoni.osid_v2.agentmanagement.agent-token_mapping
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentTokenMappingManager.class.php,v 1.14 2008/04/08 20:02:42 adamfranco Exp $
 */
class AgentTokenMappingManager
	implements OsidManager
{
	/**
	 * Constructor. We wish to ensure that the manager is properly configured
	 * via the assignConfiguration() method and any needed context information
	 * has been passed via assignOsidContext(), so an instance variable is set
	 * here to false untill the necessary initialization has occurred.
	 * 
	 * @return object
	 * @access public
	 * @since 3/1/05
	 */
	function AgentTokenMappingManager () {
		$this->_isInitialized = FALSE;
		$this->_osidContext = NULL;
		$this->_configuration = NULL;
		
		$this->_mappingTable = 'agenttoken_mapping';
		$this->_typeTable = 'agenttoken_mapping_authntype';
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
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignOsidContext ( OsidContext $context ) { 
        $this->_osidContext =$context;
    } 

    /**
     * Assign the configuration of this OsidManager.
     * 
     * @param object Properties $configuration (original type: java.util.Properties)
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignConfiguration ( Properties $configuration ) { 
        $this->_configuration =$configuration;
        ArgumentValidator::validate($this->_configuration->getProperty('database_id'),
        	IntegerValidatorRule::getRule());
        	
        // Store the Harmoni_Db adapter if it is configured.
        $harmoni_db_name = $this->_configuration->getProperty('harmoni_db_name');
        if (!is_null($harmoni_db_name)) {
			try {
				$this->harmoni_db = Harmoni_Db::getDatabase($harmoni_db_name);
			} catch (UnknownIdException $e) {
			}
        }
        
        $this->_dbId = $this->_configuration->getProperty('database_id');
        
        $this->_isInitialized = TRUE;
    } 

	/**
	 * Create a new mapping between AuthNTokens and an AgentId.
	 * 
	 * @param object Id $agentId
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return object AgentTokenMapping
	 * @access public
	 * @since 3/1/05
	 */
	function createMapping ( Id $agentId, AuthNTokens $authNTokens, Type $authenticationType ) {
		$this->_checkConfig();
		
		if ($this->mappingExists($agentId, $authNTokens, $authenticationType))
			throwError( new Error("Cannot create Mapping. Mapping already exists: ('"
				.$agentId->getIdString()."', '"
				.$authNTokens->getIdentifier()."', '"
				.$authenticationType->getDomain()."::"
				.$authenticationType->getAuthority()."::"
				.$authenticationType->getKeyword()."')",
				"AgentTokenMappingManager", true));
		
		if ($this->_mappingExistsForTokens($authNTokens, $authenticationType))
			throwError( new Error("Cannot create Mapping. Mapping already exists for these tokens: ('"
				.$agentId->getIdString()."', '"
				.$authNTokens->getIdentifier()."', '"
				.$authenticationType->getDomain()."::"
				.$authenticationType->getAuthority()."::"
				.$authenticationType->getKeyword()."')",
				"AgentTokenMappingManager", true));
		
		$dbc = Services::getService("DatabaseManager");
		$dbc->beginTransaction($this->_dbId);
		
		$typeKey = $this->_getTypeKey($authenticationType);
		
		$query = new InsertQuery;
		$query->setTable($this->_mappingTable);
		$query->setColumns(
			array(
				'agent_id',
				'token_identifier',
				'fk_type'));
		$query->setValues(
			array(
				"'".addslashes($agentId->getIdString())."'",
				"'".addslashes($authNTokens->getIdentifier())."'",
				"'".addslashes($typeKey)."'",));
		
		$result =$dbc->query($query, $this->_dbId);

		$dbc->commitTransaction($this->_dbId);
		
		$mapping = new AgentTokenMapping($authenticationType, $agentId, $authNTokens);
		
		return $mapping;
	}
	
	/**
	 * Remove the mapping between AuthNTokens and an Agent
	 * 
	 * @param object AgentTokenMapping $mapping
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function deleteMapping ( AgentTokenMapping $mapping ) {
		$this->_checkConfig();
				
		$dbc = Services::getService("DatabaseManager");
		$dbc->beginTransaction($this->_dbId);
		
		$agentId =$mapping->getAgentId();
		$authNTokens =$mapping->getTokens();
		$typeKey = $this->_getTypeKey($mapping->getAuthenticationType());
		
		// Delete the mapping.
		$query = new DeleteQuery;
		$query->setTable($this->_mappingTable);
		$query->addWhere(
			"agent_id='".addslashes($agentId->getIdString())."'");
		$query->addWhere(
			"token_identifier='".addslashes($authNTokens->getIdentifier())."'",
			_AND);
		$query->addWhere(
			"fk_type='".addslashes($typeKey)."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		// Delete the type if nothing is referencing it.
		$query = new SelectQuery;
		$query->addTable($this->_mappingTable);
		$query->addColumn("COUNT(*)", "count");
		$query->addWhere("fk_type='".addslashes($typeKey)."'");
		$result =$dbc->query($query, $this->_dbId);
		
		if ($result->getNumberOfRows() == 0) {
			$query = new DeleteQuery;
			$query->addTable($this->_typeTable);
			$query->addWhere(
				"id='".addslashes($typeKey)."'");
			$result =$dbc->query($query, $this->_dbId);
		}
		$result->free();
		$dbc->commitTransaction($this->_dbId);
	}
	
	/**
	 * Return the mapping for an AuthNTokens.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return mixed AgentTokenMapping OR FALSE if not found.
	 * @access public
	 * @since 3/9/05
	 */
	function getMappingForTokens ( AuthNTokens $authNTokens, Type $authenticationType ) {
		// Use Harmoni_Db method for greater performance if it is configured
		if (isset($this->harmoni_db))
			return $this->getMappingForTokens_Harmoni_Db($authNTokens, $authenticationType);
		
		// Otherwise use original method
		
		$this->_checkConfig();
		
		$dbc = Services::getService("DatabaseManager");
		
		$query =$this->_createSelectQuery();
		
		$query->addWhere(
			"token_identifier='".addslashes($authNTokens->getIdentifier())."'");
		$query->addWhere(
			"domain='".addslashes($authenticationType->getDomain())."'",
			_AND);
		$query->addWhere(
			"authority='".addslashes($authenticationType->getAuthority())."'",
			_AND);
		$query->addWhere(
			"keyword='".addslashes($authenticationType->getKeyword())."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		$mappings =$this->_createMappingsFromResult($result);
		
		if (count($mappings) == 0) {
			$mapping = FALSE;	// Returning by reference, so must create a var.
			return $mapping;
		} else if (count($mappings) != 1)
			throwError( new Error("Invalid number of results: ".count($mappings),
									 "AgentTokenMappingManager", true));
		else
			return $mappings[0];
	}
	
	/**
	 * Return the mapping for an AuthNTokens.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return mixed AgentTokenMapping OR FALSE if not found.
	 * @access private
	 * @since 3/9/05
	 */
	private function getMappingForTokens_Harmoni_Db ( AuthNTokens $authNTokens, Type $authenticationType ) {
		$this->_checkConfig();
		
		if (!isset($this->getMappingForTokens_stmt)) {
			
			$db = $this->harmoni_db;
			$query = $db->select();
			$query->addTable($this->_mappingTable);
			$query->addTable($this->_typeTable, 
				LEFT_JOIN, 
				$db->quoteIdentifier($this->_mappingTable.'.fk_type')
					.'='
					.$db->quoteIdentifier($this->_typeTable.'.id'));
			$query->addColumn('agent_id');
			$query->addColumn('token_identifier');
			$query->addColumn('domain');
			$query->addColumn('authority');
			$query->addColumn('keyword');
			$query->addColumn('description');
			
			$query->addWhereEqual("token_identifier", $authNTokens->getIdentifier());
			$query->addWhereEqual("domain", $authenticationType->getDomain());
			$query->addWhereEqual("authority", $authenticationType->getAuthority());
			$query->addWhereEqual("keyword", $authenticationType->getKeyword());
			
			$this->getMappingForTokens_stmt = $query->prepare();
		}
		$this->getMappingForTokens_stmt->bindValue(1, $authNTokens->getIdentifier());
		$this->getMappingForTokens_stmt->bindValue(2, $authenticationType->getDomain());
		$this->getMappingForTokens_stmt->bindValue(3, $authenticationType->getAuthority());
		$this->getMappingForTokens_stmt->bindValue(4, $authenticationType->getKeyword());
		
		$this->getMappingForTokens_stmt->execute();
		
		$result = $this->getMappingForTokens_stmt->getResult();
		
		$mappings =$this->_createMappingsFromResult($result);
		
		if (count($mappings) == 0) {
			$mapping = FALSE;	// Returning by reference, so must create a var.
			return $mapping;
		} else if (count($mappings) != 1)
			throwError( new Error("Invalid number of results: ".count($mappings),
									 "AgentTokenMappingManager", true));
		else
			return $mappings[0];
	}
	
	/**
	 * Return the mapping for an Agent Id.
	 * 
	 * @param object Id $agentId
	 * @param object Type $authenticationType
	 * @return object AgentTokenMapping
	 * @access public
	 * @since 3/9/05
	 */
	function getMappingsForAgentIdAndAuthenticationType ( Id $agentId, Type $authenticationType ) {
		$this->_checkConfig();
		
		$dbc = Services::getService("DatabaseManager");
		
		$query =$this->_createSelectQuery();
		
		$query->addWhere(
			"agent_id='".addslashes($agentId->getIdString())."'");
		$query->addWhere(
			"domain='".addslashes($authenticationType->getDomain())."'",
			_AND);
		$query->addWhere(
			"authority='".addslashes($authenticationType->getAuthority())."'",
			_AND);
		$query->addWhere(
			"keyword='".addslashes($authenticationType->getKeyword())."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		$mappings =$this->_createMappingsFromResult($result);
		
		$obj = new HarmoniObjectIterator($mappings);
		
		return $obj;
	}
	
	/**
	 * Return an iterator of all of the mappings for an Agent Id across
	 * all of the AuthenticationTypes
	 * 
	 * @param object Id $agentId
	 * @return object ObjectIterator
	 * @access public
	 * @since 3/9/05
	 */
	function getMappingsForAgentId ( Id $agentId ) {
		$this->_checkConfig();
				
		$dbc = Services::getService("DatabaseManager");
		
		$query =$this->_createSelectQuery();
		
		$query->addWhere(
			"agent_id='".addslashes($agentId->getIdString())."'");
		
		$result =$dbc->query($query, $this->_dbId);
		
		$mappings =$this->_createMappingsFromResult($result);
		
		$obj = new HarmoniObjectIterator($mappings);
		
		return $obj;
	}
	
	/**
	 * Return true if a mapping between AuthNTokens and an AgentId exists for this auth
	 * Type.
	 * 
	 * @param object Id $agentId
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function mappingExists ( Id $agentId, AuthNTokens $authNTokens, Type $authenticationType ) {
		$this->_checkConfig();
		
		$dbc = Services::getService("DatabaseManager");
		
		$query = new SelectQuery;
		$query->addTable($this->_mappingTable);
		$query->addTable($this->_typeTable, 
			LEFT_JOIN, 
			$this->_mappingTable.'.fk_type='.$this->_typeTable.'.id');
		$query->addColumn('agent_id');
		$query->addColumn('token_identifier');
		$query->addWhere(
			"agent_id='".addslashes($agentId->getIdString())."'");
		$query->addWhere(
			"token_identifier='".addslashes($authNTokens->getIdentifier())."'",
			_AND);
		$query->addWhere(
			"domain='".addslashes($authenticationType->getDomain())."'",
			_AND);
		$query->addWhere(
			"authority='".addslashes($authenticationType->getAuthority())."'",
			_AND);
		$query->addWhere(
			"keyword='".addslashes($authenticationType->getKeyword())."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		if ($result->getNumberOfRows() == 1) {
			$result->free();
			return TRUE;
		}
		if ($result->getNumberOfRows() == 0) {
			$result->free();
			return FALSE;
		}
		else
			throwError( new Error("Invalid number of results: ".$result->getNumberOfRows(),
									 "AgentTokenMappingManager", true));
	}
	
	/**
	 * Return true if a mapping between AuthNTokens and an AgentId exists for this auth
	 * Type.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return boolean
	 * @access private
	 * @since 3/1/05
	 */
	function _mappingExistsForTokens (AuthNTokens $authNTokens, Type $authenticationType ) {
		$this->_checkConfig();
		
		$dbc = Services::getService("DatabaseManager");
		
		$query = new SelectQuery;
		$query->addTable($this->_mappingTable);
		$query->addTable($this->_typeTable, 
			LEFT_JOIN, 
			$this->_mappingTable.'.fk_type='.$this->_typeTable.'.id');
		$query->addColumn('agent_id');
		$query->addColumn('token_identifier');
		$query->addWhere(
			"token_identifier='".addslashes($authNTokens->getIdentifier())."'",
			_AND);
		$query->addWhere(
			"domain='".addslashes($authenticationType->getDomain())."'",
			_AND);
		$query->addWhere(
			"authority='".addslashes($authenticationType->getAuthority())."'",
			_AND);
		$query->addWhere(
			"keyword='".addslashes($authenticationType->getKeyword())."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		if ($result->getNumberOfRows() == 1) {
			$result->free();
			return TRUE;
		}
		if ($result->getNumberOfRows() == 0) {
			$result->free();
			return FALSE;
		}
		else
			throwError( new Error("Invalid number of results: ".$result->getNumberOfRows(),
									 "AgentTokenMappingManager", true));
	}
	
	/**
	 * Check that we are configured
	 * 
	 * @return void
	 * @access private
	 * @since 3/9/05
	 */
	function _checkConfig () {
		if (!$this->_isInitialized)
			throwError( new Error(OsidException::CONFIGURATION_ERROR(),
									 "AgentTokenMappingManager", true));
	}
	
	/**
	 * Get the key of the type.
	 * 
	 * @param object Type $type
	 * @return integer
	 * @access private
	 * @since 3/9/05
	 */
	function _getTypeKey ( Type $type ) {
		$dbc = Services::getService("DatabaseManager");
		
		// Check if the type exists and return its key if found.
		$query = new SelectQuery;
		$query->addTable($this->_typeTable);
		$query->addColumn('id');
		$query->addWhere(
			"domain='".addslashes($type->getDomain())."'");
		$query->addWhere(
			"authority='".addslashes($type->getAuthority())."'",
			_AND);
		$query->addWhere(
			"keyword='".addslashes($type->getKeyword())."'",
			_AND);
		
		$result =$dbc->query($query, $this->_dbId);
		
		if ($result->getNumberOfRows() == 1) {
			return $result->field('id');
		} 
		
		// Otherwise, insert the type and return the new key.
		else {
			$result->free();
			$query = new InsertQuery;
			$query->setTable($this->_typeTable);
			$query->setAutoIncrementColumn("id", $this->_typeTable."_id_seq");
			$query->setColumns(
				array(
					'domain',
					'authority',
					'keyword',
					'description'));
			$query->setValues(
				array(
					"'".addslashes($type->getDomain())."'",
					"'".addslashes($type->getAuthority())."'",
					"'".addslashes($type->getKeyword())."'",
					"'".addslashes($type->getDescription())."'"));
			
			$result =$dbc->query($query, $this->_dbId);
			return $result->getLastAutoIncrementValue();
		}
	}
	
	/**
	 * Create an array of mapping objects from a query result.
	 * 
	 * @param object SelectQueryResultInterface
	 * @return array
	 * @access private
	 * @since 3/9/05
	 */
	function _createMappingsFromResult ( SelectQueryResultInterface $result ) {
		$mappings = array();
		$types = array();
		$idManager = Services::getService('Id');
		$authNMethodManager = Services::getService('AuthNMethods');
		
		while ($row = $result->getCurrentRow()) {
			$typeString = $row['domain']."::".
				$row['authority']."::".
				$row['keyword']."::".
				$row['description'];
			
			if (!isset($types[$typeString]))
				$types[$typeString] = new Type (
					$row['domain'], 
					$row['authority'], 
					$row['keyword'], 
					$row['description']);
			
			try {
				$authNMethod =$authNMethodManager->getAuthNMethodForType($types[$typeString]);
			
				$mappings[] = new AgentTokenMapping( 
					$types[$typeString],
					$idManager->getId($row['agent_id']),
					$authNMethod->createTokensForIdentifier($row['token_identifier']));
			} catch (UnknownTypeException $e) {
				// If an authn type is no longer enabled, just skip it.
			}
		
			$result->advanceRow();
		}
		
		return $mappings;
	}
	
	/**
	 * Create a select query with table joins.
	 * 
	 * @return object SelectQuery
	 * @access private
	 * @since 3/9/05
	 */
	function _createSelectQuery () {
		$query = new SelectQuery;
		$query->addTable($this->_mappingTable);
		$query->addTable($this->_typeTable, 
			LEFT_JOIN, 
			$this->_mappingTable.'.fk_type='.$this->_typeTable.'.id');
		$query->addColumn('agent_id');
		$query->addColumn('token_identifier');
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		
		return $query;
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