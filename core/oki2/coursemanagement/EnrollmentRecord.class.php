<?php 

require_once(OKI2."/osid/coursemanagement/EnrollmentRecord.php");

/**
 * EnrollmentRecord stores a student (Agent) and an Enrollment Status Type.
 * The EnrollmentRecord is the result of adding or changing a student in a
 * CourseSection.  If the student is removed from the CourseSection, there
 * will no longer be an EnrollmentRecord for the student.  The joining of a
 * status type to a student allows for the characterization of the student.
 * For example, students might be added as regular students or auditing.
 * Students might be on the enrollment list, but their status might be
 * withdrawn passing or withdrawn failing, etc.
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
 * @version $Id: EnrollmentRecord.class.php,v 1.12 2008/02/06 15:37:48 adamfranco Exp $
 */
class HarmoniEnrollmentRecord
	implements EnrollmentRecord
{
	
	/**
	 * @variable object $_id the unique id for this EnrollmentRecord.
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
	function HarmoniEnrollmentRecord($id)
	{
		$this->_id =$id;
		$this->_table = 'cm_enroll';
		
	}
	
	
	/**
	 * Get the Id of the Agent representing a student enrolled in the
	 * CourseSection.
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
	function getStudent () { 
		$idManager = Services::getService("IdManager");
		$idString = $this->_getField('fk_student_id');
		$ret =$idManager->getId($idString);
		return $ret;
		 
	} 
	
	/**
	 * Get the CourseSection that this EnrollmentRecord 
	 * enrolls the student in.
	 * 
	 * WARNING: NOT IN OSID -- USE AT YOUR OWN RISK
	 *
	 * @return object CourseSection
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
	function getCourseSection () { 
		$cm = Services::getService("CourseManagement");
		$idManager = Services::getService("IdManager");
		$idString = $this->_getField('fk_cm_section');
		$id =$idManager->getId($idString);
		return $cm->getCourseSection($id);
		 
	} 

	/**
	 * Get the Status Type for a student.  Students Status Type is supplied
	 * when the student is added or changed in the CourseSection.  The
	 * CourseManagementManager returns the Status Types supported by this
	 * implementation.
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
	function getStatus () { 
		 
		return $this->_getType('enroll_stat');
	} 
	
	
	
	function _typeToIndex($typename, $type)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_typeToIndex($typename, $type);
	}
	
	function _getTypes($typename)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_getField($this->_id,$this->_table,$key);
	}
	
	
	function _getType($typename){
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