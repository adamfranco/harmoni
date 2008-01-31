<?php
/**
 * @since 1/31/08
 * @package harmoni.osid_v2.agent.search
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentPropertiesSearch.class.php,v 1.1 2008/01/31 20:56:44 adamfranco Exp $
 */ 

/**
 * The properties search will find agents and groups that have properties matching
 * the search criteria
 * 
 * @since 1/31/08
 * @package harmoni.osid_v2.agent.search
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentPropertiesSearch.class.php,v 1.1 2008/01/31 20:56:44 adamfranco Exp $
 */
class AgentPropertiesSearch
	implements AgentSearchInterface
{

	/**
	 * Constructor
	 * 
	 * @param int $databaseIndex
	 * @return void
	 * @access public
	 * @since 1/31/08
	 */
	public function __construct ($databaseIndex) {
		ArgumentValidator::validate($databaseIndex, IntegerValidatorRule::getRule());
		$this->databaseIndex = $databaseIndex;
	}
		
	/**
	 * Get all the Agents with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @return object AgentIterator
	 * @access public
	 * @since 1/30/08
	 */
	function getAgentsBySearch ( $searchCriteria) {
		return new MembersOnlyFromTraversalIterator($this->getMatching($searchCriteria));
	}
	
	/**
	 * Get all the Groups with the specified search criteria and search Type.
	 *
	 * This method is defined in v.2 of the OSIDs.
	 * 
	 * @param mixed $searchCriteria
	 * @return object AgentIterator
	 * @access public
	 * @since 1/30/08
	 */
	function getGroupsBySearch ( $searchCriteria) {
		return new GroupsOnlyFromTraversalIterator($this->getMatching($searchCriteria));
	}
	
	/**
	 * Since the agent manager package already has support for filtering agents and
	 * groups from traversal info iterators, return our search results as traversal
	 * info.
	 * 
	 * @param string $criteria
	 * @return TraversalInfoIterator
	 * @access protected
	 * @since 1/31/08
	 */
	protected function getMatching ($criteria) {
		$dbc = Services::getService('DatabaseManager');
		$idMgr = Services::getService('Id');
		
		$query = new SelectQuery;
		$query->addTable('agent_properties');
		$query->addColumn("DISTINCT fk_object_id", "agent_id");
		$query->addWhereLike("property_value", str_replace('*', '%', $criteria));
		
		$info = array();
		$result = $dbc->query($query, $this->databaseIndex);
		while ($result->hasNext()) {
			$row = $result->next();
			$info[] = new HarmoniTraversalInfo($idMgr->getId($row['agent_id']), '', 0);
		}
		
		return new HarmoniTraversalInfoIterator($info);
	}
}

?>