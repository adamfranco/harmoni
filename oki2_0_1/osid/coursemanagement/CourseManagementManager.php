<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * CourseManagementManager handles creating and deleting
 * 
 * <ul>
 * <li>
 * CanonicalCourse,
 * </li>
 * <li>
 * CourseGradeRecord,
 * </li>
 * <li>
 * CourseGroup,
 * </li>
 * <li>
 * Term;
 * </li>
 * </ul>
 * 
 * and gets:
 * 
 * <ul>
 * <li>
 * CanonicalCourse,
 * </li>
 * <li>
 * CourseGradeRecord,
 * </li>
 * <li>
 * CourseGroup,
 * </li>
 * <li>
 * CourseOffering,
 * </li>
 * <li>
 * CourseSection,
 * </li>
 * <li>
 * Term,
 * </li>
 * <li>
 * various implementation Types.
 * </li>
 * </ul>
 * </p>
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p></p>
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
 * @package org.osid.coursemanagement
 */
interface CourseManagementManager
    extends OsidManager
{
    /**
     * Create a new CanonicalCourse.
     * 
     * @param string $title
     * @param string $number
     * @param string $description
     * @param object Type $courseType
     * @param object Type $courseStatusType
     * @param float $credits
     *  
     * @return object CanonicalCourse
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function createCanonicalCourse ( $title, $number, $description, Type $courseType, Type $courseStatusType, $credits ); 

    /**
     * Delete a CanonicalCourse.
     * 
     * @param object Id $canonicalCourseId
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteCanonicalCourse ( Id $canonicalCourseId ); 

    /**
     * Get all CanonicalCourses.
     *  
     * @return object CanonicalCourseIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCanonicalCourses (); 

    /**
     * Get a CanonicalCourse by Id.
     * 
     * @param object Id $canonicalCourseId
     *  
     * @return object CanonicalCourse
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCanonicalCourse ( Id $canonicalCourseId ); 

    /**
     * Get all CanonicalCourses of the specified Type.
     * 
     * @param object Type $courseType
     *  
     * @return object CanonicalCourseIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getCanonicalCoursesByType ( Type $courseType ); 

    /**
     * Get a CourseOffering by unique Id.
     * 
     * @param object Id $courseOfferingId
     *  
     * @return object CourseOffering
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseOffering ( Id $courseOfferingId ); 

    /**
     * Get a CourseSection by unique Id.
     * 
     * @param object Id $courseSectionId
     *  
     * @return object CourseSection
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseSection ( Id $courseSectionId ); 

    /**
     * Get all the Sections in which the specified Agent is enrolled.
     * 
     * @param object Id $agentId
     *  
     * @return object CourseSectionIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseSections ( Id $agentId ); 

    /**
     * Get all the Offerings in which the specified Agent is enrolled.
     * 
     * @param object Id $agentId
     *  
     * @return object CourseOfferingIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseOfferings ( Id $agentId ); 

    /**
     * Create a new Term with a specific type and Schedule.  Schedules are
     * defined in the scheduling OSID.
     * 
     * @param object Type $termType
     * @param object array $schedule
     *  
     * @return object Term
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function createTerm ( Type $termType, array $schedule ); 

    /**
     * Delete a Term by unique Id.
     * 
     * @param object Id $termId
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteTerm ( Id $termId ); 

    /**
     * Get a Term by unique Id.
     * 
     * @param object Id $termId
     *  
     * @return object Term
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getTerm ( Id $termId ); 

    /**
     * Get all the Terms.
     *  
     * @return object TermIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getTerms (); 

    /**
     * Get all the Terms that contain this date.
     * 
     * @param int $date
     *  
     * @return object TermIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getTermsByDate ( $date ); 

    /**
     * Get all the defined Course Types.  These Types are meaningful to the
     * implementation and applications and are not specified by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCourseTypes (); 

    /**
     * Get all the defined Canonical Course Status Types.  These Types are
     * meaningful to the implementation and applications and are not specified
     * by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCourseStatusTypes (); 

    /**
     * Get all the defined Course Offering Status Types.  These Types are
     * meaningful to the implementation and applications and are not specified
     * by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getOfferingStatusTypes (); 

    /**
     * Get all the defined Course Section Status Types.  These Types are
     * meaningful to the implementation and applications and are not specified
     * by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getSectionStatusTypes (); 

    /**
     * Get all the defined Offering Types.  These Types are meaningful to the
     * implementation and applications and are not specified by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getOfferingTypes (); 

    /**
     * Get all the defined Section Types.  These Types are meaningful to the
     * implementation and applications and are not specified by the OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getSectionTypes (); 

    /**
     * Get all the defined Enrollment Status Types.  These Types are meaningful
     * to the implementation and applications and are not specified by the
     * OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getEnrollmentStatusTypes (); 

    /**
     * Get all the defined CourseGrade Types.  GradeTypes are defined in the
     * grading OSID.  These Types are meaningful to the implementation and
     * applications and are not specified by the grading OSID.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCourseGradeTypes (); 

    /**
     * Get all the TermTypes.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getTermTypes (); 

    /**
     * Create a CourseGradeRecord for the specified Agent (student),
     * CourseOffering, CourseGradeType, and CourseGrade.  Note that the intent
     * is that this is a summative grade.
     * 
     * @param object Id $agentId
     * @param object Id $courseOfferingId
     * @param object Type $courseGradeType
     * @param object mixed $courseGrade (original type: java.io.Serializable)
     *  
     * @return object CourseGradeRecord
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function createCourseGradeRecord ( Id $agentId, Id $courseOfferingId, Type $courseGradeType, $courseGrade ); 

    /**
     * Delete the specified CourseGradeRecord by Id. courseGradeRecordId
     * 
     * @param object Id $courseGradeRecordId
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteCourseGradeRecord ( Id $courseGradeRecordId ); 

    /**
     * Get all the CourseGradeRecords, optionally including only those for a
     * specific Student, CourseOffering, or CourseGradeType.
     * 
     * @param object Id $agentId
     * @param object Id $courseOfferingId
     * @param object Type $courseGradeType
     *  
     * @return object CourseGradeRecordIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseGradeRecords ( Id $agentId, Id $courseOfferingId, Type $courseGradeType ); 

    /**
     * Create a CourseGroup of a particular CourseGroupType.  CourseGroups can
     * be used to model prerequisites, corequisites, majors, minors,
     * sequences, etc.
     * 
     * @param object Type $courseGroupType
     *  
     * @return object CourseGroup
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function createCourseGroup ( Type $courseGroupType ); 

    /**
     * Delete a CourseGroup by unique Id.
     * 
     * @param object Id $courseGroupId
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteCourseGroup ( Id $courseGroupId ); 

    /**
     * Get a CourseGroup by unique Id.
     * 
     * @param object Id $courseGroupId
     *  
     * @return object CourseGroup
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseGroup ( Id $courseGroupId ); 

    /**
     * Get all the CourseGroups of a given CourseGroupType.
     * 
     * @param object Type $courseGroupType
     *  
     * @return object CourseGroupIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getCourseGroupsByType ( Type $courseGroupType ); 

    /**
     * Get all the CourseGroups that contain the specified CanoncialCourse.
     * 
     * @param object Id $canonicalCourseId
     *  
     * @return object CourseGroupIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function getCourseGroups ( Id $canonicalCourseId ); 

    /**
     * Get all the CourseGroupTypes supported by this implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCourseGroupTypes (); 

    /**
     * This method indicates whether this implementation supports
     * CourseManagementManager methods: createCanonicalCourse,
     * createCourseGradeRecord, createCourseGroup, createTerm,
     * deleteCanonicalCourse, deleteCourseGradeRecord, deleteCourseGroup,
     * deleteTerm. CanonicalCourse methods: addEquivalentCourse, addTopic,
     * createCanonicalCourse, createCourseOffering, deleteCourseOffering.
     * CourseGroup methods: addCourse, removeCourse, updateDisplayName.
     * CourseOffering methods: addAsset, addStudent, createCourseSection,
     * deleteCourseSection, removeAsset, removeStudent, updateCourseGradeType,
     * updateDescription, updateDisplayName, updateStatus, updateTitle.
     * CourseSection methods: addAsset, addStudent, changeStudent.
     *  
     * @return boolean
     * 
     * @throws object CourseManagementException An exception
     *         with one of the following messages defined in
     *         org.osid.coursemanagement.CourseManagementException may be
     *         thrown:  {@link
     *         org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function supportsUpdate (); 
}

?>