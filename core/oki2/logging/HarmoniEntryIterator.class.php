<?php
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniEntryIterator.class.php,v 1.6 2007/09/04 20:25:43 adamfranco Exp $
 */

require_once(OKI2."/osid/logging/EntryIterator.php");
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
 * @version $Id: HarmoniEntryIterator.class.php,v 1.6 2007/09/04 20:25:43 adamfranco Exp $
 */
class HarmoniEntryIterator
	extends EntryIterator
{
	
	/**
	 * Constructor
	 * 
	 * @param string $logName
	 * @param object Type $formatType
	 * @param object Type $priorityType
	 * @return object
	 * @access public
	 * @since 3/1/06
	 */
	function HarmoniEntryIterator ( $logName, $formatType, $priorityType, $dbIndex ) {
		$this->_logName = $logName;
		$this->_formatType =$formatType;
		$this->_priorityType =$priorityType;
		$this->_dbIndex = $dbIndex;
		$this->_current = 0;
		$this->_currentRow = 0;
		$this->_numPerLoad = 50;
		$this->_entries = array();
		$this->_entryIds = array();
		
		$this->loadCount();
	}
	
	/**
     * Return true if there is an additional  Entry
     * Description_IteratorHasNext2]
     *  
     * @return boolean
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}
     * 
     * @access public
     */
    function hasNextEntry () { 
        return $this->hasNext();
    } 

    /**
     * Return the next Entry.
     *  
     * @return object Entry
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#NO_MORE_ITERATOR_ELEMENTS
     *         NO_MORE_ITERATOR_ELEMENTS}
     * 
     * @access public
     */
    function nextEntry () { 
         return $this->next();
    }
    
    /**
     * Return true if there is an additional  Entry
     * Description_IteratorHasNext2]
     *  
     * @return boolean
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}
     * 
     * @access public
     */
    function hasNext () {
        return ($this->_current < $this->_count);
    } 

    /**
     * Return the next Entry.
     *  
     * @return object Entry
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#NO_MORE_ITERATOR_ELEMENTS
     *         NO_MORE_ITERATOR_ELEMENTS}
     * 
     * @access public
     */
    function next () { 
       if (!$this->hasNext())
	 		throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(),
	 			get_class($this), true));
		
		if (!isset($this->_entries[$this->_current]))
			$this->loadNext();
		
		$entry =$this->_entries[$this->_current];
		$this->_current++;
		return $entry;
    }
    
	/**
	 * Skips the next item in the iterator
	 *
	 * @return void
	 * @public
	 */
	function skipNext() {
// 		if (!$this->hasNext())
// 			throwError(new Error(SharedException::NO_MORE_ITERATOR_ELEMENTS(),
// 				get_class($this), true));
// 		
// 		$this->_current++;

		$this->next();
	}
	 
	/**
	 * Gives the number of items in the iterator
	 *
	 * @return int
	 * @public
	 */
	 function count () {
	 	return $this->_count;
	 }
	 
	 /**
	  * Load the number of results
	  * 
	  * @return void
	  * @access public
	  * @since 3/9/06
	  */
	 function loadCount () {
	 	// load the count
		$dbc = Services::getService("DatabaseManager");
		
		$query = new SelectQuery;
		$query->addTable("log_entry");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_format_type = format_type.id", "format_type");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_priority_type = priority_type.id", "priority_type");
		$query->addColumn("id", "entry_id", "log_entry");
		$query->setDistinct(true);
		$this->addWhereClauses($query);
		
// 		Debug::printQuery($query);
		$results =$dbc->query($query, $this->_dbIndex);
		$this->_count = $results->getNumberOfRows();
		$results->free();
	 }
	
	/**
	 * Load the next bunch of items
	 * 
	 * @return void
	 * @access public
	 * @since 3/1/06
	 */
	function loadNext () {
		$dbc = Services::getService("DatabaseManager");

		// get the list of the next set of Ids
		$query = new SelectQuery;
		$query->addTable("log_entry");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_format_type = format_type.id", "format_type");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_priority_type = priority_type.id", "priority_type");
		$query->addColumn("id", "entry_id", "log_entry");
		$query->setDistinct(true);
		$query->addOrderBy("timestamp", DESCENDING);
		$this->addWhereClauses($query);
		
		$query->limitNumberOfRows($this->_numPerLoad);
		if ($this->_currentRow)
			$query->startFromRow($this->_currentRow + 1);
		
// 		debug::printQuery($query);
		$results =$dbc->query($query, $this->_dbIndex);
		$nextIds = array();
		while ($results->hasNext()) {
			$row = $results->next();
			$nextIds[] = "'".addslashes($row['entry_id'])."'";
		}	
		
		// Load the rows for the next set of Ids		
		$query =$this->getBaseQuery();
		$query->addWhere("log_entry.id IN (".implode(", ", $nextIds).")");
		$this->addColumnsAndOrder($query);
		
