<?php 
 
/**
 * Term includes an unique Id assigned by the implementation, a display name, a
 * termType, and  a schedule.
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
class Term
{
    /**
     * Update the display name for this Term.
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
     * Get the display name for this Term.
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
     * Get the unique Id for this Term.
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
     * Get the Type for this Term.  This Type is meaningful to the
     * implementation and applications and is not specified by the OSID.
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
    function &getType () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Schedule for this Term.  Schedules are defined in scheduling
     * OSID.  ScheduleItems are returned in chronological order by increasing
     * start date.
     *  
     * @return object ScheduleItemIterator
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
    function &getSchedule () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>