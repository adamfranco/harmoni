<?

/**
 * CourseGroup manages a set of CanonicalCourses.  CourseGroups have a CourseGroupType which characterizes the group.  CourseGroups can be used to model prerequisites, corequisites, majors, minors, sequences, etc.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CourseGroup.class.php,v 1.4 2005/01/19 21:10:03 adamfranco Exp $ */
class CourseGroup // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this CourseGroup.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Type for this CourseGroup.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getType() { /* :: interface :: */ }

	/**
	 * Add a CanonicalCourse to this CourseGroup.  Order may be preserved, depending on CourseGroupType.
	 * canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void addCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Remove a CanonicalCourse from the CourseGroup.
	 * @param object canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void removeCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all the CanonicalCourses in this CourseGroup.  Note that different CourseGroupType imply different ordering.  For example, if the CourseGroupType indicates prerequisites order would need be guaranteed; if corequisites order might not need to be guaranteed.
	 * @return object CanonicalCourseIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCourses()
}