<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.interface.php");
require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.class.php");

/** 
 * An AuthorizationContextHierarchy is a tree-like datastructure used by
 * the AuthorizationContextHierarchyGenerator objects.
 * @access public
 * @version $Id: AuthorizationContextHierarchy.class.php,v 1.2 2003/07/04 00:15:37 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorizationHandler.generator
 */
class AuthorizationContextHierarchy
							extends AuthorizationContextHierarchyInterface {



	/**
	 * The nodes of this hierarchy. This is an array of arrays of nodes. Each element of
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
	 * Creates and adds one node to the hierarchy and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root.
	 * @method public addNewNode
	 * @param integer systemId The system id of the new node.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return ref object The newly created node.
	 */
	function & addNewNode($systemId, & $parent) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		$optionalRule =& new OptionalRule($extendsRule);
		ArgumentValidator::validate($systemId, $integerRule, true);
		ArgumentValidator::validate($parent, $optionalRule, true);
		// ** end of parameter validation

		$node =& new AuthorizationContextHierarchyNode($systemId);	
	
		$this->addNode($node, $parent);
			
		return $node;
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
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		$optionalRule =& new OptionalRule($extendsRule);
		ArgumentValidator::validate($node, $extendsRule, true);
		ArgumentValidator::validate($parent, $optionalRule, true);
		// ** end of parameter validation

		// if $node is to be a new child of $parent
		if (!is_null($parent))
			$parent->addChild($node);
		
		$level = $node->getDepth();
		$systemId = $node->getSystemId();

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
			
		return true;
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
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the hierarchy.
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
	

	
	/**
	 * Traverses the hierarchy and returns all the nodes in an array. The traversal
	 * is a pre-order traversal.
	 * @method public traverse
	 * @param optional ref node An optional node to start traversal from.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function & traverse(& $node) {
		$results = array();
		
		$roots = array();
		
		if (!is_null($node))
		    $roots[] =& $node;
		else
			// visit each root
			$roots =& $this->getRoots();
		
		$rootsCount = count($roots);
		foreach (array_keys($roots) as $i => $key)
			$results[] =& $this->_traverse($roots[$key]);
			
		// now merge together the results for each root
		$result = array();
		for ($key = 0; $key < $rootsCount; $key++)
			foreach (array_keys($results[$key]) as $i => $key1)
				$result[] =& $results[$key][$key1];

		return $result;
	}
	
	
	/**
	 * A private recursive function that performs the pre-order traversal.
	 * @method private _traverse
	 * @param ref object node The node to be visited.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function _traverse(& $node) {
		$result = array();
		
		// visit the node
		$result[] =& $node;
		
		if ($node->hasChildren()) {
			// visit the children in the order they were added.
			$children =& $node->getChildren();
			foreach (array_keys($children) as $i => $key) {
				$child =& $children[$key];
				$resultFromChild =& $this->_traverse($child);
				foreach (array_keys($resultFromChild) as $i => $key1)
					$result[] =& $resultFromChild[$key1];
			}
		}
		// base case - do nothing
		else
			;
			
		return $result;
		
	}
	

	
}


?>