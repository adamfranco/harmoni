<?php

/**
 * A storage wrapper for the Tree class
 *
 * @package harmoni.osid.hierarchy
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: HierarchyStore.interface.php,v 1.7 2004/04/21 17:55:33 adamfranco Exp $
 */

class HierarchyStore
{

	/**
	 * Initializes this Store. Loads any saved data for the hierarchy.
	 * @deprecated Use set exists instead
	 */
	function initialize() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
    /**
     * Set the existence state
     *
     * @param boolean $exists True if the hierarchy exists in persistable storage.
	 */
	function setExists($exists) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Loads this object from persistable storage.
	 * @param string $nodeId	The id of the node that needs to be updated. If 0 or NULL,
	 * 							then load() will load the entire hierarchy as needed.
	 * @access protected
	 */
	function load ($nodeId=NULL) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @param string $nodeId	The id of the node that has been modified and needs to 
	 * 							be updated. If 0 or NULL, the save will save the entire 
	 *							hierarchy as needed.
	 * @access protected
	 */
	function save ($nodeId=NULL) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
     * Get the unique Id for this Hierarchy.
     *
     * @param object osid.shared.Id A unique Id that is usually set by a create
     *         method's implementation
     *
     * @throws HierarchyException if there is a general failure.
     *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & setId(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
    /**
     * Update the displayName for this Hierarchy.
     *
     * @param String displayName  displayName cannot be null but may be empty.
     *
     * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   displayName is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updatedisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
/******************************************************************************
 * Node functions
 ******************************************************************************/

	/**
    * Adds a node to the tree.
	* 
	* @param mixed   $data	The data that pertains to this node. This cannot contain
	*						objects. Use setData for objects.
	* @param string $parentID Optional parent node ID
    */
	function addNode(&$data, $parentID=0, $id=0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
    * Removes the node with given id. All child
	* nodes are also removed.
	* 
	* @param integer $id Node ID
    */
	function removeNode($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns total number of nodes in the tree
	*
	* @return integer Number of nodes in the tree
    */
	function totalNodes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Gets the data associated with the given
	* node ID.
	* 
	* @param  integer $id Node ID
	* @return mixed       The data
    */
	function & getData($id)	{
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Sets the data associated with the given
	* node ID.
	* 
	* @param integer $id Node ID
    */
	function setData($id, & $data) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Specifies if the node $id has been changed.
	* 
	* @param integer $id Node ID
    */
	function flagChanged($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns parent id of the node with
	* given id.
	* 
	* @param  integer $id Node ID
	* @return integer     The parent ID
    */
	function getParentID($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the depth in the tree of the node with
	* the supplied id. This is a zero based indicator,
	* so root nodes will have a depth of 0 (zero).
	*
	* @param  integer $id Node ID
	* @return integer     The depth of the node
    */
	function depth($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns true/false as to whether the node with given ID is a child
	* of the given parent node ID.
	*
	* @param  integer $id       Node ID
	* @param  integer $parentID Parent node ID
	* @return bool              Whether the ID is a child of the parent ID
    */
	function isChildOf($id, $parentID) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns true or false as to whether the node
	* with given ID has children or not. Give 0 as
	* the id to determine if there are any root nodes.
	* 
	* @param  integer $id Node ID
	* @return bool        Whether the node has children
    */
	function hasChildren($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the number of children the given node ID
	* has.
	* 
	* @param  integer $id Node ID
	* @return integer     Number of child nodes
    */
	function numChildren($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns an array of the child node IDs pertaining
	* to the given id. Returns an empty array if there
	* are no children.
	* 
	* @param  integer $id Node ID
	* @return array       The child node IDs
    */
	function getChildren($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Moves all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function moveChildrenTo($parentID, $newParentID) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Copies all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function copyChildrenTo($parentID, $newParentID) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the ID of the previous sibling to the node
	* with the given ID, or null if there is no previous
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The previous sibling ID
    */
	function prevSibling($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the ID of the next sibling to the node
	* with the given ID, or null if there is no next
	* sibling.
	* 
	* @param  integer $id Node ID
	* @return integer     The next sibling ID
    */
	function nextSibling($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Moves a node to a new parent. The node being
	* moved keeps it child nodes (they move with it
	* effectively).
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function moveTo($id, $parentID) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Copies this node to a new parent. This copies the node
	* to the new parent node and all its child nodes (ie
	* a deep copy). Technically, new nodes are created with copies
	* of the data, since this is for all intents and purposes
	* the only thing that needs copying.
	*
	* @param integer $id       Node ID
	* @param integer $parentID New parent ID
    */
	function copyTo($id, $parentID) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the id of the first node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer           The node ID
    */
	function firstNode($parentID = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the id of the last node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer The node ID
    */
	function lastNode($parentID = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns the number of nodes in the tree, optionally
	* starting at (but not including) the supplied node ID.
	*
	* @param  integer $id The node ID to start at
	* @return integer     Number of nodes
    */
	function getNodeCount($id = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
    
    /**
    * Returns a flat list of the nodes, optionally beginning at the given
	* node ID.
    *
    * @return array Flat list of the node IDs from top to bottom, left to right.
    */
    function getFlatList($id = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

    /**
    * Traverses the tree applying a function to each and every node.
    * The function name given (though this can be anything you can supply to 
    * call_user_func(), not just a name) should take two arguments. The first
	* is this tree object, and the second is the ID of the current node. This
	* way you can get the data for the nodes in your function by doing
	* $tree->getData($id). The traversal goes from top to bottom, left to right
    * (ie same order as what you get from getFlatList()).
    *
    * @param string $function The callback function to use
    */
    function traverse($function) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
    }

	/**
    * Searches the node collection for a node with a tag matching
	* what you supply. This is a simply "tag == your data" comparison, (=== if strict option is applied)
	* and more advanced comparisons can be made using the traverse() method.
	* This function returns null if nothing is found, and the first node ID found if a match is made.
	*
	* @param  mixed $data   Data to try to find and match
	* @param  mixed $strict Whether to use === or simply == to compare
	* @return mixed         Null if no match or the first node ID if a match is made
    */
	function &search(& $data, $strict = false) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
    * Returns whether or not a node of the supplied id exists in the tree.
	*
	* @author Adam Franco <adam@adamfranco.com>
	* @since 2003-10-01
	*
	* @param  integer $id The node ID to look for
	* @return boolean     True if the node exists in the tree.
    */	
	function nodeExists($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
    * Returns a list (array) of nodes after traversal.
	*
	* @author Adam Franco <adam@adamfranco.com>
	* @since 2003-10-02
	*
	* @param	string	$id 	The starting node's id
	* @param	integer	$levels	The number of levels to traverse. 
	*							NULL for infinate, 1 for the currentNode only, 2 for the current
	*							node and its children.
	* @return	array			An array of the resulting ids
	*/
	function depthFirstEnumeration($currentId, $levels = NULL) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

}
?>