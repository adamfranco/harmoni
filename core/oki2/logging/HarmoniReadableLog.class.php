<?php 
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniReadableLog.class.php,v 1.4 2008/02/06 15:37:51 adamfranco Exp $
 */
require_once(OKI2."/osid/logging/ReadableLog.php");
require_once(dirname(__FILE__)."/HarmoniEntryIterator.class.php");
require_once(dirname(__FILE__)."/SearchEntryIterator.class.php");
 
/**
 * ReadableLog allows reading of its entries.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package harmoni.osid_v2.logging
 */
class HarmoniReadableLog
	implements ReadableLog
{
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @return object
	 * @access public
	 * @since 3/1/06
	 */
	function __construct ($name, $dbIndex) {
		ArgumentValidator::validate($name, StringValidatorRule::getRule());
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule());
		$this->_name = $name;
		$this->_dbIndex = $dbIndex;
	}
	
	/**
	 * Get the display name for this ReadableLog.
	 *	
	 * @return string
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:	{@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function getDisplayName () { 
		return $this->_name;
	} 

	/**
	 * Return the ReadableLog Entries in a last-in, first-out (LIFO) order.
	 * 
	 * @param object Type $formatType
	 * @param object Type $priorityType
	 *	
	 * @return object EntryIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:	{@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#NULL_ARGUMENT NULL_ARGUMENT},
	 *		   {@link org.osid.logging.LoggingException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getEntries ( Type $formatType, Type $priorityType ) { 
		$iterator = new HarmoniEntryIterator($this->_name, $formatType, $priorityType, $this->_dbIndex);
		return $iterator;
	}
	
	/**
	 * Return the ReadableLog Entries in a last-in, first-out (LIFO) order.
	 * Limit by the search criteria.
	 *
	 * Warning: NOT IN OSID
	 * 
	 * @param mixed $searchCriteria
	 * @param object Type $searchType
	 * @param object Type $formatType
	 * @param object Type $priorityType
	 *	
	 * @return object EntryIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:	{@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#NULL_ARGUMENT NULL_ARGUMENT},
	 *		   {@link org.osid.logging.LoggingException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getEntriesBySearch ( $searchCriteria, Type $searchType, Type $formatType, Type $priorityType ) { 
		$validType = new Type("logging_search", "edu.middlebury", "Date-Range/Agent/Node");
		if (!$validType->isEqual($searchType)) {
			throwError(new HarmoniError("Invalid search type, ".$searchType->asString().".", "Logging"));
		}
		
		$iterator = new SearchEntryIterator($this->_name, $searchCriteria, $formatType, $priorityType, $this->_dbIndex);
		return $iterator;
	}
	
	/**
	 * Answer a list of categories in this log.
	 * 
	 * Warning: NOT IN OSID
	 * 
	 * @return array
	 * @access public
	 * @since 6/10/08
	 */
	public function getCategories () {
		$query = new SelectQuery();
		$query->addTable('log_entry');
		$query->addColumn('DISTINCT (category)', 'cat');
		$query->addWhereEqual('log_name', $this->_name);
		$query->addOrderBy('category');
		
		$dbc = Services::getService('DatabaseManager');
		$result = $dbc->query($query, $this->_dbIndex);
		$categories = array();
		while ($result->hasNext()) {
			$row = $result->next();
			$categories[] = $row['cat'];
		}
		
		return $categories;
	}
}

?>