<?php

require_once(HARMONI."oki/hierarchy2/tree/Tree.interface.php");
require_once(HARMONI."oki/hierarchy2/tree/TreeNode.class.php");

/** 
 * The Tree data structure used by the Hierarchy.
 * @access public
 * @version $Id: Tree.class.php,v 1.3 2004/06/01 00:05:58 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 8/30/2003
 * @package harmoni.osid.hierarchy2.tree
 */
class Tree extends TreeInterface {



	/**
	 * The nodes of this tree. This is an array of node object. The indices of
	 * the array correspond to the node id.
	 * @attribute private array _nodes
	 */
	var $_nodes;
	
	
	/**
	 * The root nodes of the tree are stored in this array.
	 * @attribute private array _roots
	 */
	var $_roots;
	
	
	/**
	 * The size of this tree.
	 * @attribute private integer _size
	 */
	var $_size;
	

	/**
	 * The constructor does some initializations.
	 * @access public
	 */
	function Tree() {
		$this->_nodes = array();
		$this->_roots = array();
		$this->_size = 0;
	}
	
	
	/**
	 * Adds the specified node to the tree and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root.
	 * @method public addNode
	 * @param ref object The node to add.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return void
	 */
	function addNode(& $node, & $parent) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("TreeNode");
		$optionalRule =& new OptionalRule($extendsRule);
		ArgumentValidator::validate($node, $extendsRule, true);
		ArgumentValidator::validate($parent, $optionalRule, true);
		// ** end of parameter validation
		
		$id = $node->getId();

		// if $parent is not null, i.e. $node will not be a root
		if (!is_null($parent)) {
			// make sure $parent is in the tree
			if (!$this->nodeExists($parent->getId())) {
				$str = "Attempted to create a child for a node that is not in the tree.";
				throwError(new Error($str, "Hierarchy", true));
			}
			
			// now add $node as a child to $parent
			$parent->addChild($node);
			
			// if the node used to be a root, then it's no more
			if (isset($this->_roots[$id]))
				unset($this->_roots[$id]);
		}
		
		// if node has not been cached then do so
		if (!$this->nodeExists($id)) {
			// add the node
		    $this->_nodes[$id] =& $node;
			$this->_size++;

			// if there is no parent then this is a root node
			if (is_null($parent)) 
				$this->_roots[$id] =& $node;
		}
	}

	
	/**
	 * Delete the node from the tree. This can only be done if the node has no
	 * parents and no children.
	 * @access public
	 * @param object node The node to delete.
	 * @return void
	 **/
	function deleteNode(& $node) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("TreeNode");
		ArgumentValidator::validate($node, $extendsRule, true);
		// ** end of parameter validation
		
		if (($node->getParentsCount() != 0) || ($node->getChildrenCount() != 0)) {
				$str = "Cannot delete a node that has parents or children.";
				throwError(new Error($str, "Hierarchy", true));
		}
		
		// now delete it
		unset($this->_nodes[$node->_id]);
		$node = null;
	}
	


	/**
	 * Returns the size (number of nodes) in this tree.
	 * @method public getSize
	 * @return integer The size (number of nodes) in this tree.
	 */
	function getSize() {
		return $this->_size;
	}


	/**
	 * Returns the node with the specified id. If it does not exist, return <code>null</code>.
	 * @method public getNode
	 * @param string id The id of the requested node.
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the tree.
	 */
	function & getNode($id) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($id, $stringRule, true);
		// ** end of parameter validation
	
		return $this->_nodes[$id];
	}
	
	
	/**
	 * Returns <code>true</code> if the node with the specified id (string) exists.
	 * @method public nodeExists
	 * @param string id The id of the node.
	 * @return boolean <code>true</code> if the node with the specified id is in the tree; else <code>false</code>.
	 */
	function nodeExists($id) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($id, $stringRule, true);
		// ** end of parameter validation
	
		return isset($this->_nodes[$id]);
	}
	
	
	/**
	 * Returns an array of all root nodes (i.e., all nodes that don't have
	 * parents) in no particular order.
	 * @method public getRoot
	 * @return ref array The root nodes.
	 */
	function & getRoots() {
		return $this->_roots;
	}
	

	/**
	 * Simply returns all nodes of this tree in an array in no particular
	 * order.
	 * @method public getNodes
	 * @return ref array An array of all nodes.
	 */
	function & getNodes() {
		return $this->_nodes;
	}
	

	/**
	 * Traverses the tree and returns all the nodes in an array. The traversal
	 * is a depth-first pre-order traversal starting from the specified node.
	 * @method public traverse
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
	function & traverse(& $node, $down, $levels) {
		// ** parameter validation
		$extendsRule =& new ExtendsValidatorRule("TreeNodeInterface");
		ArgumentValidator::validate($node, $extendsRule, true);
		ArgumentValidator::validate($down, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($levels, new IntegerValidatorRule(), true);
		// ** end of parameter validation
		
		if (!$this->nodeExists($node->getId())) {
			$str = "Attempted to traverse from a node that does not exist in the tree.";
			throwError(new Error($str, "Hierarchy", true));
		}

		$result = array();

		$this->_traverse($result, $node, $down, $levels, $levels);

		return $result;
	}
	
	
	/**
	 * A private recursive function that performs a depth-first pre-order traversal.
	 * @method private _traverse
	 * @param ref array The array where to store the result. Will consists of all 
	 * nodes in the tree visited in a pre-order manner.
	 * @param ref object node The node to be visited.
	 * @param boolean down If <code>true</code>, this argument specifies that the traversal will
	 * go down the children; if <code>false</code> then it will go up the parents.
	 * @param integer levels Specifies how many levels of nodes remain to be fetched. This
	 * will be recursively decremented and at 0 the recursion will stop. If this is negative
	 * then the recursion will go on until the last level is processed.
	 * @@param integer startingLevels This is the original value of the levels. This
	 * is needed in order to properly calculate the relative depth of each returned node.
	 * @return ref array An array of all nodes in the tree visited in a pre-order
	 * manner. The keys of the array correspond to the nodes' ids.
	 * Each element of the array is another array of two elements, the first
	 * being the node itself, and the second being the depth of the node relative
	 * to the starting node. Descendants are assigned increasingly positive levels; 
	 * ancestors increasingly negative levels. 
	 */
	function & _traverse(& $result, & $node, $down, $levels, $startingLevel) {
		// visit the node
		$result[$node->getId()][0] =& $node;
		$mult = ($down) ? 1 : -1;
		$result[$node->getId()][1] = ($startingLevel - $levels) * $mult;

		// base case 1 : all levels have been processed
		if ($levels == 0)
			return;
	
		// base case 2: there are no more nodes left
		if ($down) 
			$noMoreLeft = !$node->hasChildren();
		else 
			$noMoreLeft = !$node->hasParents();
		if ($noMoreLeft)
			return;

		// visit the children/parents
		if ($down)
			$nodes =& $node->getChildren();
		else
			$nodes =& $node->getParents();
		foreach (array_keys($nodes) as $i => $key)
			// recurse for each node
			$this->_traverse($result, $nodes[$key], $down, $levels - 1, $startingLevel);
	}
	

	
}


?>