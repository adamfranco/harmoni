<?php

/** 
 * Defines the functionallity of an authorization function, one of the three
 * authorization components. An authorization function describes the action that
 * is to be authorized and has only one property, namely its name.
 * @access public
 * @version $Id: AuthorizationFunction.interface.php,v 1.1 2003/06/30 03:08:32 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class AuhtorizationFunctionInterface {


	/**
	 * Returns the name of this authorization function. The name is a unique
	 * string.
	 * @method public getName
	 * @return string The name of this authorization function. 
	 */
	function getName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}


?>