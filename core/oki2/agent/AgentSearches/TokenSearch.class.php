<?php

require_once(dirname(__FILE__)."/AgentSearch.interface.php");

/**
 * The AgentSearch interface defines methods for searching for agents. This is 
 * used by the AgentManager for searching for agents.
 *
 * @package harmoni.osid_v2.agent.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TokenSearch.class.php,v 1.8 2008/01/31 20:56:45 adamfranco Exp $
 */

class TokenSearch
	implements AgentSearchInterface 
{
		
	/**
	 * Get all the Agents with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $agentSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function getAgentsBySearch ( $searchCriteria) {
		$allAgents = array();
		
		// See if the agent exists as known by harmoni
		$authNMethodManager = Services::getService("AuthNMethodManager");
		$authenticationManager = Services::getService("AuthenticationManager");
		$agentManager = Services::getService("AgentManager");
		
		$types =$authNMethodManager->getAuthNTypes();
		while ($types->hasNext()) {
			$type =$types->next();
			$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
			$tokensIterator =$authNMethod->getTokensBySearch($searchCriteria);
			
		
			
			while ($tokensIterator->hasNextObject()) {
				$token =$tokensIterator->nextObject();
				$agentId =$authenticationManager->_getAgentIdForAuthNTokens($token
				, $type);
				if ($agentManager->isAgent($agentId))
					$allAgents[] =$agentManager->getAgent($agentId);
			}
		}
		
		$obj = new HarmoniIterator($allAgents);
		
		return $obj;
	}
	
	/**
	 * Get all the Groups with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $groupSearchType
	 * @return object AgentIterator
	 * @access public
	 * @since 11/10/04
	 */
	function getGroupsBySearch ( $searchCriteria) {
		$allGroups = array();
		
		// See if the agent exists as known by harmoni
		$authNMethodManager = Services::getService("AuthNMethodManager");
		$authenticationManager = Services::getService("AuthenticationManager");
		$agentManager = Services::getService("AgentManager");
		$idManager = Services::getService("IdManager");
		
		$types =$authNMethodManager->getAuthNTypes();
		$idsFound = array();
		while ($types->hasNext()) {
			$type =$types->next();
			$authNMethod =$authNMethodManager->getAuthNMethodForType($type);
			if(!method_exists($authNMethod,"getGroupTokensBySearch")){
			  continue;
			}
			$tokensIterator = $authNMethod->getGroupTokensBySearch($searchCriteria);
			
		
			
			while ($tokensIterator->hasNextObject()) {
				$token = $tokensIterator->nextObject();
				if (!in_array($token->getIdentifier(), $idsFound)) {
					$allGroups[] = $agentManager->getGroup(
									$idManager->getId($token->getIdentifier()));
					$idsFound[] = $token->getIdentifier();
				}
			}
		}		
		
		$obj = new HarmoniIterator($allGroups);
		
		return $obj;
	}	
}

?>