<?php

require_once(HARMONI.'authorizationHandler/AuthorizationFunction.interface.php');

/** 
 * An implementation of a generic authorization function, one of the three
 * authorization components. An authorization function describes the action that
 * is to be authorized. It has two properties:
 * <br /><br />
 * The <b>system id</b> is a system-specific unique numeric id of the function.
 * <br /><br />
 * The <b>system name</b> is a system-specific unique name of the function.
 * @access public
 * @version $Id: AuthorizationFunction.class.php,v 1.2 2004/03/11 16:02:44 adamfranco Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorization
 */
class AuthorizationFunction extends AuthorizationFunctionInterface {

	
	/**
	 * The system id of this function.
	 * <br /><br />
	 * The <b>system id</b> is a system-specific unique numeric id of the function.
	 * @attribute private integer _systemId
	 */
	var $_systemId;
	
	/**
	 * The system name of this function.
	 * <br /><br />
	 * The <b>system name</b> is a system-specific unique name of the function.
	 * @attribute private string _systemName
	 */
	var $_systemName;
	

	/**
	 * The constructor just takes all the properties and returns a new
	 * AuthorizationFunction object.
	 * @param integer systemId The system id of this function.
	 * @param string systemName The system name of this function.
	 * @access public
	 */
	function AuthorizationFunction($systemId, $systemName) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($systemId, $integerRule, true);
		ArgumentValidator::validate($systemName, $stringRule, true);
		// ** end of parameter validation
		
		$this->_systemId = $systemId;
		$this->_systemName = $systemName;
	}

	/**
	 * Returns the system id of this function.
	 * <br /><br />
	 * The <b>system id</b> is a system-specific unique numeric id of the function.
	 * @method public getSystemId
	 * @return integer The system id of this function.
	 */
	function getSystemId() {
		return $this->_systemId;
	}


	/**
	 * Returns the system name of this authorization function.
	 * <br /><br />
	 * The <b>system name</b> is a system-specific unique name of the function.
	 * @method public getSystemName
	 * @return string The system name of this authorization function. 
	 */
	function getSystemName() {
		return $this->_systemName;
	}
	
	
	
}


?>