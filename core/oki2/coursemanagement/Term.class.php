<?php 

require_once(OKI2."/osid/coursemanagement/Term.php");
 
/**
 * Term includes an unique Id assigned by the implementation, a display name, a
 * termType, and  a schedule.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid_v2.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Term.class.php,v 1.15 2006/07/14 19:39:23 sporktim Exp $
 */
class HarmoniTerm
	extends Term
{
	
		/**
	 * @variable object $_id the unique id for this term.
	 * @access private
	 * @variable object $_table the term table.
	 * @access private
	 **/
	var $_id;
	var $_table;
	
	/**
	 * The constructor.
	 * 
	 * @param object Id $id
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniTerm(&$id)
	{
		$this->_id =& $id;
		$this->_table = 'cm_term';
		
	}
	
	
	
	/**
	 * Update the display name for this Term.
	 * 
	 * @param string $displayName
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		
		$this->_setField('name',$displayName);
	} 

	/**
	 * Get the display name for this Term.
	 *	
	 * @return string
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getDisplayName () { 
		
		return $this->_getField('name');
	} 

	/**
	 * Get the unique Id for this Term.
	 *	
	 * @return object Id
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getId () { 
		
		return $this->_id;
	} 

	/**
	 * Get the Type for this Term.	This Type is meaningful to the
	 * implementation and applications and is not specified by the OSID.
	 *	
	 * @return object Type
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getType () { 
		
		return $this->_getType('term');
	} 

	/**
	 * Get the Schedule for this Term.	Schedules are defined in scheduling
	 * OSID.  ScheduleItems are returned in chronological order by increasing
	 * start date.
	 *	
	 * @return object ScheduleItemIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getSchedule () { 
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_schedule');
		$query->addColumn('fk_sc_item');
		$query->addWhere("fk_id='".addslashes($this->_id->getIdString())."'");
		//$query->addOrderBy
		$res=& $dbManager->query($query);
		$array=array();
		$sm =& Services::getService("SchedulingManager");
		$idManager =& Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$si =&  $sm->getScheduleItem($id);
			$array[$si->getStart()] =& $si;
		}
		ksort($array);
		$ret =& new HarmoniScheduleItemIterator($array);
		return $ret;
	} 
	
	
	
	
	function _typeToIndex($typename, &$type)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_typeToIndex($typename, $type);
	}
	
	function &_getTypes($typename)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_getField($this->_id,$this->_table,$key);
	}
	
	
	function &_getType($typename){
		$cm=Services::getService("CourseManagement");
		return $cm->_getType($this->_id,$this->_table,$typename);
	}
	
	function _setField($key, $value)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_setField($this->_id,$this->_table,$key, $value);		
	}
	
	
	
}

?>