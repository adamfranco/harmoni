<?php


	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class HierarchyManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a Hierarchy.
	 * @param displayName
	 * @param nodeTypes
	 * @param description
	 * @param allowsMultipleParents
	 * @param allowsRecursion
	 * @return Hierarchy
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#UNSUPPORTED_CREATION UNSUPPORTED_CREATION}
	 * @package osid.hierarchy
	 */
	function &createHierarchy($displayName, & $nodeTypes, $description, $allowsMultipleParents, $allowsRecursion) { /* :: interface :: */ }
	// :: full java declaration :: Hierarchy createHierarchy( String displayName, osid.shared.Type[] nodeTypes, String description, boolean allowsMultipleParents, boolean allowsRecursion )

	/**
	 * Get a Hierarchy by Unique Id.
	 * @param  hierarchyId
	 * @return Hierarchy
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}
	 * @package osid.hierarchy
	 */
	function &getHierarchy(& $hierarchyId) { /* :: interface :: */ }
	// :: full java declaration :: Hierarchy getHierarchy( osid.shared.Id hierarchyId )

	/**
	 * Get all Hierarchies.
	 * @return HierarchyIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getHierarchies() { /* :: interface :: */ }
	// :: full java declaration :: HierarchyIterator getHierarchies()

	/**
	 * Delete a Hierarchy by Unique Id. All Nodes must be removed from the Hierarchy before this method is called.
	 * @param hierarchyId
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#HIERARCHY_NOT_EMPTY HIERARCHY_NOT_EMPTY}
	 * @package osid.hierarchy
	 */
	function deleteHierarchy(& $hierarchyId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteHierarchy( osid.shared.Id hierarchyId )
}


	/**
	 * A Hierarchy is a structure comprised of nodes arranged in root, parent, and child form.  The Hierarchy can be traversed in several ways to determine the arrangement of nodes. A Hierarchy can allow multiple parents.  A Hierarchy can allow recursion.  The implementation is responsible for ensuring that the integrity of the Hierarchy is always maintained.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class Hierarchy // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Hierarchy.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	/**
	 * Get the name for this Hierarchy.
	 * @return String the name
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	/**
	 * Get the description for this Hierarchy.
	 * @return String the name
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getDescription() { /* :: interface :: */ }
	// :: full java declaration :: String getDescription()

	/**
	 * Update the description for this Hierarchy.
	 * @param description  Description cannot be null but may be empty.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.hierarchy
	 */
	function updateDescription(& $description) { /* :: interface :: */ }
	// :: full java declaration :: void updateDescription(java.lang.String description)

	/**
	 * Create a root Node with root status. The Node is created with the specified Unique Id, and, unlike Nodes created with createNode, initially has no parents or children.
	 * @param nodeId The Unique Id to be associated with the new Node; Unique Id cannot be null.
	 * @param nodeType The Type of the new Node; type may be null if the node has no type.
	 * @param displayName The displayName of the new Node; displayName cannot be null, but may be empty.
	 * @param description The description of the new Node; description cannot be null, but may be empty.
	 * new Node with root status.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}  {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#SINGLE_PARENT_HIERARCHY SINGLE_PARENT_HIERARCHY}
	 * @package osid.hierarchy
	 */
	function &createRootNode(& $nodeId, & $nodeType, $displayName, $description) { /* :: interface :: */ }
	// :: full java declaration :: Node createRootNode
	 * Create a Node. The Node is created with the specified Unique Id and initially has only the one specified parent.
	 * @param nodeId The Unique Id to be associated with the new Node; Unique Id cannot be null.
	 * @param parentId The Unique Id to be associated with the parent of this new Node; Unique Id cannot be null.
	 * @param type The Type of the new Node; type may be null if the node has no type.
	 * @param displayName The displayName of the new Node; displayName cannot be null, but may be empty.
	 * @param description The description of the new Node; description cannot be null, but may be empty.
	 * new Node.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#UNKNOWN_PARENT_NODE UNKNOWN_PARENT_NODE}, {@link HierarchyException#ATTEMPTED_RECURSION ATTEMPTED_RECURSION}
	 * @package osid.hierarchy
	 */
	function &createNode(& $nodeId, & $parentId, & $type, $displayName, $description) { /* :: interface :: */ }
	// :: full java declaration :: Node createNode
	 * Delete a Node by Id.  Only leaf Nodes can be deleted.
	 * @param nodeId The Unique Id to be associated with the new Node; Unique Id cannot be null.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#INCONSISTENT_STATE INCONSISTENT_STATE}
	 * @package osid.hierarchy
	 */
	function deleteNode(& $nodeId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteNode(osid.shared.Id nodeId)

	/**
	 * Add a NodeType to this Hierarchy.
	 * @param type nodeType
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.hierarchy
	 */
	function addNodeType(& $type) { /* :: interface :: */ }
	// :: full java declaration :: void addNodeType(osid.shared.Type type)

	/**
	 * Remove a NodeType from this Hierarchy.  Note that no Nodes can have this NodeType.
	 * @param type nodeType
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_IN_USE NODE_TYPE_IN_USE}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}
	 * @package osid.hierarchy
	 */
	function removeNodeType(& $type) { /* :: interface :: */ }
	// :: full java declaration :: void removeNodeType(osid.shared.Type type)

	/**
	 * Get all the Nodes in this Hierarchy.
	 * @return NodeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getAllNodes() { /* :: interface :: */ }
	// :: full java declaration :: NodeIterator getAllNodes()

	/**
	 * Get the root Nodes in this Hierarchy.  The root Nodes are defined as all Nodes without parents.
	 * @return NodeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getRootNodes() { /* :: interface :: */ }
	// :: full java declaration :: NodeIterator getRootNodes()

	/**
	 * Get a Node by Unique Id.
	 * @param nodeId The Unique Id to be associated with the new Node; Unique Id cannot be null.
	 * @return Node
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}
	 * @package osid.hierarchy
	 */
	function &getNode(& $nodeId) { /* :: interface :: */ }
	// :: full java declaration :: Node getNode( osid.shared.Id nodeId )

	/**
	 * Get all NodeTypes used in this Hierarchy.
	 * @return osid.shared.TypeIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getNodeTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getNodeTypes()

	/**
	 * Returns true if multiple parents are allowed; false otherwise.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function allowsMultipleParents() { /* :: interface :: */ }
	// :: full java declaration :: boolean allowsMultipleParents()

	/**
	 * Returns true if recursion allowed; false otherwise.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function allowsRecursion() { /* :: interface :: */ }
	// :: full java declaration :: boolean allowsRecursion()

	/**
	 *  Constant indicating depth-first traversal.
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("TRAVERSE_MODE_DEPTH_FIRST",0xdf;);

	/**
	 *  Constant indicating breadth-first traversal.
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("TRAVERSE_MODE_BREADTH_FIRST",0xbf;);

	/**
	 *  Constant indicating traversal up the Hierarchy, or traversal of parents.
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("TRAVERSE_DIRECTION_UP",0x01;);

	/**
	 *  Constant indicating traversal down the Hierarchy, or traversal of children.
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("TRAVERSE_DIRECTION_DOWN",0x02;);

	/**
	 *  Constant indicating no limit on the depth of traversal.
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("TRAVERSE_LEVELS_ALL",-1;);

	/**
	 * Traverse a Hierarchy returning information about each Node encountered.
	 * @param startId the Unique Id of the node from which traversal should start.
	 * @param mode Mode must be either TRAVERSE_MODE_DEPTH_FIRST or TRAVERSE_MODE_BREADTH_FIRST, indicating either depth-first or breadth-first traversal, respectively
	 * @param direction Direction must be either TRAVERSE_DIRECTION_UP or TRAVERSE_DIRECTION_DOWN, indicating the whether the traversal should proceed up the parents or down the children.
	 * @param levels The number of levels to traverse.  If this value is $lt; 0 (or TRAVERSE_LEVELS_ALL, which equals -1), the traversal will proceed to the end of the Hierarchy or until a circular reference returns to a Node already traversed.
	 * @return TraversalInfoIterator where each TraversalInfo object contains information about the Node traversed in the order they were encountered.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#UNKNOWN_TRAVERSAL_MODE UNKNOWN_TRAVERSAL_MODE}, {@link HierarchyException#UNKNOWN_TRAVERSAL_DIRECTION UNKNOWN_TRAVERSAL_DIRECTION}
	 * @package osid.hierarchy
	 */
	function &traverse(& $startId, $mode, $direction, $levels) { /* :: interface :: */ }
	// :: full java declaration :: TraversalInfoIterator traverse

	/**
	 * A TraversalInfo contains a Node Unique Id, a Node displayName, and a Node Level.  The level of the Node represented by the node Unique Id is in relation to the startId of the Hierarchy traverse method call. Children Nodes are represented by positive levels, parent Nodes by negative levels.  For example, a traverse of a Hierarchy has level -1 for parents of the Node represented by startId, and a level -2 for grandparents.  Similarly, the children of the Node would have level 1, and grandchildren would have level 2.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class TraversalInfo // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Node.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getNodeId() { /* :: interface :: */ }

	/**
	 * Get the name for this Node.
	 * @return String the name
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Get the level of this Node in relation to the startId of the Hierarchy traversal method call.  Descendants are assigned increasingly positive levels; ancestors increasingly negative levels.
	 * @return int level
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getLevel() { /* :: interface :: */ }
}

