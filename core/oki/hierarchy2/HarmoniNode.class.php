<?

require_once(OKI."/hierarchy.interface.php");

/**
 * A Node is a Hierarchy's representation of an external object that is one of
 * a number of similar objects to be organized. Nodes must be connected to a
 * Hierarchy.
 * 
 * 
 * <p></p>
 *
 * @package harmoni.osid.hierarchy2
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 * @version $Id: HarmoniNode.class.php,v 1.1 2004/05/07 19:22:06 dobomode Exp $
 *
 * @todo Replace JavaDoc with PHPDoc
 */

class HarmoniNode
	extends Node
{ // begin Node

	/**
	 * The id for this node.
	 * @var object Id $_id 
	 */
	var $_id;
	
	
	/**
	 * The type of this node.
	 * @attribute private object _type
	 */
	var $_type;
	
	
	/**
	 * The description for this node.
	 * @var string $_description
	 */
	var $_description;
	

	/**
	 * The display name for this node.
	 * @var string $_displayName
	 */
	var $_displayName;
	

	/**
	 * The parents of this node. This is an array of Node objects. The index of
	 * each element of the array is the string representation of the Id of the
	 * corresponding Node.
	 * @attribute protected array _parent
	 */
	var $_parents;
	

	/**
	 * The children of this node. This is an array of Node objects. The index of
	 * each element of the array is the string representation of the Id of the
	 * corresponding Node.
	 * @attribute protected array _children
	 */
	var $_children;
	

	/**
	 * The depth of this node. 0 is the absolute minimum.
	 * @attribute private integer _depth
	 */
	var $_depth;


	/**
	 * Constructor.
	 *
	 * @param object ID   $id   The Id of this Node.
	 * @param object Type $type The Type of the new Node.
	 * @param string $displayName The displayName of the Node.
	 * @param string $description The description of the Node.
	 * @param optional integer depth The depth of this node. Default is 0.
	 */
	function HarmoniNode(& $id, & $type, $displayName, $description, $depth = 0) {
 		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"));
 		ArgumentValidator::validate($displayName, new StringValidatorRule);
 		ArgumentValidator::validate($description, new StringValidatorRule);
		
		// set the private variables
		$this->_id =& $id;
		$this->_type =& $type;
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_parents = array();
		$this->_children = array();
		
		$this->_depth = $depth;
		
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
	function & getId() {
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
	 * Get the Type for this Node.
	 *
	 * @return object osid.shared.Type
	 *
	 * @throws HierarchyException if there is a general failure.
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getType() {
		return $this->_type;
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
	function & getParents() {
		$result =& new HarmoniNodeIterator($this->_parents);
		return $result;
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
	function & getChildren() {
		$result =& new HarmoniNodeIterator($this->_children);
		return $result;
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
		
		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
		
		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
		
		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
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

		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
		
		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
		
		// *********************************************
		// UPDATE THE DB UPDATE THE DB UPDATE THE DB
		// *********************************************
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
		// *********************************************
		// STUF HEREE !!!!@!#!!!
		// *********************************************
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
		// *********************************************
		// STUF HEREE !!!!@!#!!!
		// *********************************************
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
		// *********************************************
		// STUF HEREE !!!!@!#!!!
		// *********************************************
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
		// *********************************************
		// STUF HEREE !!!!@!#!!!
		// *********************************************
	}

	/**
	 * Changes the parent of this Node by adding a new parent and removing the old parent.
	 * @param object oldParentId
	 * @param object newParentId
	 * @throws osid.hierarchy.HierarchyException An exception with one of the following messages defined in osid.hierarchy.HierarchyException may be thrown:  {@link HierarchyException#OPERATION_FAILED OPERATION_FAILED}, {@link HierarchyException#PERMISSION_DENIED PERMISSION_DENIED}, {@link HierarchyException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link HierarchyException#UNIMPLEMENTED UNIMPLEMENTED}, {@link HierarchyException#NULL_ARGUMENT NULL_ARGUMENT}, {@link HierarchyException#NODE_TYPE_NOT_FOUND NODE_TYPE_NOT_FOUND}, {@link HierarchyException#ATTEMPTED_RECURSION ATTEMPTED_RECURSION}
	 * @package harmoni.osid.hierarchy
	 */
	function changeParent(& $oldParentId, & $newParentId) { 
		// *********************************************
		// STUF HEREE !!!!@!#!!!
		// *********************************************
	}

} // end Node
