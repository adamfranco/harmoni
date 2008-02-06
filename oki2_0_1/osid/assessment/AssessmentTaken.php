<?php 
 
/**
 * AssessmentTaken includes a AssessmentPublished, the agentId of the student
 * who took it, the Sections taken within which are the Items taken, and the
 * Evaluations for the Assessment.  There is also any supporting data.
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
interface AssessmentTaken
{
    /**
     * Update the display name for this AssessmentTaken.
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
     * Update the data for this AssessmentTaken.  The structure of the Data is
     * not defined in the OSID. .
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
     * Get the display name for this AssessmentTaken.
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
     * Get the unique Id for this AssessmentTaken.
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
     * Get the AssessmentPublished that was taken.
     *  
     * @return object AssessmentPublished
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
    public function getAssessmentPublished (); 

    /**
     * Get the agentId of the student who took the Assessment.
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
    public function getAgentId (); 

    /**
     * Get the date the Assessment was taken.
     *  
     * @return int
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
    public function getDate (); 

    /**
     * Get the Data for this AssessmentTaken.  The structure of the Data is not
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
     * Create a SectionTaken based on an AssessmentPublished and agentId of the
     * student.
     * 
     * @param object Section $section
     *  
     * @return object SectionTaken
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
    public function createSectionTaken ( Section $section ); 

    /**
     * Delete a SectionTaken.
     * 
     * @param object Id $sectionTakenId
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
    public function deleteSectionTaken ( Id $sectionTakenId ); 

    /**
     * Get all the Sections taken for this Assessment.  SectionsTaken are
     * returned first in, first out (FIFO). Only the Sections taken that are
     * directly associated with this Assessment are returned.
     *  
     * @return object SectionTakenIterator
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
    public function getSectionsTaken (); 

    /**
     * Create an Evaluation of the specified Type for this Assessment.
     * 
     * @param object Type $evaluationType
     *  
     * @return object Evaluation
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
    public function createEvaluation ( Type $evaluationType ); 

    /**
     * Delete this Evaluation from this Assessment.
     * 
     * @param object Id $evaluationId
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
    public function deleteEvaluation ( Id $evaluationId ); 

    /**
     * Get the Evaluations of the specified Type for this Assessment.
     * 
     * @param object Type $evaluationType
     *  
     * @return object EvaluationIterator
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
    public function getEvaluationsByType ( Type $evaluationType ); 

    /**
     * Get all the Evaluations for this Assessment.
     *  
     * @return object EvaluationIterator
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
    public function getEvaluations (); 
}

?>