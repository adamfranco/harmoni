<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.interface.php");
require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.class.php");

/** 
 * An AuthorizationContextHierarchy is a tree-like datastructure used by
 * the AuthorizationContextHierarchyGenerator objects.
 * @access public
 * @version $Id: AuthorizationContextHierarchy.class.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.authorization.generator
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
		
		// you can only add one node at a time
		if ($node->getChildrenCount() > 0) {
			$str = "Must add only one node at a time to the hierarchy";
			throwError(new Error($str, "AuthorizationHandler", true));
		}

		// if $node is to be a new child of $parent
		if (!is_null($parent)) {
			// make sure $parent is in the hierarchy
			$pDepth = $parent->getDepth();
			$pId = $parent->getSystemId();
			if (!$this->nodeExists($pDepth, $pId)) {
				$str = "Attempted to create a child for a node that is not ";
				$str .= "in the hierarchy.";
				throwError(new Error($str, "AuthorizationHandler", true));
			}
			
			// now add $node as a child to $parent		
			$parent->addChild($node);
		}
		
		$level = $node->getDepth();
		$systemId = $node->getSystemId();

		// make sure this node is not already present in the hierarchy
		if (isset($this->_nodes[$level][$systemId])) {
			$str = "Cannot add node to the hierarchy, because it has already";
			$str .= " been added.";
			throwError(new Error($str, "AuthorizationHandler", true));
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
	 * Returns an array of all root nodes (i.e., all nodes that don't have
	 * parents) in no particular order.
	 * @method public getRoot
	 * @return ref array The root nodes.
	 */
	function & getRoots() {
		// get all nodes
		$nodes =& $this->getAllNodes();
		
		$result = array();
		// now return only those nodes that do not have parents
		$count = count($nodes);
		for ($i = 0; $i < $count; $i++) {
			$node =& $nodes[$i];
			if (is_null($node->getParent()))
			    $result[] =& $node;
		}

		return $result;
	}
	
	
	
	/**
	 * Returns an array of all leaf nodes (i.e., all nodes that don't have
	 * children) in no particular order.
	 * @method public getLeaves
	 * @return ref array The leaf nodes.
	 */
	function & getLeaves() {
		// get all nodes
		$nodes =& $this->getAllNodes();
		
		$result = array();
		// now return only those nodes that do not have children
		$count = count($nodes);
		for ($i = 0; $i < $count; $i++) {
			$node =& $nodes[$i];
			if ($node->getChildrenCount() === 0)
			    $result[] =& $node;
		}

		return $result;
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
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		ArgumentValidator::validate($node, $extendsRule, true);
		// ** end of parameter validation
		
		$result = array();

		// while $node has a parent
		while (!is_null($parent =& $node->getParent())) {
			// add it to $result
			$depth = $parent->getDepth();
			$id = $parent->getSystemId();
			$result[$depth] = $id;
			
			// go up the hierarchy
			$node =& $parent;
		}
		
		return $result;
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
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		ArgumentValidator::validate($node, $extendsRule, true);
		// ** end of parameter validation
		
		$result = array();
		
		// convert the tree into an array
		$nodes =& $this->traverse($node);
		
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
	 * Returns all the nodes on a given level.
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
	 * Returns <code>true</code> if the node with the specified depth and system
	 * id is in the hierarchy.
	 * @method public nodeExists
	 * @param integer depth The depth of the node.
	 * @oaram integer systemId The system id of the node.
	 * @return boolean <code>true</code> if the node with the specified depth and system
	 * id is in the hierarchy.
	 */
	function nodeExists($depth, $systemId) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($depth, $integerRule, true);
		ArgumentValidator::validate($systemId, $integerRule, true);
		// ** end of parameter validation
	
		$node =& $this->getNodeAtLevel($depth, $systemId);

		return isset($node);
	}
	
	
	
	

	/**
	 * Simply returns all nodes of this hierarchy in an array in no particular
	 * order.
	 * @method public getAllNodes
	 * @return ref array An array of all nodes.
	 */
	function & getAllNodes() {
		$result = array();		
	
		foreach (array_keys($this->_nodes) as $i1 => $key1)
			foreach (array_keys($this->_nodes[$key1]) as $i2 => $key2)
				$result[] =& $this->_nodes[$key1][$key2];
				
		
		return $result;
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
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("AuthorizationContextHierarchyNodeInterface");
		$optionalRule =& new OptionalRule($extendsRule);
		ArgumentValidator::validate($node, $optionalRule, true);
		// ** end of parameter validation

		$roots = array();

		if (!is_null($node))
		    $roots[] =& $node;
		else
			$roots =& $this->getRoots(); // visit each root

		$result = array();

		foreach (array_keys($roots) as $i => $key)
			$this->_traverse($result, $roots[$key]);

		return $result;
	}
	
	
	/**
	 * A private recursive function that performs the pre-order traversal.
	 * @method private _traverse
	 * @param ref array The array where to store the result. Will consists of all 
	 * nodes in the hierarchy visited in a pre-order manner.
	 * @param ref object node The node to be visited.
	 * @return ref array An array of all nodes in the hierarchy visited in a pre-order
	 * manner.
	 */
	function _traverse(& $result, & $node) {
		// visit the node
		$result[] =& $node;

		// visit children, if any
		if ($node->hasChildren()) {
			// visit the children in the order they were added.
			$children =& $node->getChildren();
			foreach (array_keys($children) as $i => $key)
				$this->_traverse($result, $children[$key]);
		}
		// no children: base case - do nothing
		else 
			;
	}
	

	
}


?>