// :: post-declaration code ::
/**
 * @const int TRAVERSE_MODE_DEPTH_FIRST public static final int TRAVERSE_MODE_DEPTH_FIRST = 0xdf;
 * @package osid.hierarchy
 */
define("TRAVERSE_MODE_DEPTH_FIRST", 0xdf;);

/**
 * @const int TRAVERSE_MODE_BREADTH_FIRST public static final int TRAVERSE_MODE_BREADTH_FIRST = 0xbf;
 * @package osid.hierarchy
 */
define("TRAVERSE_MODE_BREADTH_FIRST", 0xbf;);

/**
 * @const int TRAVERSE_DIRECTION_UP public static final int TRAVERSE_DIRECTION_UP = 0x01;
 * @package osid.hierarchy
 */
define("TRAVERSE_DIRECTION_UP", 0x01;);

/**
 * @const int TRAVERSE_DIRECTION_DOWN public static final int TRAVERSE_DIRECTION_DOWN = 0x02;
 * @package osid.hierarchy
 */
define("TRAVERSE_DIRECTION_DOWN", 0x02;);

/**
 * @const int TRAVERSE_LEVELS_ALL public static final int TRAVERSE_LEVELS_ALL = -1;
 * @package osid.hierarchy
 */
define("TRAVERSE_LEVELS_ALL", -1;);


	/**
	 * A Node is a Hierarchy's representation of an external object that is one of a number of similar objects to be organized. Nodes must be connected to a Hierarchy.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class Node // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Node.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	/**
	 * Get the name for this Node.
	 * @return String the name
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	/**
	 * Get the description for this
	 * @return String the name
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function getDescription() { /* :: interface :: */ }
	// :: full java declaration :: String getDescription()

	/**
	 * Get the parents of this Node.  To get other ancestors use the Hierarchy traverse method.
	 * @return NodeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getParents() { /* :: interface :: */ }
	// :: full java declaration :: NodeIterator getParents()

	/**
	 * Get the children of this Node.  To get other descendants use the Hierarchy traverse method.
	 * @return NodeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getChildren() { /* :: interface :: */ }
	// :: full java declaration :: NodeIterator getChildren()

	/**
	 * Get the Type for this Node.
	 * @return osid.shared.Type
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function &getType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getType()

	/**
	 * Update the name of this Node.
	 * @param description The description of the new Node; description cannot be null, but may be empty.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.hierarchy
	 */
	function updateDescription(& $description) { /* :: interface :: */ }
	// :: full java declaration :: void updateDescription(java.lang.String description)

	/**
	 * Update the name of this Node. Node name changes are permitted since the Hierarchy's integrity is based on the Node's Unique Id.
	 * @param displayName The displayName of the new Node; displayName cannot be null, but may be empty.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.hierarchy
	 */
	function updateDisplayName(& $displayName) { /* :: interface :: */ }
	// :: full java declaration :: void updateDisplayName(java.lang.String displayName)

	/**
	 * Return true if this Node is a leaf; false otherwise.  A Node is a leaf if it has no children.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function isLeaf() { /* :: interface :: */ }
	// :: full java declaration :: boolean isLeaf()

	/**
	 * Return true if this Node is a root; false otherwise.  A Node is a root if it has no parents.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function isRoot() { /* :: interface :: */ }
	// :: full java declaration :: boolean isRoot()

	/**
	 * Link a parent to this Node.
	 * @param nodeId The Unique Id to be associated with the new Node; Unique Id cannot be null.
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#SINGLE_PARENT_HIERARCHY SINGLE_PARENT_HIERARCHY}, {@link HierarchyException#ALREADY_ADDED ALREADY_ADDED}, {@link HierarchyException#ATTEMPTED_RECURSION ATTEMPTED_RECURSION}
	 * @package osid.hierarchy
	 */
	function addParent(& $nodeId) { /* :: interface :: */ }
	// :: full java declaration :: void addParent( osid.shared.Id nodeId )

	/**
	 * Unlink a parent from this Node.
	 * @param parentId
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#SINGLE_PARENT_HIERARCHY SINGLE_PARENT_HIERARCHY}, {@link HierarchyException#INCONSISTENT_STATE INCONSISTENT_STATE}
	 * @package osid.hierarchy
	 */
	function removeParent(& $parentId) { /* :: interface :: */ }
	// :: full java declaration :: void removeParent( osid.shared.Id parentId )

	/**
	 * Changes the parent of this Node by adding a new parent and removing the old parent.
	 * @param oldParentId
	 * @param newParentId
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#ATTEMPTED_RECURSION ATTEMPTED_RECURSION}
	 * @package osid.hierarchy
	 */
	function changeParent(& $oldParentId, & $newParentId) { /* :: interface :: */ }
	// :: full java declaration :: void changeParent(osid.shared.Id oldParentId, osid.shared.Id newParentId)
}


	/**
	 * TraversalInfoIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class TraversalInfoIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  TraversalInfos ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next TraversalInfo.
	 * @return TraversalInfo
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.hierarchy
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: TraversalInfo next()
}


	/**
	 * HierarchyIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class HierarchyIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Hierarchies ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Hierarchy.
	 * @return Hierarchy
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.hierarchy
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Hierarchy next()
}


	/**
	 * NodeIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class NodeIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Nodes ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.hierarchy
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Node.
	 * @return Node
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.hierarchy
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Node next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	<p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.hierarchy
	 */
