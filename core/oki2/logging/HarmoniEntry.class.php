<?php 
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniEntry.class.php,v 1.5 2008/02/06 15:37:51 adamfranco Exp $
 */

require_once(OKI2."/osid/logging/Entry.php");
require_once(dirname(__FILE__)."/AgentNodeEntryItem.class.php");

/**
 * Contains the logged item, its format type, its priority type, and the time
 * the item was logged.
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
class HarmoniEntry
	implements Entry
{
	
	/**
	 * Constructor
	 * 
	 * @param mixed $entryItem
	 * @param object Type $formatType
	 * @param object Type $priorityType
	 * @return object
	 * @access public
	 * @since 3/1/06
	 */
	function HarmoniEntry ( $timestamp, $category, $description, $backtrace, $agents, $nodes, $formatType, $priorityType ) {
		ArgumentValidator::validate($timestamp, ExtendsValidatorRule::getRule("DateAndTime"));
		ArgumentValidator::validate($category, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($backtrace, StringValidatorRule::getRule());
		ArgumentValidator::validate($agents, ArrayValidatorRule::getRule());
		ArgumentValidator::validate($nodes, ArrayValidatorRule::getRule());
		ArgumentValidator::validate($formatType, ExtendsValidatorRule::getRule("Type"));
		ArgumentValidator::validate($priorityType, ExtendsValidatorRule::getRule("type"));
		
		$this->_timestamp =$timestamp;
		$this->_formatType =$formatType;
		$this->_priorityType =$priorityType;
		
		
		$this->_entryItem = new AgentNodeEntryItem($category, $description);
		$this->_entryItem->setBacktrace($backtrace);
		
		$idManager = Services::getService("Id");
		foreach ($agents as $idString) {	
			if ($idString)
				$this->_entryItem->addAgentId($idManager->getId($idString));
		}
		foreach ($nodes as $idString)
			if ($idString)
				$this->_entryItem->addNodeId($idManager->getId($idString));
	}
	
	/**
	 * Return the logged item.
	 *	
	 * @return object mixed (original type: java.io.Serializable)
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
	function getItem () { 
		return $this->_entryItem;
	} 

	/**
	 * Return the format type of logged item.
	 *	
	 * @return object Type
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
	function getFormatType () { 
		return $this->_formatType;
	} 

	/**
	 * Return the format type of logged item.
	 *	
	 * @return object Type
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
	function getPriorityType () { 
		return $this->_priorityType;
	} 

	/**
	 * Return the time that the item was logged.
	 *	
	 * @return object Timestamp OSID specifies returning an int (Unix timestamp)
	 *							but we might as well use our nice primitives.
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
	function getTimestamp () { 
		return $this->_timestamp;
	} 
}

?>