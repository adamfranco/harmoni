<?php

/** 
 * Defines the functionallity of a generic authorization context, one of the three
 * authorization components. An authorization context describes the 
 * context in which the authorization function will be authorized. It stores
 * several properties:
 * <br><br>
 * The <b>system name</b> narrows the location on a high level. For example,
 * this could be the application name, i.e. 'segue'.
 * <br><br>
 * The <b>subsystem name</b> narrows the location within the specific system. For
 * example, in the 'segue' system, we could have two subsystems: 'siteunit' subsystem
 * dealing with user permissions of site, section, page, and story objects, and a
 * 'discussion' subsystem dealing with discussion permissions of users within a specific
 * story.
 * <br><br>
 * The context <b>id</b> narrows the location to a specific unit in the subsystem, which we are trying
 * to authorize. For example, this could be a primary key in a database table. Note that
 * the id is not restricted to just numeric values.
 * @access public
 * @version $Id: AuthorizationContext.interface.php,v 1.1 2003/06/30 03:08:32 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class AuhtorizationContextInterface {

	/**
	 * Returns the system name of this authorization context.
	 * @method public getSystem
	 * @return string The system name of this authorization context.
	 */
	function getSystem() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the subsystem name of this authorization context.
	 * @method public getSubsystem
	 * @return string The subsystem name of this authorization context.
	 */
	function getSubsystem() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the id of this authorization context.
	 * @method public getId
	 * @return string The id of this authorization context.
	 */
	function getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}


?>