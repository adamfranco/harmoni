<?php

/** 
 * Defines the functionallity of a generic authorization context, one of the three
 * authorization components. An authorization context describes the 
 * context in which the authorization function will be authorized. It stores
 * several properties:
 * <br><br>
 * The <b>system</b> narrows the location on a high level. For example,
 * this could be the application name, i.e. 'segue'.
 * <br><br>
 * The <b>subsystem</b> narrows the location within the specific system. For
 * example, in the 'segue' system, we could have two subsystems: 'siteunit' subsystem
 * dealing with user permissions of site, section, page, and story objects, and a
 * 'discussion' subsystem dealing with discussion permissions of users within a specific
 * story.
 * <br><br>
 * The <b>system id</b> narrows the location to a specific unit in the subsystem, which we are trying
 * to authorize. For example, this could be a primary key in a database table.
 * @access public
 * @version $Id: AuthorizationContext.interface.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.interfaces.authorization
 */
class AuthorizationContextInterface {

	/**
	 * Returns the system of this authorization context.
	 * The <b>system</b> narrows the location on a high level. For example,
	 * this could be the application name, i.e. 'segue'.
	 * @method public getSystem
	 * @return string The system of this authorization context.
	 */
	function getSystem() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the subsystem of this authorization context.
	 * <br><br>
	 * The <b>subsystem</b> narrows the location within the specific system. For
	 * example, in the 'segue' system, we could have two subsystems: 'siteunit' subsystem
	 * dealing with user permissions of site, section, page, and story objects, and a
	 * 'discussion' subsystem dealing with discussion permissions of users within a specific
	 * story.
	 * @method public getSubsystem
	 * @return string The subsystem of this authorization context.
	 */
	function getSubsystem() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * <br><br>
	 * The <b>system id</b> narrows the location to a specific unit in the subsystem, which we are trying
	 * to authorize. For example, this could be a primary key in a database table.
	 * Returns the system id of this authorization context.
	 * @method public getSystemId
	 * @return string The system id of this authorization context.
	 */
	function getSystemId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}


?>