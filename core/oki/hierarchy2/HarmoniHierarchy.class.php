<?

require_once(OKI."/hierarchy.interface.php");
require_once(HARMONI.'/oki/hierarchy2/HarmoniNode.class.php');
require_once(HARMONI.'/oki/hierarchy2/HierarchyCache.class.php');
require_once(HARMONI.'/oki/hierarchy2/HarmoniNodeIterator.class.php');
require_once(HARMONI.'/oki/hierarchy2/HarmoniTraversalInfo.class.php');
require_once(HARMONI.'/oki/hierarchy2/HarmoniTraversalInfoIterator.class.php');
require_once(HARMONI.'/oki/hierarchy2/DefaultNodeType.class.php');

/**
 * A Hierarchy is a structure comprised of nodes arranged in root, parent, and
 * child form.  The Hierarchy can be traversed in several ways to determine
 * the arrangement of nodes. A Hierarchy can allow multiple parents.  A
 * Hierarchy can allow recursion.  The implementation is responsible for
 * ensuring that the integrity of the Hierarchy is always maintained.
 *
 * @package harmoni.osid.hierarchy2
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniHierarchy.class.php,v 1.10 2005/01/19 21:10:09 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniHierarchy extends Hierarchy {


	/**
	 * The Id of this hierarchy.
	 * @attribute private object _id
	 */
	var $_id;
	
	
	/**
	 * The display name of this hierarchy.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	
	/**
	 * The description of this hierarchy.
	 * @attribute private string _description
	 */
	var $_description;
	
	
	/**
	 * Constructor.
	 *
	 * @param object ID   $id   The Id of this Hierarchy.
	 * @param string $displayName The displayName of the Hierarchy.
	 * @param string $description The description of the Hierarchy.
	 * @param boolean allowsMultipleParents This is true if the hierarchy will allow
	 * multiple parents.
	 * @param ref object cache This is the HierarchyCache object. Must be the same
	 * one that all other nodes in the Hierarchy are using.
	 * @access public
	 */
	function HarmoniHierarchy(& $id, $displayName, $description, & $cache) {
		// ** parameter validation
 		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
 		ArgumentValidator::validate($displayName, new StringValidatorRule(), true);
 		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		ArgumentValidator::validate($cache, new ExtendsValidatorRule("HierarchyCache"), true);
		// ** end of parameter validation
	
		$this->_id =& $id;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_cache =& $cache;
	}

	
    /**
     * Get the unique Id for this Hierarchy.
     *
     * @return object osid.shared.Id A unique Id that is usually set by a create
     *         method's implementation
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getId() {
		return $this->_id;
	}

    /**
     * Get the display name for this Hierarchy.
     *
     * @return String the display name
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDisplayName() {
		return $this->_displayName;
	}

    /**
     * Get the description for this Hierarchy.
     *
     * @return String the description
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDescription() {
		return $this->_description;
	}

    /**
     * Update the description for this Hierarchy.
     *
     * @param String description  Description cannot be null but may be empty.
     *
     * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   description is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDescription($description) {
		// ** parameter validation
		ArgumentValidator::validate($description, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		if ($this->_description == $description)
		    return; // nothing to update

		// update the object
		$this->_description = $description;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."hierarchy");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}hierarchy.hierarchy_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}hierarchy.hierarchy_description"));
		$query->setValues(array("'".addslashes($description)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The hierarchy with Id: ".$idValue." does not exist in the database.","Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple hierarchies with Id: ".$idValue." exist in the database. Note: their descriptions have been updated." ,"Hierarchy",true));
	}

	
	/**
	 * Update the name of this Hierarchy. Hierarchy name changes are permitted since the
	 * Hierarchy's integrity is based on the Hierarchy's unique Id. name The
	 * displayName of the new Hierarchy; displayName cannot be null, but may be
	 * empty.
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   displayName is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDisplayName($displayName) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		// ** end of parameter validation
		
		if ($this->_displayName == $displayName)
		    return; // nothing to update
		
		// update the object
		$this->_displayName = $displayName;

		// update the database
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_cache->_hyDB.".";
		
		$query =& new UpdateQuery();
		$query->setTable($db."hierarchy");
		$id =& $this->getId();
		$idValue = $id->getIdString();
		$where = "{$db}hierarchy.hierarchy_id = '{$idValue}'";
		$query->setWhere($where);
		$query->setColumns(array("{$db}hierarchy.hierarchy_display_name"));
		$query->setValues(array("'".addslashes($displayName)."'"));
		
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The hierarchy with Id: ".$idValue." does not exist in the database.","Hierarchy",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple hierarchys with Id: ".$idValue." exist in the database. Note: their display names have been updated." ,"Hierarchy",true));
	}

	
	/**
	 * Create a root Node with root status. The Node is created with the
	 * specified unique Id, and, unlike Nodes created with createNode,
	 * initially has no parents or children.
	 *
	 * @param object osid.shared.Id nodeId nodeId The unique Id to be associated with
	 *		  the new Node; unique Id cannot be null.
	 * @param object osid.shared.Type nodeType type The Type of the new Node; type may
	 *		  be null if the node has no type.
	 * @param String displayName name The displayName of the new Node;
	 *		  displayName cannot be null, but may be empty.
	 * @param String description The description of the new Node; description
	 *		  cannot be null, but may be empty. new Node with root status.
	 *
	 * @throws HierarchyException if there is a general failure.     Thows an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   id, displayName, or description is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createRootNode(& $nodeId, & $type, $displayName, $description) {
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation

		return $this->_cache->createRootNode($nodeId, $type, $displayName, $description);
	}

	/**
	 * Create a Node. The Node is created with the specified unique Id and
	 * initially has only the one specified parent.
	 *
	 * @param object osid.shared.Id nodeId nodeId The unique Id to be associated with
	 *		  the new Node; unique Id cannot be null.
	 * @param object osid.shared.Id parentId nodeId The unique Id to be associated
	 *		  with the parent of this new Node; unique Id cannot be null.
	 * @param object osid.shared.Type nodeType type The Type of the new Node; type may
	 *		  be null if the node has no type.
	 * @param String displayName name The displayName of the new Node;
	 *		  displayName cannot be null, but may be empty.
	 * @param String description The description of the new Node; description
	 *		  cannot be null, but may be empty. new Node.
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message
	 *		   HierarchyException.ATTEMPTED_RECURSION if the Hierarchy was
	 *		   created with allowsRecurion false and recursive node link is
	 *		   attempted.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createNode(& $nodeId, & $parentId, & $type, $displayName, $description) {
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($parentId, new ExtendsValidatorRule("Id"), true);
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation

		return $this->_cache->createNode($nodeId, $parentId, $type, $displayName, $description);
	}

	/**
	 * Delete a Node by Id.  Only leaf Nodes can be deleted.
	 *
	 * @param object osid.shared.Id nodeId
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message HierarchyException.UNKNOWN_NODE if
	 *		   there is no Node mathching nodeId.  Throws an exception with
	 *		   the message HierarchyException.INCONSISTENT_STATE if nodeId is
	 *		   not a leaf.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteNode(& $nodeId) {
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$this->_cache->deleteNode($nodeId->getIdString());
	}

	/**
	 * Add a NodeType to this Hierarchy.
	 *
	 * @param object osid.shared.Type nodeType
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   nodeType is null.  Throws and exception with the message
	 *		   HierarchyException.ALREADY_ADDED if the nodeType was already
	 *		   added.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function addNodeType(& $nodeType) {
		throwError(new Error(UNIMPLEMENTED, "Hierarchy", true));
	}

	/**
	 * Remove a NodeType from this Hierarchy.  Note that no Nodes can have this
	 * NodeType.
	 *
	 * @param object osid.shared.Type nodeType
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   nodeType is null.  Throws an exception with the message
	 *		   HierarchyException.NODE_TYPE_IN_USE if the nodeType is
	 *		   referenced by a Node.  Throws an exception with the message
	 *		   HierarchyException.NODE_TYPE_NOT_FOUND if the nodeType was not
	 *		   found.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function removeNodeType(& $nodeType) {
		throwError(new Error(UNIMPLEMENTED, "Hierarchy", true));
	}

	/**
	 * Get all the Nodes in this Hierarchy. The order in which nodes are 
	 * returned is undefined.
	 *
	 * @return NodeIterator  Iterators return a set, one at a time.  The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.  The Iterator's next method
	 *		   returns the next object.  The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAllNodes() {
		// if all the nodes haven't been cached then do it
		$nodes =& $this->_cache->getAllNodes();

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}

	/**
	 * Get the root Nodes in this Hierarchy.  The root Nodes are defined as all
	 * Nodes without parents.
	 *
	 * @return NodeIterator  Iterators return a set, one at a time.  The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.  The Iterator's next method
	 *		   returns the next object.  The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getRootNodes() {
		// if all the nodes haven't been cached then do it
		$nodes =& $this->_cache->getRootNodes();

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}
	
	/**
	 * Get the Nodes of the specified Type in this Hierarchy. 
	 *
	 * WARNING: This method is not in the OSIDs as of version 2.0.
	 *
	 * @param object Type $nodeType
	 * @return object NodeIterator  Iterators return a set, one at a time.  The
	 *		   Iterator's hasNext method returns true if there are additional
	 *		   objects available; false otherwise.  The Iterator's next method
	 *		   returns the next object.  The order of the objects returned by
	 *		   the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getNodesByType( & $nodeType ) {
		// if all the nodes haven't been cached then do it
		$where = "type_domain = '".addslashes($nodeType->getDomain())."'";
		$where .= " AND type_authority = '".addslashes($nodeType->getAuthority())."'";
		$where .= " AND type_keyword = '".addslashes($nodeType->getKeyword())."'";
		$nodes =& $this->_cache->getNodesFromDB($where);

		// create the iterator and return them
		return new HarmoniNodeIterator($nodes);
	}

	/**
	 * Get a Node by unique Id.
	 *
	 * @return Node
	 *
	 * @throws HierarchyException if there is a general failure.     Throws an
	 * 		 exception with the message HierarchyException.UNKNOWN_NODE if
	 *		   there is no Node matching nodeId.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getNode(& $nodeId) {
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
		
		$idValue = $nodeId->getIdString();
		$node =& $this->_cache->getNode($idValue);
		
		return $node;
	}

	/**
	 * Get all NodeTypes used in this Hierarchy.
	 *
	 * @return object osid.shared.TypeIterator Iterators return a set, one at a time.
	 *		   The Iterator's hasNext method returns true if there are
	 *		   additional objects available; false otherwise.  The Iterator's
	 *		   next method returns the next object.  The order of the objects
	 *		   returned by the Iterator is not guaranteed.
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getNodeTypes() {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_cache->_hyDB.".";
		// set the tables
		$query->addTable($db."node");
		$joinc = $db."node.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		$hierarchyIdValue = $this->_id->getIdString();
		$query->addWhere($db."node.fk_hierarchy = '{$hierarchyIdValue}'");

		// set the columns to select
		$query->setDistinct(true);
		$query->addColumn("type_id", "id", $db."type");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "description", $db."type");
		$queryResult =& $dbHandler->query($query, $this->_cache->_dbIndex);

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
	 * Returns true if multiple parents are allowed; false otherwise.
	 *
	 * @return boolean
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function allowsMultipleParents() {
		return $this->_cache->_allowsMultipleParents;
	}

	/**
	 * Returns true if recursion allowed; false otherwise.
	 *
	 * @return boolean
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function allowsRecursion() {
		return false;
	}

	/**
	 * Traverse a Hierarchy returning information about each Node encountered.
	 * It is best in terms of efficiency to always do full traversal, i.e. with levels
	 * < 0.
	 *
	 * @param object osid.shared.Id startId the unique Id of the node from which
	 *		  traversal shoudl start.
	 * @param int mode must be either TRAVERSE_MODE_DEPTH_FIRST or
	 *		  TRAVERSE_MODE_BREADTH_FIRST, indicating either depth-first or
	 *		  breadth-first traversal, respectively
	 * @param int direction must be either TRAVERSE_DIRECTION_UP or
	 *		  TRAVERSE_DIRECTION_DOWN, indicating the whether the traversal
	 *		  should proceed up the parents or down the children.
	 * @param int levels the number of levels to traverse.  If this value is
	 *		  &lt; 0 (or TRAVERSE_LEVELS_ALL, which equals -1), the
	 *		  traversal will proceed to the end of the Hierarchy or until a
	 *		  circular reference returns to a Node already traversed.
	 *
	 * @return TraversalInfoIterator where each TraversalInfo object contains
	 *		   information about the Node traversed in the order they were
	 *		   encountered.
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message UNKNOWN_NODE if startId is unknown;
	 *		   the message UNKNOWN_TRAVERSAL_MODE, if the mode is neither
	 *		   depth- nor breath-first; and the message
	 *		   UNKNOWN_TRAVERSAL_DIRECTION if the direction is neither up nor
	 *		   down.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &traverse(& $startId, $mode, $direction, $levels) {
		// Check the arguments
		ArgumentValidator::validate($startId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($mode, new IntegerValidatorRule);
		ArgumentValidator::validate($direction, new IntegerValidatorRule);
		ArgumentValidator::validate($levels, new IntegerValidatorRule);

		if ($mode != TRAVERSE_MODE_DEPTH_FIRST) {
			$str = "Only depth-first traversal is supported in the current implementation.";
			throwError(new Error($str, "Hierarchy", true));
		}

		$down = ($direction == TRAVERSE_DIRECTION_DOWN);
		$result =& $this->_cache->traverse($startId, $down, $levels);

		return $result;
	}
	
	
	/**
	 * Clears the cache.
	 * @access public
	 **/
	function clearCache() {
		$this->_cache->clearCache();
	}
		
}

?>