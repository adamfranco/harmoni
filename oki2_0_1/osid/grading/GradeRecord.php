<?php 
 
/**
 * GradeRecord includes a reference to a gradable object, an Agent Id, a Grade,
 * and GradeType.
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
interface GradeRecord
{
    /**
     * Update the value for this Grade.
     * 
     * @param object mixed $gradeValue (original type: java.io.Serializable)
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
    public function updateGradeValue ( $gradeValue ); 

    /**
     * Get the unique Id for this GradeRecord's GradableObject.
     *  
     * @return object Id
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
    public function getGradableObject (); 

    /**
     * Get the Agent Id associated with this GradeRecord.  The Agent in this
     * context is not the person who took the test nor, necessarily, the
     * person who is grading.  It is the person whose "GradeBook" this is, for
     * example the CourseSection instructor.
     *  
     * @return object Id
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
    public function getAgentId (); 

    /**
     * Get the value for this Grade.
     *  
     * @return object mixed (original type: java.io.Serializable)
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
    public function getGradeValue (); 

    /**
     * Get the Id of the Agent who modified this GradeRecord.
     *  
     * @return object Id
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
    public function getModifiedBy (); 

    /**
     * Get the date when this GradeRecord was modified.
     *  
     * @return int
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
    public function getModifiedDate (); 

    /**
     * Get the GradeRecordType for this GradeRecord.  This is the Type of the
     * GradeRecord, which is distinct from the Type of Grade.  A GradeRecord
     * Type might be advisory, mid-term, final, etc, while a Grade Type might
     * be letter, numeric, etc.
     *  
     * @return object Type
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
    public function getGradeRecordType (); 

    /**
     * Get the GradeType associated with the GradableObject and Grade.
     *  
     * @return object Type
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
    public function getGradeType (); 

    /**
     * Get all the Property Types for  GradeRecord.
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
    public function getPropertyTypes (); 

    /**
     * Get the Properties of this Type associated with this GradeRecord.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
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
    public function getPropertiesByType ( Type $propertiesType ); 

    /**
     * Get the Properties associated with this GradeRecord.
     *  
     * @return object PropertiesIterator
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
    public function getProperties (); 
}

?>