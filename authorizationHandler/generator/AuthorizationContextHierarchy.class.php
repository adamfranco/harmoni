<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.interface.php");
require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.class.php");

/** 
 * An AuthorizationContextHierarchy is a tree-like datastructure used by
 * the AuthorizationContextHierarchyGenerator objects.
 * @access public
 * @version $Id: AuthorizationContextHierarchy.class.php,v 1.4 2003/07/07 02:27:48 dobomode Exp $
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
	 * Returns the subtree rooted at the specified node (excluding the root).
	 * @method public getSubtree
	 * @return ref array An array of all the nodes in the subtree rooted at the 
	 * specified node. Each element of the array corresponds to a certain level
	 * in the hierarchy. For example, the first level will contain the root's children. 
	 * The second level will have the root's grandchildren and so forth. 
	 * The array does not consist of the actual node objects; 
	 * instead, it only stores their system ids.
	 */
	function & getSubtree($node) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		ArgumentValidator::validate($node, $extendsRule, true);
		// ** end of parameter validation
		
		$result = array();
		
		// convert the tree into an array
		$nodes =& $this->traverse(false, $node);
		
		$numNodes = count($nodes);
		// place nodes on the same level in a separate array (exclude first node)
		for ($i = 1; $i < $numNodes; $i++) {
			$depth = $nodes[$i]->getDepth();
			$id = $nodes[$i]->getSystemId();
			$result[$depth][] = $id;
		}
		
		return $result;
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
	 * is a pre-order traversal starting from the specified node.
	 * @method public traverse
	 * @param optional boolean onlyCached If <code>true</code>, will return only
	 * nodes whose subtres have been cached.
	 * @param optional ref object node An optional node to start traversal from.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function & traverse($onlyCached, & $node) {
		// ** parameter validation
		$booleanRule =& new BooleanValidatorRule();
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		$optionalRule =& new OptionalRule($extendsRule);
		ArgumentValidator::validate($onlyCached, $booleanRule, true);
		ArgumentValidator::validate($node, $optionalRule, true);
		// ** end of parameter validation

		$roots = array();
		
		if (!is_null($node))
		    $roots[] =& $node;
		else
			$roots =& $this->getRoots(); // visit each root


		$result = array();
		
		foreach (array_keys($roots) as $i => $key)
			$this->_traverse($result, $onlyCached, $roots[$key]);
			
		return $result;
	}
	
	
	/**
	 * A private recursive function that performs the pre-order traversal.
	 * @method private _traverse
	 * @param ref array The array where to store the result. Will consists of all 
	 * nodes in the hierarchy visited in a pre-order manner.
	 * @param optional boolean onlyCached If <code>true</code>, will return only
	 * nodes whose subtres have been cached.
	 * @param ref object node The node to be visited.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function _traverse(& $result, $onlyCached = false, & $node) {

		if ($onlyCached === true && $node->cachedSubtree() === true) {
				// stop the traversal if the subtree is cached
				$result[] =& $node;
				return;
		}

		if ($onlyCached === false)
			// visit the node
			$result[] =& $node;

		// visit children, if any
		if ($node->hasChildren()) {
			// visit the children in the order they were added.
			$children =& $node->getChildren();
			foreach (array_keys($children) as $i => $key)
				$this->_traverse($result, $onlyCached, $children[$key]);
		}
		// no children: base case - do nothing
		else 
			;
	}
	

	
}


?>