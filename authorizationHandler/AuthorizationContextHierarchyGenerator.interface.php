<?php

/** 
 * Defines the functionallity of an AuthorizationContextHierarchyGenerator.
 * The necessity of such an interface is dictated by the fact that the
 * authorization hierarchy is quite independent of the authorization methods.
 * For example, an application might store the hierarchy on a file system, but
 * use a database authorization method. The interface abstracts the concept
 * of an authorization hierarchy. Consequently, by passing a 
 * AuthorizationContextHierarchyGenerator to an authorization method, the method will
 * not have to care about the way the hierarchy is stored and/or retrieved.
 * 
 * @access public
 * @version $Id: AuthorizationContextHierarchyGenerator.interface.php,v 1.1 2003/06/30 20:41:44 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/30/2003
 * @package harmoni.authorizationHandler
 */
class AuthorizationContextHierarchyGeneratorInterface {


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