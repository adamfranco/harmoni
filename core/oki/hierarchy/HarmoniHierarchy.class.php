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
	 * @var array $_rootNodes An array of root nodes in this hierarchy.
	 */
	var $_rootNodes = array();
	
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
	function & createRootNode() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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

	// public Node & createNode();
	function & createNode() {
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