<?

require_once(HARMONI."oki/hierarchy2/tree/TreeNode.interface.php");

/**
 * This is the building piece of the Tree data structure used for the backbone of the
 * hierarchy.
 * @access public
 * @version $Id: TreeNode.class.php,v 1.1 2004/05/07 19:22:07 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.osid.hierarchy2.tree
 */

class TreeNode extends TreeNodeInterface
{ // begin Node

	/**
	 * The id (string representation) for this node.
	 * @attribute protected string Id $_id 
	 */
	var $_id;
	
	
	/**
	 * The parents of this node. The index of
	 * each element of the array is the string representation of the Id of the
	 * corresponding Node.
	 * @attribute protected array _parent
	 */
	var $_parents;
	
	
	/**
	 * The children of this node. The index of
	 * each element of the array is the string representation of the Id of the
	 * corresponding Node.
	 * @attribute protected array _children
	 */
	var $_children;
	
	
	/**
	 * Constructor.
	 *
	 * @param string $id The id of this Node.
	 */
	function TreeNode($id) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($id, $stringRule, true);
		// ** end of parameter validation
	
		$this->_id = $id;
		$this->_parents = array();
		$this->_children = array();
	}

	

	/**
	 * Returns true if this TreeNode is among the children of the given node.
	 * @access public
	 * @param objcet node The node to start recursing from.
	 * @return boolean True, if this TreeNode is among the children of <code>$node</code>.
	 **/
	function _checkForCycle(& $node) {
		// base case
		if ($this->_id == $node->_id)
			return true;
		// check children
		else
			foreach (array_keys($node->_children) as $i => $key)
				// recurse down
				if ($this->_checkForCycle($node->_children[$key]))
					return true;
		
		return false;
	}
	

	/**
	 * Adds a new child for this node.
	 * @method public addChild
	 * @param ref object child The child node to add.
	 * @return void
	 */
	function addChild(& $child) {
		// echo "Adding {$child->_id} to {$this->_id} <br>";
	
		$extendsRule =& new ExtendsValidatorRule("TreeNode");
		ArgumentValidator::validate($child, $extendsRule, true);

		// check whether we are duplicating $child
		if (isset($this->_children[$child->_id])) {
			$str = "A child with the given id already exists!";
			throwError(new Error($str, "Hierarchy", true));
		}

		// check if we are duplicating $this
		$childsParents = $child->getParents();
		if (isset($childsParents[$this->_id])) {
			$str = "Child node already has a parent with the given id!";
			throwError(new Error($str, "Hierarchy", true));
		}

		// now perform cycle check
		if ($this->_checkForCycle($child)) {
			$str = "Adding this node would result in a cycle!";
			throwError(new Error($str, "Hierarchy", true));
		}

		// see if $this is among any of $child's children.
		// if yes, that signifies a cycle

		// set parent-child relationship
		$child->_parents[$this->_id] =& $this;
		$this->_children[$child->_id] =& $child;
	}
	
	
	/**
	 * Returns the parent node of this node.
	 * @method public getParent
	 * @return ref array The parent nodes of this node.
	 */
	function & getParents() {
		return $this->_parents;
	}
	

	/**
	 * Returns the number of parents for this node.
	 * @method public getParentsCount
	 * @return integer The number of parents for this node.
	 */
	function getParentsCount() {
		return count($this->_parents);
	}
	
	
	/**
	 * Determines if this node has any parents.
	 * @method public hasParents
	 * @return boolean <code>true</code> if this node has at least one parent;
	 * <code>false</code>, otherwise.
	 */
	function hasParents() {
		return $this->getParentsCount() > 0;
	}


	/**
	 * Returns the children of this node in the order they were added.
	 * @method public getChildren
	 * @return ref array An array of the children nodes of this node.
	 */
	function & getChildren() {
		return $this->_children;
	}
	
	
	/**
	 * Returns the number of children for this node.
	 * @method public getChildrenCount
	 * @return integer The number of children for this node.
	 */
	function getChildrenCount() {
		return count($this->_children);
	}
	
	
	/**
	 * Determines if this node has any children.
	 * @method public hasChildren
	 * @return boolean <code>true</code> if this node has at least one child;
	 * <code>false</code>, otherwise.
	 */
	function hasChildren() {
		return $this->getChildrenCount() > 0;
	}

	
	/**
	 * Returns the id of this node.
	 * @method public getId
	 * @return integer The id of this node.
	 */
	function getId() {
		return $this->_id;
	}
}
