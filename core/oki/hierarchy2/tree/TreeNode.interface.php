<?php

/** 
 * This is the building piece of the Tree data structure used for the backbone of the
 * hierarchy.
 *
 * @package harmoni.osid_v1.hierarchy2.tree
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TreeNode.interface.php,v 1.8 2005/02/07 21:38:22 adamfranco Exp $
 */
class TreeNodeInterface {

	
	/**
	 * Adds a new child for this node.
	 * @access public
	 * @param ref object child The child node to add.
	 * @return void
	 */
	function addChild(& $child) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Detaches the child from this node. The child remains in the hierarchy.
	 * @access public
	 * @param ref object child The child node to detach.
	 * @return void
	 **/
	function detachChild(& $child) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns the parent node of this node.
	 * @access public
	 * @return ref array The parent nodes of this node.
	 */
	function &getParents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

	/**
	 * Returns the number of parents for this node.
	 * @access public
	 * @return integer The number of parents for this node.
	 */
	function getParentsCount() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}


	/**
	 * Determines if this node has any parents.
	 * @access public
	 * @return boolean <code>true</code> if this node has at least one parent;
	 * <code>false</code>, otherwise.
	 */
	function hasParents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}


	/**
	 * Returns the children of this node in the order they were added.
	 * @access public
	 * @return ref array An array of the children nodes of this node.
	 */
	function &getChildren() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns the number of children for this node.
	 * @access public
	 * @return integer The number of children for this node.
	 */
	function getChildrenCount() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Determines if this node has any children.
	 * @access public
	 * @return boolean <code>true</code> if this node has at least one child;
	 * <code>false</code>, otherwise.
	 */
	function hasChildren() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Checks if the given node is a child of this node.
	 * @access public
	 * @param ref object node The child node to check.
	 * @return boolean <code>true</code> if <code>$node</code> is a child of this node.
	 **/
	function isChild(& $node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Checks if the given node is a parent of this node.
	 * @access public
	 * @param ref object node The child node to check.
	 * @return boolean <code>true</code> if <code>$node</code> is a parent of this node.
	 **/
	function isParent(& $node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the id of this node.
	 * @access public
	 * @return string The id of this node.
	 */
	function getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>