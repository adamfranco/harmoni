<?php

/** 
 * The interface for the Tree data structure used by the Hierarchy.
 * @access public
 * @version $Id: Tree.interface.php,v 1.1 2004/05/07 19:22:07 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorization.generator
 */
class TreeInterface {



	/**
	 * Adds the specified node to the hierarchy and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root.
	 * @method public addNode
	 * @param ref object The node to add.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return boolean <code>true</code> on success; <code>false</code>, otherwise.
	 */
	function & addNode(& $node, & $parent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Returns the size (number of nodes) in this hierarchy.
	 * @method public getSize
	 * @return integer The size (number of nodes) in this hierarchy.
	 */
	function getSize() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	


	/**
	 * Returns all the ancestors of the given node.
	 * @method public getAncestors
	 * @param ref object node The node whose ancestors are to be found.
	 * @return array An array of all the ancestors of the given node. Each array
	 * key corresponds to the hierarchy level of the ancestor. Each element stores
	 * the system id of the ancestor.
	 */
	function getAncestors(& $node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	

	/**
	 * Returns the subtree rooted at the specified node (excluding the root).
	 * @method public getSubtree
	 * @param ref object node The node whose subtree is to be found.
	 * @return array An array of all the nodes in the subtree rooted at the 
	 * specified node. Each array key corresponds to a certain level
	 * in the hierarchy. For example, the first level (with array key = 0) will 
	 * contain the root's children. The second level will have the root's 
	 * grandchildren and so forth. The array does not consist of the actual node objects; 
	 * instead, it only stores their system ids.
	 */
	function getSubtree(& $node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	
	/**
	 * Returns the node with the specified id. If it does not exist, return <code>null</code>.
	 * @method public getNode
	 * @param string id The id of the requested node.
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the tree.
	 */
	function & getNode($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns <code>true</code> if the node with the specified id (string) exists.
	 * @method public nodeExists
	 * @param string id The id of the node.
	 * @return boolean <code>true</code> if the node with the specified id is in the tree; else <code>false</code>.
	 */
	function nodeExists($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns an array of all root nodes (i.e., all nodes that don't have
	 * parents) in no particular order.
	 * @method public getRoot
	 * @return ref array The root nodes.
	 */
	function & getRoots() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	
	/**
	 * Simply returns all nodes of this hierarchy in an array in no particular
	 * order.
	 * @method public getAllNodes
	 * @return ref array An array of all nodes.
	 */
	function & getAllNodes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Traverses the hierarchy and returns all the nodes in an array. The traversal
	 * is a pre-order traversal starting from the specified node.
	 * @method public traverse
	 * @param optional ref object node An optional node to start traversal from.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function & traverse(& $node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
}


?>