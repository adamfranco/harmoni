<?php

/** 
 * The interface for an AuthorizationContextHierarchy, a tree-like datastructure used by
 * the AuthorizationContextHierarchyGenerator objects.
 * @access public
 * @version $Id: AuthorizationContextHierarchy.interface.php,v 1.3 2003/07/04 03:32:34 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorizationHandler.generator
 */
class AuthorizationContextHierarchyInterface {


	/**
	 * Creates and adds one node to the hierarchy and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root.
	 * @method public addNewNode
	 * @param integer systemId The system id of the new node.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return ref object The newly created node.
	 */
	function & addNewNode($systemId, & $parent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

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
	 * Returns the height (number of levels) of this hierarchy
	 * @method public getHeight
	 * @return integer The height (number of levels) of this hierarchy
	 */
	function getHeight() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns an array of all root nodes.
	 * Equivalent to <code>getNodesAtLevel(0)</code>.
	 * @method public getRoot
	 * @return ref array The root nodes.
	 */
	function & getRoots() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Returns all the nodes on a given level. <code>getNodesAtLevel(0)</code> is
	 * equivalent to getRoots().
	 * @method public getNodesAtLevel
	 * @param integer level The level to return all nodes for.
	 * @return ref array The nodes on the given hierarchy level.
	 */
	function & getNodesAtLevel($level) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}



	/**
	 * Returns the node with the specified system id that is at the specified
	 * level.
	 * @method public getNodeAtLevel
	 * @param integer level The level of the requested node.
	 * @param integer systemId The systemId of the requested node.
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the hierarchy.
	 */
	function & getNodeAtLevel($level, $systemId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Traverses the hierarchy and returns all the nodes in an array. The traversal
	 * is a pre-order traversal.
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