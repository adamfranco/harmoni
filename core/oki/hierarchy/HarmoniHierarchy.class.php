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
	}
	
	// public osid.shared.Id & nodeId();
	function & nodeId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & nodeType();
	function & nodeType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String displayName();
	function displayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String description();
	function description() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & parentId();
	function & parentId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & type();
	function & type() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteNode(osid.shared.Id & $nodeId);
	function deleteNode(& $nodeId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public NodeIterator & getRootNodes();
	function & getRootNodes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Node & getNode(osid.shared.Id & $nodeId);
	function & getNode(& $nodeId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getNodeTypes();
	function & getNodeTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean allowsMultipleParents();
	function allowsMultipleParents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean allowsRecursion();
	function allowsRecursion() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public TraversalInfoIterator & traverse();
	function & traverse() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & startId();
	function & startId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public int mode();
	function mode() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public int direction();
	function direction() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public int levels();
	function levels() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Hierarchy