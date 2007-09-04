<?php 
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniReadableLog.class.php,v 1.3 2007/09/04 20:25:43 adamfranco Exp $
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
	extends ReadableLog
{
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @return object
	 * @access public
	 * @since 3/1/06
	 */
	function HarmoniReadableLog ($name, $dbIndex) {
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
	function getEntries ( $formatType, $priorityType ) { 
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
	function getEntriesBySearch ( $searchCriteria, $searchType, $formatType, $priorityType ) { 
		$validType = new Type("logging_search", "edu.middlebury", "Date-Range/Agent/Node");
		if (!$validType->isEqual($searchType)) {
			throwError(new Error("Invalid search type, ".Type::typeToString($searchType).".", "Logging"));
		}
		
		$iterator = new SearchEntryIterator($this->_name, $searchCriteria, $formatType, $priorityType, $this->_dbIndex);
		return $iterator;
	} 
}

?>