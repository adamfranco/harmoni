<?

require_once(OKI2."/osid/hierarchy/HierarchyManager.php");

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
 * @version $Id: HarmoniHierarchyManager.class.php,v 1.10 2005/03/25 18:34:26 adamfranco Exp $
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
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($dbName, new StringValidatorRule(), true);
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
	function &createHierarchy ( $displayName, &$nodeTypes, $description, $allowsMultipleParents, $allowsRecursion ) { 
		// ** parameter validation
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($allowsMultipleParents, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($allowsRecursion, new BooleanValidatorRule(), true);
		// ** end of parameter validation

		// check for supported hierarchies
		if ($allowsRecursion)
			throwError(new Error(HierarchyException::UNSUPPORTED_HIERARCHY(), "HierarchyManager", 1));
		
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";

		// Create an Id for the Hierarchy
		$idManager =& Services::requireService("Id");
		$id =& $idManager->createId();
		$idValue = $id->getIdString();
		
		// Create a new hierarchy and insert it into the database
		$hierarchy =& new HarmoniHierarchy($id, $displayName, $description,
										   new HierarchyCache($idValue, $allowsMultipleParents,
															  $this->_dbIndex, $this->_hyDB));

		$query =& new InsertQuery();
		$query->setTable($db."hierarchy");
		$columns = array();
		$columns[] = "hierarchy_id";
		$columns[] = "hierarchy_display_name";
		$columns[] = "hierarchy_description";
		$columns[] = "hierarchy_multiparent";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($description)."'";
		$multiparent = ($allowsMultipleParents) ? '1' : '0';
		$values[] = "'".$multiparent."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
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
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		$idValue = $hierarchyId->getIdString();
		
		// check the cache
		if (isset($this->_hierarchies[$idValue]))
			return $this->_hierarchies[$idValue];

		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";
		
		$query =& new SelectQuery();
		$query->addColumn("hierarchy_id", "id", $db."hierarchy");
		$query->addColumn("hierarchy_display_name", "display_name", $db."hierarchy");
		$query->addColumn("hierarchy_description", "description", $db."hierarchy");
		$query->addColumn("hierarchy_multiparent", "multiparent", $db."hierarchy");
		$query->addTable($db."hierarchy");
		$query->addWhere($db."hierarchy.hierarchy_id = '{$idValue}'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) 
			throwError(new Error(HierarchyException::UNKNOWN_ID(), "Hierarchy", 1));
		
		$row = $queryResult->getCurrentrow();

		$idValue =& $row['id'];
		$idManager =& Services::requireService("Id");
		$id =& $idManager->getId($idValue);
		$allowsMultipleParents = ($row['multiparent'] == '1');
		
		$cache =& new HierarchyCache($idValue, $allowsMultipleParents, $this->_dbIndex, $this->_hyDB);
		
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

		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";
		
		$query =& new SelectQuery();
		$query->addColumn("hierarchy_id", "id", $db."hierarchy");
		$query->addColumn("hierarchy_display_name", "display_name", $db."hierarchy");
		$query->addColumn("hierarchy_description", "description", $db."hierarchy");
		$query->addColumn("hierarchy_multiparent", "multiparent", $db."hierarchy");
		$query->addTable($db."hierarchy");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$hierarchies = array();
		
		$idManager =& Services::requireService("Id");

		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentrow();
	
			$idValue =& $row['id'];
			
			// check the cache
			if (isset($this->_hierarchies[$idValue]))
				$hierarchy =& $this->_hierarchies[$idValue];
			else {
				$id =& $idManager->getId($idValue);
				$allowsMultipleParents = ($row['multiparent'] == '1');
		
				$cache =& new HierarchyCache($idValue, $allowsMultipleParents, $this->_dbIndex, $this->_hyDB);
						
				$hierarchy =& new HarmoniHierarchy($id, $row['display_name'], $row['description'], $cache);
				$this->_hierarchies[$idValue] =& $hierarchy;
			}
	
			$hierarchies[$idValue] =& $hierarchy;
			$queryResult->advanceRow();
		}
		
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
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";
		
		$idValue = $hierarchyId->getIdString();
		
		// see if there are any nodes remaining that have to removed
		$query =& new SelectQuery();
		$query->addTable($db."node");
		$query->addColumn("COUNT({$db}node.node_id)", "num");
		$query->addWhere("{$db}node.fk_hierarchy = '{$idValue}'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$row = $queryResult->getCurrentRow();
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
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation

		$idValue = $id->getIdString();
		
		$dbHandler =& Services::requireService("DBHandler");

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
			throwError(new Error(HierarchyException::OPERATION_FAILED(), "Hierarchy", true));
		}
		
		$nodeRow = $nodeQueryResult->getCurrentRow();

		$idManager =& Services::requireService("Id");

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
		$idManager =& Services::requireService("Id");
		$hierarchyId =& $idManager->getId($node->_cache->_hierarchyId);
		$hierarchy =& $this->getHierarchy($hierarchyId);
		
		return $hierarchy;
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
	 **/
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
	 **/
	function stop() {
	}

}

?>