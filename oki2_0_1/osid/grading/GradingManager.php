<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * GradingManager handles creating and deleting:
 * 
 * <ul>
 * <li>
 * GradableObject,
 * </li>
 * <li>
 * GradeRecord
 * </li>
 * </ul>
 * 
 * and getting:
 * 
 * <ul>
 * <li>
 * GradableObject,
 * </li>
 * <li>
 * GradeRecords,
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
 * @package org.osid.grading
 */
interface GradingManager
    extends OsidManager
{
    /**
     * Create a new GradableObject which includes all the elements for grading
     * something for a CourseSection.  The type of grade and other grade
     * characteristics are also specified.
     * 
     * @param string $displayName
     * @param string $description
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     * @param object Type $gradeType
     * @param object Type $scoringDefinition
     * @param object Type $gradeScale
     * @param int $gradeWeight
     *  
     * @return object GradableObject
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_TYPE UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function createGradableObject ( $displayName, $description, Id $courseSectionId, Id $externalReferenceId, Type $gradeType, Type $scoringDefinition, Type $gradeScale, $gradeWeight ); 

    /**
     * Delete a GradableObject.
     * 
     * @param object Id $gradableObjectId
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteGradableObject ( Id $gradableObjectId ); 

    /**
     * Get a GradableObject by unique Id.
     * 
     * @param object Id $gradableObjectId
     *  
     * @return object GradableObject
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getGradableObject ( Id $gradableObjectId ); 

    /**
     * Get all the GradableObjects, optionally including only those for a
     * specific CourseSection or External Reference to what is being graded.
     * If any parameter is null, what is returned is not filtered by that
     * parameter.
     * 
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     *  
     * @return object GradableObjectIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getGradableObjects ( Id $courseSectionId, Id $externalReferenceId ); 

    /**
     * Create a new GradeRecord for an Agent and with a Grade and
     * GradeRecordType.   The GradeRecordType is they Type of GradeRecord not
     * the Type of Grade contained in it.  GradeRecord Types might indicate a
     * mid-term, partial, or final grade while GradeTypes might be letter,
     * numeric, etc.  The Agent in this context is not the person who took the
     * test nor, necessarily, the person who is grading.  It is the person
     * whose "GradeBook" this is, for example the CourseSection instructor.
     * 
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object mixed $gradeValue (original type: java.io.Serializable)
     * @param object Type $GradeRecordType
     *  
     * @return object GradeRecord
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.grading.GradingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function createGradeRecord ( Id $gradableObjectId, Id $agentId, $gradeValue, Type $GradeRecordType ); 

    /**
     * Delete a GradableObject.
     * 
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object Type $GradeRecordType
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteGradeRecord ( Id $gradableObjectId, Id $agentId, Type $GradeRecordType ); 

    /**
     * Get all the GradeRecords, optionally including only those for a specific
     * CourseSection, GradableObject, External Reference to what is being
     * graded, GradeRecordType, or Agent.  If any parameter is null, what is
     * returned is not filtered by that parameter.  For example,
     * getGradeRecords(xyzCourseSectionId,null,null,null,null) returns all
     * GradeRecords for the xyzCourseSection; and
     * getGradeRecords(xyzCourseSectionId,null,null,myAgent,quizGradeRecordType)
     * returns all GradeRecords for quizzes taken by myAgent in the
     * xyzCourseSection.
     * 
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object Type $GradeRecordType
     *  
     * @return object GradeRecordIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.grading.GradingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getGradeRecords ( Id $courseSectionId, Id $externalReferenceId, Id $gradableObjectId, Id $agentId, Type $GradeRecordType ); 

    /**
     * Get all GradeRecordTypes.
     *  
     * @return object TypeIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getGradeRecordTypes (); 

    /**
     * Get all GradeTypes.
     *  
     * @return object TypeIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getGradeTypes (); 

    /**
     * Get all ScoringDefinitions.
     *  
     * @return object TypeIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getScoringDefinitions (); 

    /**
     * Get all GradeScales.
     *  
     * @return object TypeIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getGradeScales (); 
}

?>