<?php

/** 
 * This is the building piece of the tree-like AuthorizationContextHierarchy
 * data structure used in AuthorizationContextGenerator obejcts.
 * @access public
 * @version $Id: AuthorizationContextHierarchyNode.interface.php,v 1.1 2003/07/01 01:55:22 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorizationHandler.generator
 */
class AuthorizationContextHierarchyNodeInterface {

	
	/**
	 * Adds a new child for this node.
	 * @method public addChild
	 * @param ref object child The child node to add.
	 * @return void
	 */
	function addChild(& $child) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns the parent node of this node.
	 * @method public getParent
	 * @return ref object The parent node of this node.
	 */
	function & getParent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the children of this node in the order they were added.
	 * @method public getChildren
	 * @return ref array An array of the children nodes of this node.
	 */
	function & getChildren() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns the number of children for this node.
	 * @method public getChildrenCount
	 * @return integer The number of children for this node.
	 */
	function getChildrenCount() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Determines if this node has any children.
	 * @method public hasChildren
	 * @return boolean <code>true</code> if this node has at least one child;
	 * <code>false</code>, otherwise.
	 */
	function hasChildren() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns the depth of this node. For a root, the depth is 0.
	 * @method public getDepth
	 * @return void The depth of this node.
	 */
	function getDepth() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the system id of this node.
	 * @method public getSystemId
	 * @return object The system id of this node.
	 */
	function getSystemId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>