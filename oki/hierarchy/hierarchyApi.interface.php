<?php

class HierarchyManager
	extends OsidManager
{ // begin HierarchyManager
	// public Hierarchy & createHierarchy(boolean $allowsMultipleParents, String $description, String $name, osid.shared.Type[] & $nodeTypes, boolean $allowsRecursion);
	function & createHierarchy($allowsMultipleParents, $description, $name, & $nodeTypes, $allowsRecursion) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Hierarchy & getHierarchy(osid.shared.Id & $hierarchyId);
	function & getHierarchy(& $hierarchyId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public HierarchyIterator & getHierarchies();
	function & getHierarchies() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteHierarchy(osid.shared.Id & $hierarchyId);
	function deleteHierarchy(& $hierarchyId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end HierarchyManager


// public static final int TRAVERSE_MODE_DEPTH_FIRST = 0xdf;
define("TRAVERSE_MODE_DEPTH_FIRST",0xdf;);

// public static final int TRAVERSE_MODE_BREADTH_FIRST = 0xbf;
define("TRAVERSE_MODE_BREADTH_FIRST",0xbf;);

// public static final int TRAVERSE_DIRECTION_UP = 0x01;
define("TRAVERSE_DIRECTION_UP",0x01;);

// public static final int TRAVERSE_DIRECTION_DOWN = 0x02;
define("TRAVERSE_DIRECTION_DOWN",0x02;);

// public static final int TRAVERSE_LEVELS_INFINITE = -1;
define("TRAVERSE_LEVELS_INFINITE",-1;);

class Hierarchy
	// extends java.io.Serializable    
{ // begin Hierarchy
	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDescription(java.lang.String & $description);
	function updateDescription(& $description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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

	// public osid.shared.Id & nodeId();
	function & nodeId() {
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

	// public String displayName();
	function displayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String description();
	function description() {
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


class TraversalInfo
	// extends java.io.Serializable
{ // begin TraversalInfo
	// public osid.shared.Id & getNodeId();
	function & getNodeId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public int getLevel();
	function getLevel() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end TraversalInfo


class Node
	// extends java.io.Serializable
{ // begin Node
	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public NodeIterator & getParents();
	function & getParents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public NodeIterator & getChildren();
	function & getChildren() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getType();
	function & getType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDescription(java.lang.String & $description);
	function updateDescription(& $description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDisplayName(java.lang.String & $displayName);
	function updateDisplayName(& $displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isLeaf();
	function isLeaf() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isRoot();
	function isRoot() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void addParent(osid.shared.Id & $nodeId);
	function addParent(& $nodeId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void removeParent(osid.shared.Id & $parentId);
	function removeParent(& $parentId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Node


class TraversalInfoIterator
{ // begin TraversalInfoIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public TraversalInfo & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end TraversalInfoIterator


class HierarchyIterator
{ // begin HierarchyIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Hierarchy & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end HierarchyIterator


class NodeIterator
{ // begin NodeIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Node & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end NodeIterator


// public static final String UNKNOWN_PARENT_NODE = "Cannot create Node without unknown parent "
define("UNKNOWN_PARENT_NODE","Cannot create Node without unknown parent ");

// public static final String HIERARCHY_NOT_EMPTY = "Cannot delete a Hierarchy containing Nodes "
define("HIERARCHY_NOT_EMPTY","Cannot delete a Hierarchy containing Nodes ");

// public static final String UNKNOWN_HIERARCHY = "No known Hierarchy with this Id "
define("UNKNOWN_HIERARCHY","No known Hierarchy with this Id ");

// public static final String UNKNOWN_NODE = "No known Node with this Id "
define("UNKNOWN_NODE","No known Node with this Id ");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String ATTEMPTED_RECURSION = "Hierarchy does not allow recursion "
define("ATTEMPTED_RECURSION","Hierarchy does not allow recursion ");

// public static final String SINGLE_PARENT_HIERARCHY = "Hierarchy does not allow multiple parents "
define("SINGLE_PARENT_HIERARCHY","Hierarchy does not allow multiple parents ");

// public static final String INCONSISTENT_STATE = "Removing parent will result in an inconsistent state "
define("INCONSISTENT_STATE","Removing parent will result in an inconsistent state ");

// public static final String UNKNOWN_TRAVERSAL_MODE = "Unrecognized traversal mode "
define("UNKNOWN_TRAVERSAL_MODE","Unrecognized traversal mode ");

// public static final String UNKNOWN_TRAVERSAL_DIRECTION = "Unrecognized traversal direction "
define("UNKNOWN_TRAVERSAL_DIRECTION","Unrecognized traversal direction ");

// public static final String NODE_TYPE_ALREADY_ADDED = "NodeType already added "
define("NODE_TYPE_ALREADY_ADDED","NodeType already added ");

// public static final String NODE_TYPE_NOT_FOUND = "NodeType has never been added "
define("NODE_TYPE_NOT_FOUND","NodeType has never been added ");

// public static final String NODE_TYPE_IN_USE = "Cannot remove NodeType referenced by a Node "
define("NODE_TYPE_IN_USE","Cannot remove NodeType referenced by a Node ");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

// public static final String OPERATION_FAILED = "Operation Failed "
define("OPERATION_FAILED","Operation Failed ");

// public static final String PERMISSION_DENIED = "Permission Denied "
define("PERMISSION_DENIED","Permission Denied ");

// public static final String CONFIGURATION_ERROR = "Configuration error"
define("CONFIGURATION_ERROR","Configuration error");

?>
