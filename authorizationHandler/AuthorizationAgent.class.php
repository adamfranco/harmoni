<?php

require_once(HARMONI.'authorizationHandler/AuthorizationAgent.interface.php');

/** 
 * An implementation of a generic authorization agent, one of the three
 * authorization components. An authorization agent specifies the agent to be
 * authorized. It stores several properties:
 * <br><br>
 * The <b>system id</b> is a system-specific unique numeric id of the agent.
 * <br><br>
 * The <b>system name</b> is a system-specific unique name of the agent.
 * <br><br>
 * The <b>type</b> is a system-specific type used to differentiate between verious
 * types of agents.
 * 
 * @access public
 * @version $Id: AuthorizationAgent.class.php,v 1.1 2003/06/30 20:41:44 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 6/29/2003
 * @package harmoni.authorizationHandler
 */
class AuthorizationAgent extends AuthorizationAgentInterface {


	/**
	 * The system id of this agent.
	 * <br><br>
	 * The <b>system id</b> is a system-specific unique numeric id of the agent.
	 * @attribute private integer _systemId
	 */
	var $_systemId;
	
	/**
	 * The system name of this agent.
	 * <br><br>
	 * The <b>system name</b> is a system-specific unique name of the agent.
	 * @attribute private string _systemName
	 */
	var $_systemName;
	
	/**
	 * The type of this agent.
	 * <br><br>
	 * The <b>type</b> is a system-specific type used to differentiate between verious
	 * types of agents.
	 * @attribute private string _type
	 */
	var $_type;
	

	/**
	 * The constructor just takes all the properties and returns a new
	 * AuthorizationAgent object.
	 * @param integer systemId The system id of this agent.
	 * @param string systemName The system name of this agent.
	 * @param string type The type of this agent.
	 * @access public
	 */
	function AuthorizationAgent($systemId, $systemName, $type) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($systemId, $integerRule, true);
		ArgumentValidator::validate($systemName, $stringRule, true);
		ArgumentValidator::validate($type, $stringRule, true);
		// ** end of parameter validation
		
		$this->_systemId = $systemId;
		$this->_systemName = $systemName;
		$this->_type = $type;
	}

	/**
	 * Returns the system id of this agent.
	 * <br><br>
	 * The <b>system id</b> is a system-specific unique numeric id of the agent.
	 * @method public getSystemId
	 * @return integer The system id of this agent.
	 */
	function getSystemId() {
		return $this->_systemId;
	}

	/**
	 * Returns the system name of this agent.
	 * <br><br>
	 * The <b>system name</b> is a system-specific unique name of the agent.
	 * @method public getSystemName
	 * @return string The system name of this agent.
	 */
	function getSystemName() {
		return $this->_systemName;
	}

	/**
	 * Returns the type of this agent.
	 * <br><br>
	 * The <b>type</b> is a system-specific type used to differentiate between verious
	 * types of agents.
	 * @method public getType
	 * @return string The type of this agent.
	 */
	function getType() {
		return $this->_type	;
	}
	
	
}


?>