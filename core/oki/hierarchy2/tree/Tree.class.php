<?php

require_once(HARMONI."oki/hierarchy2/tree/Tree.interface.php");
require_once(HARMONI."oki/hierarchy2/tree/TreeNode.class.php");

/** 
 * The Tree data structure used by the Hierarchy.
 *
 * @package harmoni.osid_v1.hierarchy2.tree
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tree.class.php,v 1.11 2005/03/29 19:44:20 adamfranco Exp $
 */
class Tree extends TreeInterface {



	/**
	 * The nodes of this tree. This is an array of node object. The indices of
	 * the array correspond to the node id.
	 * @var array _nodes 
	 * @access private
	 */
	var $_nodes;
	
	
	/**
	 * The size of this tree.
	 * @var integer _size 
	 * @access private
	 */
	var $_size;
	

	/**
	 * The constructor does some initializations.
	 * @access public
	 */
	function Tree() {
		$this->_nodes = array();
		$this->_size = 0;
	}
	
	
	/**
	 * Adds the specified node to the tree and makes it a child of the specified
	 * parent. If the parent is not specified, then it makes the node a root. Always
	 * use this method instead of the addChild() method of the individual tree nodes.
	 * @access public
	 * @param ref object The node to add.
	 * @param optional ref object parent The node that will become the parent of the added node.
	 * @return void
	 */
	function addNode(& $node, & $parent) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("TreeNode");
		$optionalRule =& OptionalRule::getRule($extendsRule);
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
		}
		
		// if node has not been cached then do so
		if (!$this->nodeExists($id)) {
			// add the node
		    $this->_nodes[$id] =& $node;
			$this->_size++;
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
		$extendsRule =& ExtendsValidatorRule::getRule("TreeNode");
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
	 * @access public
	 * @return integer The size (number of nodes) in this tree.
	 */
	function getSize() {
		return $this->_size;
	}


	/**
	 * Returns the node with the specified id. If it does not exist, return <code>null</code>.
	 * @access public
	 * @param string id The id of the requested node.
	 * @return ref object The requested node. <code>Null</code>, if the node
	 * is not in the tree.
	 */
	function &getNode($id) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($id, $stringRule, true);
		// ** end of parameter validation
	
		return $this->_nodes[$id];
	}
	
	
	/**
	 * Returns <code>true</code> if the node with the specified id (string) exists.
	 * @access public
	 * @param string id The id of the node.
	 * @return boolean <code>true</code> if the node with the specified id is in the tree; else <code>false</code>.
	 */
	function nodeExists($id) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($id, $stringRule, true);
		// ** end of parameter validation
	
		return isset($this->_nodes[$id]);
	}
	
	
	/**
	 * Simply returns all nodes of this tree in an array in no particular
	 * order.
	 * @access public
	 * @return ref array An array of all nodes.
	 */
	function &getNodes() {
		return $this->_nodes;
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
	function &traverse(& $node, $down, $levels) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("TreeNodeInterface");
		ArgumentValidator::validate($node, $extendsRule, true);
		ArgumentValidator::validate($down, BooleanValidatorRule::getRule(), true);
		ArgumentValidator::validate($levels, IntegerValidatorRule::getRule(), true);
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
	 * @access private
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
	function &_traverse(& $result, & $node, $down, $levels, $startingLevel) {
		// visit the node
		
		// note: the node could possibly been have visited already (if it has
		// several parents and we reached it earlier through a different parent);
		// in this case, we would only change the depth if it got smaller
		$mult = ($down) ? 1 : -1;
		$newLevel = ($startingLevel - $levels) * $mult;
		
		if (!isset($result[$node->getId()])) {
			$result[$node->getId()][0] =& $node;
			$result[$node->getId()][1] = $newLevel;
		}
		else if (abs($result[$node->getId()][1]) > abs($newLevel))
			$result[$node->getId()][1] = $newLevel;

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