// 		debug::printQuery($query);
		
		$results =$dbc->query($query, $this->_dbIndex);
		
		$i = $this->_current;
		$currentEntryId = null;
		$timestamp = null;
		$category = null;
		$description = null;
		$backtrace = '';
		$agents = array();
		$nodes = array();
		$rowsTraversed = 0;
		while ($results->hasNext()) {
			$row = $results->next();
			
			// Create the entry if we have all of the data for it.
			if ($currentEntryId && $currentEntryId != $row["id"]) {
// 				printpre("Creating Entry: ".$currentEntryId." ".$timestamp." -- ".($i+1)." of ".$this->_count);
				$this->_entries[$i] = new HarmoniEntry($dbc->fromDBDate($timestamp, $this->_dbIndex),
												$category,
												$description,
												$backtrace,
												array_unique($agents),
												array_unique($nodes),
												$this->_formatType,
												$this->_priorityType);
				$i++;
				$currentEntryId = null;
				$timestamp = null;
				$category = null;
				$description = null;
				$backtrace = '';
				$agents = array();
				$nodes = array();
				$this->_currentRow = $this->_currentRow + $rowsTraversed;
				$rowsTraversed = 0;
			}
			
			$currentEntryId = $row["id"];
			$timestamp = $row["timestamp"];
			$category = $row["category"];
			$description = $row["description"];
			$backtrace = $row["backtrace"];
			$agents[] = $row["agent_id"];
			$nodes[] = $row["node_id"];
			
// 			printpre($currentEntryId." ".$timestamp." ".$this->_currentRow);
			$rowsTraversed++;
		}
		$results->free();
		
		// get the last entry if we are at the end of the iterator
		if ($currentEntryId && $i == ($this->_count - 1)) {
// 			printpre("Creating Entry: ".$currentEntryId." ".$timestamp." -- ".($i+1)." of ".$this->_count);
			$this->_entries[$i] = new HarmoniEntry($dbc->fromDBDate($timestamp, $this->_dbIndex),
												$category,
												$description,
												$backtrace,
												array_unique($agents),
												array_unique($nodes),
												$this->_formatType,
												$this->_priorityType);
		}
	}
	
	/**
	 * Answer the basic query
	 * 
	 * @return object SelectQuery
	 * @access public
	 * @since 3/9/06
	 */
	function getBaseQuery () {
		$query = new SelectQuery;
		
		$query->addTable("log_entry");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_format_type = format_type.id", "format_type");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_priority_type = priority_type.id", "priority_type");
		$query->addTable("log_agent", LEFT_JOIN, "log_entry.id = log_agent.fk_entry");
		$query->addTable("log_node", LEFT_JOIN, "log_entry.id = log_node.fk_entry");
		
		return $query;
	}
	
	/**
	 * Add columns, orders, and limits to our query
	 * 
	 * @param object SelectQuery $query
	 * @return void
	 * @access public
	 * @since 3/9/06
	 */
	function addColumnsAndOrder ( $query ) {
		$query->addOrderBy("timestamp", DESCENDING);
		$query->addOrderBy("id", ASCENDING);
		
		$query->addColumn("id", "id", "log_entry");
		$query->addColumn("timestamp", "timestamp", "log_entry");
		$query->addColumn("category", "category", "log_entry");
		$query->addColumn("description", "description", "log_entry");
		$query->addColumn("backtrace", "backtrace", "log_entry");
		$query->addColumn("fk_agent", "agent_id", "log_agent");
		$query->addColumn("fk_node", "node_id", "log_node");
	}
	
	/**
	 * Add where clauses to the query
	 * 
	 * @param object SelectQuery $query
	 * @return void
	 * @access public
	 * @since 3/9/06
	 */
	function addWhereClauses ( $query ) {
		$query->addWhere("log_name = '".addslashes($this->_logName)."'");
		$query->addWhere("format_type.domain = '".addslashes($this->_formatType->getDomain())."'");
		$query->addWhere("format_type.authority = '".addslashes($this->_formatType->getAuthority())."'");
		$query->addWhere("format_type.keyword = '".addslashes($this->_formatType->getKeyword())."'");
		if ($this->_priorityType) {
			$query->addWhere("priority_type.domain = '".addslashes($this->_priorityType->getDomain())."'");
			$query->addWhere("priority_type.authority = '".addslashes($this->_priorityType->getAuthority())."'");
			$query->addWhere("priority_type.keyword = '".addslashes($this->_priorityType->getKeyword())."'");
		}
	}
}

?>