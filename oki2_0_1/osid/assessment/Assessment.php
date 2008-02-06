<?php 
 
/**
 * Assessment includes zero or more Sections which in turn contain zero or more
 * Items. The Sections added to an Assessment are returned first in, first out
 * (FIFO). Items can be ordered explicitly using the orderSections method.
 * AssessmentType is meaningful to an application and not specifcally defined
 * in the OSID.  The unique Id for an Item is set by the AssessmentManager's
 * createAssessment method's implementation.  Assessments also contain a
 * Topic.  An Assessment is related to a AssessmentPublished which is an
 * Assessment and a set of data relating to the availability of the
 * Assessment.  An Assessment is also related to an AssessmentTaken which is
 * an Assessment and a set of data relating to an agentId of the student's
 * integration with it.
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
 * @package org.osid.assessment
 */
interface Assessment
{
    /**
     * Update the display name for this Assessment.
     * 
     * @param string $displayName
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDisplayName ( $displayName ); 

    /**
     * Update the description for this Assessment.
     * 
     * @param string $description
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDescription ( $description ); 

    /**
     * Update the Topic for this  Assessment.
     * 
     * @param string $topic
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateTopic ( $topic ); 

    /**
     * Update the data for this Assessment.  The structure of the Data is not
     * defined in the OSID.
     * 
     * @param object mixed $data (original type: java.io.Serializable)
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateData ( $data ); 

    /**
     * Get the display name for this Assessment.
     *  
     * @return string
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDisplayName (); 

    /**
     * Get the description for this Assessment.
     *  
     * @return string
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDescription (); 

    /**
     * Get the unique Id for this Assessment.
     *  
     * @return object Id
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getId (); 

    /**
     * Get the AssessmentType for this Assessment.
     *  
     * @return object Type
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getAssessmentType (); 

    /**
     * Get all the Property Types for  Assessment.
     *  
     * @return object TypeIterator
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getPropertyTypes (); 

    /**
     * Get the Properties associated with this Assessment.
     *  
     * @return object PropertiesIterator
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getProperties (); 

    /**
     * Get the Topic for this  Assessment.
     *  
     * @return string
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getTopic (); 

    /**
     * Get the Data for this Assessment.  The structure of the Data is not
     * defined in the OSID.
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getData (); 

    /**
     * Get the Properties of this Type associated with this Assessment.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getPropertiesByType ( Type $propertiesType ); 

    /**
     * Add a Section to this Assessment. The Sections added to an Assessment
     * are returned first in, first out (FIFO).  Sections can be ordered
     * explicitly using the orderSections method.
     * 
     * @param object Section $section
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @access public
     */
    public function addSection ( Section $section ); 

    /**
     * Remove a Section from this Assessment.
     * 
     * @param object Id $sectionId
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function removeSection ( Id $sectionId ); 

    /**
     * Get all the Sections in the Assessment.  The Sections added to a
     * Assessment are returned first in, first out (FIFO).  Sections can be
     * ordered explicitly using the orderSections method. Only the Sections
     * directly associated with this Assessment are returned.
     *  
     * @return object SectionIterator
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getSections (); 

    /**
     * Change the order of the  Sections in the Assessment.  Sections normally
     * are returned first in, first out (FIFO).  This ordering, which has
     * important pedagogical implications, is changed to match the order in
     * the  Sections array.  Additional added Sections are returned first in,
     * first out (FIFO) after the ordered Sections.
     * 
     * @param object array $sections
     * 
     * @throws object AssessmentException An exception with one of
     *         the following messages defined in
     *         org.osid.assessment.AssessmentException may be thrown:  {@link
     *         org.osid.assessment.AssessmentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.assessment.AssessmentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.assessment.AssessmentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.assessment.AssessmentException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_SECTION
     *         UNKNOWN_SECTION}
     * 
     * @access public
     */
    public function orderSections ( array $sections ); 
}

?>