<?php

require_once(HARMONI."authorizationHandler/generator/CachedAuthorizationContextHierarchyGenerator.interface.php");

/** 
 * A database implementation of the AuthorizationContextHierarchyGeneratorInterface.
 * The implementation takes a database connection index (as returned by the DBHandler
 * service). The user has to call continously the
 * addContextDepth method to setup all the possible levels of the context
 * hierarchy. Subsequently, the user (or rather - the authorization method)
 * can call any of the three interface methods to generate the necessary 
 * hierarchical information.
 * 
 * @access public
 * @version $Id: DatabaseCachedAuthorizationContextHierarchyGenerator.class.php,v 1.4 2003/07/03 01:34:14 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/30/2003
 * @package harmoni.authorizationHandler
 */
class DatabaseCachedAuthorizationContextHierarchyGenerator 
					extends CachedAuthorizationContextHierarchyGeneratorInterface {


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
	 * @see {@link DatabaseCachedAuthorizationContextHierarchyGenerator::addContextHierarchyLevel}
	 * @attribute private array _levels
	 */
	var $_levels;
	
	
					
	/**
	 * The constructor takes a database connection index (as returned by the DBHandler
	 * service) and returns a new DatabaseAuthorizationContextHierarchyGenerator object.
	 * @param integer dbIndex The database connection index.
	 * @access public
	 */
	function DatabaseCachedAuthorizationContextHierarchyGenerator($dbIndex) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_levels = array();
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
		
		$level = array($table, $id_column, $FK_column);
		$this->_levels[] = $level;
		
		return (count($this->_levels) - 1);
	}
	
	
	
	/**
	 * Generates the whole context hierarchy tree. This method is probably not
	 * going to be very useful, but is included in any case.
	 * @method public generateTree
	 * @return array An <code>h</code>-dimensional array, where <code>h</code> is the height
	 * of the context hierarchy. Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy depth.
	 */
	function generateTree() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	
	/**
	 * Generates the subtree rooted at the specified context.
	 * @method public generateSubtree
	 * @param integer hierarchyLevel The level of the root context.
	 * @param integer systemId  The system id of the root context.
	 * @return array An <code>(h-1)</code>-dimensional array, where <code>h</code> is the height
	 * of the subtree. Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy level. The root itself, is not included.
	 * Thus the indexing of the array starts from <code>l+1</code> where <code>l</code>
	 * is the level of the root.
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

		
		// create an appropriate query and fetch the information from the
		// database
		$query = new SelectQuery();

		// process the first level	
		$level = $this->_levels[$hierarchyLevel];
		// select from the first level (this will be needed for the where condition)
		$query->addTable($level[0]);
		// set where condition (only get subtree for $systemId)
		$query->setWhere($level[1]." = ".$systemId);

		// process the other levels
		for($key = $hierarchyLevel + 1; $key < $this->getHierarchyHeight(); $key++) {
			$level = $this->_levels[$key];
			$previousLevel = $this->_levels[$key - 1];

			// make a LEFT JOIN between the previous and this level
			$query->addTable($level[0], LEFT_JOIN, $level[2]." = ".$previousLevel[1]);

			// select the id column of this level
			$query->addColumn($level[1]);

			// set order by
			$query->addOrderBy($level[1]);
		}
		
		// follow, some debugging stuff
		// echo "<pre>";
		// echo MySQL_SQLGenerator::generateSQLQuery($query);
		// echo "</pre>";

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

		$result = array();
		$numFields = $dbResult->getNumberOfFields();
		while($dbResult->hasMoreRows()) {
			for ($i = 0; $i < $numFields; $i++) {
				$value = $dbResult->field($i);
				// if we haven't put the value already in the array, then do it
				if (!in_array($value, $result[$i + $hierarchyLevel + 1]))
				    $result[$i + $hierarchyLevel + 1][] = $value;
			}

			$dbResult->advanceRow();
		}

		return $result;
	}
	
	
	/**
	 * Returns all the ancestors of a given context.
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
		
		// follow, some debugging stuff
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

		// there should be a unique path from the specified context to the 
		// top level. Error, if more than one rows were returned.
		if ($dbResult->getNumberOfRows() > 1) {
			$str = "Query returned more than one rows. ";
			$str .= "Possible invalid database hierarchy.";
		    throw(new Error($str, "AuthorizationHandler", true));
		}
		    
		// fill the result array
		$result = array();
		$numFields = $dbResult->getNumberOfFields();
		for ($i = 0; $i < $numFields; $i++) {
			$value = $dbResult->field($i);
		    $result[$hierarchyLevel - ($i + 1)] = $value;
		}

		return $result;		
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