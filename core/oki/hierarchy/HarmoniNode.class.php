<?

require_once(OKI."/hierarchy.interface.php");

/**
 * A Node is a Hierarchy's representation of an external object that is one of
 * a number of similar objects to be organized. Nodes must be connected to a
 * Hierarchy.
 *
 * @package harmoni.osid_v1.hierarchy
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniNode.class.php,v 1.25 2005/01/26 17:37:54 adamfranco Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniNode
	extends Node
{ // begin Node

	/**
	 * @var object Id $_id The id for this node.
	 */
	var $_id;
	
	/**
	 * @var string $_description The description for this node.
	 */
	var $_description;
	
	/**
	 * @var string $_displayName The description for this node.
	 */
	var $_displayName;
	
	/**
	 * @var object HarmoniHierarchyStore $_hierarchyStore A hierarchy storage/loader object.
	 */
	var $_hierarchyStore = NULL;
	
	/**
	 * Constructor.
	 *
	 * @param object ID   $id   The Id of this Node.
	 * @param object HierarchyStore	The storage/loader for the hierarchy that this node is a
	 * 								part of.
	 * @param object Type $type The Type of the new Node; type may
	 * 							be null if the node has no type.
	 * @param string $displayName The displayName of the Node.
	 * @param string $description The description of the Node.
	 */
	function HarmoniNode(& $id, & $hierarchyStore, & $type, $displayName, $description) {
		// Check the arguments
		// SLOW-VALIDATE -- comment validation out to increase program speed.
		// This function should only be called by the HarmoniHierarchyClass and the
		// Hierarchy Stores, so we can assume that they have validated the parameters 
		// already. Adding the validation adds 1/3 to the load time of the hierarchy.
/* 		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id")); */
/* 		ArgumentValidator::validate($hierarchyStore, new ExtendsValidatorRule("HierarchyStore")); */
/* 		if ($type !== NULL) */
/* 			ArgumentValidator::validate($type, new ExtendsValidatorRule("Type")); */
/* 		ArgumentValidator::validate($displayName, new StringValidatorRule); */
/* 		ArgumentValidator::validate($description, new StringValidatorRule); */
		
		// set the private variables
		$this->_id =& $id;
		$this->_hierarchyStore =& $hierarchyStore;
		$this->_type =& $type;
		$this->_displayName = $displayName;
		$this->_description = $description;
//		$this->save();
	}

	/**
	 * Get the unique Id for this Node.
	 *
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		   method's implementation
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getId() {
		return $this->_id;
	}

	/**
	 * Get the display name for this Node.
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
	 * Get the description for this
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
	 * Get the parents of this Node.  To get other ancestors use the Hierarchy
	 * traverse method.
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
	function &getParents() {
		if ($this->isRoot()) {
			$parentArray = array();
		} else {			
			$parentId = $this->_hierarchyStore->getParentID($this->_id->getIdString());
			$parentArray = array();
			$parentArray[] =& $this->_hierarchyStore->getData($parentId);
		}
		$parentIterator =& new HarmoniNodeIterator($parentArray);
		return $parentIterator;
	}

	/**
	 * Get the children of this Node.  To get other descendants use the
	 * Hierarchy traverse method.
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
	function &getChildren() {
		$childIds = $this->_hierarchyStore->getChildren($this->_id->getIdString());
		$childArray = array();
		foreach ($childIds as $id) {
			$childArray[] =& $this->_hierarchyStore->getData($id);
		}
		$childIterator =& new HarmoniNodeIterator($childArray);
		return $childIterator;
	}

	/**
	 * Get the Type for this Node.
	 *
	 * @return object osid.shared.Type
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getType() {
		return $this->_type;
	}

	/**
	 * Update the name of this Node. Node name changes are permitted since the
	 * Hierarchy's integrity is based on the Node's unique Id. name The
	 * displayName of the new Node; displayName cannot be null, but may be
	 * empty.
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   displayName is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDescription($description) {
		// Check the arguments
		ArgumentValidator::validate($description, new StringValidatorRule);
				
		// update and save
		$this->_description = $description;
		$this->_hierarchyStore->flagChanged($this->_id->getIdString());
		$this->save();	
	}

	/**
	 * Update the name of this Node. The description of the new Node;
	 * description cannot be null, but may be empty.
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message osid.OsidException.NULL_ARGUMENT if
	 *		   displayName is null.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDisplayName($displayName) {
		// Check the arguments
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		
		// update and save
		$this->_displayName = $displayName;
		$this->_hierarchyStore->flagChanged($this->_id->getIdString());
		$this->save();
	}

	/**
	 * Return true if this Node is a leaf; false otherwise.  A Node is a leaf
	 * if it has no children.
	 *
	 * @return boolean
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function isLeaf() {
		return !$this->_hierarchyStore->hasChildren($this->_id->getIdString());
	}

	/**
	 * Return true if this Node is a root; false otherwise.  A Node is a root
	 * if it has no parents.
	 *
	 * @return boolean
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function isRoot() {
		return ($this->_hierarchyStore->depth($this->_id->getIdString()) == 0)?TRUE:FALSE;
	}

	/**
	 * Link a parent to this Node.
	 *
	 * @param object osid.shared.Id parentId
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message HierarchyException.UNKNOWN_NODE if
	 *		   there is no Node mathching parentId.  Throws an exception with
	 *		   the message HierarchyException.SINGLE_PARENT_HIERARCHY if the
	 *		   Hierarchy was created with allowsMultipleParents false and an
	 *		   attempt is made to add a Parent.  Throws and exception with the
	 *		   message HierarchyException.ALREADY_ADDED if the parent was
	 *		   already added.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function addParent(& $nodeId) {
		// This implimentation only allows single-parent hierarchies.
		throwError(new Error(SINGLE_PARENT_HIERARCHY, "Hierarchy", 1));
	}

	/**
	 * Unlink a parent from this Node.
	 *
	 * @param object osid.shared.Id parentId
	 *
	 * @throws HierarchyException if there is a general failure.	 Throws an
	 *		   exception with the message HierarchyException.UNKNOWN_NODE if
	 *		   there is no Node mathching parentId.  Throws an exception with
	 *		   the message HierarchyException.SINGLE_PARENT_HIERARCHY if the
	 *		   Hierarchy was created with allowsMultipleParents false.  Throws
	 *		   an exception with the message
	 *		   HierarchyException.INCONSISTENT_STATE if the disconnection
	 *		   causes a state inconsistency.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function removeParent(& $parentId) {
		// This implimentation only allows single-parent hierarchies.
		throwError(new Error(SINGLE_PARENT_HIERARCHY, "Hierarchy", 1));	
	}

	/**
	 * Changes the parent of this Node by adding a new parent and removing the old parent.
	 * @param object oldParentId
	 * @param object newParentId
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#ATTEMPTED_RECURSION ATTEMPTED_RECURSION}
	 */
	function changeParent(& $oldParentId, & $newParentId) { 
		// Check the arguments
		ArgumentValidator::validate($oldParentId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($newParentId, new ExtendsValidatorRule("Id"));
		
		// Verify the old parent if not a root node
		if (!$this->isRoot()) {
			$parentId = $this->_hierarchyStore->getParentID($this->_id->getIdString());
			if ($oldParentId->getIdString() != $parentId)
				throwError(new Error(OPERATION_FAILED.": Unknown parent node.", "Hierarchy", 1));
		}
		
		// Make sure that we are not moving a node to itsself
		if ($newParentId->isEqual($this->getId()))
			throwError(new Error(OPERATION_FAILED.": Can not add a node to its self.", "Hierarchy", 1));
			
		// Make sure that we are not moving a node to one of its children
		$depth = $this->_hierarchyStore->depth($this->_id->getIdString());
		$newParentDepth = $this->_hierarchyStore->depth($newParentId->getIdString());
		if ($newParentDepth > $depth) {
			$descendentIds = $this->_hierarchyStore->depthFirstEnumeration($this->_id->getIdString());
			if (in_array($newParentId->getIdString(), $descendentIds))
				throwError(new Error(OPERATION_FAILED.": Can not add a node to its decendent.", "Hierarchy", 1));
		}
		
		// move the node
		$idString = $this->_id->getIdString();
		$newParentIdString = $newParentId->getIdString();
		$this->_hierarchyStore->moveTo($idString, $newParentIdString);
	}

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		$idString = $this->_id->getIdString();
		$this->_hierarchyStore->save($idString);
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		$idString = $this->_id->getIdString();
		$this->_hierarchyStore->load($idString);
	}	

} // end Node
