<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.interface.php");

/** 
 * This is the building piece of the tree-like AuthorizationContextHierarchy
 * data structure used in AuthorizationContextHierarchyGenerator obejcts.
 * @access public
 * @version $Id: AuthorizationContextHierarchyNode.class.php,v 1.7 2003/07/10 02:34:20 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorization.generator
 */
class AuthorizationContextHierarchyNode
							extends AuthorizationContextHierarchyNodeInterface {

							
	/**
	 * The system id of this node.
	 * @attribute private integer _systemId
	 */
	var $_systemId;
	
	/**
	 * The parent node of this node.
	 * @attribute private object _parent
	 */
	var $_parent;
	
	/**
	 * The children of this node.
	 * @attribute private array _children
	 */
	var $_children;
	
	
	/**
	 * The depth of this node.
	 * @attribute private integer _depth
	 */
	var $_depth;


							
	/**
     * Constructor.
	 * @param integer systemId The system id of this node.
	 * @param optional integer depth The depth of this node. Default is 0.
     * @access public
     */
	function AuthorizationContextHierarchyNode($systemId, $depth = 0) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($systemId, $integerRule, true);
		ArgumentValidator::validate($depth, $integerRule, true);
		// ** end of parameter validation
	
		$this->_systemId = $systemId;
		$this->_parent = null;
		$this->_children = array();
		
		$this->_depth = $depth;
	}
	
	/**
	 * Adds a new child for this node. This method updates the depth of the child
	 * automatically, by calling updateDepth().
	 * @method public addChild
	 * @param ref object child The child node to add.
	 * @return void
	 */
	function addChild(& $child) {
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		ArgumentValidator::validate($child, $extendsRule, true);

		$childsParent = $child->getParent();
		if (isset($childsParent)) {
			$str = "Child node already has a parent!";
			throw(new Error($str, "AuthorizationHandler", true));
		}

		// set parent-child relationship
		$child->_parent =& $this;
		$this->_children[] =& $child;

		// set depth
		AuthorizationContextHierarchyNode::updateDepth($child);
	}
	
	
	
	/**
	 * Recursively updates the depth of the specified node and all of its children.
	 * This method is useful in a scenario where a new child is added to a node.
	 * In that case, the child (and any children it might have) might change
	 * its depth to correspond to its new parent.
	 * @method public updateDepth
	 * @static
	 * @param ref node The node to start updating the children's depth from.
	 * @return void 
	 */
	function updateDepth(& $node) {
		$parent =& $node->getParent();
		$node->_depth = $parent->_depth + 1;
	
		if ($node->hasChildren()) {
			$children =& $node->getChildren();
			foreach(array_keys($children) as $i => $key)
				// recursively update
				AuthorizationContextHierarchyNode::updateDepth($children[$key]);
		}
		// base case: do nothing
		else
			;
	}
	

	/**
	 * Returns the parent node of this node.
	 * @method public getParent
	 * @return ref object The parent node of this node.
	 */
	function & getParent() {
		return $this->_parent;
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
	 * Returns the depth of this node. For a root, the depth is 0.
	 * @method public getDepth
	 * @return void The depth of this node.
	 */
	function getDepth() {
		return $this->_depth;
	}
	
	/**
	 * Returns the system id of this node.
	 * @method public getSystemId
	 * @return object The system id of this node.
	 */
	function getSystemId() {
		return $this->_systemId;
	}
	

}

?>