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
 * @version $Id: GroupsFromNodesIterator.class.php,v 1.1 2005/09/09 21:32:54 gabeschine Exp $
 */
class GroupsFromNodesIterator
	extends HarmoniAgentIterator
//	implements AgentIterator
{
	/**
	 * @var object $_nodeIterator;  
	 * @access private
	 * @since 8/30/05
	 */
	var $_nodeIterator;
	
	/**
	 * Constructor
	 * 
	 * @param object TraversalInfoIterator $traversalInfoIterator
	 * @return object
	 * @access public
	 * @since 8/30/05
	 */
	function GroupsFromNodesIterator ( &$nodeIterator ) {
		$this->_nodeIterator =& $nodeIterator;
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
		return $this->_nodeIterator->hasNext();
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
		$node =& $this->_nodeIterator->next();
		$agentManager =& Services::getService('Agent');
		$group =& $agentManager->getGroup($node->getId());
		return $group;
	}
	
	/**
	 * Gives the number of items in the iterator
	 * 
	 * @return integer
	 * @access public
	 * @since 8/31/05
	 */
	function count () {
			return $this->_nodeIterator->count();
	}

}

?>