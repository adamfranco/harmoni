<?

require_once(OKI."/hierarchy.interface.php");
require_once(HARMONI.'/oki/hierarchy/Tree.php');
require_once(HARMONI.'/oki/hierarchy/MemoryOnlyHierarchyStore.class.php');
require_once(HARMONI.'/oki/hierarchy/SQLDatabaseHierarchyStore.class.php');
require_once(HARMONI.'/oki/hierarchy/HarmoniNode.class.php');
require_once(HARMONI.'/oki/hierarchy/HarmoniNodeIterator.class.php');
require_once(HARMONI.'/oki/hierarchy/HarmoniTraversalInfo.class.php');
require_once(HARMONI.'/oki/hierarchy/HarmoniTraversalInfoIterator.class.php');
require_once(HARMONI.'/oki/hierarchy/GenericNodeType.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTypeIterator.class.php');


/**
 * A Hierarchy is a structure comprised of nodes arranged in root, parent, and
 * child form.  The Hierarchy can be traversed in several ways to determine
 * the arrangement of nodes. A Hierarchy can allow multiple parents.  A
 * Hierarchy can allow recursion.  The implementation is responsible for
 * ensuring that the integrity of the Hierarchy is always maintained.
 *
 * @package harmoni.osid.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniHierarchy.class.php,v 1.30 2005/01/19 21:10:07 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniHierarchy
	extends Hierarchy
{ // begin Hierarchy

	/**
	 * @var object Id $_id The id for this hierarchy.
	 */
	var $_id;
	
	/**
	 * @var object HarmoniHierarchyStore $_hierarchyStore A hierarchy storage/loader object.
	 */
	var $_hierarchyStore = NULL;

	/**
	 * Constructor.
	 *
	 * @param object ID   $id   The Id of this Node.
	 * @param string $displayName The displayName of the Node.
	 * @param string $description The description of the Node.
	 * @param array	 $nodeType  An array of Types of the supported nodes.
	 * @param object HierarchyStore $hierarchyStore	The storage/loader for this hierarchy.
	 * @parem boolean $exists Pass true if reading the hierarchy out of persistable storage,
	 *					false otherwise.
	 * @access public
	 */
	function HarmoniHierarchy(& $id, $displayName, $description, & $nodeTypes, & $hierarchyStore, $exists = FALSE) {
		// Check the arguments
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		if (count($nodeTypes))
			ArgumentValidator::validate($nodeTypes, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("TypeInterface")));
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($hierarchyStore, new ExtendsValidatorRule("HierarchyStore"));
		
		// make sure that the Store was created with our same id
		if ($hierarchyStore->getId()) 
			throwError(new Error("Hierarchy Store already in use.","Hierarchy", TRUE));
		
		// set the private variables
		$this->_id =& $id;
		$this->_hierarchyStore =& $hierarchyStore;
		$this->_hierarchyStore->setId($this->_id);
