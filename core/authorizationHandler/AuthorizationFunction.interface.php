<?php

/** 
 * Defines the functionallity of an authorization function, one of the three
 * authorization components. An authorization function describes the action that
 * is to be authorized. It has two properties:
 * <br><br>
 * The <b>system id</b> is a system-specific unique numeric id of the function.
 * <br><br>
 * The <b>system name</b> is a system-specific unique name of the function.
 * @access public
 * @version $Id: AuthorizationFunction.interface.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.interfaces.authorization
 */
class AuthorizationFunctionInterface {


	/**
	 * Returns the system id of this function.
	 * <br><br>
	 * The <b>system id</b> is a system-specific unique numeric id of the function.
	 * @method public getSystemId
	 * @return integer The system id of this function.
	 */
	function getSystemId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the system name of this authorization function.
	 * <br><br>
	 * The <b>system name</b> is a system-specific unique name of the function.
	 * @method public getSystemName
	 * @return string The system name of this authorization function. 
	 */
	function getSystemName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}


?>