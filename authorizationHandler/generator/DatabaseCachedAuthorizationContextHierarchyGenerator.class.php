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
 * @version $Id: DatabaseCachedAuthorizationContextHierarchyGenerator.class.php,v 1.1 2003/07/01 01:55:22 dobomode Exp $
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
	 * The constructor takes a database connection index (as returned by the DBHandler
	 * service) and returns a new DatabaseAuthorizationContextHierarchyGenerator object.
	 * @access public
	 */
	function DatabaseCachedAuthorizationContextHierarchyGenerator($dbIndex) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
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
	 * @param optional string id_column The name of the column that contains the system
	 * id of the context units.
	 * @param optional string FK_column The name of the column that contains the foreign
	 * key to the parent context (which could or could not be in the same table).
	 * @return integer The depth of the level that was just added.
	 */
	function addContextHierarchyLevel($table, $id_column = "", $FK_column = "") {
	}
	
	
	
	/**
	 * Generates the whole context hierarchy tree.
	 * @method public generateTree
	 * @return array An <code>h</code>-dimensional array, where <code>h</code> is the height
	 * of the context hierarchy. Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy depth.
	 *
	function generateTree() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	*/
	
	/**
	 * Generates the subtree rooted at the specified context.
	 * @method public generateSubtree
	 * @param integer hierarchyDepth The depth of the root context.
	 * @param integer systemId  The system id of the root context.
	 * @return array An <code>(h-1)</code>-dimensional array, where <code>h</code> is the height
	 * of the subtree. The root itself, is not included.
	 * Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy depth.
	 */
	function generateSubtree($hierarchyDepth, $systemId) {
		return "";
	}
	
	
	/**
	 * Returns all the ancestors of a given context.
	 * @method public getAncestors
	 * @param integer hierarchyDepth The depth of the context.
	 * @param integer systemId  The system id of the context.
	 * @return array An array of all the ancestors of the given context. The keys
	 * of the array coincide with the hierarchy depth of each ancestor. 
	 * Each element is the system id of the ancestor.
	 */
	function getAncestors($hierarchyDepth, $systemId) {
		return "";
	}
	

}


?>