class HierarchyException // :: normal class
	extends OsidException
{

	/**
	 * Unknown or unsupported Type
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Unknown Id
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Iterator has no more elements
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Cannot create Node without unknown parent
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNKNOWN_PARENT_NODE","Cannot create Node with unknown parent ");

	/**
	 * Cannot delete a Hierarchy containing Nodes
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("HIERARCHY_NOT_EMPTY","Cannot delete a Hierarchy containing Nodes ");

	/**
	 * Null argument
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument");

	/**
	 * Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNSUPPORTED_CREATION","Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true ");

	/**
	 * Hierarchy does not allow recursion
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("ATTEMPTED_RECURSION","Hierarchy does not allow recursion ");

	/**
	 * Hierarchy does not allow multiple parents
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("SINGLE_PARENT_HIERARCHY","Hierarchy does not allow multiple parents ");

	/**
	 * Removing parent will result in an inconsistent state
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("INCONSISTENT_STATE","Removing node will result in an inconsistent state ");

	/**
	 * Unknown traversal mode
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNKNOWN_TRAVERSAL_MODE","Unknown traversal mode ");

	/**
	 * Unknown traversal direction
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("UNKNOWN_TRAVERSAL_DIRECTION","Unknown traversal direction ");

	/**
	 * NodeType has never been added
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("NODE_TYPE_NOT_FOUND","NodeType has never been added ");

	/**
	 * Cannot remove NodeType referenced by a Node
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("NODE_TYPE_IN_USE","Cannot remove NodeType referenced by a Node ");

	/**
	 * Operation Failed
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Permission Denied
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Configuration error
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error");

	/**
	 * Object already added
	 * @package osid.hierarchy
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.hierarchy
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.hierarchy
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.hierarchy
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string UNKNOWN_PARENT_NODE public static final String UNKNOWN_PARENT_NODE =        "Cannot create Node with unknown parent "
 * @package osid.hierarchy
 */
define("UNKNOWN_PARENT_NODE", "Cannot create Node with unknown parent ");

/**
 * @const string HIERARCHY_NOT_EMPTY public static final String HIERARCHY_NOT_EMPTY = "Cannot delete a Hierarchy containing Nodes "
 * @package osid.hierarchy
 */
define("HIERARCHY_NOT_EMPTY", "Cannot delete a Hierarchy containing Nodes ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument"
 * @package osid.hierarchy
 */
define("NULL_ARGUMENT", "Null argument");

/**
 * @const string UNSUPPORTED_CREATION public static final String UNSUPPORTED_CREATION = "Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true "
 * @package osid.hierarchy
 */
define("UNSUPPORTED_CREATION", "Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true ");

/**
 * @const string ATTEMPTED_RECURSION public static final String ATTEMPTED_RECURSION = "Hierarchy does not allow recursion "
 * @package osid.hierarchy
 */
define("ATTEMPTED_RECURSION", "Hierarchy does not allow recursion ");

/**
 * @const string SINGLE_PARENT_HIERARCHY public static final String SINGLE_PARENT_HIERARCHY = "Hierarchy does not allow multiple parents "
 * @package osid.hierarchy
 */
define("SINGLE_PARENT_HIERARCHY", "Hierarchy does not allow multiple parents ");

/**
 * @const string INCONSISTENT_STATE public static final String INCONSISTENT_STATE = "Removing node will result in an inconsistent state "
 * @package osid.hierarchy
 */
define("INCONSISTENT_STATE", "Removing node will result in an inconsistent state ");

/**
 * @const string UNKNOWN_TRAVERSAL_MODE public static final String UNKNOWN_TRAVERSAL_MODE = "Unknown traversal mode "
 * @package osid.hierarchy
 */
define("UNKNOWN_TRAVERSAL_MODE", "Unknown traversal mode ");

/**
 * @const string UNKNOWN_TRAVERSAL_DIRECTION public static final String UNKNOWN_TRAVERSAL_DIRECTION = "Unknown traversal direction "
 * @package osid.hierarchy
 */
define("UNKNOWN_TRAVERSAL_DIRECTION", "Unknown traversal direction ");

/**
 * @const string NODE_TYPE_NOT_FOUND public static final String NODE_TYPE_NOT_FOUND = "NodeType has never been added "
 * @package osid.hierarchy
 */
define("NODE_TYPE_NOT_FOUND", "NodeType has never been added ");

/**
 * @const string NODE_TYPE_IN_USE public static final String NODE_TYPE_IN_USE = "Cannot remove NodeType referenced by a Node "
 * @package osid.hierarchy
 */
define("NODE_TYPE_IN_USE", "Cannot remove NodeType referenced by a Node ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.hierarchy
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.hierarchy
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error"
 * @package osid.hierarchy
 */
define("CONFIGURATION_ERROR", "Configuration error");

/**
 * @const string ALREADY_ADDED public static final String ALREADY_ADDED = "Object already added "
 * @package osid.hierarchy
 */
define("ALREADY_ADDED", "Object already added ");

?>
