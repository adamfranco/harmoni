<?php

require_once(HARMONI."authorizationHandler/AuthorizationContextHierarchyGenerator.interface.php");

/** 
 * A database implementation of the AuthorizationContextHierarchyGeneratorInterface.
 * The implementation takes a database connection index (as returned by the DBHandler
 * service), a system, and a subsystem. The user has to call continously the
 * addContextDepth method to setup all the possible levels of the context
 * hierarchy. Subsequently, the user (or rather - the authorization method)
 * can call any of the three interface methods to generate the necessary 
 * hierarchical information.
 * 
 * @access public
 * @version $Id: AuthorizationContextHierarchyGenerator.class.php,v 1.1 2003/06/30 20:41:44 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/30/2003
 * @package harmoni.authorizationHandler
 */
class DatabaseAuthorizationContextHierarchyGenerator 
					extends AuthorizationContextHierarchyGeneratorInterface {


	/**
	 * The constructor takes a database connection index (as returned by the DBHandler
	 * service), a system, and a subsystem; and returns a new
	 * DatabaseAuthorizationContextHierarchyGenerator object.
	 * @access public
	 */
	function DatabaseAuthorizationContextHierarchyGenerator($dbIndex, $system, $subsystem) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		ArgumentValidator::validate($system, $stringRule, true);
		ArgumentValidator::validate($subsystem, $stringRule, true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_system = $system;
		$this->_subsystem = $subsystem;
	}
					
	/**
	 * Generates the whole context hierarchy tree.
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
	 * @param integer hierarchyDepth The depth of the root context.
	 * @param integer systemId  The system id of the root context.
	 * @return array An <code>(h-1)</code>-dimensional array, where <code>h</code> is the height
	 * of the subtree. The root itself, is not included.
	 * Each element of the array is another array containing the
	 * system ids of all contexts on that hierarchy depth.
	 */
	function generateSubtree($hierarchyDepth, $systemId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

}


?>