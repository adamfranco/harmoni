<?

require_once(HARMONI."oki2/agent/AgentFilteringFromTraversalIterator.class.php");

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
 * @version $Id: GroupsOnlyFromTraversalIterator.class.php,v 1.1 2005/09/07 21:17:57 adamfranco Exp $
 */
class GroupsOnlyFromTraversalIterator
	extends AgentFilteringFromTraversalIterator
//	implements AgentIterator
{
	
	/**
	 * Return True if we should select the Agent with the given id, FALSE if
	 * we are filtering it.
	 * 
	 * @param object Id $id
	 * @return boolean
	 * @access private
	 * @since 8/31/05
	 */
	function _shouldSelect ( &$id ) {
		$agentManager =& Services::getService("Agent");
		if ($agentManager->isGroup($id))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * create a new Agent of the appropriate class and return it.
	 * 
	 * @param object Id $id
	 * @return object Agent
	 * @access private
	 * @since 8/31/05
	 */
	function &_getAgent ( &$id ) {
		$agentManager =& Services::getService("Agent");
		
		return $agentManager->getGroup($id);
	}

}

?>