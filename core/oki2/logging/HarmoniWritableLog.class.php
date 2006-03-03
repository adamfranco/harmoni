<?php 
/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniWritableLog.class.php,v 1.1 2006/03/03 17:45:52 adamfranco Exp $
 */

require_once(OKI2."/osid/logging/WritableLog.php");
require_once(dirname(__FILE__)."/HarmoniReadableLog.class.php");

/**
 * Interface WritableLog allows writing of entry items, format types, priority
 * types to a log.	Two methods are used to write the entryItems:
 * 
 * <p>
 * <code>appendLog(java.io.Serializable entryItem)</code> which writes the
 * entry to the Log,
 * </p>
 * 
 * <p>
 * <code>appendLog(java.io.Serializable entryItem, org.osid.shared.Type
 * formatType, org.osid.shared.Type priorityType)</code> which writes the
 * entryItem to the Log as well as formatType and priorityType.
 * </p>
 * 
 * <p>
 * The implementation sets the timestamp for the for when the entryItem was
 * appended to the log. The format type and the priority type can be set as
 * defaults for subsequent appends.
 * </p>
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
class HarmoniWritableLog
	extends HarmoniReadableLog
//	extends WritableLog	// implements writable log
{

	/**
	 * Write the entryItem to the Log. The entryItem is written to the Log
	 * using the format type and priority type explicitly set by the
	 * application or the implementation default.
	 * 
	 * @param object mixed $entryItem (original type: java.io.Serializable)
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
	 *		   org.osid.logging.LoggingException#PRIORITY_TYPE_NOT_SET
	 *		   PRIORITY_TYPE_NOT_SET}, {@link
	 *		   org.osid.logging.LoggingException#FORMAT_TYPE_NOT_SET
	 *		   FORMAT_TYPE_NOT_SET}, {@link
	 *		   org.osid.logging.LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function appendLog ( &$entryItem ) {
		if (!$entryItem)
			throwError(new Error(LoggingException::NULL_ARGUMENT(), "HarmoniWritableLog"));
		if (!isset($this->_formatType))
			throwError(new Error(LoggingException::FORMAT_TYPE_NOT_SET(), "HarmoniWritableLog"));
		if (!isset($this->_priorityType))
			throwError(new Error(LoggingException::PRIORITY_TYPE_NOT_SET(), "HarmoniWritableLog"));
		
		$this->appendLogWithTypes($entryItem, $this->_formatType, $this->_priorityType);
	} 

	/**
	 * Write the entry, the priorityType and formatType to the Log.
	 * 
	 * @param object mixed $entryItem (original type: java.io.Serializable)
	 * @param object Type $formatType
	 * @param object Type $priorityType
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
	 *		   org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.logging.LoggingException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function appendLogWithTypes ( &$entryItem, &$formatType, &$priorityType ) { 
		ArgumentValidator::validate($entryItem, ExtendsValidatorRule::getRule("AgentNodeEntryItem"));
		ArgumentValidator::validate($formatType, ExtendsValidatorRule::getRule("Type"));
		ArgumentValidator::validate($priorityType, ExtendsValidatorRule::getRule("Type"));
			
		$formatTypeId = $this->_getTypeId($formatType);
		$priorityTypeId = $this->_getTypeId($priorityType);
		
		$dbc =& Services::getService("DatabaseManager");
		
		// Insert the entry
		$query =& new InsertQuery;
		$query->setTable("log_entry");
		$query->setColumns(array(	"log_name",
									"fk_format_type",
									"fk_priority_type",
									"description"));
		$query->addRowOfValues(array("'".addslashes($this->_name)."'",
									"'".addslashes($formatTypeId)."'",
									"'".addslashes($priorityTypeId)."'",
									"'".addslashes($entryItem->getDescription())."'"));
		$results =& $dbc->query($query, $this->_dbIndex);
		$entryId = $results->getLastAutoIncrementValue();
		
		// Add the agents
		$agentIds =& $entryItem->getAgentIds();
		if (!$agentIds->hasNext())
			$entryItem->addUserIds();
		
		$agentIds =& $entryItem->getAgentIds();
		if ($agentIds->hasNext()) {
			$query =& new InsertQuery;
			$query->setTable("log_agent");
			$query->setColumns(array(	"fk_entry",
										"fk_agent"));
			while ($agentIds->hasNext()) {
				$agentId =& $agentIds->next();
				$query->addRowOfValues(array("'".addslashes($entryId)."'",
										"'".addslashes($agentId->getIdString())."'"));
			}
			$dbc->query($query, $this->_dbIndex);
		}
		
		// Add the nodes
		$nodeIds =& $entryItem->getNodeIds();
		if ($nodeIds->hasNext()) {
			$query =& new InsertQuery;
			$query->setTable("log_node");
			$query->setColumns(array(	"fk_entry",
										"fk_node"));
			while ($nodeIds->hasNext()) {
				$nodeId =& $nodeIds->next();
				$query->addRowOfValues(array("'".addslashes($entryId)."'",
										"'".addslashes($nodeId->getIdString())."'"));
			}
			$dbc->query($query, $this->_dbIndex);
		}
	} 

	/**
	 * Assign the priorityType for all subsequent writes during the lifetime of
	 * this instance. PriorityType has meaning to the caller of this method.
	 * 
	 * @param object Type $priorityType
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
	 *		   org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.logging.LoggingException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignPriorityType ( &$priorityType ) {
		ArgumentValidator::validate($priorityType, ExtendsValidatorRule::getRule("Type"));
		$this->_priorityType =& $priorityType;
	} 

	/**
	 * Assign the formatType for all subsequent writes during the lifetime of
	 * this instance. FormatType has meaning to the caller of this method.
	 * 
	 * @param object Type $formatType
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
	 *		   org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.logging.LoggingException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignFormatType ( &$formatType ) {
		ArgumentValidator::validate($formatType, ExtendsValidatorRule::getRule("Type"));
		$this->_formatType =& $formatType;
	}
	
	/**
	 * Answer the database id for the type passed.
	 * 
	 * @param object Type $type
	 * @return string
	 * @access public
	 * @since 3/1/06
	 */
	function _getTypeId ( &$type ) {
		if (!isset($this->_typeIds))
			$this->_typeIds = array();
		
		if (!isset($this->_typeIds[Type::typeToString($type)])) {
			$dbc =& Services::getService("DatabaseManager");
			$query =& new SelectQuery;
			$query->addColumn("id");
			$query->addTable("log_type");
			$query->addWhere("domain = '".addslashes($type->getDomain())."'");
			$query->addWhere("authority = '".addslashes($type->getAuthority())."'");
			$query->addWhere("keyword = '".addslashes($type->getKeyword())."'");
			$results =& $dbc->query($query, $this->_dbIndex);
			
			if ($results->getNumberOfRows()) {
				$this->_typeIds[Type::typeToString($type)] = $results->field("id");
				$results->free();
			} else {
				$results->free();
				$query =& new InsertQuery;
				$query->setTable("log_type");
				$query->setColumns(array(	"domain",
											"authority",
											"keyword",
											"description"));
				$query->addRowOfValues(array("'".addslashes($type->getDomain())."'",
											"'".addslashes($type->getAuthority())."'",
											"'".addslashes($type->getKeyword())."'",
											"'".addslashes($type->getDescription())."'"));
				$results =& $dbc->query($query, $this->_dbIndex);
				$this->_typeIds[Type::typeToString($type)] = $results->getLastAutoIncrementValue();
			}
		}
		return $this->_typeIds[Type::typeToString($type)];
	}
}

?>