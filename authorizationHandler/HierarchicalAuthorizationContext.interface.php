<?php

require_once(HARMONI."authorizationHandler/AuthorizationContext.interface.php");

/** 
 * An extension of the generic authorization context to support hierarchical
 * authorization schemes. A hierarchical authorization structure resembles a tree structure - a certain
 * unit described by an authorization context can have zero or one parents and 
 * zero or more children. The unit inherits permissions from its parent unit.
 * Similarly, all its children inherit from its permissions. The hierarchical
 * authorization context adds one property:
 * <br><br>
 * The <b>hierarchy level</b> narrows the location within the subsystem to a specific
 * level in the hierarchy. For example, in the 'segue' system and 'siteunit' subsystem,
 * the hierarchy level could be either 0, 1, 2, or 3. These would correspond to 'site', 
 * 'section', 'page', and 'story'. The hierarchy level is always 0 for the topmost
 * level and goes up to <code>h - 1</code>, where <code>h</code> is the height of
 * the tree structure.
 * <br><br>
 * Thus, in a hierarchical authorization scheme, four things need to be specified
 * in order to define the context in which authorization is to be performed:
 * <br>
 * <b>system -> subsystem -> hierarchy level -> context system id</b>
 * 
 * 
 * @access public
 * @version $Id: HierarchicalAuthorizationContext.interface.php,v 1.4 2003/07/10 02:34:20 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorization
 */
class HierarchicalAuthorizationContextInterface extends AuthorizationContextInterface {

	/**
	 * Returns the hierarchy level of this authorization context.
	 * <br><br>
	 * The <b>hierarchy level</b> narrows the location within the subsystem to a specific
	 * level in the hierarchy. For example, in the 'segue' system and 'siteunit' subsystem,
	 * the hierarchy level could be either 0, 1, 2, or 3. These would correspond to 'site', 
	 * 'section', 'page', and 'story'. The hierarchy level is always 0 for the topmost
	 * level and goes up to <code>h - 1</code>, where <code>h</code> is the height of
	 * the tree structure.
	 * @method public getHierarchyLevel
	 * @return string The hierarchy level of this authorization context.
	 */
	function getHierarchyLevel() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

}


?>