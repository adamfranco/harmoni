<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.interface.php");
require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.class.php");

/** 
 * An AuthorizationContextHierarchy is a tree-like datastructure used by
 * the AuthorizationContextHierarchyGenerator objects.
 * @access public
 * @version $Id: AuthorizationContextHierarchy.class.php,v 1.1 2003/07/01 01:55:22 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorizationHandler.generator
 */
class AuthorizationContextHierarchy
							extends AuthorizationContextHierarchyInterface {



	/**
	 * The nodes of this hierarchy. This is an array of nodes. Each element of
	 * the array corresponds to one level of the hierarchy.
	 * @attribute private array _nodes
	 */
	var $_nodes;
	
	/**
	 * The size of this hierarchy.
	 * @attribute private integer _size
	 */
	var $_size;
	
	/**
	 * The height of this hierarchy.
	 * @attribute private integer _height
	 */
	var $_height;
	
	

	/**
	 * The constructor does some initializations.
	 * @access public
	 */
	function AuthorizationContextHierarchy() {
		$this->_nodes[0] = array();
		$this->_size = 0;
		$this->_height = 0;
	}
	
	
	/**
	 * Adds one node to the hierarchy and make it a child of the specified
	 * parent.
	 * @method public addNode
	 * @param integer systemId The system id of the new node.
	 * @param ref object parent The node that will become the parent of the added node.
	 * @return ref object The newly created node.
	 */
	function & addNode($systemId, & $parent) {
		$node =& new AuthorizationContextHierarchyNode($systemId);	
	
		// if adding a new root
		if (is_null($parent))
			$level = 0;
		else {
			$level = $parent->getDepth() + 1;
			$parent->addChild($node);
		}
			
		// make sure this node is not already present in the hierarchy
		if (isset($this->_nodes[$level][$systemId])) {
			$str = "Cannot add node to the hierarchy, because it has already";
			$str .= " been added.";
			throw(new Error($str, "AuthorizationHandler", true));
		}
	
		// add the node
	    $this->_nodes[$level][$systemId] =& $node;
		$this->_size++;
		if ($node->getDepth() + 1 > $this->_height)
		    $this->_height = $node->getDepth() + 1; // adjust the height
			
		return $node;
	}
	
	
	/**
	 * Returns the size (number of nodes) in this hierarchy.
	 * @method public getSize
	 * @return integer The size (number of nodes) in this hierarchy.
	 */
	function getSize() {
		return $this->_size;
	}

	
	/**
	 * Returns the height (number of levels) of this hierarchy
	 * @method public getHeight
	 * @return integer The height (number of levels) of this hierarchy
	 */
	function getHeight() {
		return $this->_height;
	}
	
	
	/**
	 * Returns an array of all root nodes.
	 * Equivalent to <code>getNodesAtLevel(0)</code>.
	 * @method public getRoot
	 * @return ref array The root nodes.
	 */
	function & getRoots() {
		return $this->getNodesAtLevel(0);
	}
	
	
	/**
	 * Returns all the nodes on a given level. <code>getNodesAtLevel(0)</code> is
	 * equivalent to getRoots().
	 * @method public getNodesAtLevel
	 * @param integer level The level to return all nodes for.
	 * @return ref array The nodes on the given hierarchy level.
	 */
	function & getNodesAtLevel($level) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($level, $integerRule, true);
		// ** end of parameter validation
	
		return $this->_nodes[$level];
	}
	


	/**
	 * Returns the node with the specified system id that is at the specified
	 * level.
	 * @method public getNodeAtLevel
	 * @param integer level The level of the requested node.
	 * @param integer systemId The systemId of the requested node.
	 * @return ref object The requested node.
	 */
	function & getNodeAtLevel($level, $systemId) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($level, $integerRule, true);
		ArgumentValidator::validate($systemId, $integerRule, true);
		// ** end of parameter validation
	
		if (!isset($this->_nodes[$level][$systemId]))
			return null;
				
		return $this->_nodes[$level][$systemId];
	}

}


?>