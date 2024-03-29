<?php

/** 
 * The interface for the Tree data structure used by the Hierarchy.
 *
 * @package harmoni.osid_v2.hierarchy.tree
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tree.interface.php,v 1.7 2007/09/04 20:25:42 adamfranco Exp $
 */
class TreeInterface {



	/**
	 * Adds the specified node to the hierarchy and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root.
	 * @access public
	 * @param ref object The node to add.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return boolean <code>true</code> on success; <code>false</code>, otherwise.
	 */
	function addNode($node, $parent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Returns the size (number of nodes) in this hierarchy.
	 * @access public
	 * @return integer The size (number of nodes) in this hierarchy.
	 */
	function getSize() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	


	/**
	 * Returns all the ancestors of the given node.
	 * @access public
	 * @param ref object node The node whose ancestors are to be found.
	 * @return array An array of all the ancestors of the given node. Each array
	 * key corresponds to the hierarchy level of the ancestor. Each element stores
	 * the system id of the ancestor.
	 */
	function getAncestors($node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	

	/**
	 * Returns the subtree rooted at the specified node (excluding the root).
	 * @access public
	 * @param ref object node The node whose subtree is to be found.
	 * @return array An array of all the nodes in the subtree rooted at the 
	 * specified node. Each array key corresponds to a certain level
	 * in the hierarchy. For example, the first level (with array key = 0) will 
	 * contain the root's children. The second level will have the root's 
	 * grandchildren and so forth. The array does not consist of the actual node objects; 
	 * instead, it only stores their system ids.
	 */
	function getSubtree($node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Delete the node from the tree. This can only be done if the node has no
	 * parents and no children.
	 * @access public
	 * @param object node The node to delete.
	 * @return void
	 **/
	function deleteNode($node) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	
	/**
	 * Returns the node with the specified id. If it does not exist, return <code>null</code>.
	 * @access public
	 * @param string id The id of the requested node.
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the tree.
	 */
	function getNode($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns <code>true</code> if the node with the specified id (string) exists.
	 * @access public
	 * @param string id The id of the node.
	 * @return boolean <code>true</code> if the node with the specified id is in the tree; else <code>false</code>.
	 */
	function nodeExists($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

	/**
	 * Simply returns all nodes of this hierarchy in an array in no particular
	 * order.
	 * @access public
	 * @return ref array An array of all nodes.
	 */
	function getAllNodes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Traverses the tree and returns all the nodes in an array. The traversal
	 * is a depth-first pre-order traversal starting from the specified node.
			 * @access public
	 * @param ref object node The node to start traversal from.
	 * @param boolean down If <code>true</code>, this argument specifies that the traversal will
	 * go down the children; if <code>false</code> then it will go up the parents.
	 * @param integer levels Specifies how many levels of nodes remain to be fetched. This
	 * will be recursively decremented and at 0 the recursion will stop. If this is negative
	 * then the recursion will go on until the last level is processed.
	 * @return ref array An array of all nodes in the tree visited in a pre-order
	 * manner. The keys of the array correspond to the nodes' ids.
	 * Each element of the array is another array of two elements, the first
	 * being the node itself, and the second being the depth of the node relative
	 * to the starting node. Descendants are assigned increasingly positive levels; 
	 * ancestors increasingly negative levels. 
	 */
	function traverse($node, $down, $levels) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
}


?>