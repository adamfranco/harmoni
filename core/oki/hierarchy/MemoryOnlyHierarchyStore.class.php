<?php

require_once(HARMONI.'/oki/hierarchy/HierarchyStore.interface.php');

/**
 * A storage wrapper for the Tree class
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MemoryOnlyHierarchyStore.class.php,v 1.10 2005/01/19 22:28:09 adamfranco Exp $
 */


class MemoryOnlyHierarchyStore
	extends HierarchyStore
{
	
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
	var $_tree = NULL;

	/**
	 * @var boolean $_exists True if the hierarchy exists in persistable storage.
	 */
	var $_exists = FALSE;

	/**
	 * @var array $_nodeTypes Node types in this hierarchy.
	 */
	var $_nodeTypes = array();
	
	/**
	 * Constructor
	 *
	 */
	function MemoryOnlyHierarchyStore () {
		$this->_tree =& new Tree;
	}

	/**
	 * *Deprecated* Initializes this Store. Loads any saved data for the hierarchy.
	 * @deprecated Use set exists instead
	 */
	function initialize() {
		// Do Nothing
	}

    /**
     * Set the existence state
     *
     * @param boolean $exists True if the hierarchy exists in persistable storage.
	 */
	function setExists($exists) {
		// Check the arguments
		ArgumentValidator::validate($exists, new BooleanValidatorRule);
		
		$this->_exists = FALSE;
	}

	/**
	 * Initializes this Store. Loads any saved data for the hierarchy.
	 *
	 * @param object Id	$hierarchyId		The Id of the hierarchy that should be initialized.
	 */
	function setId(& $hierarchyId) {
		// Check the arguments
		ArgumentValidator::validate($hierarchyId, new ExtendsValidatorRule("Id"));
		
		// set the private variables
		$this->_id =& $hierarchyId;
		$this->_tree =& new Tree();
	}
	
	/**
	 * Loads this object from persistable storage.
	 * @param string $nodeId	The id of the node that needs to be updated. If 0 or NULL,
	 * 							then load() will load the entire hierarchy as needed.
	 * @access protected
	 */
	function load ($nodeId=NULL) {
		// Do nothing as this store isn't saved
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @param string $nodeId	The id of the node that has been modified and needs to 
	 * 							be updated. If 0 or NULL, the save will save the entire 
	 *							hierarchy as needed.
	 * @access protected
	 */
	function save ($nodeId=NULL) {
		// Do nothing as this store isn't saved
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
     * Update the id for this Hierarchy.
     *
     * @param String id  id cannot be null.
     *
     * @throws HierarchyException if there is a general failure.     Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   id is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateid($id) {
		// Check the arguments
		ArgumentValidator::validate($id, new StringValidatorRule);
				
		// update and save
		$this->_id = $id;
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
		// Check the arguments
		ArgumentValidator::validate($displayName, new StringValidatorRule);
				
		// update and save
		$this->_displayName = $displayName;
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
		// Check the arguments
		ArgumentValidator::validate($description, new StringValidatorRule);
				
		// update and save
		$this->_description = $description;
	}

/******************************************************************************
 * below here are the methods of the Tree class
 ******************************************************************************/


	/**
    * Adds a node to the tree.
	* 
	* @param mixed   $data	The data that pertains to this node. This cannot contain
	*						objects. Use setData for objects.
	* @param integer $parentID Optional parent node ID
    */
	function addNode(&$data, $parentID=0, $id=0) {
		$this->_tree->addNode($data, $parentID, $id);
	}

	/**
    * Removes the node with given id. All child
	* nodes are also removed.
	* 
	* @param integer $id Node ID
    */
	function removeNode($id) {
		$this->_tree->removeNode($id);
	}
	
	/**
    * Returns total number of nodes in the tree
	*
	* @return integer Number of nodes in the tree
    */
	function totalNodes() {
		return $this->_tree->totalNodes();
	}
	
	/**
    * Gets the data associated with the given
	* node ID.
	* 
	* @param  integer $id Node ID
	* @return mixed       The data
    */
	function &getData($id)	{
		return $this->_tree->getData($id);
	}
	
	/**
    * Sets the data associated with the given
	* node ID.
	* 
	* @param integer $id Node ID
    */
	function setData($id, & $data) {
		$this->_tree->setData($id, $data);
	}
	
	/**
    * Returns parent id of the node with
	* given id.
	* 
	* @param  integer $id Node ID
	* @return integer     The parent ID
    */
	function getParentID($id) {
		return $this->_tree->getParentID($id);
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
		return $this->_tree->depth($id);
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
		return $this->_tree->isChildOf($id, $parentID);
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
		return $this->_tree->hasChildren($id);
	}
	
	/**
    * Returns the number of children the given node ID
	* has.
	* 
	* @param  integer $id Node ID
	* @return integer     Number of child nodes
    */
	function numChildren($id) {
		return $this->_tree->numChildren($id);
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
		return $this->_tree->getChildren($id);
	}
	
	/**
    * Moves all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function moveChildrenTo($parentID, $newParentID) {
		$this->_tree->moveChildrenTo($parentID, $newParentID);
	}
	
	/**
    * Copies all children of the supplied parent ID to the
	* supplied new parent ID
	*
	* @param integer $parentID    Current parent ID
	* @param integer $newParentID New parent ID
    */
	function copyChildrenTo($parentID, $newParentID) {
		$this->_tree->copyChildrenTo($parentID, $newParentID);
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
		return $this->_tree->prevSibling($id);
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
		return $this->_tree->nextSibling($id);
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
		$this->_tree->moveTo($id, $parentID);
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
		$this->_tree->copyTo($id, $parentID);
	}
	
	/**
    * Returns the id of the first node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer           The node ID
    */
	function firstNode($parentID = 0) {
		return $this->_tree->firstNode($parentID);
	}
	
	/**
    * Returns the id of the last node of the tree
	* or of the child nodes with the given parent ID.
	*
	* @param  integer $parentID Optional parent ID
	* @return integer The node ID
    */
	function lastNode($parentID = 0) {
		return $this->_tree->lastNode($parentID);
	}
	
	/**
    * Returns the number of nodes in the tree, optionally
	* starting at (but not including) the supplied node ID.
	*
	* @param  integer $id The node ID to start at
	* @return integer     Number of nodes
    */
	function getNodeCount($id = 0) {
		return $this->_tree->getNodeCount($id);
	}
    
    /**
    * Returns a flat list of the nodes, optionally beginning at the given
	* node ID.
    *
    * @return array Flat list of the node IDs from top to bottom, left to right.
    */
    function getFlatList($id = 0) {
		return $this->_tree-> getFlatList($id);
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
		$this->_tree->traverse($function);
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
		return $this->_tree->search($data, $strict);
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
		return $this->_tree->nodeExists($id);
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
		return $this->_tree->depthFirstEnumeration($currentId, $levels);
	}

}
?>