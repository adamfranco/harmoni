<?

/**
 * CourseSection is associated with a CourseOffering and is has a separate roster and possibly a separate SectionType from any other Sections of the Offering. CanonicalCourse is designed to capture general information about a course.  This is in contrast to the CourseOffering which is designed to capture information about a concrete offering of this course in a specific term and with identified people and roles.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CourseSection.class.php,v 1.3 2005/01/19 21:10:04 adamfranco Exp $
 */
class HarmoniCourseSection // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the title for this CourseSection.
	 * @return object String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() { /* :: interface :: */ }

	/**
	 * Update the title for this CourseSection.
	 * @param object title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($Title) { /* :: interface :: */ }

	/**
	 * Get the number for this CourseSection.
	 * @return object String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() { /* :: interface :: */ }

	/**
	 * Update the number for this CourseSection.
	 * @param object number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($Number) { /* :: interface :: */ }

	/**
	 * Get the description for this CourseSection.
	 * @return string the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this CourseSection.
	 * @param string description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this CourseSection.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Section Type for this CourseSection.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionType() { /* :: interface :: */ }

	/**
	 * Get the CourseOffering that contains this CourseSection.
	 * @return object CourseOffering
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering() { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering getCourseOffering()

	/**
	 * Add an Asset for this CourseSection.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void addAsset(osid.shared.Id assetId)

	/**
	 * Remove an Asset for this CourseSection.
	 * @param object assetId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void removeAsset(osid.shared.Id assetId)

	/**
	 * Get the Assets associated with this CourseSection.
	 * @return object osid.shared.IdIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getAssets() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.IdIterator getAssets()

	/**
	 * Get the Schedule for this Section.  Schedules are defined in osid.sched.  ScheduleItems are returned in chronological order by increasing start date.
	 * @return object osid.scheduling.schedule
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSchedule() { /* :: interface :: */ }

	/**
	 * Update the Schedule for this Section.  Schedules are defined in osid.sched.
	 * @param object scheduleItems
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateSchedule(& $scheduleItems) { /* :: interface :: */ }
	// :: full java declaration :: void updateSchedule(osid.scheduling.ScheduleItem scheduleItems[])

	/**
	 * Get the location may be a room address, a map, or any other object.
	 * @return object java.io.Serializable
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getLocation() { /* :: interface :: */ }

	/**
	 * Update the location may be a room address, a map, or any other object.
	 * @param object location
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateLocation(& $Location) { /* :: interface :: */ }

	/**
	 * Add a student to the roster and assign the specified Enrollment Status Type.
	 * @param object agentId
	 * @param object enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void addStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Change the Enrollment Status Type for the student on the roster.
	 * @param object agentId
	 * @param object enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function changeStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void changeStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Remove a student from the roster.
	 * @param object agentId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeStudent(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: void removeStudent(osid.shared.Id agentId)

	/**
	 * Get the student roster.
	 * @return object EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getRoster() { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRoster()

	/**
	 * Get the student roster.  Include only students with the specified Enrollment Status Type.
	 * @param object enrollmentStatusType
	 * @return object EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getRosterByType(& $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRosterByType(osid.shared.Type enrollmentStatusType)

	/**
	 * Get the Status for this CourseSection.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CourseSection.
	 * @param object statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)
}