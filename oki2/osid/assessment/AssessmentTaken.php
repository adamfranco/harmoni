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
class AssessmentTaken
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
     * @public
     */
    function updateDisplayName ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function updateData ( &$data ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getAssessmentPublished () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getAgentId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function getDate () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getData () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &createSectionTaken ( &$section ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function deleteSectionTaken ( &$sectionTakenId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getSectionsTaken () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &createEvaluation ( &$evaluationType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function deleteEvaluation ( &$evaluationId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getEvaluationsByType ( &$evaluationType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getEvaluations () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>