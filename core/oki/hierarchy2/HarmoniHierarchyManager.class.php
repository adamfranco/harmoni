<?

require_once(OKI."/hierarchy.interface.php");

require_once(HARMONI."oki/hierarchy2/HarmoniHierarchy.class.php");
require_once(HARMONI."oki/hierarchy2/HarmoniHierarchyIterator.class.php");
require_once(HARMONI."oki/hierarchy2/HarmoniNodeIterator.class.php");
require_once(HARMONI."oki/hierarchy2/HarmoniTraversalInfoIterator.class.php");

require_once(HARMONI.'/oki/shared/HarmoniSharedManager.class.php');

/**
 * All implementors of OsidManager provide create, delete, and get methods for
 * the various objects defined in the package.  Most managers also include
 * methods for returning Types.  We use create methods in place of the new
 * operator.  Create method implementations should both instantiate and
 * persist objects.  The reason we avoid the new operator is that it makes the
 * name of the implementating package explicit and requires a source code
 * change in order to use a different package name. In combination with
 * OsidLoader, applications developed using managers permit implementation
 * substitution without source code changes.
 * 
 * 
 * @package harmoni.osid.hierarchy2
 * @author Middlebury College
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: HarmoniHierarchyManager.class.php,v 1.8 2004/07/29 15:39:51 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniHierarchyManager extends HierarchyManager {


	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute protected integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @attribute protected string _hierarchyDB
	 */
	var $_hyDB;
	
	
	/**
	 * An array that will store all hierarchies and fulfil the function of a
	 * cache.
	 * @attribute private array _hierarchies
	 */
	var $_hierarchies;
	
	
	/**
	 * Constructor
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string hyDB The name of the hierarchy database.
	 * manager.
	 * @access public
	 */
	function HarmoniHierarchyManager ($dbIndex, $hyDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($hyDB, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_hyDB = $hyDB;
		$this->_hierarchies = array();
	}

	/**
	 * Create a Hierarchy.
	 *
	 * @param String displayName
	 * @param array nodeTypes An array of nodeTypes to add to the Hierarchy. NOTE:
	 * this value is irrelevant since the current implementation does not include
	 * a pre-defined set of allowed node types.
	 * @param String description
	 * @param boolean allowsMultipleParents
	 * @param boolean allowsRecursion
	 *
	 * @return Hierarchy
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.ILLEGAL_HIERARCHY
	 *		   if allowsMultipleParents is false and allowsResursion is true.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & createHierarchy($displayName, $nodeTypes, $description, $allowsMultipleParents, $allowsRecursion) {
		// ** parameter validation
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
		ArgumentValidator::validate($allowsMultipleParents, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($allowsRecursion, new BooleanValidatorRule(), true);
		// ** end of parameter validation

		// check for supported hierarchies
		if ($allowsRecursion)
			throwError(new Error(UNSUPPORTED_HIERARCHY, "HierarchyManager", 1));
		
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";

		// Create an Id for the Hierarchy
		$sharedManager =& Services::requireService("Shared");
		$id =& $sharedManager->createId();
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
	 * @param object osid.shared.Id hierarchyId
	 *
	 * @return Hierarchy
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.HIERARCHY_UNKNOWN
	 *		   if there is no Hierarchy matching hierarchyId.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getHierarchy(& $hierarchyId) {
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
			throwError(new Error(UNKNOWN_ID, "Hierarchy", 1));
		
		$row = $queryResult->getCurrentrow();

		$idValue =& $row['id'];
		$shared_manager =& Services::requireService("Shared");
		$id =& $shared_manager->getId($idValue);
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
	 * @return HierarchyIterator  Iterators return a set, one at a time.  The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.  The Iterator's next method
	 *		   returns the next object.  The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getHierarchies() {
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
		
		$shared_manager =& Services::requireService("Shared");

		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentrow();
	
			$idValue =& $row['id'];
			
			// check the cache
			if (isset($this->_hierarchies[$idValue]))
				$hierarchy =& $this->_hierarchies[$idValue];
			else {
				$id =& $shared_manager->getId($idValue);
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
	 * @param object osid.shared.Id hierarchyId
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.HIERARCHY_UNKNOWN
	 *		   if there is no Hierarchy matching hierarchyId and throws an
	 *		   exception with the message
	 *		   HierarchyException.HIERARCHY_NOT_EMPTY if the Hierarchy
	 *		   contains nodes.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteHierarchy(& $hierarchyId) {
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
			throwError(new Error(HIERARCHY_NOT_EMPTY, "Hierarchy", true));
			return;
		}
		
		// now delete it
		$query =& new DeleteQuery();
		$query->setTable($db."hierarchy");
		$query->addWhere("{$db}hierarchy.hierarchy_id = '{$idValue}'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() != 1) {
			$str = "Something went wrong when deleting the hierarchy.";
			throwError(new Error($str, "Hierarchy", true));
		}
		
		// update the cache
		$this->_hierarchies[$idValue] = null;
		unset($this->_hierarchies[$idValue]);
	}
	
	
	/**
	 * Returns the hierarchy Node with the specified Id.
	 * @access public
	 * @param ref object id The Id object.
	 * @return ref object The Node with the given Id.
	 **/
	function & getNode(& $id) {
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
			$err = "Exactly one row should be returned!";
			throwError(new Error($err, "Hierarchy", true));
		}
		
		$nodeRow = $nodeQueryResult->getCurrentRow();

		$shared_manager =& Services::requireService("Shared");

		$hierarchyId = $nodeRow['hierarchy_id'];

		// get the hierarchy
		$hierarchy =& $this->getHierarchy($shared_manager->getId($hierarchyId));
		
	    $node =& $hierarchy->getNode($id);

		return $node;
	}
	

	
	/**
	 * Returns the hierarchy to which the given Node belongs. Note: this method
	 * is not part of the OKI interface as of 07/06/04 but has been scheduled for
	 * addition.
	 * @access public
	 * @return ref object The Hierarchy to which the Node belongs.
	 **/
	function & getHierarchyForNode(& $node) {
		$sharedManager =& Services::requireService("Shared");
		$hierarchyId =& $sharedManager->getId($node->_cache->_hierarchyId);
		$hierarchy =& $this->getHierarchy($hierarchyId);
		
		return $hierarchy;
	}
	
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}

}

?>