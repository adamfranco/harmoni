<?php

require_once(HARMONI."authenticationHandler/AgentInformationHandler.interface.php");

/**
 * The AgentInformationHandler is responsible for fetching Agent Information. The
 * {@link AuthenticationHandler Authentication} service is required and methods
 * from it are used, based on priority settings, in order to fetch information such
 * as email addresses, full names, etc.
 *
 * @package harmoni.authenticationHandler.agentInformationHandler
 * @version $Id: AgentInformationHandler.class.php,v 1.2 2003/06/30 02:16:09 gabeschine Exp $
 * @copyright 2003 
 **/
class AgentInformationHandler extends AgentInformationHandlerInterface {
	/**
	 * @access private
	 * @var object $_authHandler The AuthenticationHandler service object.
	 **/
	var $_authHandler;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function AgentInformationHandler() {
		Services::requireService("Authentication");
		$this->_authHandler =& Services::getService("Authentication");
	}
	
	/**
	 * Gets agent information (such as email, etc) as defined in each AuthenticationMethod.
	 * 
	 * This function cycles through each installed AuthenticationMethod (or just 
	 * the one specified in $method if passed) and fetches the agent information
	 * associated with that method. If all methods are checked, this function
	 * will compile a single result, resolving conflicting information from
	 * multiple methods by looking at the method's priority setting, making
	 * lower number (higher priority) take precedence.
	 * @param string $systemName The system name to fetch information for.
	 * @param optional string $method The method name to fetch information from.
	 * If not specified, will use all methods and combine the information.
	 * @see {@link AuthenticationMethodInterface::setPriority()}
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationHandler}
	 * @access public
	 * @return array An associative array of agent information. If $method is
	 * omitted, a join based on priority of all {@link AuthenticationMethod}s is
	 * returned. 
	 **/
	function getAgentInformation( $systemName, $method = "") {
		if ($method != "") {
			// we only need to fetch the info from one method -- easy enough
			return $this->_getInformation($systemName,$method);
		}
		// otherwise, we're gonna have to go through ALL the methods in
		// priority order
		
		// get an array of all available methods
		$methods = $this->_authHandler->getMethodNames();
		
		// now get their priority, each in turn
		$priorities = array();
		foreach($methods as $method) {
			$methodObj =& $this->_authHandler->getMethod($method);
			$priorities[$method] = $methodObj->getPriority();
		}
		
		// sort them lower priority (highest priority value) to highest to over-write
		// any lower priority values with the higher ones
		arsort($priorities,SORT_NUMERIC);

		// go through them and populate the $info hashtable
		$info = array();

		foreach (array_keys($priorities) as $method) {
			$array = $this->_getInformation($systemName, $method);
			foreach ($array as $field=>$value) {
				if ($value)
					$info[$field] = $value;
			}
		}
		
		// all done
		return $info;
	}

	/**
	 * Gets the agent information from one method.
	 * @param string $systemName The system name.
	 * @param string $method The method to use.
	 * @access private
	 * @return array An associative array of agent information.
	 **/
	function _getInformation( $systemName, $method ) {
		print "<br><br>$systemName,$method<BR>";
		$methodObj =& $this->_authHandler->getMethod($method);
//		print "<pre>"; print_r($methodObj);
		if (is_object($methodObj)) print "$method = object<br>";
		else print "$method = not object<BR>";
		$array = $methodObj->getAgentInformation($systemName);
		return $array;
	}
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
		
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
		
	}
	
}

?>