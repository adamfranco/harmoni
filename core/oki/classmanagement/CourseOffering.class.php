<?

	/**
	 * CourseOffering is a CanonicalCourse offered in a specific Term.  CanonicalCourse is designed to capture general information about a course in general.  The CourseSection is the third and most specific course-related object.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require.  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class HarmoniCourseOffering // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the title for this CourseOffering.
	 * @return object String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() { /* :: interface :: */ }

	/**
	 * Update the title for this CourseOffering.
	 * @param object title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($Title) { /* :: interface :: */ }

	/**
	 * Get the number for this CourseOffering.
	 * @return object String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() { /* :: interface :: */ }

	/**
	 * Update the number for this CourseOffering.
	 * @param object number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($Number) { /* :: interface :: */ }

	/**
	 * Get the description for this CourseOffering.
	 * @return string the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this CourseOffering.
	 * @param string description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this CourseOffering.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Offering Type for this CourseOffering.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingType() { /* :: interface :: */ }

	/**
	 * Get the CanonicalCourse that contains this CourseOffering.
	 * @return object CanonicalCourse
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourse() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse getCanonicalCourse()

	/**
	 * Create a new CourseSection.
	 * @param object title
	 * @param object number
	 * @param string description
	 * @param object sectionType
	 * @param object sectionStatusType
	 * @param object location
	 * @return object CourseSection with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCourseSection($title, $number, $description, & $sectionType, & $sectionStatusType, & $location) { /* :: interface :: */ }
	// :: full java declaration :: CourseSection createCourseSection
	/**
	 * Delete a CourseSection.
	 * @param object courseSectionId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseSection(& $courseSectionId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseSection(osid.shared.Id courseSectionId)

	/**
	 * Get all CourseSections.
	 * @return object CourseSectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseSections() { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSections()

	/**
	 * Get all CourseSections of the specified Type.
	 * @param object sectionType
	 * @return object CourseSectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCourseSectionsByType(& $sectionType) { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSectionsByType(osid.shared.Type sectionType)

	/**
	 * Add an Asset for this CourseOffering.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void addAsset(osid.shared.Id assetId)

	/**
	 * Remove an Asset for this CourseOffering.
	 * @param object assetId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void removeAsset(osid.shared.Id assetId)

	/**
	 * Get the Assets associated with this CourseOffering.
	 * @return object osid.shared.IdIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getAssets() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.IdIterator getAssets()

	/**
	 * Get the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeType() { /* :: interface :: */ }

	/**
	 * Update the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @param object gradeType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateGradeType(& $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: void updateGradeType(osid.shared.Type gradeType)

	/**
	 * Get a Term by Unique Id.
	 * @return object Term
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTerm() { /* :: interface :: */ }

	/**
	 * Get the Status for this CanonicalCourse.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CanonicalCourse.
	 * @param object statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)

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
}