//		$this->_hierarchyStore->initialize(); 	// This is being handled by the $exists param
												// Responsibility for this being correct is
												// passed to the manager.
		// lets pass on the existance state from the manager to the store
		$this->_hierarchyStore->setExists($exists);
		
		
		if ($this->_hierarchyStore->getDisplayName() != $displayName)
			$this->_hierarchyStore->updateDisplayName($displayName);
		if ($this->_hierarchyStore->getDescription() != $description)
			$this->_hierarchyStore->updateDescription($description);
		
		
		foreach ($nodeTypes as $key => $val) {
			$this->addNodeType($nodeTypes[$key]);
		}
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
		return $this->_hierarchyStore->getId();
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
		return $this->_hierarchyStore->getDisplayName();
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
		return $this->_hierarchyStore->getDescription();
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
		// Check the arguments
		ArgumentValidator::validate($description, new StringValidatorRule);
				
		// update and save
		$this->_description = $description;
		$this->_hierarchyStore->updateDescription($description);
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
		// return a node with itself as the parent.
		return $this->createNode($nodeId, $nodeId, $type, $displayName, $description);
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
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($parentId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"));
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		
		$nodeIdString = $nodeId->getIdString();
		if ($parentId->isEqual($nodeId)) { // if this is a root node (its parent is itsself)
			// Richard Heyes' tree implimentation uses 0 as a parent node id to indicate
			// a root node.
			$parentIdString = 0;
		} else {	// if this is not a root node
			$parentIdString = $parentId->getIdString();
			// Check that the parent exists
			if (!$this->_hierarchyStore->nodeExists($parentIdString))
				throwError(new Error(UNKNOWN_PARENT_NODE, "Hierarchy", 1));
		}
		
		// Add the node Type to the hierarchy if it doesn't already exist.
		$nodeTypes =& $this->getNodeTypes();
		$typeExists = FALSE;
		while ($nodeTypes->hasNext()) {
			$nodeType =& $nodeTypes->next();
			if ($type->isEqual($nodeType)) {
				$typeExists = TRUE;
			}
		}
		if (!$typeExists)
			$this->_hierarchyStore->addNodeType($type);

		$node =& new HarmoniNode($nodeId, $this->_hierarchyStore, $type, $displayName, $description);
		$treeNodeId = $this->_hierarchyStore->addNode($node, $parentIdString, $nodeIdString);
		
		return $node;
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
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		
		$nodeIdString = $nodeId->getIdString();
		
		// Throw an error if the node doesn't exist
		if (!$this->_hierarchyStore->nodeExists($nodeIdString))
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		// If the node is not a leaf, trow a HIERARCHY_NOT_EMPTY error
		if ($this->_hierarchyStore->hasChildren($nodeIdString))
			throwError(new Error(HIERARCHY_NOT_EMPTY, "Hierarchy", 1));
		
		// Remove the node
		$this->_hierarchyStore->removeNode($nodeIdString);
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
		// Check the arguments
		ArgumentValidator::validate($nodeType, new ExtendsValidatorRule("TypeInterface"));
		
		// Throw an error if the nodeType has already been added.
		$nodeTypes =& $this->getNodeTypes();
		while ($nodeTypes->hasNext()) {
			$type =& $nodeTypes->next();
			if ($nodeType->isEqual($type))
				throwError(new Error(ALREADY_ADDED, "Hierarchy", 1));
		}
		
		// add the node type
		$this->_hierarchyStore->addNodeType($nodeType);
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
		// Check the arguments
		ArgumentValidator::validate($nodeType, new ExtendsValidatorRule("TypeInterface"));
		
		// Throw an error if the nodeType is in use.
		$nodeIterator =& $this->getAllNodes();
		while ($nodeIterator->hasNext()) {
			$node =& $nodeIterator->next();
			if ($nodeType->isEqual($node->getType()))
				throwError(new Error(NODE_TYPE_IN_USE, "Hierarchy", 1));
		}
		
		$this->_hierarchyStore->removeNodeType($nodeType);
	}

	/**
	 * Get all the Nodes in this Hierarchy.
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
		
/* 		// Throw an error if we have no nodes */
/* 		if ($this->_hierarchyStore->totalNodes() < 1) */
/* 			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1)); */
	
		// array of the node IDs from top to bottom, left to right.
		$treeNodes =& $this->_hierarchyStore->getFlatList();
		
		// Object array of HarmoniNode objects to pass to the iterator
		$nodeArray = array();
		
		// put the HarmoniNode objects into the nodeArray
		foreach ($treeNodes as $treeNodeId) {
			$nodeArray[] =& $this->_hierarchyStore->getData($treeNodeId);
		}
		
		// pass off the array to the iterator and return it.
		$nodeIterator =& new HarmoniNodeIterator($nodeArray);
		return $nodeIterator;
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
		
		// Throw an error if we have no nodes
		if ($this->_hierarchyStore->totalNodes() < 1) {
			$nodeArray = array();
		
		} else {
		
			$treeNodes =& $this->_hierarchyStore->getChildren(0);
			
			// Object array of HarmoniNode objects to pass to the iterator
			$nodeArray = array();
	
			// put the HarmoniNode objects into the nodeArray
			foreach ($treeNodes as $treeNodeId) {
				$nodeArray[] =& $this->_hierarchyStore->getData($treeNodeId);
			}
		}
		
		// pass off the array to the iterator and return it.
		$nodeIterator =& new HarmoniNodeIterator($nodeArray);
		return $nodeIterator;
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
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		
		$nodeIdString = $nodeId->getIdString();
		
		// Make sure the node exists
		if (!$this->_hierarchyStore->nodeExists($nodeIdString))
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		$node =& $this->_hierarchyStore->getData($nodeIdString);
		
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
		$typesArray =& $this->_hierarchyStore->getNodeTypes();
		$typeIterator =& new HarmoniTypeIterator($typesArray);
		return $typeIterator;
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
		return false;
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

		// check that the modes and directions are supported
		if (($mode != TRAVERSE_MODE_DEPTH_FIRST) &&
				($mode != TRAVERSE_MODE_BREADTH_FIRST)) {
			throwError(new Error(UNKNOWN_TRAVERSAL_MODE, "Hierarchy", 1));
		}
		
		if (($direction != TRAVERSE_DIRECTION_UP) &&
				($direction != TRAVERSE_DIRECTION_DOWN)) {
			throwError(new Error(UNKNOWN_TRAVERSAL_DIRECTION, "Hierarchy", 1));
		}

		// Throw an error if we have no nodes
		if ($this->_hierarchyStore->totalNodes() < 1)
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		// A string of our ID and the starting depth
		$startIdString = $startId->getIdString();
		$startLevel = $this->_hierarchyStore->depth($startIdString);

		// Object array of TraversalInfo objects to pass to the iterator
		$traversalInfoArray = array();

		// --- Do the traversal ---

		if ($direction == TRAVERSE_DIRECTION_DOWN) {	// Direction: down
			if ($mode == TRAVERSE_MODE_DEPTH_FIRST) {	// Mode: depth first
				if ($levels < 0 || $levels == TRAVERSE_LEVELS_ALL)
					$treeLevels = NULL;
				else
					$treeLevels = $levels + 1;
				$traversalIdArray = $this->_hierarchyStore->depthFirstEnumeration($startIdString, $treeLevels);
			} else {	// Mode: breadth first
				// @todo if needed
				throwError(new Error(UNKNOWN_TRAVERSAL_MODE, "Hierarchy", 1));
			}
		} else {	// Direction: up
			if ($mode == TRAVERSE_MODE_DEPTH_FIRST) {	// Mode: depth first
				// @todo if needed
			} else {	// Mode: breadth first
				// @todo if needed
				throwError(new Error(UNKNOWN_TRAVERSAL_MODE, "Hierarchy", 1));
			}
		}
		
		foreach ($traversalIdArray as $id) {
			$node =& $this->_hierarchyStore->getData($id);
			$nodeId =& $node->getId();
			$displayName = $node->getDisplayName();
			$depth = $this->_hierarchyStore->depth($id);
			$traversalInfoArray[] =& new HarmoniTraversalInfo($nodeId, $displayName, $depth);
		}
		
		// pass off the array to the iterator and return it.
		$traversalInfoIterator =& new HarmoniTraversalInfoIterator($traversalInfoArray);
		return $traversalInfoIterator;
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		$this->_hierarchyStore->save();
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * 
	 * @param object Id $nodeId The Id of the node from which to load the hierarchy from.
	 * @param boolean $childrenOnly Set to true if it is wished only to load the children
	 *					of the specified node and not the grandchildren, etc.
	 * 
	 * @access protected
	 */
	function load ($nodeId = NULL, $childrenOnly = FALSE) {
		// Check the arguments
		ArgumentValidator::validate($childrenOnly, new BooleanValidatorRule);
		if ($nodeId != NULL) {
			// Check the arguments
			ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
			
			$nodeId = $nodeId->getIdString();
		}
		$this->_hierarchyStore->load($nodeId, $childrenOnly);
	}	

} // end Hierarchy