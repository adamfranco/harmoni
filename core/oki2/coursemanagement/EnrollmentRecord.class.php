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
 * @package harmoni.osid.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EnrollmentRecord.class.php,v 1.3 2005/01/19 17:39:09 adamfranco Exp $
 */
class HarmoniEnrollmentRecord
	extends EnrollmentRecord
{
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
	function &getStudent () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "EnrollmentRecord", true)); 
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
	function &getStatus () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "EnrollmentRecord", true)); 
	} 
}

?>