<?

	/**
	 * GradeRecord manages the Grade of a specific GradeType for an Agent and a CourseOffering.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid_v1.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GradeRecord.class.php,v 1.4 2005/01/19 22:28:05 adamfranco Exp $
	 */
class HarmoniGradeRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the grade for this GradeRecord.
	 * @return object java.io.Serializable grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGrade() { /* :: interface :: */ }

	/**
	 * Update the grade for this GradeRecord.
	 * @param object grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateGrade(& $Grade) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this GradeRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Unique Id for the CourseOffering for this GradeRecord..
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation courseOfferingId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getCourseOffering()

	/**
	 * Get the Agent (student) associated with this GradeRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStudent() { /* :: interface :: */ }

	/**
	 * Get the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.Type termType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeType() { /* :: interface :: */ }
}