<?php

require_once(HARMONI."oki/hierarchy2/tree/Tree.class.php");

/**
 * This class provides a mechanism for caching different parts of a hierarchy. A
 * single instance of this class will be included with a single <code>Hierarchy</code> 
 * object and all its <code>Node</code> objects.<br><br>
 * 
 * The class maintains a single <code>Tree</code> object called <code>tree</code>
 * that will store the parts of the hierarchy already cached. In addition, 
 * there is a special array called <code>cache</code>. Given an id of a cached node,
 * this array enables us to determine whether any of the node's inheritors or ancestors have
 * been cached as well. In specific, each element of the array corresponds to a unique
 * node (each index of the array is a node id) and is another array storing
 * one <code>Node</code> object and two integer values. 
 * If any of the integer values is positive, then that means that 
 * we have information about the cache status of the node's immediate ancestors or
 * inheritors. Specifically, the two integer values determine the amount of caching, i.e. the first
 * integer specifies the number of tree levels cached down the node, and the second integer
 * specifies the number of tree levels cached up the node. If any of these values is negative
 * then that means that the caching extends all the way up or down. If any of the two
 * values is zero, then nothing has been cached in the corresponding direction.<br><br>
 * 
 * Caching occurs when the user calls the accessor methods of the <code>Hierarchy</code> class,
 * i.e. <code>traverse()</code>, <code>getChildren()</code> or <code>getParents()</code>.
 * @version $Id: HierarchyCache.class.php,v 1.1 2004/05/25 18:53:17 dobomode Exp $
 * @package harmoni.osid.hierarchy2
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class HierarchyCache {


	/**
	 * This is the <code>Tree</code> object that will store the cached portions
	 * of the hierarchy.
	 * @attribute private object _tree
	 */
	var $_tree;
	
	
	/**
	 * Given an id of a cached node,
	 * this array enables us to determine whether any of the node's inheritors or ancestors have
	 * been cached as well. In specific, each element of the array corresponds to a unique
	 * node (each index of the array is a node id) and is another array storing
	 * one <code>Node</code> object and two integer values. 
	 * If any of the integer values is positive, then that means that 
	 * we have information about the cache status of the node's immediate ancestors or
	 * inheritors. Specifically, the two integer values determine the amount of caching, i.e. the first
	 * integer specifies the number of tree levels cached down the node, and the second integer
	 * specifies the number of tree levels cached up the node. If any of these values is negative
	 * then that means that the caching extends all the way down or up. If any of the two
	 * values is zero, then nothing has been cached in the corresponding direction.<br><br>
	 * @attribute private array _cache
	 */
	var $_cache;


	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @attribute private string _hierarchyDB
	 */
	var $_sharedDB;
	
	
	/**
	 * The id of the hierarchy.
	 * @attribute private string _$hierarchyId
	 */
	var $_hierarchyId;
	
	
	/**
     * Constructor
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
     * @access protected
     */
	function HierarchyCache($hierarchyId, $dbIndex, $sharedDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($sharedDB, new StringValidatorRule(), true);
		ArgumentValidator::validate($hierarchyId, new StringValidatorRule(), true);
		// ** end of parameter validation

		$this->_tree = new Tree();
		$this->_cache = array();
		$this->_dbIndex = $dbIndex;
		$this->_sharedDB = $sharedDB;
		$this->_hierarchyId = $hierarchyId;
	}
	
	
	/**
	 * Determines whether a node has been cached down
	 * @see {@link HierarchyCache::_cache}.
	 * @access private
	 * @param string idValue The string id of the node.
	 * @param integer levels The number of tree levels down to check for caching.
	 * If negative, then cached all the way down.
	 * @return boolean If <code>true</code> then <code>levels</code> number of
	 * levels have been cached down.
	 **/
	function _isCachedDown($idValue, $levels) {
		if (isset($this->_cache[$idValue]))
			return ($this->_cache[$idValue][1] >= $levels);
		else
			return false;
	}


	/**
	 * Determines whether a node has been cached up 
	 * @see {@link HierarchyCache::_cache}.
	 * @access private
	 * @param string idValue The string id of the node.
	 * @param integer levels The number of tree levels up to check for caching. 
	 * If negative, then cached all the way up.
	 * @return boolean If <code>true</code> then <code>levels</code> number of
	 * levels have been cached up.
	 **/
	function _isCachedUp($idValue, $levels) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		ArgumentValidator::validate($levels, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		if (isset($this->_cache[$idValue]))
			return ($this->_cache[$idValue][2] >= $levels);
		else
			return false;
	}
	
	
	/**
	 * Returns <code>true</code> if the node with the specified string id has
	 * been cached.
	 * @access private
	 * @param string idValue The string id of the node.
	 * @return boolean <code>true</code> if the with the specified string id has
	 * been cached.
	 **/
	function _isCached($idValue) {
		return (isset($this->_cache[$idValue]));
	}
	
	
	
	/**
	 * Returns (and caches if necessary) the node with the specified string id.
	 * @access public
	 * @param string idValue The string id of the node.
	 * @return mixed The corresponding <code>Node</code> object.
	 **/
	function cacheAndGetNode($idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		// ** end of parameter validation


		// if the node has not been already cached, do it
		if (!$this->_isCached($idValue)) {

			// now fetch the node from the database
	
			$db = $this->_sharedDB.".";
			$dbHandler =& Services::requireService("DBHandler");
			$query =& new SelectQuery();
	
			// set the columns to select
			$query->addColumn("node_id", "id", $db."node");
			$query->addColumn("node_display_name", "display_name", $db."node");
			$query->addColumn("node_description", "description", $db."node");
			$query->addColumn("type_domain", "domain", $db."type");
			$query->addColumn("type_authority", "authority", $db."type");
			$query->addColumn("type_keyword", "keyword", $db."type");
			$query->addColumn("type_description", "type_description", $db."type");
	
			// set the tables
			$query->addTable($db."node");
			$joinc = $db."node.fk_type = ".$db."type.type_id";
			$query->addTable($db."type", INNER_JOIN, $joinc);
			
			$where = $db."node.node_id = '".$idValue."'";
			$query->addWhere($where);
			
//			echo "<pre>\n";
//			echo MySQL_SQLGenerator::generateSQLQuery($query);
//			echo "</pre>\n";
			
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
	
			// must be only one row
			if ($queryResult->getNumberOfRows() != 1) {
				$str = "Exactly one node must have been returned!";
				throwError(new Error($str, "Hierarchy", true));
			}
			
			$row = $queryResult->getCurrentRow();
				
			$id =& new HarmoniId($idValue);
			$type =& new HarmoniType($row['domain'], $row['authority'], 
									  $row['keyword'], $row['type_description']);
		    $node =& new HarmoniNode($id, $type, 
									  $row['display_name'], $row['description'], $this);
			$this->_tree->addNode(new TreeNode($idValue));
			$this->_cache[$idValue][0] =& $node;
			$this->_cache[$idValue][1] = 0;
			$this->_cache[$idValue][2] = 0;
		}
		
		// now that all nodes are cached, just return all children
		$result = $this->_cache[$idValue][0];
			
		return $result;
	}
	
	
	
	/**
	 * Caches the parents (if not cached already)
	 * of the given node by fecthing them from the database
	 * if neccessary, and then inserting them in <code>_tree</code> and updating
	 * <code>_cache</code>.
	 * @access public
	 * @param object node The node object whose parents we must cache.
	 * @return array An array of the parent nodes of the given node.
	 **/
	function cacheAndGetParents($node) {
		// ** parameter validation
		ArgumentValidator::validate($node, new ExtendsValidatorRule("HarmoniNode"), true);
		// ** end of parameter validation
		
		$idValue = $node->_id->getIdString();

		// if the children have not been already cached, do it
		if (!$this->_isCachedUp($idValue, 1)) {

			// include the given node in the cache of nodes if necessary
			if (!$this->_isCached($idValue)) {
				$this->_tree->addNode(new TreeNode($idValue));
			    $this->_cache[$idValue][0] =& $node;
			}
	
			// now fetch <code>$node</code>'s parents from the database
			// with the exception of those parents that have been already fetched
			$treeNode =& $this->_tree->getNode($idValue);
			$nodesToExclude = (isset($treeNode)) ? ($treeNode->getParents()) : array();
	
			$db = $this->_sharedDB.".";
			$dbHandler =& Services::requireService("DBHandler");
			$query =& new SelectQuery();
	
			// set the columns to select
			$query->addColumn("node_id", "id", $db."parents");
			$query->addColumn("node_display_name", "display_name", $db."parents");
			$query->addColumn("node_description", "description", $db."parents");
			$query->addColumn("type_domain", "domain", $db."type");
			$query->addColumn("type_authority", "authority", $db."type");
			$query->addColumn("type_keyword", "keyword", $db."type");
			$query->addColumn("type_description", "type_description", $db."type");
	
			// set the tables
			$query->addTable($db."j_node_node", NO_JOIN, "", "child");
			$joinc = $db."child.fk_parent = ".$db."parents.node_id";
			$query->addTable($db."node", INNER_JOIN, $joinc, "parents");
			$joinc = $db."parents.fk_type = ".$db."type.type_id";
			$query->addTable($db."type", INNER_JOIN, $joinc);
			
			$where = $db."child.fk_child = '".$idValue."'";
			$query->addWhere($where);
			
			if (count($nodesToExclude) > 0) {
				$where = implode(", ",array_keys($nodesToExclude));
				$where = $db."children.node_id NOT IN ({$where})";
				$query->addWhere($where);
			}
			
			echo "<pre>\n";
			echo MySQL_SQLGenerator::generateSQLQuery($query);
			echo "</pre>\n";
			
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
	
			// for all rows returned by the query
			while($queryResult->hasMoreRows()) {
				$row = $queryResult->getCurrentRow();
				
				// see if node in current row is in the cache
				$parentIdValue = $row['id'];
				// if not create it and cache it
				if (!$this->_isCached[$parentIdValue]) {
					$parentId =& new HarmoniId($parentIdValue);
					$parentType =& new HarmoniType($row['domain'], $row['authority'], 
												  $row['keyword'], $row['type_description']);
				    $parent =& new HarmoniNode($parentId, $parentType, 
											  $row['display_name'], $row['description'], $this);
					$parentTreeNode =& new TreeNode($parentIdValue);
					$this->_tree->addNode($parentTreeNode);
					$this->_tree->addNode($treeNode, $parentTreeNode);
					$this->_cache[$parentIdValue][0] =& $parent;
					$this->_cache[$parentIdValue][1] = 0;
					$this->_cache[$parentIdValue][2] = 0;
				}
				// if yes, then just update tree stucture
				else 
					$this->_tree->addNode($treeNode, $this->_tree->getNode($parentIdValue));
	
				$queryResult->advanceRow();
			}
			
			// finish caching
			$this->_cache[$idValue][2] = 1; // parents have been cached
		}
		
		// now that all nodes are cached, just return all children
		$treeNode =& $this->_tree->getNode($idValue);
		$result = array();
		$parentsIds =& $treeNode->getParents();
		foreach (array_keys($parentsIds) as $i => $key)
			$result[] =& $this->_cache[$key][0];
			
		return $result;
	}
	
	

	/**
	 * Caches the children (if not cached already)
	 * of the given node by fecthing them from the database
	 * if neccessary, and then inserting them in <code>_tree</code> and updating
	 * <code>_cache</code>.
	 * @access public
	 * @param object node The node object whose children we must cache.
	 * @return array An array of the children nodes of the given node.
	 **/
	function cacheAndGetChildren($node) {
		// ** parameter validation
		ArgumentValidator::validate($node, new ExtendsValidatorRule("HarmoniNode"), true);
		// ** end of parameter validation
		
		$idValue = $node->_id->getIdString();

		// if the children have not been already cached, do it
		if (!$this->_isCachedDown($idValue, 1)) {

			// include the given node in the cache of nodes if necessary
			if (!$this->_isCached($idValue)) {
				$this->_tree->addNode(new TreeNode($idValue));
			    $this->_cache[$idValue][0] =& $node;
			}
	
			// now fetch <code>$node</code>'s children from the database
			// with the exception of those children that have been already fetched
			$treeNode =& $this->_tree->getNode($idValue);
			$nodesToExclude = (isset($treeNode)) ? ($treeNode->getChildren()) : array();
	
			$db = $this->_sharedDB.".";
			$dbHandler =& Services::requireService("DBHandler");
			$query =& new SelectQuery();
	
			// set the columns to select
			$query->addColumn("node_id", "id", $db."children");
			$query->addColumn("node_display_name", "display_name", $db."children");
			$query->addColumn("node_description", "description", $db."children");
			$query->addColumn("type_domain", "domain", $db."type");
			$query->addColumn("type_authority", "authority", $db."type");
			$query->addColumn("type_keyword", "keyword", $db."type");
			$query->addColumn("type_description", "type_description", $db."type");
	
			// set the tables
			$query->addTable($db."j_node_node", NO_JOIN, "", "parent");
			$joinc = $db."parent.fk_child = ".$db."children.node_id";
			$query->addTable($db."node", INNER_JOIN, $joinc, "children");
			$joinc = $db."children.fk_type = ".$db."type.type_id";
			$query->addTable($db."type", INNER_JOIN, $joinc);
			
			$where = $db."parent.fk_parent = '".$idValue."'";
			$query->addWhere($where);
			
			if (count($nodesToExclude) > 0) {
				$where = implode(", ",array_keys($nodesToExclude));
				$where = $db."children.node_id NOT IN ({$where})";
				$query->addWhere($where);
			}
			
//			echo "<pre>\n";
//			echo MySQL_SQLGenerator::generateSQLQuery($query);
//			echo "</pre>\n";
			
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
	
			// for all rows returned by the query
			while($queryResult->hasMoreRows()) {
				$row = $queryResult->getCurrentRow();
				
				// see if node in current row is in the cache
				$childIdValue = $row['id'];
				// if not create it and cache it
				if (!$this->_isCached[$childIdValue]) {
					$childId =& new HarmoniId($childIdValue);
					$childType =& new HarmoniType($row['domain'], $row['authority'], 
												  $row['keyword'], $row['type_description']);
				    $child =& new HarmoniNode($childId, $childType, 
											  $row['display_name'], $row['description'], $this);
					$this->_tree->addNode(new TreeNode($childIdValue), $treeNode);
					$this->_cache[$childIdValue][0] =& $child;
					$this->_cache[$childIdValue][1] = 0;
					$this->_cache[$childIdValue][2] = 0;
				}
				// if yes, then just update tree stucture
				else 
					$this->_tree->addNode($this->_tree->getNode($childIdValue), $treeNode);
	
				$queryResult->advanceRow();
			}
			
			// finish caching
			$this->_cache[$idValue][1] = 1; // children have been cached
		}		
		
		
		// now that all nodes are cached, just return all children
		$treeNode =& $this->_tree->getNode($idValue);
		$result = array();
		$childrenIds =& $treeNode->getChildren();
		foreach (array_keys($childrenIds) as $i => $key)
			$result[] =& $this->_cache[$key][0];
			
		return $result;
	}
	
	
	
	
}

?>