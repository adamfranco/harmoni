<?php

//require_once(HARMONI."authenticationHandler/AgentInformationHandler.interface.php");

/**
 * The AgentInformationHandler is responsible for fetching Agent Information. The
 * {@link AuthenticationHandler Authentication} service is required and methods
 * from it are used, based on priority settings, in order to fetch information such
 * as email addresses, full names, etc.
 *
 * @package harmoni.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentInformationHandler.class.php,v 1.10 2005/02/04 15:58:59 adamfranco Exp $
 **/
class AgentInformationHandler extends ServiceInterface {
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
	 * @param boolean $searchMode Specifies if we should do a wildcard search
	 * for the supplied $systemName.
	 * @param optional string $method The method name to fetch information from.
	 * If not specified, will use all methods and combine the information.
	 * @see AuthenticationMethodInterface::setPriority()
	 * @see AuthenticationMethodInterface
	 * @see AuthenticationHandler
	 * @access public
	 * @return array An associative array of agent information. If $method is
	 * omitted, a join based on priority of all {@link AuthenticationMethod}s is
	 * returned. If $searchMode=true, an associative array of said arrays is returned,
	 * following the format: [username1]=>array([key1]=>value1,...),...
	 **/
	function getAgentInformation( $systemName, $searchMode=false, $method = "") {
		if ($method != "") {
			// we only need to fetch the info from one method -- easy enough
			$unames = $this->_getInformation($systemName, $searchMode, $method);
			return ($searchMode)?$unames:$unames[$systemName];
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
//		print_r($priorities);
		// go through them and populate the $info hashtable
		$info = array();

		foreach (array_keys($priorities) as $method) {
			$users = $this->_getInformation($systemName, $searchMode, $method);
			foreach ($users as $uname=>$array) {
    			foreach ($array as $field=>$value) {
    				if ($value)
    					$info[$uname][$field] = $value;
    			}
			}
		}
//		print_r($info);
		// all done
		if ($searchMode)
			return $info;
		return $info[$systemName];
	}

	/**
	 * Gets the agent information from one method.
	 * @param string $systemName The system name.
	 * @param boolean $searchMode If we are searching using wildcards or just looking for one name.
	 * @param string $method The method to use.
	 * @access private
	 * @return array An associative array of agent information.
	 **/
	function _getInformation( $systemName, $searchMode, $method ) {
		$methodObj =& $this->_authHandler->getMethod($method);
		$array = $methodObj->getAgentInformation($systemName,$searchMode);
		return $array;
	}
	
	/**
	 * Checks to see if an agent system name is present in any of the authentication methods.
	 * @param string $agentName The agent's name to be checked.
	 * @param optional string $method A single method to check.
	 * @access public
	 * @return void
	 */
	function agentExists($agentName, $method = null) {
		// get an array of available methods
		$methods = $this->_authHandler->getMethodNames();
		
		if ($method) {
			if (!in_array($method, $methods)) {
				throwError( new Error("Could not execute AgentInformationHandler::agentExists($agentName, $method) because the method does not seem to be available in the AuthenticationHandler.","AgentInformationHandler",true));
				return false;
			}
			
			$methodObj =& $this->_authHandler->getMethod($method);
			return $methodObj->agentExists($agentName);
		}
		
		// otherwise, step through them each... until we find a positive
		foreach ($methods as $method) {
			$methodObj =& $this->_authHandler->getMethod($method);
			if ($methodObj->agentExists($agentName)) return true;
		}
		
		return false;
	}
	
	/**
	 * Searches for agent system names in any of the authentication methods.
	 * @param mixed $searchCriteria The criteria to search for.
	 * @param optional string $method A single method to check.
	 * @access public
	 * @return void
	 */
	function getAgentNamesBySearch($searchCriteria, $method = null) {
		// get an array of available methods
		$methods = $this->_authHandler->getMethodNames();
		
		if ($method) {
			if (!in_array($method, $methods)) {
				throwError( new Error("Could not execute AgentInformationHandler::getAgentNamesBySearch($searchCriteria, $method) because the method does not seem to be available in the AuthenticationHandler.","AgentInformationHandler",true));
			}
			
			$methodObj =& $this->_authHandler->getMethod($method);
			return $methodObj->getAgentNamesBySearch($searchCriteria);
		} else {
		
			// otherwise, step through them each... and combine the results
			$agentNames = array();
			foreach ($methods as $method) {
				$methodObj =& $this->_authHandler->getMethod($method);
				$agentNames = array_merge(
								$agentNames,
								$methodObj->getAgentNamesBySearch($searchCriteria)
							);
				
			}
			
			return $agentNames;
		}
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