<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyGenerator.interface.php");

/** 
 * A database implementation of the AuthorizationContextHierarchyGeneratorInterface.
 * The implementation takes a database connection index (as returned by the DBHandler
 * service). The user has to call continously the
 * <code>addContextHierarchyLevel</code> method to setup all the possible levels of the context
 * hierarchy. Subsequently, the user (or rather - the authorization method)
 * can call any of the three interface methods to generate the necessary 
 * hierarchical information.
 * 
 * @access public
 * @version $Id: DatabaseAuthorizationContextHierarchyGenerator.class.php,v 1.7 2003/07/10 02:34:20 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/30/2003
 * @package harmoni.authorization.generator
 */
class DatabaseAuthorizationContextHierarchyGenerator 
					extends AuthorizationContextHierarchyGeneratorInterface {


	/**
	 * The database connection index (as returned by the DBHandler
	 * service) for this generator.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;
	
					
	/**
	 * This array member variable stores all the hierarchy levels.
	 * Each element of the array stores an array that has three things included:
	 * the database table name, the id column name, and the foreign key column name.
	 * @see {@link DatabaseAuthorizationContextHierarchyGenerator::addContextHierarchyLevel}
	 * @attribute private array _levels
	 */
	var $_levels;
	


	
	/**
	 * This variable will store cached information about the hierarchy. This is
	 * an AuthorizationContextHierarchy object. If a node is in this cache, then
	 * that means that all its ancestors have been cached as well.
	 * @attribute private object _cache
	 */
	var $_cacheUp;
	


	
	/**
	 * This variable will store cached information about the hierarchy. This is
	 * an AuthorizationContextHierarchy object. If a node is in this cache, then
	 * that means that all its descendents (i.e., the subtree rooted at that node)
	 * have been cached as well.
	 * @attribute private object _cache
	 */
	var $_cacheDown;
	
	
					
	/**
	 * The constructor takes a database connection index (as returned by the DBHandler
	 * service) and returns a new DatabaseAuthorizationContextHierarchyGenerator object.
	 * @param integer dbIndex The database connection index.
	 * @access public
	 */
	function DatabaseAuthorizationContextHierarchyGenerator($dbIndex) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_levels = array();
		$this->_cacheUp =& new AuthorizationContextHierarchy();
		$this->_cacheDown =& new AuthorizationContextHierarchy();
	}
					
					
	
	/**
	 * Adds a new hierarchy level at the bottom of the context hierarchy. This method
	 * is passed a table, and two column names. One of the columns is the foreign
	 * key to the table that was specified with the previous call to
	 * <code>addContextDepth()</code>.<br><br>
	 * <b>The first time this method is called, only <code>$table</code> should be specified.</b>
	 * @method public addContextDepth
	 * @param string table The name of the database table that contains the
	 * context units at this depth.
	 * @param string id_column The name of the column that contains the system
	 * id of the context units.
	 * @param optional string FK_column The name of the column that contains the foreign
	 * key to the parent context (which could or could not be in the same table).
	 * @return integer The depth of the level that was just added.
	 */
	function addContextHierarchyLevel($table, $id_column, $FK_column = "") {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($table, $stringRule, true);
		ArgumentValidator::validate($id_column, $stringRule, true);
		ArgumentValidator::validate($FK_column, $stringRule, true);
		// ** end of parameter validation
		
		// clear the cache
		$this->clearCache();

		$level = array($table, $id_column, $FK_column);
		$this->_levels[] = $level;
		
		return (count($this->_levels) - 1);
	}
	
	
	
	/**
	 * Generates the whole context hierarchy tree. This method is probably not
	 * going to be very useful, but is included in any case.
	 * @method public generateTree
	 * @return array An <code>2</code>-dimensional array.
	 * Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy depth.
	 */
	function generateTree() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * An auxilliary private function for the generateSubtree() method that will
	 * return all the nodes that are to be excluded from the SELECT query.
	 * @method public _getNodesToExcludeDown
	 * @return ref array An array whose keys specify the hierarchy level of the 
	 * nodes. Each element of the array is another array storing the system ids
	 * of the nodes.
	 */
	function & _getNodesToExcludeDown($hierarchyLevel, $systemId) {
		$result = array();
		 
	 	// get all nodes in $cacheDown
	 	$nodesDown = array();
		$nodesDown =& $this->_cacheDown->getRoots();
	
		// now add whatever is in $nodesDown to $result
		foreach (array_keys($nodesDown) as $i => $key) {
			$node =& $nodesDown[$key];
			$depth = $node->getDepth();
			$id = $node->getSystemId();
			$result[$depth][] = $id;
		}
	
		return $result;
	}
	
	
	
	
	/**
	 * Generates the subtree rooted at the specified context. This method is
	 * cached. In other words, if the same subtree (or part of the subtree)
	 * is requested several times, only the first call will access the database,
	 * while the other calls will read the information from a cached ContextHierarchy
	 * object.
	 * @method public generateSubtree
	 * @param integer hierarchyLevel The level of the root context.
	 * @param integer systemId  The system id of the root context.
	 * @return array A <code>2</code>-dimensional array.
	 * Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy level. The root itself, is not included.
	 * Thus the indexing of the array starts from <code>l+1</code> where <code>l</code>
	 * is the hierarchy level of the root.
	 * Returns null if something went wrong.
	 */
	function generateSubtree($hierarchyLevel, $systemId) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($hierarchyLevel, $integerRule, true);
		ArgumentValidator::validate($systemId, $integerRule, true);
		// ** end of parameter validation
		
		if ($hierarchyLevel < 0 || $hierarchyLevel > $this->getHierarchyHeight() - 1) {
			$str = "\$hierarchyLevel is outside the possible range; cannot ";
			$str .= "generate subtree.";
		    throw(new Error($str, "AuthorizationHandler", true));
			return null;
		}

		// if this is the last level, then just return an empty array: there
		// is no subtree.
		if ($hierarchyLevel == $this->getHierarchyHeight() - 1)
			return array();


		/***************************************************************/			

		// this will store the result
		$result = array();
		
		// special case: the root has already been cached
		// then just return the cached subtree		
		if ($this->_cacheDown->nodeExists($hierarchyLevel, $systemId)) {
			$root =& $this->_cacheDown->getNodeAtLevel($hierarchyLevel, $systemId);
			$result =& $this->_cacheDown->getSubtree($root);
			return $result;
		}

		// get nodes that have been already cached and to be excluded from
		// the select query
		$nodesToExclude =& $this->_getNodesToExcludeDown($hierarchyLevel, $systemId);

		// create an appropriate query and fetch the information from the
		// database
		$query = new SelectQuery();

		// process the first level	
		$level = $this->_levels[$hierarchyLevel];
		// select from the first level (this will be needed for the where condition)
		$query->addTable($level[0]);
		// set where condition (only get subtree for $systemId)
		$query->addWhere($level[1]." = ".$systemId);

		// process the other levels
		for($key = $hierarchyLevel + 1; $key < $this->getHierarchyHeight(); $key++) {
			$level = $this->_levels[$key];
			$previousLevel = $this->_levels[$key - 1];

			$joinCondition = "";
			$joinCondition .= $level[2]." = ".$previousLevel[1];

			// now the nodes to exclude
			foreach ($nodesToExclude[$key - 1] as $id) {
				$joinCondition .= "\n\t\tAND ";
				$joinCondition .= $level[2]." <> ".$id;
			}

			// make a LEFT JOIN between the previous and this level
			$query->addTable($level[0], LEFT_JOIN, $joinCondition);
			
			// select the id column of this level
			$query->addColumn($level[1], "", $level[0]);

			// set order by
			$query->addOrderBy($level[1]);
		}
		
		// follows, some debugging stuff
		echo "<pre>";
		echo MySQL_SQLGenerator::generateSQLQuery($query);
		echo "</pre>";

		// now, execute the query
		Services::requireService("DBHandler");
		$dbHandler =& Services::getService("DBHandler");
		$dbResult =& $dbHandler->query($query, $this->_dbIndex);

		
		if ($dbResult === null) {
			$str = "Query failed. Possible invalid configuration of the HierarchyGenerator object.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		if ($dbResult->getNumberOfRows() < 1) {
			$str = "Query did not return any rows. ";
			$str .= "Possible invalid configuration of the HierarchyGenerator object.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		// the query will return something like this:
		// +------------+---------+
		// | section_id | page_id |
		// +------------+---------+
		// |        251 |     811 |
		// |        251 |     812 |
		// |        251 |     813 |
		// |        252 |     814 |
		// +------------+---------+
		// each column in the result has to go in an array ano NO values should
		// repeat. For the example, above, the method should return:
		//
		// $result = array();
		// $result[0] = array(251, 252);
		// $result[1] = array(811, 812, 813, 814);

		// fill the values of $result, and cache it, so that next time we request 
		// this information, we don't have to query the database

		$root =& new AuthorizationContextHierarchyNode($systemId, $hierarchyLevel);
	    $this->_cacheDown->addNode($root);
			
		$numFields = $dbResult->getNumberOfFields();
		// for all rows returned by the query
		while($dbResult->hasMoreRows()) {
			// add all nodes to $result
			for ($fieldIndex = 0; $fieldIndex < $numFields; $fieldIndex++) {
				$level = $fieldIndex + $hierarchyLevel + 1;

				$value = $dbResult->field($fieldIndex);
				// ignore null values
				if (is_null($value))
				    continue;
				$value = intval($value);

				// if we haven't put the value already in the array, then do it
				if (!in_array($value, $result[$level])) {
					// put in $result
				    $result[$level][] = $value;

					// this will be its parent
					if ($fieldIndex == 0)
						$parent =& $root;
					else
						$parent =& $this->_cacheDown->getNodeAtLevel($level - 1, 
    									intval($dbResult->field($fieldIndex - 1)));

					// need to add this node					
					if ($this->_cacheDown->nodeExists($level, $value)) {
					    $node =& $this->_cacheDown->getNodeAtLevel($level, $value);
					    $parent->addChild($node);
					}
					else {
						$node =& new AuthorizationContextHierarchyNode($value, $level);
						$this->_cacheDown->addNode($node, $parent);
					}
				}
			}

			$dbResult->advanceRow();
		}
		
		$result =& $this->_cacheDown->getSubtree($root);
		
		return $result;
	}
	
	
	
	
	/**
	 * Returns all the ancestors of a given context. It is non-trivial and not
	 * feasible to make this method cached. For this reason, it always queries
	 * the database.
	 * @method public getAncestors
	 * @param integer hierarchyLevel The level of the context.
	 * @param integer systemId  The system id of the context.
	 * @return array An array of all the ancestors of the given context. The keys
	 * of the array coincide with the hierarchy depth of each ancestor. 
	 * Each element is the system id of the ancestor.
	 */
	function getAncestors($hierarchyLevel, $systemId) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($hierarchyLevel, $integerRule, true);
		ArgumentValidator::validate($systemId, $integerRule, true);
		// ** end of parameter validation
		
		if ($hierarchyLevel < 0 || $hierarchyLevel > $this->getHierarchyHeight() - 1) {
			$str = "\$hierarchyLevel is outside the possible range; cannot ";
			$str .= "generate subtree.";
		    throw(new Error($str, "AuthorizationHandler", true));
			return null;
		}

		// if this is the first level, then just return an empty array: there
		// are no ancestors.
		if ($hierarchyLevel == 0)
			return array();

		
		/***************************************************************/			

		// this will store the result
		$result = array();
		
		// special case: the node has already been cached
		// then just return the cached ancestors
		if ($this->_cacheUp->nodeExists($hierarchyLevel, $systemId)) {
			$root =& $this->_cacheUp->getNodeAtLevel($hierarchyLevel, $systemId);
			$result =& $this->_cacheUp->getAncestors($root);
			return $result;
		}

		// create an appropriate query and fetch the information from the
		// database
		$query = new SelectQuery();

		// process the specified level
		$level = $this->_levels[$hierarchyLevel];
		// select from the first level (this will be needed for the where condition)
		$query->addTable($level[0]);
		// set where condition (only get subtree for $systemId)
		$query->setWhere($level[1]." = ".$systemId);

		// process the other levels
		for($key = $hierarchyLevel - 1; $key >= 0; $key--) {
			$level = $this->_levels[$key];
			$previousLevel = $this->_levels[$key + 1];

			// make an INNER JOIN between the previous and this level
			$query->addTable($level[0], INNER_JOIN, $previousLevel[2]." = ".$level[1]);

			// select the id column of this level
			$query->addColumn($level[1]);
		}
		
		// follows, some debugging stuff
		//echo "<pre>";
		//echo MySQL_SQLGenerator::generateSQLQuery($query);
		//echo "</pre>";
		
		// now, execute the query
		Services::requireService("DBHandler");
		$dbHandler =& Services::getService("DBHandler");
		$dbResult =& $dbHandler->query($query, $this->_dbIndex);

		
		if ($dbResult === null) {
			$str = "Query failed. Possible invalid configuration of the HierarchyGenerator object.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		if ($dbResult->getNumberOfRows() < 1) {
			$str = "Query did not return any rows. ";
			$str .= "Possible invalid configuration of the HierarchyGenerator object.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}

		// there should be a unique path from the specified context to the 
		// top level. Error, if more than one rows were returned.
		if ($dbResult->getNumberOfRows() > 1) {
			$str = "Query returned more than one rows. ";
			$str .= "Possible invalid database hierarchy.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}
		    
		// fill the result array
		$numFields = $dbResult->getNumberOfFields();
		for ($fieldIndex = $numFields - 1; $fieldIndex >= 0; $fieldIndex--) {
			$level = $hierarchyLevel - ($fieldIndex + 1);
			$value = $dbResult->field($fieldIndex);
			
			// null values are bad
			if (is_null($value)) {
				$str = "";	
				$str .= "NULL returned by SELECT query. ";
				$str .= "Possible invalid configuration of the HierarchyGenerator object.";
			    throw(new Error($str, "AuthorizationHandler", true));
			}
			$value = intval($value);
			
			// this will be its parent
			if ($fieldIndex == $numFields - 1)
				$parent = null;
			else
				$parent =& $this->_cacheUp->getNodeAtLevel($level - 1,
  									intval($dbResult->field($fieldIndex + 1)));
						
			// need to add this node if not added already
			if (!$this->_cacheUp->nodeExists($level, $value)) {
				$node =& new AuthorizationContextHierarchyNode($value, $level);
				$this->_cacheUp->addNode($node, $parent);
			}
			
		}

		// finally, add the original node
		$root =& new AuthorizationContextHierarchyNode($systemId, $hierarchyLevel);
		$parentId = intval($dbResult->field(0));
		$parent =& $this->_cacheUp->getNodeAtLevel($hierarchyLevel - 1, $parentId);
	    $this->_cacheUp->addNode($root, $parent);

		// get result from cache
		$result =& $this->_cacheUp->getAncestors($root);
					
		return $result;
	}
	


	/**
	 * Clears the hierarchy cache. You should call this function, whenever the
	 * hierarchy structure has changed on whatever media is used (i.e., the
	 * database has been updated). This gets called automatically by
	 * addContextHierarchyLevel().
	 * 
	 * @method public clearCache
	 * @return void 
	 */
	function clearCache() {
		unset($this->_cacheUp);
		unset($this->_cacheDown);
		$this->_cacheUp =& new AuthorizationContextHierarchy();
		$this->_cacheDown =& new AuthorizationContextHierarchy();
	}
	

	/**
	 * Returns the height of the hierarchy for this generator.
	 * @method public getHeight
	 * @return integer The height of the hierarchy.
	 */
	function getHierarchyHeight() {
		return count($this->_levels);
	}
	

}


?>