<?php

require_once(HARMONI."oki/hierarchy2/tree/Tree.class.php");
require_once(HARMONI."oki/hierarchy2/HarmoniTraversalInfo.class.php");
require_once(HARMONI."oki/hierarchy2/HarmoniTraversalInfoIterator.class.php");

/**
 * This class provides a mechanism for caching different parts of a hierarchy and
 * acts as an interface between the datastructures and the database. A
 * single instance of this class will be included with a single <code>Hierarchy</code> 
 * object and all its <code>Node</code> objects.<br /><br />
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
 * values is zero, then nothing has been cached in the corresponding direction.<br /><br />
 * 
 * Caching occurs when the user calls the accessor methods of the <code>Hierarchy</code> class,
 * i.e. <code>traverse()</code>, <code>getChildren()</code> or <code>getParents()</code>.
 *
 * @package harmoni.osid_v1.hierarchy2
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HierarchyCache.class.php,v 1.22 2005/02/07 21:15:19 adamfranco Exp $
 **/

class HierarchyCache {


	/**
	 * This is the <code>Tree</code> object that will store the cached portions
	 * of the hierarchy.
	 * @var object _tree 
	 * @access protected
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
	 * values is zero, then nothing has been cached in the corresponding direction.<br /><br />
	 * @var array _cache 
	 * @access protected
	 */
	var $_cache;


	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbIndex;

	
	/**
	 * The name of the hierarchy database.
	 * @var string _hierarchyDB 
	 * @access protected
	 */
	var $_hyDB;
	
	
	/**
	 * The id of the hierarchy.
	 * @var string _$hierarchyId 
	 * @access protected
	 */
	var $_hierarchyId;
	
	
	/**
	 * This is a SELECT query that we will often use to get one single
	 * node from the database.
	 * @var object _nodeQuery 
	 * @access protected
	 */
	var $_nodeQuery;
	
	
	/**
	 * This is true if the hierarchy will allow
	 * multiple parents.
	 * @var boolean _allowsMultipleParents 
	 * @access private
	 */
	var $_allowsMultipleParents;


	/**
     * Constructor
	 * @param string hierarchyId The id of the corresponding hierarchy.
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string hyDB The name of the hierarchy database.
     * @access protected
     */
	function HierarchyCache($hierarchyId, $allowsMultipleParents, $dbIndex, $hyDB) {
		// ** parameter validation
		ArgumentValidator::validate($hierarchyId, new StringValidatorRule(), true);
		ArgumentValidator::validate($allowsMultipleParents, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($hyDB, new StringValidatorRule(), true);
		// ** end of parameter validation

		$this->_tree = new Tree();
		$this->_cache = array();
		$this->_dbIndex = $dbIndex;
		$this->_hyDB = $hyDB;
		$this->_hierarchyId = $hierarchyId;
		$this->_allowsMultipleParents = $allowsMultipleParents;

		// initialize a generic SELECT query to fetch one node from the DB
		$db = $this->_hyDB.".";
		$this->_nodeQuery =& new SelectQuery();
		$this->_nodeQuery->addColumn("node_id", "id", $db."node");
		$this->_nodeQuery->addColumn("node_display_name", "display_name", $db."node");
		$this->_nodeQuery->addColumn("node_description", "description", $db."node");
		$this->_nodeQuery->addColumn("fk_hierarchy", "hierarchy_id", $db."node");
		$this->_nodeQuery->addColumn("type_domain", "domain", $db."type");
		$this->_nodeQuery->addColumn("type_authority", "authority", $db."type");
		$this->_nodeQuery->addColumn("type_keyword", "keyword", $db."type");
		$this->_nodeQuery->addColumn("type_description", "type_description", $db."type");
		$this->_nodeQuery->addTable($db."node");
		$this->_nodeQuery->addOrderBy($db."node.node_id");
		$joinc = $db."node.fk_type = ".$db."type.type_id";
		$this->_nodeQuery->addTable($db."type", INNER_JOIN, $joinc);
	}
	
	
	/**
	 * Determines whether a node has been cached down
	 * @see HierarchyCache::_cache
	 * @access private
	 * @param string idValue The string id of the node.
	 * @param integer levels The number of tree levels down to check for caching.
	 * If negative, then cached all the way down.
	 * @return boolean If <code>true</code> then <code>levels</code> number of
	 * levels have been cached down.
	 **/
	function _isCachedDown($idValue, $levels) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		ArgumentValidator::validate($levels, new IntegerValidatorRule(), true);
		// ** end of parameter validation

		if (isset($this->_cache[$idValue]))
			return (($this->_cache[$idValue][1] >= $levels) && ($levels >= 0)) || 
				   ($this->_cache[$idValue][1] < 0);
		else
			return false;
	}


