<?php

/** 
 * Defines the functionallity of a CachedAuthorizationContextHierarchyGenerator.
 * The necessity of such an interface is dictated by the fact that the
 * authorization hierarchy is quite independent of the authorization methods.
 * For example, an application might store the hierarchy on a file system, but
 * use a database authorization method. The interface abstracts the concept
 * of an authorization hierarchy. Consequently, by passing a 
 * AuthorizationContextHierarchyGenerator to an authorization method, the method will
 * not have to care about the way the hierarchy is stored and/or retrieved.
 * 
 * @access public
 * @version $Id: AuthorizationContextHierarchyGenerator.interface.php,v 1.3 2003/08/06 22:32:40 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/30/2003
 * @package harmoni.interfaces.authorization.generator
 */
class AuthorizationContextHierarchyGeneratorInterface {


	
					
	
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	 * Generates the subtree rooted at the specified context.
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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