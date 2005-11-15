<?

require_once(OKI2."/osid/hierarchy/HierarchyManager.php");
require_once(OKI2."/osid/hierarchy/HierarchyException.php");

require_once(HARMONI."oki2/hierarchy/HarmoniHierarchy.class.php");
require_once(HARMONI."oki2/hierarchy/HarmoniHierarchyIterator.class.php");
require_once(HARMONI."oki2/hierarchy/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki2/hierarchy/HarmoniTraversalInfoIterator.class.php");

require_once(HARMONI.'/oki2/id/HarmoniIdManager.class.php');

/**
 * <p>
 * HierarchyManager handles creating, deleting, and getting Hierarchies.
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
 *
 * @package harmoni.osid_v2.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniHierarchyManager.class.php,v 1.21 2005/11/15 20:49:26 adamfranco Exp $
 */
class HarmoniHierarchyManager 
	extends HierarchyManager {


	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @var string _hierarchyDB 
	 * @access protected
	 */
	var $_hyDB;
	
	
	/**
	 * An array that will store all hierarchies and fulfil the function of a
	 * cache.
	 * @var array _hierarchies 
	 * @access private
	 */
	var $_hierarchies;
	
	
	/**
	 * Constructor
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string hyDB The name of the hierarchy database.
	 * manager.
	 * @access public
	 */
	function HarmoniHierarchyManager () {
		$this->_hierarchies = array();
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$dbIndex =& $configuration->getProperty('database_index');
		$dbName =& $configuration->getProperty('database_name');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($dbName, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_hyDB = $dbName;
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
	function &getOsidContext () { 
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
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	} 

	/**
	 * Create a Hierarchy.
	 * 
	 * @param string $displayName
	 * @param object Type[] $nodeTypes
	 * @param string $description
	 * @param boolean $allowsMultipleParents
	 * @param boolean $allowsRecursion
	 * @param optional object Id $id WARNING: NOT IN OSID
	 *	
	 * @return object Hierarchy
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNSUPPORTED_CREATION
	 *		   UNSUPPORTED_CREATION}
	 * 
	 * @access public
	 */
	function &createHierarchy ( $displayName, &$nodeTypes, $description, $allowsMultipleParents, $allowsRecursion, $id = NULL ) { 
		// ** parameter validation
		ArgumentValidator::validate($description, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($allowsMultipleParents, BooleanValidatorRule::getRule(), true);
		ArgumentValidator::validate($allowsRecursion, BooleanValidatorRule::getRule(), true);
		ArgumentValidator::validate($id, OptionalRule::getRule(
			ExtendsValidatorRule::getRule("Id")), true);
		
		// ** end of parameter validation

		// check for supported hierarchies
		if ($allowsRecursion)
			throwError(new Error(HierarchyException::UNSUPPORTED_CREATION(), "HierarchyManager", 1));
		
		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_hyDB.".";

		// Create an Id for the Hierarchy
		if (!is_object($id)) {
			$idManager =& Services::getService("Id");
			$id =& $idManager->createId();
		}
		$idValue = $id->getIdString();
		

		$query =& new InsertQuery();
		$query->setTable($db."hierarchy");
		$columns = array();
		$columns[] = "hierarchy_id";
		$columns[] = "hierarchy_display_name";
		$columns[] = "hierarchy_description";
		$columns[] = "hierarchy_multiparent";
		$columns[] = "last_struct_mod_time";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($description)."'";
		$multiparent = ($allowsMultipleParents) ? '1' : '0';
		$values[] = "'".$multiparent."'";
		$values[] = "NOW()";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// Create a new hierarchy and insert it into the database
		$hierarchy =& new HarmoniHierarchy($id, $displayName, $description,
			new HierarchyCache($idValue, $allowsMultipleParents, $this->_dbIndex, 
		   		$this->_hyDB, DateAndTime::now()));
		
		// then cache it
		$this->_hierarchies[$idValue] =& $hierarchy;
		
		return $hierarchy;
	}

	
	/**
	 * Get a Hierarchy by unique Id.
	 * 
	 * @param object Id $hierarchyId
	 *	
	 * @return object Hierarchy
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}
	 * 
	 * @access public
	 */
	function &getHierarchy ( &$hierarchyId ) { 
		// ** parameter validation
		ArgumentValidator::validate($hierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		$idValue = $hierarchyId->getIdString();
		
		// check the cache
		if (isset($this->_hierarchies[$idValue]))
			return $this->_hierarchies[$idValue];

		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_hyDB.".";
		
		$query =& new SelectQuery();
		$query->addColumn("hierarchy_id", "id", $db."hierarchy");
		$query->addColumn("hierarchy_display_name", "display_name", $db."hierarchy");
		$query->addColumn("hierarchy_description", "description", $db."hierarchy");
		$query->addColumn("hierarchy_multiparent", "multiparent", $db."hierarchy");
		$query->addColumn("last_struct_mod_time", "last_struct_mod_time", $db."hierarchy");
		$query->addTable($db."hierarchy");
		$query->addWhere($db."hierarchy.hierarchy_id = '{$idValue}'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$queryResult->free();
			throwError(new Error(HierarchyException::UNKNOWN_ID(), "Hierarchy", 1));
		}		
		$row = $queryResult->getCurrentrow();
		$queryResult->free();

		$idValue =& $row['id'];
		$idManager =& Services::getService("Id");
		$id = $idManager->getId($idValue);
		$allowsMultipleParents = ($row['multiparent'] == '1');
		
		$cache =& new HierarchyCache($idValue, $allowsMultipleParents, $this->_dbIndex, $this->_hyDB, $dbHandler->fromDBDate($row['last_struct_mod_time']));
		
		$hierarchy =& new HarmoniHierarchy($id, $row['display_name'], $row['description'], $cache);

		// cache it
		$this->_hierarchies[$idValue] =& $hierarchy;

		return $hierarchy;		
	}
	

	/**
	 * Get all Hierarchies.
	 *	
	 * @return object HierarchyIterator
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getHierarchies () { 

		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_hyDB.".";
		
		$query =& new SelectQuery();
		$query->addColumn("hierarchy_id", "id", $db."hierarchy");
		$query->addColumn("hierarchy_display_name", "display_name", $db."hierarchy");
		$query->addColumn("hierarchy_description", "description", $db."hierarchy");
		$query->addColumn("hierarchy_multiparent", "multiparent", $db."hierarchy");
		$query->addColumn("last_struct_mod_time", "last_struct_mod_time", $db."hierarchy");
		$query->addTable($db."hierarchy");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$hierarchies = array();
		
		$idManager =& Services::getService("Id");

		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentrow();
	
			$idValue =& $row['id'];
			
			// check the cache
			if (isset($this->_hierarchies[$idValue]))
				$hierarchy =& $this->_hierarchies[$idValue];
			else {
				$id =& $idManager->getId($idValue);
				$allowsMultipleParents = ($row['multiparent'] == '1');
		
				$cache =& new HierarchyCache($idValue, $allowsMultipleParents, $this->_dbIndex, $this->_hyDB, $dbHandler->fromDBDate($row['last_struct_mod_time']));
						
				$hierarchy =& new HarmoniHierarchy($id, $row['display_name'], $row['description'], $cache);
				$this->_hierarchies[$idValue] =& $hierarchy;
			}
	
			$hierarchies[$idValue] =& $hierarchy;
			$queryResult->advanceRow();
		}
		$queryResult->free();
		
		return new HarmoniHierarchyIterator($hierarchies);
	}

	
	/**
	 * Delete a Hierarchy by unique Id. All Nodes must be removed from the
	 * Hierarchy before this method is called.
	 * 
	 * @param object Id $hierarchyId
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown:	 {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
	 *		   NODE_TYPE_NOT_FOUND}, {@link
	 *		   org.osid.hierarchy.HierarchyException#HIERARCHY_NOT_EMPTY
	 *		   HIERARCHY_NOT_EMPTY}
	 * 
	 * @access public
	 */
	function deleteHierarchy ( &$hierarchyId ) { 
		// ** parameter validation
		ArgumentValidator::validate($hierarchyId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
		
		$dbHandler =& Services::getService("DatabaseManager");
		$db = $this->_hyDB.".";
		
		$idValue = $hierarchyId->getIdString();
		
		// see if there are any nodes remaining that have to removed
		$query =& new SelectQuery();
		$query->addTable($db."node");
		$query->addColumn("COUNT({$db}node.node_id)", "num");
		$query->addWhere("{$db}node.fk_hierarchy = '{$idValue}'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$row = $queryResult->getCurrentRow();
		$queryResult->free();

		// if the hierarchy contains any nodes, cannot delete
		if ($row['num'] > 0) {
			throwError(new Error(HierarchyException::HIERARCHY_NOT_EMPTY(), "Hierarchy", true));
			return;
		}
		
		// now delete it
		$query =& new DeleteQuery();
		$query->setTable($db."hierarchy");
		$query->addWhere("{$db}hierarchy.hierarchy_id = '{$idValue}'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() != 1) {
			throwError(new Error(HierarchyException::OPERATION_FAILED(), "Hierarchy", true));
		}
		
		// update the cache
		$this->_hierarchies[$idValue] = null;
		unset($this->_hierarchies[$idValue]);
	}
	
	/**
	 * This method indicates whether this implementation supports
	 * HierarchyManager methods: createHierarchy, deleteHierarchy, updateName,
	 * updateDescription, createRootNode, createNode, deleteNode, addNodeType,
	 * removeNodeType. Note methods: nodeUpdateDescription,
	 * noteUpdateDisplayName, addParent, removeParent, changeParent.
	 *	
	 * @return boolean
	 * 
	 * @throws object HierarchyException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.hierarchy.HierarchyException may be thrown: {@link
	 *		   org.osid.hierarchy.HierarchyException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function supportsMaintenance () { 
		return TRUE;
	} 
	
	
	/**
	 * Returns the hierarchy Node with the specified Id.
	 *
	 * WARNING: NOT IN OSID - As of Version 2.0, this method has been removed
	 * from the OSID.
	 *
	 * @access public
	 * @param ref object id The Id object.
	 * @return ref object The Node with the given Id.
	 **/
	function &getNode(& $id) {
		// ** parameter validation
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation

		$idValue = $id->getIdString();
		
		$dbHandler =& Services::getService("DatabaseManager");

		// find the hierarchy id for this node
		$db = $this->_hyDB.".";
		$query =& new SelectQuery();
		$query->addColumn("fk_hierarchy", "hierarchy_id", $db."node");
		$query->addTable($db."node");
		$joinc = $db."node.fk_hierarchy = ".$db."hierarchy.hierarchy_id";
		$query->addTable($db."hierarchy", INNER_JOIN, $joinc);
		$where = $db."node.node_id = '".addslashes($idValue)."'";
		$query->addWhere($where);
		
		$nodeQueryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($nodeQueryResult->getNumberOfRows() != 1) {
			$nodeQueryResult->free();
			throwError(new Error(HierarchyException::OPERATION_FAILED()." Could not find node of id, '".$id->getIdString()."'.", 
				"Hierarchy", true));
		}
		
		$nodeRow = $nodeQueryResult->getCurrentRow();
		$nodeQueryResult->free();

		$idManager =& Services::getService("Id");

		$hierarchyId = $nodeRow['hierarchy_id'];

		// get the hierarchy
		$hierarchy =& $this->getHierarchy($idManager->getId($hierarchyId));
		
		$node =& $hierarchy->getNode($id);

		return $node;
	}
	
	/**
	 * Returns the hierarchy to which the given Node belongs. 
	 * 
	 * WARNING: NOT IN OSID - This method is not part of the OKI interface as 
	 * of 07/06/04 but has been scheduled for addition.
	 *
	 * Note: As of version 2.0, the getNode() method has been removed from the
	 * OSID, removing the need for this method.
	 *
	 * @access public
	 * @return ref object The Hierarchy to which the Node belongs.
	 **/
	function &getHierarchyForNode(& $node) {
		$idManager =& Services::getService("Id");
		$hierarchyId =& $idManager->getId($node->_cache->_hierarchyId);
		$hierarchy =& $this->getHierarchy($hierarchyId);
		
		return $hierarchy;
	}
}

?>