	/**
	 * Determines whether a node has been cached up 
	 * @see  HierarchyCache::_cache
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
			return (($this->_cache[$idValue][2] >= $levels)  && ($levels >= 0)) || 
			       ($this->_cache[$idValue][2] < 0);
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
	 * Makes the first node the parent of the second node.
	 * @access public
	 * @param object parentIdValue The string id of the node to add as a parent.
	 * @param object childIdValue The string id of the child node.
	 * @return void
	 **/
	function addParent($parentIdValue, $childIdValue) {
		// ** parameter validation
		ArgumentValidator::validate($parentIdValue, new StringValidatorRule(), true);
		ArgumentValidator::validate($childIdValue, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		// get the two nodes
		$parent =& $this->getNode($parentIdValue);
		$child =& $this->getNode($childIdValue);
		// the next two calls make sure everything will go smoothly
		// i.e. will help to detect that $parent is not already a parent of $child
		$parent->getChildren();
		$child->getParents();
		$this->traverse($child->getId(), true, -1); // traverse fully down in order to detect cycles
		
		// get the tree nodes
		$parentTreeNode =& $this->_tree->getNode($parentIdValue);
		$childTreeNode =& $this->_tree->getNode($childIdValue);

		// make sure that we are not adding a second parent in a single-parent hierarchy
		if (!$this->_allowsMultipleParents)
			if ($childTreeNode->getParentsCount() > 1)
				throwError(new Error(SINGLE_PARENT_HIERARCHY, "Hierarchy", true));



		// IMPORTANT SPECIAL CASES:

		// A = the number of levels that the parent is cached down
		$A = $this->_cache[$parentIdValue][1];
		// B = the number of levels that the child is cached down
		$B = $this->_cache[$childIdValue][1];
		// if B < A-1 AND B >= 0 then cache down the child A-1 levels
		if (($B < ($A-1)) && ($B >= 0))
			$this->_traverseDown($childIdValue, $A-1);
		// if A < 0 AND B >= 0 then cache down the child fully
		if (($A < 0) && ($B >= 0))
			$this->_traverseDown($childIdValue, -1);

		// the special cases are symmetric when going up
		// A = the number of levels that the child is cached up
		$A = $this->_cache[$childIdValue][2];
		// B = the number of levels that the parent is cached up
		$B = $this->_cache[$parentIdValue][2];
		// if B < A-1 AND B >= 0 then cache up the parent A-1 levels
		if (($B < ($A-1)) && ($B >= 0))
			$this->_traverseUp($parentIdValue, $A-1);
		// if A < 0 AND B >= 0 then cache up the parent fully
		if (($A < 0) && ($B >= 0))
			$this->_traverseUp($parentIdValue, -1);
			
		// now add the new node as a parent
		
		// 1) update the cache
		$this->_tree->addNode($childTreeNode, $parentTreeNode);

		// 2) update the database
		$db = $this->_hyDB.".";
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new InsertQuery();
		$query->setTable($db."j_node_node");
		$columns = array();
		$columns[] = $db."j_node_node.fk_parent";
		$columns[] = $db."j_node_node.fk_child";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($parentIdValue)."'";
		$values[] = "'".addslashes($childIdValue)."'";
		$query->setValues($values);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
	
		if ($queryResult->getNumberOfRows() != 1)
			throwError(new Error("Insert failed.","Hierarchy",true));
	}
	
	
	/**
	 * Removes the first node from the list of parents of the second node.
	 * @access public
	 * @param object parentIdValue The string id of the node to to remove as a parent.
	 * @param object childIdValue The string id of the child node.
	 * @return void
	 **/
	function removeParent($parentIdValue, $childIdValue) {
		// ** parameter validation
		ArgumentValidator::validate($parentIdValue, new StringValidatorRule(), true);
		ArgumentValidator::validate($childIdValue, new StringValidatorRule(), true);
		// ** end of parameter validation
		

		// get the two nodes
		$parent =& $this->getNode($parentIdValue);
		$child =& $this->getNode($childIdValue);
		// the next two calls make sure everything will go smoothly
		// i.e. will help to detect that $parent is indeed a parent of $child

		$parent->getChildren();
		$child->getParents();
		
		// now add remove the parent
		
		// 1) update the cache
		$parentTreeNode =& $this->_tree->getNode($parentIdValue);
		$childTreeNode =& $this->_tree->getNode($childIdValue); 
		$parentTreeNode->detachChild($childTreeNode);

		// 2) update the database
		$db = $this->_hyDB.".";
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new DeleteQuery();
		$query->setTable($db."j_node_node");
		$query->addWhere($db."j_node_node.fk_parent = '".addslashes($parentIdValue)."'");
		$query->addWhere($db."j_node_node.fk_child = '".addslashes($childIdValue)."'");
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1)
			throwError(new Error("Delete failed.","SharedManager",true));
	}
	
		
	/**
	 * Gets node(s) from the database that match the criteria specified by
	 * the given where condition.
	 * @access public
	 * @param string where The where condition that will be used to determine
	 * which nodes to return.
	 * @return ref object An array of HarmoniNode objects.
	 **/
	function &getNodesFromDB($where) {
		// ** parameter validation
		ArgumentValidator::validate($where, new StringValidatorRule(), true);
		// ** end of parameter validation

		$dbHandler =& Services::requireService("DBHandler");

		$this->_nodeQuery->resetWhere();
		$this->_nodeQuery->addWhere($where);
		$this->_nodeQuery->addWhere($db."node.fk_hierarchy = '".addslashes($this->_hierarchyId)."'");

		$nodeQueryResult =& $dbHandler->query($this->_nodeQuery, $this->_dbIndex);
		
		$result = array();

		$shared_manager =& Services::requireService("Shared");

		while ($nodeQueryResult->hasMoreRows()) {
			$nodeRow = $nodeQueryResult->getCurrentRow();
			$idValue =& $nodeRow['id'];
			
			$id =& $shared_manager->getId($idValue);
			$type =& new HarmoniType($nodeRow['domain'], $nodeRow['authority'], 
									  $nodeRow['keyword'], $nodeRow['type_description']);
		    $node =& new HarmoniNode($id, $type, 
									  $nodeRow['display_name'], $nodeRow['description'], $this);
	
			$result[] =& $node;
		
			$nodeQueryResult->advanceRow();
		}
		
		return $result;
	}
	
	
	/**
	 * Returns an array of all nodes in this hierarchy.
	 * @access public
	 * @return ref array An array of all nodes in this hierarchy.
	 **/
	function &getAllNodes() {
		$dbHandler =& Services::requireService("DBHandler");
		$shared_manager =& Services::requireService("Shared");

		$db = $this->_hyDB.".";
		$query =& new SelectQuery();
		$query->addColumn("node_id", "id", $db."node");
		$query->addColumn("node_display_name", "display_name", $db."node");
		$query->addColumn("node_description", "description", $db."node");
		$query->addColumn("type_domain", "domain", $db."type");
		$query->addColumn("type_authority", "authority", $db."type");
		$query->addColumn("type_keyword", "keyword", $db."type");
		$query->addColumn("type_description", "type_description", $db."type");
		$query->addColumn("fk_parent", "parent_id", $db."j_node_node");

		$query->addTable($db."node");
		$joinc = $db."node.fk_type = ".$db."type.type_id";
		$query->addTable($db."type", INNER_JOIN, $joinc);
		$joinc = $db."node.node_id = ".$db."j_node_node.fk_child";
		$query->addTable($db."j_node_node", LEFT_JOIN, $joinc);

		$query->addWhere($db."node.fk_hierarchy = '{$this->_hierarchyId}'");

		$query->addOrderBy($db."node.node_id");
		
		$nodeQueryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$result = array();
		
		// CLEAR THE CACHE
		$this->clearCache();

		while ($nodeQueryResult->hasMoreRows()) {
			$nodeRow = $nodeQueryResult->getCurrentRow();
			$idValue = $nodeRow['id'];
			$parentIdValue = $nodeRow['parent_id'];
			
			// update cache
			// 1) update the tree structure
			// create a TreeNode for the current node, if necessary
			if ($this->_tree->nodeExists($idValue))
				$tn =& $this->_tree->getNode($idValue);
			else
				$tn =& new TreeNode($idValue);
			
			// 2) create a TreeNode for the parent node, if necessary
			if (is_null($parentIdValue)) {
				unset($parent_tn); // this line is very important (without it, the previous 
								// instance of $parent_tn will be reset to null
				$parent_tn = null;
			}
			else if ($this->_tree->nodeExists($parentIdValue))
				$parent_tn =& $this->_tree->getNode($parentIdValue);
			else {
				$parent_tn =& new TreeNode($parentIdValue);
				$this->_tree->addNode($parent_tn);
			}
			// 3) insert child-parent relationship into the tree
			$this->_tree->addNode($tn, $parent_tn);

			// 4) update cache of hierarchy nodes
			$id =& $shared_manager->getId($idValue);
			$type =& new HarmoniType($nodeRow['domain'], $nodeRow['authority'], 
									  $nodeRow['keyword'], $nodeRow['type_description']);
		    $node =& new HarmoniNode($id, $type, 
									  $nodeRow['display_name'], $nodeRow['description'], $this);
			$this->_cache[$idValue][0] =& $node;
			$this->_cache[$idValue][1] = -1;
			$this->_cache[$idValue][2] = -1;
			
			$result[] =& $this->_cache[$idValue][0];
		
			$nodeQueryResult->advanceRow();
		}
		
		return $result;
	}
	
	
	/**
	 * Returns an array of all root nodes in this hierarchy.
	 * @access public
	 * @return ref array An array of all root nodes in this hierarchy.
	 **/
	function &getRootNodes() {
		$dbHandler =& Services::requireService("DBHandler");
		$shared_manager =& Services::requireService("Shared");
		$db = $this->_hyDB.".";

		// copy _nodeQuery into a new object
		$query = $this->_nodeQuery;
		$query->resetWhere();
		$joinc = "{$db}node.node_id = {$db}j_node_node.fk_child";
		$query->addTable("{$db}j_node_node", LEFT_JOIN, $joinc);
		$query->addColumn("fk_child", "join_id", "{$db}j_node_node");
		$query->addWhere($db."node.fk_hierarchy = '{$this->_hierarchyId}'");
		$query->addWhere("ISNULL({$db}j_node_node.fk_child)");
		$query->addOrderBy("fk_child");

//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";

		$nodeQueryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$result = array();

		while ($nodeQueryResult->hasMoreRows()) {
			$nodeRow = $nodeQueryResult->getCurrentRow();
			$idValue =& $nodeRow['id'];
			
			if (!$this->_isCached($idValue)) {
				$id =& $shared_manager->getId($idValue);
				$type =& new HarmoniType($nodeRow['domain'], $nodeRow['authority'], 
										  $nodeRow['keyword'], $nodeRow['type_description']);
			    $node =& new HarmoniNode($id, $type, 
										  $nodeRow['display_name'], $nodeRow['description'], $this);

				// insert node into cache
				$this->_tree->addNode(new TreeNode($idValue));
				$this->_cache[$idValue][0] =& $node;
				$this->_cache[$idValue][1] = 0;
				$this->_cache[$idValue][2] = 0;
			}
			
			$result[] =& $this->_cache[$idValue][0];
		
			$nodeQueryResult->advanceRow();
		}
		
		return $result;
	}
	
	
	

