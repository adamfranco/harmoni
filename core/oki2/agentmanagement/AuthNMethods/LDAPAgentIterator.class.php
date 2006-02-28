<?

require_once(OKI2."/osid/agent/AgentIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * AgentIterator provides access to these objects sequentially, one at a time.
 * The purpose of all Iterators is to to offer a way for OSID methods to
 * return multiple values of a common type and not use an array.  Returning an
 * array may not be appropriate if the number of values returned is large or
 * is fetched remotely.	 Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.agent
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAgentIterator.class.php,v 1.1 2006/02/28 18:59:59 adamfranco Exp $
 */
class LDAPAgentIterator
	extends HarmoniAgentIterator
//	implements AgentIterator
{
	/**
	 * @var object $_nodeIterator;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_dns;
	
	/**
	 * @var object $_agents; 
	 * @access private
	 * @since 2/27/06
	 */
	var $_agents;
	
	/**
	 * Constructor 
	 * 
	 * @param object LDAPAuthNMethod $authNMethod
	 * @param ref array $agents	An array of agents to populate with our created
	 *							Agent objects
	 * @param optional array $dns
	 * @return object
	 * @access public
	 * @since 8/30/05
	 */
	function LDAPAgentIterator ( &$authNMethod, &$agents, $dns = array() ) {
		
		// determine the count (if we are passed dns, or just a poplulated $agents array)
		if (count($dns) > count($agents))
			$this->_count = count($dns);
		else
			$this->_count = count($agents);
		
		$this->_current = 0;
		
		$this->_authNMethod =& $authNMethod;
		$this->_agents =& $agents;
		$this->_dns = $dns;
	}
	
	/**
	 * Return true if there is an additional  Agent ; false otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function hasNext () {
		if ($this->_count == 0)
			return false;
		else
			return ($this->_current < $this->_count);
	} 

	/**
	 * Return the next Agent.
	 *	
	 * @return object Agent
	 * 
	 * @throws object AgentException An exception with one of the
	 *		   following messages defined in org.osid.agent.AgentException may
	 *		   be thrown:  {@link
	 *		   org.osid.agent.AgentException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.agent.AgentException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.agent.AgentException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.agent.AgentException#NO_MORE_ITERATOR_ELEMENTS
	 *		   NO_MORE_ITERATOR_ELEMENTS}
	 * 
	 * @access public
	 */
	function &next () {
		if (!isset($this->_agents[$this->_current])) {
			$authenticationManager =& Services::getService("AuthN");
			$agentManager =& Services::getService("AgentManager");
			
			if (!isset($this->_dns[$this->_current]))
				throwError(new Error("Tried to get Group for un-passed dn", "LDAPAgentIterator", true));
			
			$tokens =& $this->_authNMethod->createTokensForIdentifier($this->_dns[$this->_current]);
			$agentId =& $authenticationManager->_getAgentIdForAuthNTokens($tokens, $this->_authNMethod->getType());
			$this->_agents[$this->_current] =& $agentManager->getAgent($agentId);
		}
		$agent =& $this->_agents[$this->_current];
		$this->_current++;
		return $agent;
	}
	
	/**
	 * Gives the number of items in the iterator
	 * 
	 * @return integer
	 * @access public
	 * @since 8/31/05
	 */
	function count () {
		return count($this->_count);
	}
}

?>