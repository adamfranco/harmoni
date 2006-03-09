<?php
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SearchEntryIterator.class.php,v 1.2 2006/03/09 21:07:16 adamfranco Exp $
 */

require_once(dirname(__FILE__)."/HarmoniEntryIterator.class.php");
require_once(dirname(__FILE__)."/HarmoniEntry.class.php");

/**
 * EntryIterator provides access to these objects sequentially, one at a time.
 * The purpose of all Iterators is to to offer a way for OSID methods to
 * return multiple values of a common type and not use an array.  Returning an
 * array may not be appropriate if the number of values returned is large or
 * is fetched remotely.  Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
 * 
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SearchEntryIterator.class.php,v 1.2 2006/03/09 21:07:16 adamfranco Exp $
 */
class SearchEntryIterator
	extends HarmoniEntryIterator
{
	
	/**
	 * Constructor
	 * 
	 * @param string $logName
	 * @param array $searchCriteria
	 * @param object Type $formatType
	 * @param object Type $priorityType
	 * @return object
	 * @access public
	 * @since 3/1/06
	 */
	function SearchEntryIterator ( $logName, &$searchCriteria, &$formatType, &$priorityType, $dbIndex ) {
		$this->_startDate =& $searchCriteria['start'];
		$this->_endDate =& $searchCriteria['end'];
		
		if (isset($searchCriteria['agent_id']))
			$this->_agentId = $searchCriteria['agent_id'];
		else
			$this->_agentId = false;
			
		if (isset($searchCriteria['node_id']))
			$this->_nodeId = $searchCriteria['node_id'];
		else
			$this->_nodeId = false;
				
		$this->HarmoniEntryIterator($logName, $formatType, $priorityType, $dbIndex);
	}
	
	/**
	 * Add where clauses to the query
	 * 
	 * @param object SelectQuery $query
	 * @return void
	 * @access public
	 * @since 3/9/06
	 */
	function addWhereClauses ( &$query ) {
		$dbc =& Services::getService("DatabaseManager");
		if ($this->_agentId) {
			$query->addTable("log_agent", INNER_JOIN, "log_entry.id = search_agent.fk_entry", "search_agent");
			$query->addWhere("search_agent.fk_agent = '".addslashes($this->_agentId->getIdString())."'");
		}
		
		if ($this->_nodeId) {
			$query->addTable("log_node", INNER_JOIN, "log_entry.id = search_node.fk_entry", "search_node");
			$query->addWhere("search_node.fk_node = '".addslashes($this->_nodeId->getIdString())."'");
		}
		
		$query->addWhere("log_entry.timestamp > ".$dbc->toDBDate($this->_startDate, $this->_dbIndex));
		$query->addWhere("log_entry.timestamp < ".$dbc->toDBDate($this->_endDate, $this->_dbIndex));
		
		parent::addWhereClauses($query);
	}
}

?>