<?php

require_once("AuthorizationContext.interface.php");


/** 
 * An extension of the generic authorization context to support hierarchical
 * authorization schemes. A hierarchical authorization structure resembles a tree structure - a certain
 * unit described by an authorization context can have zero or one parents and 
 * zero or more children. The unit inherits permissions from its parent unit.
 * Similarly, all its children inherit from its permissions. The hierarchical
 * authorization context adds the following property:
 * <br><br>
 * The <b>hierarchy depth</b> narrows the location within the subsystem to a specific
 * level in the hierarchy.
 * <br><br>
 * Thus, in a hierarchical authorization scheme, four things need to be specified
 * in order to define the context in which authorization is to be performed:
 * <br>
 * <b>system -> subsystem -> hierarchy depth -> context id</b>
 * 
 * 
 * @access public
 * @version $Id: HierarchicalAuthorizationContext.interface.php,v 1.1 2003/06/30 03:08:32 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class HierarchicalAuhtorizationContextInterface extends AuhtorizationContextInterface {

	/**
	 * Returns the hierarchy depth of this authorization context.
	 * @method public getHierarchyDepth
	 * @return string The hierarchy depth of this authorization context.
	 */
	function getHierarchyDepth() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}


?>