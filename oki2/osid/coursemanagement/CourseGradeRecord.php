<?php 
 
/**
 * CourseGradeRecord manages the CourseGrade of a specific CourseGradeType for
 * an Agent and a CourseOffering.
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
class CourseGradeRecord
{
    /**
     * Update the grade for this CourseGradeRecord.
     * 
     * @param object mixed $courseGrade (original type: java.io.Serializable)
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
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function updateCourseGrade ( &$courseGrade ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the display name for this CourseGradeRecord.
     * 
     * @param string $displayName
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
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function updateDisplayName ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the grade for this CourseGradeRecord.
     *  
     * @return object mixed (original type: java.io.Serializable)
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
     * @public
     */
    function &getCourseGrade () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the display name for this CourseGradeRecord.
     *  
     * @return string
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
     * @public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the unique Id for this CourseGradeRecord.
     *  
     * @return object Id
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
     * @public
     */
    function &getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Agent (student) associated with this CourseGradeRecord.
     *  
     * @return object Id
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
     * @public
     */
    function &getStudent () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the CourseGradeType for this Offering.  GradingType is defined in
     * the grading OSID.  These Types are meaningful to the implementation and
     * applications and are not specified by the OSID.
     *  
     * @return object Type
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
     * @public
     */
    function &getCourseGradeType () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the unique Id for the CourseOffering for this CourseGradeRecord..
     *  
     * @return object Id
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
     * @public
     */
    function &getCourseOffering () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>