	/**
	 * Returns (and caches if necessary) the node with the specified string id.
	 * @access public
	 * @param string idValue The string id of the node.
	 * @return mixed The corresponding <code>Node</code> object.
	 **/
	function &getNode($idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		// ** end of parameter validation

		// if the node has not been already cached, do it
		if (!$this->_isCached($idValue)) {
			// now fetch the node from the database
			$nodes =& $this->getNodesFromDB($db."node.node_id = '".addslashes($idValue)."'");
			
			// must be only one node
			if (count($nodes) != 1) {
				$str = "Exactly one node must have been returned!";
				throwError(new Error($str, "Hierarchy", true));
			}
			
			$displayName = $nodes[0]->getDisplayName();
//			echo "<br />Creating node # <b>$idValue - '$displayName'</b>";
			
			// insert node into cache
			$this->_tree->addNode(new TreeNode($idValue));
			$this->_cache[$idValue][0] =& $nodes[0];
			$this->_cache[$idValue][1] = 0;
			$this->_cache[$idValue][2] = 0;
		}
		
		// now that all nodes are cached, just return all children
		$result =& $this->_cache[$idValue][0];

		return $result;
	}
	
	
	
	/**
	 * Caches the parents (if not cached already)
	 * of the given node by fecthing them from the database
	 * if neccessary, and then inserting them in <code>_tree</code> and updating
	 * <code>_cache</code>.
	 * @access public
	 * @param object node The node object whose parents we must cache.
	 * @return ref array An array of the parent nodes of the given node.
	 **/
	function &getParents($node) {
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
	
			$db = $this->_hyDB.".";
			$dbHandler =& Services::requireService("DBHandler");
			$shared_manager =& Services::requireService("Shared");
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
			
			$where = $db."child.fk_child = '".addslashes($idValue)."'";
			$query->addWhere($where);
			$query->addOrderBy("node_id");
			
			if (count($nodesToExclude) > 0) {
				$where = implode(", ",array_keys($nodesToExclude));
				$where = $db."parents.node_id NOT IN ({$where})";
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
				$parentIdValue = $row['id'];
				// if not create it and cache it
				if (!$this->_isCached[$parentIdValue]) {
					$parentId =& $shared_manager->getId($parentIdValue);
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
	 * @return ref array An array of the children nodes of the given node.
	 **/
	function &getChildren($node) {
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
	
			$db = $this->_hyDB.".";
			$dbHandler =& Services::requireService("DBHandler");
			$shared_manager =& Services::requireService("Shared");
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
			
			$where = $db."parent.fk_parent = '".addslashes($idValue)."'";
			$query->addWhere($where);
			$query->addOrderBy("node_id");
			
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
					$childId =& $shared_manager->getId($childIdValue);
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
	
	/**
	 * Performs a depth-first pre-order traversal. It either returns the previously cached nodes 
	 * or fetches them from the database and then caches them (depending on whtether
	 * they had been already cached).
	 * @access public
	 * @param object id The id of the node where to start traversal from.
	 * @param boolean down If <code>true</code>, this argument specifies that the traversal will
	 * go down the children; if <code>false</code> then it will go up the parents.
	 * @param integer levels Specifies how many levels of nodes to traverse. If this is negative
	 * then the traversal will go on until the last level is processed.
	 * @return ref array An array of all nodes in the tree visited in a pre-order
	 * manner.
	 **/
	function &traverse(& $id, $down, $levels) {
		// ** parameter validation
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($down, new BooleanValidatorRule(), true);
		ArgumentValidator::validate($levels, new IntegerValidatorRule(), true);
		// ** end of parameter validation
		
		// get the id value
		$idValue = $id->getIdString();

		// see if the nodes have already been cached, if so
		// there is no need to access the database, but if not,
		// then hell yeah, we gotta access the database.
		
		// the manner of traversing if completely different
		// for the 2 directions: therefore, execution splits here
		
		// BIG NOTE: It seems that efficient caching mechanisms with
		// partial fetching of the hierarchy (i.e. traversing with levels > 1)
		// is not feasible. Thus, this method will only take advantage of the cache
		// when traversing all the way down (levels < 0) or when getting the children
		
		// 1) GOING DOWN
		if ($down) {
			// if not cached, fetch from DB and cache!
			if (!$this->_isCachedDown($idValue, $levels))
				$this->_traverseDown($idValue, $levels);
		}
		// 2) GOING UP
		else {
			// if not cached, fetch from DB and cache!
			if (!$this->_isCachedUp($idValue, $levels))
				$this->_traverseUp($idValue, $levels);
		}

		// now that all nodes are cached, return them
		$treeNode =& $this->_tree->getNode($idValue);
		$treeNodes =& $this->_tree->traverse($treeNode, $down, $levels);
		
		$result = array();
		foreach (array_keys($treeNodes) as $i => $key) {
			$node =& $this->_cache[$key][0];
			$result[] =& new HarmoniTraversalInfo($node->getId(),
												  $node->getDisplayName(),
												  $treeNodes[$key][1]);
		}
			
		return new HarmoniTraversalInfoIterator($result);
	}
	
	
	/**
	 * Traverses down and caches whatever needs to be cached.
	 * @access public
	 * @param string idValue The string id of the node to start traversal from.
	 * @param integer levels Specifies how many levels of nodes to traverse. If this is negative
	 * then the traversal will go on until the last level is processed.
	 * @return void
	 **/
	function _traverseDown($idValue, $levels) {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_hyDB.".";
		
		// the original value of levels
		$originalLevels = $levels;
		
//		echo "<br /><br /><br /><b>=== Caching node # $idValue, $levels levels down</b><br />";
		
		// MySQL has a limit of 31 tables in a select query, thus essentially
		// there is a limit to the max value of $levels.
		// if levels > 31 or levels is negative (full traversal)
		// then set it to 31
		if (($levels > 31) || ($levels < 0))
			$levels = 31;
			
		// generate query
		$query->addColumn("fk_parent", "level0_id", "level0");
		$query->addColumn("fk_child",  "level1_id", "level0");
		$query->addTable($db."j_node_node", NO_JOIN, "", "level0");
		$query->addOrderBy("level0_id");
		$query->addOrderBy("level1_id");
		
		// now left join with itself.
		// maximum number of joins is 31, we've used 1 already, so there are 30 left
		for ($level = 1; $level <= $levels-1; $level++) {
			$joinc = "level".($level-1).".fk_child = level".($level).".fk_parent";
			$query->addTable($db."j_node_node", LEFT_JOIN, $joinc, "level".($level));
			$query->addColumn("fk_child", "level".($level+1)."_id", "level".($level));
			$query->addOrderBy("level".($level+1)."_id");
		}
		
		// this is the where clause
		$where = "level0.fk_parent = '".addslashes($idValue)."'";
		$query->addWhere($where);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		// execute the query
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() == 0)
			return;
			
		// note that the query only returns ids of nodes; thus, for each id,
		// we would need to fetch the actual node information from the node table.
		
		// for all rows returned by the query
		while($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
			// check all non-null values in current row
			// see if it is cached, if not create a group object and cache it
				
			for ($level = 0; $level <= $levels; $level++) {
				$nodeId = $row["level{$level}_id"];

				// ignore null values
				if (is_null($nodeId)) {
//					echo "<br />--- skipping to next row (null value encountered)<br />";
				    break;
				}
				
//				echo "<br /><b>Level: $level - Node # $nodeId</b>";

				// if the node has not been cached, then we must create it
//				echo "<br />--- CACHE UPDATE: ";
				if (!$this->_isCached($nodeId)) {
					$nodes =& $this->getNodesFromDB($db."node.node_id = '".addslashes($nodeId)."'");
					
					// must be only one node
					if (count($nodes) != 1) {
						$str = "Exactly one node must have been returned!";
						throwError(new Error($str, "Hierarchy", true));
					}
					
					$displayName = $nodes[0]->getDisplayName();
//					echo "Creating node # <b>$nodeId - '$displayName'</b>, ";

					// insert node into cache
					$this->_cache[$nodeId][0] =& $nodes[0];
					$this->_cache[$nodeId][1] = 0;
					$this->_cache[$nodeId][2] = 0;
				}
//				else
//					echo "Node already in cache, ";
				
				
				// update the levels fetched down, if necessary
				if (($this->_cache[$nodeId][1] >= 0) && 
				    ($this->_cache[$nodeId][1] < ($levels - $level))) {
					$old = $this->_cache[$nodeId][1];
					if ($originalLevels < 0)
						// if fully, then the node is fetched fully as well
						$this->_cache[$nodeId][1] = -1;
					else
						// if not fully, then set the value appropriately
						$this->_cache[$nodeId][1] = $levels - $level;

//					echo "changing level of caching from <b>$old</b> to <b>".$this->_cache[$nodeId][1]."</b>";
				}
//				else
//					echo "no need to set level of caching";
				
				// now, update tree structure
//				echo "<br />--- TREE STRUCTURE UPDATE: ";

				// get the current node (create it, if necessary)
				if ($this->_tree->nodeExists($nodeId))
					$node =& $this->_tree->getNode($nodeId);
				else {
//					echo "Creating new tree node # <b>$nodeId</b>, ";
					$node =& new TreeNode($nodeId);
					$this->_tree->addNode($node);
				}
				
				// does the current node have a parent?
				// if no, there is nothing to update
				if ($level == 0) {
//					echo "Skipping root node, continuing with child";
					continue;
				}
				// if there is a parent, check if it has already been added
				else {
					// get the parent id
					$parentId = $row["level".($level-1)."_id"];
					// get the parent node
					$parent =& $this->_tree->getNode($parentId);
						
					// has the parent been added? if no, add it!
					if (!$node->isParent($parent)) {
//						echo "adding node # <b>$nodeId</b> as a child of node # <b>$parentId</b>";
						$this->_tree->addNode($node, $parent);
					}
//					else
//						echo "already parent";
				}
			}

			$queryResult->advanceRow();
		}
	}
	
	
	
	
	/**
	 * Traverses up and caches whatever needs to be cached.
	 * @access public
	 * @param string idValue The string id of the node to start traversal from.
	 * @param integer levels Specifies how many levels of nodes to traverse. If this is negative
	 * then the traversal will go on until the last level is processed.
	 * @return void
	 **/
	function _traverseUp($idValue, $levels) {
		$dbHandler =& Services::requireService("DBHandler");
		$query =& new SelectQuery();
		
		$db = $this->_hyDB.".";
		
		// the original value of levels
		$originalLevels = $levels;
		
//		echo "<br /><br /><br /><b>=== Caching node # $idValue, $levels levels up</b><br />";

		// MySQL has a limit of 31 tables in a select query, thus essentially
		// there is a limit to the max value of $levels.
		// if levels > 31 or levels is negative (full traversal)
		// then set it to 31
		if (($levels > 31) || ($levels < 0))
			$levels = 31;
			
		// generate query
		$query->addColumn("fk_child", "level0_id", "level0");
		$query->addColumn("fk_parent",  "level1_id", "level0");
		$query->addTable($db."j_node_node", NO_JOIN, "", "level0");
		$query->addOrderBy("level0_id");
		$query->addOrderBy("level1_id");
		
		// now left join with itself.
		// maximum number of joins is 31, we've used 1 already, so there are 30 left
		for ($level = 1; $level <= $levels-1; $level++) {
			$joinc = "level".($level-1).".fk_parent = level".($level).".fk_child";
			$query->addTable($db."j_node_node", LEFT_JOIN, $joinc, "level".($level));
			$query->addColumn("fk_parent", "level".($level+1)."_id", "level".($level));
			$query->addOrderBy("level".($level+1)."_id");
		}
		
		// this is the where clause
		$where = "level0.fk_child = '".addslashes($idValue)."'";
		$query->addWhere($where);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		// execute the query
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() == 0)
			return;
			
		// note that the query only returns ids of nodes; thus, for each id,
		// we would need to fetch the actual node information from the node table.
		
		// for all rows returned by the query
		while($queryResult->hasMoreRows()) {
			$row = $queryResult->getCurrentRow();
			// check all non-null values in current row
			// see if it is cached, if not create a group object and cache it
				
			for ($level = 0; $level <= $levels; $level++) {
				$nodeId = $row["level{$level}_id"];

				// ignore null values
				if (is_null($nodeId)) {
//					echo "<br />--- skipping to next row (null value encountered)<br />";
				    break;
				}
				
//				echo "<br /><b>Level: $level - Node # $nodeId</b>";

				// if the node has not been cached, then we must create it
//				echo "<br />--- CACHE UPDATE: ";
				if (!$this->_isCached($nodeId)) {
					$nodes =& $this->getNodesFromDB($db."node.node_id = '".addslashes($nodeId)."'");
					
					// must be only one node
					if (count($nodes) != 1) {
						$str = "Exactly one node must have been returned!";
						throwError(new Error($str, "Hierarchy", true));
					}
					
					$displayName = $nodes[0]->getDisplayName();
//					echo "Creating node # <b>$nodeId - '$displayName'</b>, ";

					// insert node into cache
					$this->_cache[$nodeId][0] =& $nodes[0];
					$this->_cache[$nodeId][1] = 0;
					$this->_cache[$nodeId][2] = 0;
				}
				else
//					echo "Node already in cache, ";
				
				
				// update the levels fetched up, if necessary
				if (($this->_cache[$nodeId][2] >= 0) && 
				    ($this->_cache[$nodeId][2] < ($levels - $level))) {
					$old = $this->_cache[$nodeId][2];
					if ($originalLevels < 0)
						// if fully, then the node is fetched fully as well
						$this->_cache[$nodeId][2] = -1;
					else
						// if not fully, then set the value appropriately
						$this->_cache[$nodeId][2] = $levels - $level;

//					echo "changing level of caching from <b>$old</b> to <b>".$this->_cache[$nodeId][2]."</b>";
				}
//				else
//					echo "no need to set level of caching";
				
				// now, update tree structure
//				echo "<br />--- TREE STRUCTURE UPDATE: ";

				// get the current node (create it, if necessary)
				if ($this->_tree->nodeExists($nodeId))
					$node =& $this->_tree->getNode($nodeId);
				else {
//					echo "Creating new tree node # <b>$nodeId</b>, ";
					$node =& new TreeNode($nodeId);
					$this->_tree->addNode($node);
				}
				
				// does the current node have a child?
				// if no, there is nothing to update
				if ($level == 0) {
//					echo "Skipping leaf node, continuing with parent";
					continue;
				}
				// if there is a child, check if it has already been added
				else {
					// get the child id
					$childId = $row["level".($level-1)."_id"];
					// get the child node
					$child =& $this->_tree->getNode($childId);
						
					// has the child been added? if no, add it!
					if (!$node->isChild($child)) {
//						echo "adding node # <b>$nodeId</b> as a parent of node # <b>$childId</b>";
						// print_r($child);
						// print_r($node);
						$this->_tree->addNode($child, $node);
					}
//					else
//						echo "already child";
				}
			}

			$queryResult->advanceRow();
		}
	}
	
	
	/**
	 * Attempts to create the specified node as root node in the database.
	 * @access public
	 * @param object nodeId The id of the node.
	 * @param object type The type of the node.
	 * @param string displayName The display name of the node.
	 * @param string description The description of the node.
	 * @return void
	 **/
	function &createRootNode(& $nodeId, & $type, $displayName, $description) {
		// ** parameter validation
		ArgumentValidator::validate($nodeId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"), true);
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($displayName, $stringRule, true);
		ArgumentValidator::validate($description, $stringRule, true);
		// ** end of parameter validation
		
		// check that the node does not exist in the cache
		$idValue =& $nodeId->getIdString();
		if ($this->_isCached($idValue)) {
				$str = "The node has already been cached!";
				throwError(new Error($str, "Hierarchy", true));
		}
		
		// attempt to insert the node now
		$dbHandler =& Services::requireService("DBHandler");
		$db = $this->_hyDB.".";

		// 1. Insert the type
		
		$domain = $type->getDomain();
		$authority = $type->getAuthority();
		$keyword = $type->getKeyword();
		$typeDescription = $type->getDescription();

		// check whether the type is already in the DB, if not insert it
		$query =& new SelectQuery();
		$query->addTable($db."type");
		$query->addColumn("type_id", "id", $db."type");
		$where = $db."type.type_domain = '".addslashes($domain)."'";
		$where .= " AND {$db}type.type_authority = '".addslashes($authority)."'";
		$where .= " AND {$db}type.type_keyword = '".addslashes($keyword)."'";
		$where .= " AND {$db}type.type_description = '".addslashes($typeDescription)."'";
											  
		$query->addWhere($where);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 0) // if the type is already in the database
			$typeIdValue = $queryResult->field("id"); // get the id
		else { // if not, insert it
			$query =& new InsertQuery();
			$query->setTable($db."type");
			$columns = array();
			$columns[] = "type_domain";
			$columns[] = "type_authority";
			$columns[] = "type_keyword";
			$columns[] = "type_description";
			$query->setColumns($columns);
			$values = array();
			$values[] = "'".addslashes($domain)."'";
			$values[] = "'".addslashes($authority)."'";
			$values[] = "'".addslashes($keyword)."'";
			$values[] = "'".addslashes($typeDescription)."'";
			$query->setValues($values);

			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			$typeIdValue = $queryResult->getLastAutoIncrementValue();
		}
		
		// 2. Now that we know the id of the type, insert the node itself
		$query =& new InsertQuery();
		$query->setTable($db."node");
		$columns = array();
		$columns[] = "node_id";
		$columns[] = "node_display_name";
		$columns[] = "node_description";
		$columns[] = "fk_hierarchy";
		$columns[] = "fk_type";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes($displayName)."'";
		$values[] = "'".addslashes($description)."'";
		$values[] = "'".addslashes($this->_hierarchyId)."'";
		$values[] = "'".addslashes($typeIdValue)."'";
		$query->setValues($values);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
				$str = "Could not insert the node (it already exists?)";
				throwError(new Error($str, "Hierarchy", true));
		}
		
		// create the node object to return
		$node =& new HarmoniNode($nodeId, $type, $displayName, $description, $this);
		// then cache it
		$this->_cache[$idValue][0] =& $node;
		$this->_cache[$idValue][1] = -1; // fully cached up and down because
		$this->_cache[$idValue][2] = -1; // in fact this node does not have any ancestors or descendents
		// update _tree
		$this->_tree->addNode(new TreeNode($idValue));
		
		return $node;		
	}
		
	
	/**
	 * Attempts to create the specified node in the database and adds the
	 * specified parent.
	 * @access public
	 * @param object nodeId The id of the node.
	 * @param object parentId The id of the parent.
	 * @param object type The type of the node.
	 * @param string displayName The display name of the node.
	 * @param string description The description of the node.
	 * @return void
	 **/
	function &createNode(& $nodeId, & $parentId, & $type, $displayName, $description) {
		// create the root node and assign the parent
		$node =& $this->createRootNode($nodeId, $type, $displayName, $description);
		$this->addParent($parentId->getIdString(), $nodeId->getIdString());
		
		return $node;
	}
	
	
	/**
	 * Attempts to delete the specified node in the database. Only leaf nodes can
	 * be deleted.
	 * @access public
	 * @param string idValue The string id of the node to delete.
	 * @return void
	 **/
	function deleteNode($idValue) {
		// ** parameter validation
		ArgumentValidator::validate($idValue, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		// get the node
		$node =& $this->getNode($idValue);
		// if not a leaf, cannot delete
		if (!$node->isLeaf()) {
				$str = "Cannon delete non-leaf nodes.";
				throwError(new Error($str, "Hierarchy", true));
		}
		
		// clear the cache and update the _tree structure

		// detach the node from each of its parents and update the join table
		$parents =& $node->getParents();
		while ($parents->hasNext()) {
			$parent =& $parents->next();
			$node->removeParent($parent->getId());
		}
			
		// now delete the tree node
		$treeNode =& $this->_tree->getNode($idValue);
		$this->_tree->deleteNode($treeNode);

		// -----------------		

		// remove from cache
		unset($this->_cache[$idValue]);
		$node = null;

		// now remove from database
		$dbHandler =& Services::requireService("DBHandler");

		// 1. Get the id of the type associated with the node
		$query =& new SelectQuery();
		
		$db = $this->_hyDB.".";
		$query->addTable($db."node");
		$query->addColumn("fk_type", "type_id", $db."node");
		$query->addWhere($db."node.node_id = '".addslashes($idValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() == 0)
			throwError(new Error("The node with Id: ".$idValue." does not exist in the database.","SharedManager",true));
		if ($queryResult->getNumberOfRows() > 1)
			throwError(new Error("Multiple nodes with Id: ".$idValue." exist in the database." ,"SharedManager",true));
		$typeIdValue = $queryResult->field("type_id");
		
		// 2. Now delete the node
		$query =& new DeleteQuery();
		$query->setTable($db."node");
		$query->addWhere($db."node.node_id = '".addslashes($idValue)."'");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// 3. Now see if any other nodes have the same type
		$query =& new SelectQuery();
		
		$db = $this->_hyDB.".";
		$query->addTable($db."node");
		// count the number of nodes using the same type
		$query->addColumn("COUNT({$db}node.fk_type)", "num");
		$query->addWhere($db."node.fk_type = '".addslashes($typeIdValue)."'");

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		$num = $queryResult->field("num");
		if ($num == 0) { // if no other nodes use this type, then delete the type
			$query =& new DeleteQuery();
			$query->setTable($db."type");
			$query->addWhere($db."type.type_id = '".addslashes($typeIdValue)."'");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		}

	}
	
	
	/**
	 * Clears the cache.
	 * @access public
	 **/
	function clearCache() {
		$this->_tree = null;
		$this->_cache = null;
		unset($this->_tree);
		unset($this->_cache);
		$this->HierarchyCache($this->_hierarchyId, $this->_allowsMultipleParents,
							  $this->_dbIndex, $this->_hyDB);
	}

}

?>