<?php 
 
/**
 * CourseSection is associated with a CourseOffering and is has a separate
 * roster and possibly a separate SectionType from any other Sections of the
 * Offering. CanonicalCourse contains general information about a course.
 * This is in contrast to the CourseOffering which contains information about
 * a concrete offering of this course in a specific term and with identified
 * people and roles.  The section includes information about the location of
 * the class as well as the roster of students.  CanonicalCourses can contain
 * other CanonicalCourses and may be organized hierarchically, in schools,
 * departments, for majors, and so on.  For each CanonicalCourse, there are
 * zero or more offerings and for each offering, zero or more sections.  All
 * three levels have separate data for Title, Number, Description, and Id.
 * This information can be the same or different as implementations choose and
 * applications require.
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
class CourseSection
{
    /**
     * Update the title for this CourseSection.
     * 
     * @param string $title
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
    function updateTitle ( $title ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the number for this CourseSection.
     * 
     * @param string $number
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
    function updateNumber ( $number ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the description for this CourseSection.
     * 
     * @param string $description
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
    function updateDescription ( $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the display name for this CourseSection.
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
     * Update the location may be a room address, a map, or any other object.
     * 
     * @param object mixed $location (original type: java.io.Serializable)
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
    function updateLocation ( &$location ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the title for this CourseSection.
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
    function getTitle () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the number for this CourseSection.
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
    function getNumber () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the description for this CourseSection.
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
    function getDescription () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the display name for this CourseSection.
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
     * Get the unique Id for this CourseSection.
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
     * Get the Section Type for this CourseSection.  This Type is meaningful to
     * the implementation and applications and are not specified by the OSID.
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
    function &getSectionType () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Schedule for this Section.  Schedules are defined in scheduling
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

    /**
     * Get the location may be a room address, a map, or any other object.
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
    function &getLocation () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Status for this CourseSection.
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
    function &getStatus () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the Property Types for  CourseSection.
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
     * @public
     */
    function &getPropertyTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties associated with this CourseSection.
     *  
     * @return object PropertiesIterator
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
    function &getProperties () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the CourseOffering that contains this CourseSection.
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
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function &getCourseOffering () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Add an Asset for this CourseSection.
     * 
     * @param object Id $assetId
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
     *         org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @public
     */
    function addAsset ( &$assetId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Remove an Asset for this CourseSection.
     * 
     * @param object Id $assetId
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
     * @public
     */
    function removeAsset ( &$assetId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Assets associated with this CourseSection.
     *  
     * @return object IdIterator
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
    function &getAssets () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the Schedule for this Section.  Schedules are defined in
     * scheduling OSID.
     * 
     * @param object ScheduleItem[] $scheduleItems
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
    function updateSchedule ( &$scheduleItems ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Add a student to the roster and assign the specified Enrollment Status
     * Type.
     * 
     * @param object Id $agentId
     * @param object Type $enrollmentStatusType
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
     *         org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @public
     */
    function addStudent ( &$agentId, &$enrollmentStatusType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Change the Enrollment Status Type for the student on the roster.
     * 
     * @param object Id $agentId
     * @param object Type $enrollmentStatusType
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
     * @public
     */
    function changeStudent ( &$agentId, &$enrollmentStatusType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Remove a student from the roster.
     * 
     * @param object Id $agentId
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
     * @public
     */
    function removeStudent ( &$agentId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the student roster.
     *  
     * @return object EnrollmentRecordIterator
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
    function &getRoster () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the student roster.  Include only students with the specified
     * Enrollment Status Type.
     * 
     * @param object Type $enrollmentStatusType
     *  
     * @return object EnrollmentRecordIterator
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
     * @public
     */
    function &getRosterByType ( &$enrollmentStatusType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the Status for this CourseSection.
     * 
     * @param object Type $statusType
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
     * @public
     */
    function updateStatus ( &$statusType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties of this Type associated with this CourseSection.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
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
     * @public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>