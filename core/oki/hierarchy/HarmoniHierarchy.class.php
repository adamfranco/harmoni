<?

require_once(OKI."/hierarchy/hierarchyAPI.interface.php");


class HarmoniHierarchy
	extends Hierarchy
{ // begin Hierarchy

	/**
	 * @var object Id $_id The id for this hierarchy.
	 */
	var $_id;
	
	/**
	 * @var string $_description The description for this hierarchy.
	 */
	var $_description;
	
	/**
	 * @var string $_displayName The description for this hierarchy.
	 */
	var $_displayName;
	
	/**
	 * @var object Tree $_tree A tree object.
	 */
	var $_tree = new Tree();
	
	// public osid.shared.Id & getId();
	function & getId() {
		return $this->_id;
	}

	// public String getDisplayName();
	function getDisplayName() {
		return $this->_displayName;
	}

// no updateDisplayName in the Hierarchy OSID
/* 	// public void updateDisplayName(String $displayName); */
/* 	function updateDisplayName($displayName) { */
/* 		// Check the arguments */
/* 		ArgumentValidator::validate($displayName, new StringValidatorRule); */
/* 		 */
/* 		// update and save */
/* 		$this->_displayName = $displayName; */
/* 		$this->save(); */
/* 	} */

	// public String getDescription();
	function getDescription() {
		return $this->_description;
	}

	// public void updateDescription(java.lang.String & $description);
	function updateDescription(& $description) {
		// Check the arguments
		ArgumentValidator::validate($description, new StringValidatorRule);
				
		// update and save
		$this->_description = $description;
		$this->save();
	}

	// public Node & createRootNode();
	function & createRootNode(& $nodeId, & $type, $displayName, $description) {
		// return a node with itself as the parent.
		return createNode($nodeId, $nodeId, $type, $displayName, $description);
	}

	// public Node & createNode();
	function & createNode(& $nodeId, & $parentId, & $type, $displayName, $description) {
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($parentId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"));
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
			if (!$this->_tree->nodeExists($parentIdString))
				throwError(new Error(UNKNOWN_PARENT_NODE, "Hierarchy", 1));
		}
		
		$node =& new HaromoniNode($this->_tree, $type, $displayName, $description);
		$treeNodeId = $this->_tree->addNode($node, $parentIdString);
		
		// Store the updated tree
		$this->save();
		
		return $node;
	}

	// public void deleteNode(osid.shared.Id & $nodeId);
	function deleteNode(& $nodeId) {
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		
		$nodeIdString = $nodeId->getIdString();
		
		// Throw an error if the node doesn't exist
		if ($this->_tree->nodeExists($nodeIdString))
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		// If the node is not a leaf, trow a HIERARCHY_NOT_EMPTY error
		if ($this->_tree->hasChildren($nodeIdString))
			throwError(new Error(HIERARCHY_NOT_EMPTY, "Hierarchy", 1));
		
		// Remove the node
		$this->_tree->removeNode($nodeIdString);
		
		// Store the updated tree
		$this->save();
	}

	// public void addNodeType(osid.shared.Type & $type);
	function addNodeType(& $type) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void removeNodeType(osid.shared.Type & $type);
	function removeNodeType(& $type) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public NodeIterator & getAllNodes();
	function & getAllNodes() {
		
		// Throw an error if we have no nodes
		if ($this->_tree->totalNodes() < 1)
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
	
		// array of the node IDs from top to bottom, left to right.
		$treeNodes =& $this->_tree->getFlatList();
		
		// Object array of HarmoniNode objects to pass to the iterator
		$nodeArray = array();
		
		// put the HarmoniNode objects into the nodeArray
		foreach ($treeNodes as $treeNodeId) {
			$nodeArray[] =& $this->_tree->getData($treeNodeId);
		}
		
		// pass off the array to the iterator and return it.
		$nodeIterator =& new HarmoniNodeIterator($nodeArray);
		return $nodeIterator;
	}

	// public NodeIterator & getRootNodes();
	function & getRootNodes() {
		
		// Throw an error if we have no nodes
		if ($this->_tree->totalNodes() < 1)
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		$treeNodes =& $this->_tree->getChildren(0);
		
		// Object array of HarmoniNode objects to pass to the iterator
		$nodeArray = array();

		// put the HarmoniNode objects into the nodeArray
		foreach ($treeNodes as $treeNodeId) {
			$nodeArray[] =& $this->_tree->getData($treeNodeId);
		}
		
		// pass off the array to the iterator and return it.
		$nodeIterator =& new HarmoniNodeIterator($nodeArray);
		return $nodeIterator;
	}

	// public Node & getNode(osid.shared.Id & $nodeId);
	function & getNode(& $nodeId) {
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
		
		$nodeIdString = $nodeId->getIdString();
		
		// Make sure the node exists
		if (!$this->_tree->nodeExists($nodeIdString))
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));
		
		$node =& $this->_tree->getData($nodeIdString);
		
		return $node;
	}

	// public osid.shared.TypeIterator & getNodeTypes();
	function & getNodeTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean allowsMultipleParents();
	function allowsMultipleParents() {
		return false;
	}

	// public boolean allowsRecursion();
	function allowsRecursion() {
		return false;
	}

	// public TraversalInfoIterator & traverse();
	function & traverse(& $startId, $mode, $direction, $levels) {
		// Check the arguments
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"));
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
		if ($this->_tree->totalNodes() < 1)
			throwError(new Error(UNKNOWN_NODE, "Hierarchy", 1));

		// Object array of TraversalInfo objects to pass to the iterator
		$traversalInfoArray = array();

		// --- Do the traversal ---

		if ($direction == TRAVERSE_DIRECTION_DOWN) {	// Direction: down
			// @todo
		} else {	// Direction: up
			// @todo
		}
		
		// pass off the array to the iterator and return it.
		$traversalInfoIterator =& new HarmoniTraversalInfoIterator($traversalInfoArray);
		return $traversalInfoIterator;
	}

} // end Hierarchy