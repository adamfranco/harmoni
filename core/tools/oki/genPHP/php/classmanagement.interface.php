<?php


	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseManagementManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a new CanonicalCourse.
	 * @param title
	 * @param number
	 * @param description
	 * @param courseType
	 * @param courseStatusType
	 * @param credits
	 * @return CanonicalCourse with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCanonicalCourse($title, $number, $description, & $courseType, & $courseStatusType, $credits) { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse createCanonicalCourse
	 * Delete a CanonicalCourse.
	 * @param canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCanonicalCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses.
	 * @return CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCourses()

	/**
	 * Get a CanonicalCourse by Id.
	 * @param canonicalCourseId
	 * @return CanonicalCourse
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse getCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses of the specified Type.
	 * @param courseType
	 * @return CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCoursesByType(& $courseType) { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCoursesByType(osid.shared.Type courseType)

	/**
	 * Get a CourseOffering by Unique Id.
	 * @param courseOfferingId
	 * @return CourseOffering
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering(& $courseOfferingId) { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering getCourseOffering(osid.shared.Id courseOfferingId)

	/**
	 * Get a CourseSection by Unique Id.
	 * @param courseSectionId
	 * @return CourseSection
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseSection(& $courseSectionId) { /* :: interface :: */ }
	// :: full java declaration :: CourseSection getCourseSection(osid.shared.Id courseSectionId)

	/**
	 * Get all the Sections in which the specified Agent is enrolled.
	 * @param agentId
	 * @return CourseSectionIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseSections(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSections(osid.shared.Id agentId)

	/**
	 * Get all the Offerings in which the specified Agent is enrolled.
	 * @param agentId
	 * @return CourseOfferingIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseOfferings(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferings(osid.shared.Id agentId)

	/**
	 * Create a new Term with a specific type and Schedule.  Schedules are defined in the Scheduling SID.
	 * @param termType
	 * @param schedule
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createTerm(& $termType, & $schedule) { /* :: interface :: */ }
	// :: full java declaration :: Term createTerm(osid.shared.Type termType, osid.scheduling.ScheduleItem[] schedule)

	/**
	 * Delete a Term by Unique Id.
	 * @param termId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteTerm(& $termId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteTerm(osid.shared.Id termId)

	/**
	 * Get a Term by Unique Id.
	 * @param termId
	 * @return Term
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getTerm(& $termId) { /* :: interface :: */ }
	// :: full java declaration :: Term getTerm(osid.shared.Id termId)

	/**
	 * Get all the Terms.
	 * @return TermIterator Terms are returned in chronological order by increasing start date.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTerms() { /* :: interface :: */ }
	// :: full java declaration :: TermIterator getTerms()

	/**
	 * Get all the defined Course Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseTypes()

	/**
	 * Get all the defined Canonical Course Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseStatusTypes()

	/**
	 * Get all the defined Course Offering Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getOfferingStatusTypes()

	/**
	 * Get all the defined Course Section Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSectionStatusTypes()

	/**
	 * Get all the defined Offering Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getOfferingTypes()

	/**
	 * Get all the defined Section Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSectionTypes()

	/**
	 * Get all the defined Enrollment Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getEnrollmentStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getEnrollmentStatusTypes()

	/**
	 * Get all the defined Grade Types.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getGradeTypes()

	/**
	 * Get all the TermTypes.
	 * @return osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTermTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getTermTypes()

	/**
	 * Create a GradeRecord for the specified Agent (student), CourseOffering, GradeType, and Grade.  Note that the intent is that this is a summative grade.
	 * @param agentId
	 * @param courseOfferingId
	 * @param gradeType
	 * @param grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &createGradeRecord(& $agentId, & $courseOfferingId, & $gradeType, & $grade) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecord createGradeRecord(osid.shared.Id agentId,osid.shared.Id courseOfferingId,osid.shared.Type gradeType,java.io.Serializable grade)

	/**
	 * Delete the specified GradeRecord by Id.
	 * gradeRecordId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteGradeRecord(& $gradeRecordId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteGradeRecord(osid.shared.Id gradeRecordId)

	/**
	 * Get all the GradeRecords, optionally including only those for a specific Student, CourseOffering, or GradeType.
	 * @param agentId
	 * @param courseOfferingId
	 * @param gradeType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getGradeRecords(& $agentId, & $courseOfferingId, & $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecordIterator getGradeRecords(osid.shared.Id agentId,osid.shared.Id courseOfferingId,osid.shared.Type gradeType)

	/**
	 * Create a CourseGroup of a particular CourseGroupType.  CourseGroups can be used to model prerequisites, corequisites, majors, minors, sequences, etc.
	 * @param courseGroupType
	 * @return CourseGroup with its Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCourseGroup(& $courseGroupType) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroup createCourseGroup(osid.shared.Type courseGroupType)

	/**
	 * Delete a CourseGroup by Unique Id.
	 * @param courseGroupId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseGroup(& $courseGroupId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseGroup(osid.shared.Id courseGroupId)

	/**
	 * Get a CourseGroup by Unique Id.
	 * @param courseGroupId
	 * @return CourseGroup
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseGroup(& $courseGroupId) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroup getCourseGroup(osid.shared.Id courseGroupId)

	/**
	 * Get all the CourseGroups of a given CourseGroupType.
	 * @param courseGroupType
	 * @return CourseGroupIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCourseGroupsByType(& $courseGroupType) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroupIterator getCourseGroupsByType(osid.shared.Type courseGroupType)

	/**
	 * Get all the CourseGroups that contain the specified CanoncialCourse.
	 * @param canonicalCourseId
	 * @return CourseGroupIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseGroups(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroupIterator getCourseGroups(osid.shared.Id canonicalCourseId)

	/**
	 * Get all the CourseGroupTypes supported by this implementation.
	 * @return osid.shared.TypeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseGroupTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseGroupTypes()
}


	/**
	 * CourseGroup manages a set of CanonicalCourses.  CourseGroups have a CourseGroupType which characterizes the group.  CourseGroups can be used to model prerequisites, corequisites, majors, minors, sequences, etc.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseGroup // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this CourseGroup.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Type for this CourseGroup.
	 * @return osid.shared.Type
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
	 * @param canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void removeCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all the CanonicalCourses in this CourseGroup.  Note that different CourseGroupType imply different ordering.  For example, if the CourseGroupType indicates prerequisites order would need be guaranteed; if corequisites order might not need to be guaranteed.
	 * @return CanonicalCourseIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCourses()
}


	/**
	 * CanonicalCourse is designed to capture general information about a course.  This is in contrast to the CourseOffering which is designed to capture information about a concrete offering of this course in a specific term and with identified people and roles.  The CourseSection is the third and most specific course-related object.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CanonicalCourse // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the title for this CanonicalCourse.
	 * @return String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() { /* :: interface :: */ }

	/**
	 * Update the title for this CanonicalCourse.
	 * @param title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($Title) { /* :: interface :: */ }

	/**
	 * Get the number for this CanonicalCourse.
	 * @return String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() { /* :: interface :: */ }

	/**
	 * Update the number for this CanonicalCourse.
	 * @param number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($Number) { /* :: interface :: */ }

	/**
	 * Get the description for this CanonicalCourse.
	 * @return String the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this CanonicalCourse.
	 * @param description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($Description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this CanonicalCourse.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Course Type for this CanonicalCourse.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseType() { /* :: interface :: */ }

	/**
	 * Create a new CanonicalCourse.
	 * @param title
	 * @param number
	 * @param description
	 * @param courseType
	 * @param courseStatusType
	 * @param credits
	 * @return CanonicalCourse with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCanonicalCourse($title, $number, $description, & $courseType, & $courseStatusType, $credits) { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse createCanonicalCourse
	 * Delete a CanonicalCourse.
	 * @param canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCanonicalCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses.
	 * @return CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCourses()

	/**
	 * Get all CanonicalCourses of the specified Type.
	 * @param courseType
	 * @return CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCoursesByType(& $courseType) { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCoursesByType(osid.shared.Type courseType)

	/**
	 * Create a new CourseOffering.
	 * @param title
	 * @param number
	 * @param description
	 * @param termId
	 * @param offeringType
	 * @param offeringStatusType
	 * @param gradeType
	 * @return CourseOffering with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCourseOffering($title, $number, $description, & $termId, & $offeringType, & $offeringStatusType, & $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering createCourseOffering
	 * Delete a CourseOffering.
	 * @param courseOfferingId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseOffering(& $courseOfferingId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseOffering(osid.shared.Id courseOfferingId)

	/**
	 * Get all CourseOfferingsc.
	 * @return CourseOfferingIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseOfferings() { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferings()

	/**
	 * Get all CourseOfferings of the specified Type.
	 * @param offeringType
	 * @return CourseOfferingIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCourseOfferingsByType(& $offeringType) { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferingsByType(osid.shared.Type offeringType)

	/**
	 * Add an equivalent course which are for mapping courses across departments, schools, or institutions as well as for providing new courses that map to previous ones.  This can be used for cross-listening.  Note that if course A is equivalent to course B it does not necessarily follow that course B is equivalent to course A.  Course A could cover a superset of the mateiral in course B.
	 * @param canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addEquivalentCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void addEquivalentCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Remove a equivalent courses for this CanonicalCourse.
	 * @param canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeEquivalentCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void removeEquivalentCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all equivalent courses for this CanonicalCourse.
	 * @return CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getEquivalentCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getEquivalentCourses()

	/**
	 * Add a Topic for this CanonicalCourse.
	 * @param topic
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: void addTopic(String topic)

	/**
	 * Remove a Topic for this CanonicalCourse.
	 * @param topic
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function removeTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: void removeTopic(String topic)

	/**
	 * Get all Topics for this CanonicalCourse.
	 * @return osid.shared.StringIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTopics() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getTopics()

	/**
	 * Get the credits for this CanonicalCourse.
	 * @return float credits
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getCredits() { /* :: interface :: */ }

	/**
	 * Update the credits for this CanonicalCourse.
	 * @param credits
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateCredits($Credits) { /* :: interface :: */ }

	/**
	 * Get the Status for this CanonicalCourse.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CanonicalCourse.
	 * @param statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)
}


	/**
	 * CourseOffering is a CanonicalCourse offered in a specific Term.  CanonicalCourse is designed to capture general information about a course in general.  The CourseSection is the third and most specific course-related object.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require.  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseOffering // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the title for this CourseOffering.
	 * @return String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() { /* :: interface :: */ }

	/**
	 * Update the title for this CourseOffering.
	 * @param title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($Title) { /* :: interface :: */ }

	/**
	 * Get the number for this CourseOffering.
	 * @return String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() { /* :: interface :: */ }

	/**
	 * Update the number for this CourseOffering.
	 * @param number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($Number) { /* :: interface :: */ }

	/**
	 * Get the description for this CourseOffering.
	 * @return String the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this CourseOffering.
	 * @param description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($Description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this CourseOffering.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Offering Type for this CourseOffering.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingType() { /* :: interface :: */ }

	/**
	 * Get the CanonicalCourse that contains this CourseOffering.
	 * @return CanonicalCourse
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourse() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse getCanonicalCourse()

	/**
	 * Create a new CourseSection.
	 * @param title
	 * @param number
	 * @param description
	 * @param sectionType
	 * @param sectionStatusType
	 * @param location
	 * @return CourseSection with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCourseSection($title, $number, $description, & $sectionType, & $sectionStatusType, & $location) { /* :: interface :: */ }
	// :: full java declaration :: CourseSection createCourseSection
	 * Delete a CourseSection.
	 * @param courseSectionId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseSection(& $courseSectionId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseSection(osid.shared.Id courseSectionId)

	/**
	 * Get all CourseSections.
	 * @return CourseSectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseSections() { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSections()

	/**
	 * Get all CourseSections of the specified Type.
	 * @param sectionType
	 * @return CourseSectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCourseSectionsByType(& $sectionType) { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSectionsByType(osid.shared.Type sectionType)

	/**
	 * Add an Asset for this CourseOffering.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void addAsset(osid.shared.Id assetId)

	/**
	 * Remove an Asset for this CourseOffering.
	 * @param assetId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void removeAsset(osid.shared.Id assetId)

	/**
	 * Get the Assets associated with this CourseOffering.
	 * @return osid.shared.IdIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getAssets() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.IdIterator getAssets()

	/**
	 * Get the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeType() { /* :: interface :: */ }

	/**
	 * Update the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @param gradeType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateGradeType(& $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: void updateGradeType(osid.shared.Type gradeType)

	/**
	 * Get a Term by Unique Id.
	 * @return Term
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTerm() { /* :: interface :: */ }

	/**
	 * Get the Status for this CanonicalCourse.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CanonicalCourse.
	 * @param statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)

	/**
	 * Add a student to the roster and assign the specified Enrollment Status Type.
	 * @param agentId
	 * @param enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void addStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Change the Enrollment Status Type for the student on the roster.
	 * @param agentId
	 * @param enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function changeStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void changeStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Remove a student from the roster.
	 * @param agentId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeStudent(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: void removeStudent(osid.shared.Id agentId)

	/**
	 * Get the student roster.
	 * @return EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getRoster() { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRoster()

	/**
	 * Get the student roster.  Include only students with the specified Enrollment Status Type.
	 * @param enrollmentStatusType
	 * @return EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getRosterByType(& $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRosterByType(osid.shared.Type enrollmentStatusType)
}


	/**
	 * CourseSection is associated with a CourseOffering and is has a separate roster and possibly a separate SectionType from any other Sections of the Offering. CanonicalCourse is designed to capture general information about a course.  This is in contrast to the CourseOffering which is designed to capture information about a concrete offering of this course in a specific term and with identified people and roles.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseSection // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the title for this CourseSection.
	 * @return String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() { /* :: interface :: */ }

	/**
	 * Update the title for this CourseSection.
	 * @param title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($Title) { /* :: interface :: */ }

	/**
	 * Get the number for this CourseSection.
	 * @return String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() { /* :: interface :: */ }

	/**
	 * Update the number for this CourseSection.
	 * @param number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($Number) { /* :: interface :: */ }

	/**
	 * Get the description for this CourseSection.
	 * @return String the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this CourseSection.
	 * @param description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($Description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this CourseSection.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Section Type for this CourseSection.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionType() { /* :: interface :: */ }

	/**
	 * Get the CourseOffering that contains this CourseSection.
	 * @return CourseOffering
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering() { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering getCourseOffering()

	/**
	 * Add an Asset for this CourseSection.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void addAsset(osid.shared.Id assetId)

	/**
	 * Remove an Asset for this CourseSection.
	 * @param assetId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: void removeAsset(osid.shared.Id assetId)

	/**
	 * Get the Assets associated with this CourseSection.
	 * @return osid.shared.IdIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getAssets() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.IdIterator getAssets()

	/**
	 * Get the Schedule for this Section.  Schedules are defined in osid.sched.  ScheduleItems are returned in chronological order by increasing start date.
	 * @return osid.scheduling.schedule
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSchedule() { /* :: interface :: */ }

	/**
	 * Update the Schedule for this Section.  Schedules are defined in osid.sched.
	 * @param scheduleItems
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateSchedule(& $scheduleItems[]) { /* :: interface :: */ }
	// :: full java declaration :: void updateSchedule(osid.scheduling.ScheduleItem scheduleItems[])

	/**
	 * Get the location may be a room address, a map, or any other object.
	 * @return java.io.Serializable
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getLocation() { /* :: interface :: */ }

	/**
	 * Update the location may be a room address, a map, or any other object.
	 * @param location
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateLocation(& $Location) { /* :: interface :: */ }

	/**
	 * Add a student to the roster and assign the specified Enrollment Status Type.
	 * @param agentId
	 * @param enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void addStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Change the Enrollment Status Type for the student on the roster.
	 * @param agentId
	 * @param enrollmentStatusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function changeStudent(& $agentId, & $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: void changeStudent(osid.shared.Id agentId, osid.shared.Type enrollmentStatusType)

	/**
	 * Remove a student from the roster.
	 * @param agentId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeStudent(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: void removeStudent(osid.shared.Id agentId)

	/**
	 * Get the student roster.
	 * @return EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getRoster() { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRoster()

	/**
	 * Get the student roster.  Include only students with the specified Enrollment Status Type.
	 * @param enrollmentStatusType
	 * @return EnrollmentRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getRosterByType(& $enrollmentStatusType) { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecordIterator getRosterByType(osid.shared.Type enrollmentStatusType)

	/**
	 * Get the Status for this CourseSection.
	 * @return osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CourseSection.
	 * @param statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)
}


	/**
	 * Term includes an Unique Id set by the implementation, a TermType, and an osid.sched.Schedule. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class Term // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Term.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Type for this Term.  This Type is meaningful to the implementation and applications and is not specified by the SID.
	 * @return osid.shared.Type Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getType() { /* :: interface :: */ }

	/**
	 * Get the Schedule for this Term.  Schedules are defined in osid.sched.  ScheduleItems are returned in chronological order by increasing start date.
	 * @return osid.scheduling.ScheduleItemIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSchedule() { /* :: interface :: */ }
}


	/**
	 * EnrollmentRecord stores a student (Agent) and an Enrollment Status Type.  The EnrollmentRecord is the result of adding or changing a student in a CourseSection.  If the student is removed from the CourseSection, there will no longer be an EnrollmentRecord for the student.  The joining of a status type to a student allows for the characterization of the student.  For example, students might be added as regular students or auditing.  Students might be on the enrollment list, but their status might be withdrawn passing or withdrawn failing, etc.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class EnrollmentRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Id of the Agent representing a student enrolled in the CourseSection.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation agentId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStudent() { /* :: interface :: */ }

	/**
	 * Get the Status Type for a student.  Students Status Type is supplied when the student is added or changed in the CourseSection.  The CourseManagementManager returns the Status Types supported by this implementation.
	 * @return osid.shared.Type Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStatus() { /* :: interface :: */ }
}


	/**
	 * GradeRecord manages the Grade of a specific GradeType for an Agent and a CourseOffering.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class GradeRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the grade for this GradeRecord.
	 * @return java.io.Serializable grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGrade() { /* :: interface :: */ }

	/**
	 * Update the grade for this GradeRecord.
	 * @param grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateGrade(& $Grade) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this GradeRecord.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Unique Id for the CourseOffering for this GradeRecord..
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation courseOfferingId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getCourseOffering()

	/**
	 * Get the Agent (student) associated with this GradeRecord.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getStudent() { /* :: interface :: */ }

	/**
	 * Get the Grade for this Offering.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return osid.shared.Type termType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeType() { /* :: interface :: */ }
}


	/**
	 * CanonicalCourseIterator provides access to CanonicalCourses.  CanonicalCourse provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CanonicalCourseIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  CanonicalCourses ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next CanonicalCourses.
	 * @return CanonicalCourse
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourse next()
}


	/**
	 * CourseOfferingIterator provides access to CourseOfferings.  CourseOffering provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseOfferingIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  CourseOfferings ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next CourseOfferings.
	 * @return CourseOffering
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering next()
}


	/**
	 * CourseSectionIterator provides access to CourseSections.  CourseSection provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseSectionIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  CourseSections ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next CourseSections.
	 * @return CourseSection
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: CourseSection next()
}


	/**
	 * TermIterator provides access to Terms.  Term provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class TermIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  Term ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Terms.
	 * @return Term
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Term next()
}


	/**
	 * GradeRecordIterator provides access to GradeRecords.  GradeRecord provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class GradeRecordIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  GradeRecord ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next GradeRecords.
	 * @return GradeRecord
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: GradeRecord next()
}


	/**
	 * CourseGroupIterator provides access to CourseGroups.  CourseGroup provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseGroupIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  CourseGroup ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next CourseGroups.
	 * @return CourseGroup
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: CourseGroup next()
}


	/**
	 * EnrollmentRecordIterator provides access to EnrollmentRecords.  EnrollmentRecord provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class EnrollmentRecordIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  EnrollmentRecord ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next EnrollmentRecords.
	 * @return EnrollmentRecord
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.classmanagement
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: EnrollmentRecord next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class CourseManagementException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown or unsupported Type
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Operation failed
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Null argument
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Permission denied
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Object already added
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");

	/**
	 * Configuration error
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * Unknown topic
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("UNKNOWN_TOPIC","Unknown Topic ");

	/**
	 * Invalid credits value
	 * @package osid.classmanagement
	 */
	// :: defined globally :: define("INVALID_CREDITS_VALUE","Invalid value for credits ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.classmanagement
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.classmanagement
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.classmanagement
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.classmanagement
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.classmanagement
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.classmanagement
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string ALREADY_ADDED public static final String ALREADY_ADDED = "Object already added "
 * @package osid.classmanagement
 */
define("ALREADY_ADDED", "Object already added ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.classmanagement
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.classmanagement
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string UNKNOWN_TOPIC public static final String UNKNOWN_TOPIC = "Unknown Topic "
 * @package osid.classmanagement
 */
define("UNKNOWN_TOPIC", "Unknown Topic ");

/**
 * @const string INVALID_CREDITS_VALUE public static final String INVALID_CREDITS_VALUE = "Invalid value for credits "
 * @package osid.classmanagement
 */
define("INVALID_CREDITS_VALUE", "Invalid value for credits ");

?>
