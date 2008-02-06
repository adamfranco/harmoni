<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * AssessmentManager handles creating and deleting:
 * 
 * <ul>
 * <li>
 * Assessment,
 * </li>
 * <li>
 * AssessmentPublished,
 * </li>
 * <li>
 * Item,
 * </li>
 * <li>
 * Section;
 * </li>
 * </ul>
 * 
 * and getting:
 * 
 * <ul>
 * <li>
 * Assessment,
 * </li>
 * <li>
 * AssessmentPublished,
 * </li>
 * <li>
 * Item,
 * </li>
 * <li>
 * Section,
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
 * @package org.osid.assessment
 */
interface AssessmentManager
    extends OsidManager
{
    /**
     * Create a new Assessment and add it to the Assessment Bank.
     * 
     * @param string $name
     * @param string $description
     * @param object Type $assessmentType
     *  
     * @return object Assessment
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
    public function createAssessment ( $name, $description, Type $assessmentType ); 

    /**
     * Delete an Assessment from the Assessment Bank.
     * 
     * @param object Id $assessmentId
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
    public function deleteAssessment ( Id $assessmentId ); 

    /**
     * Get the Assessment with the specified unique Id
     * 
     * @param object Id $assessmentId
     *  
     * @return object Assessment
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
    public function getAssessment ( Id $assessmentId ); 

    /**
     * Get all the Assessments of a specific Type.
     * 
     * @param object Type $assessmentType
     *  
     * @return object AssessmentIterator
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
    public function getAssessmentsByType ( Type $assessmentType ); 

    /**
     * Get all the Assessments in the Assessment Bank.
     *  
     * @return object AssessmentIterator
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
    public function getAssessments (); 

    /**
     * Create a new Section and add it to the Section Bank.
     * 
     * @param string $name
     * @param string $description
     * @param object Type $sectionType
     *  
     * @return object Section
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
    public function createSection ( $name, $description, Type $sectionType ); 

    /**
     * Delete a Section from the Section Bank.
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
     *         UNIMPLEMENTED} , {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteSection ( Id $sectionId ); 

    /**
     * Get the Section with the specified unique Id
     * 
     * @param object Id $sectionId
     *  
     * @return object Section
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
    public function getSection ( Id $sectionId ); 

    /**
     * Get all the Sections of a specific Type.
     * 
     * @param object Type $sectionType
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
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getSectionsByType ( Type $sectionType ); 

    /**
     * Get all the Sections in the Section Bank.
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
     * Create a new Item  and add it to the Item Bank.
     * 
     * @param string $name
     * @param string $description
     * @param object Type $itemType
     *  
     * @return object Item
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
    public function createItem ( $name, $description, Type $itemType ); 

    /**
     * Delete an Item from the Item Bank.
     * 
     * @param object Id $itemId
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
    public function deleteItem ( Id $itemId ); 

    /**
     * Get the Item with the specified unique Id
     * 
     * @param object Id $itemId
     *  
     * @return object Item
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
    public function getItem ( Id $itemId ); 

    /**
     * Get all the Items of a specific Type.
     * 
     * @param object Type $itemType
     *  
     * @return object ItemIterator
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
    public function getItemsByType ( Type $itemType ); 

    /**
     * Get all the Items in the Item Bank.
     *  
     * @return object ItemIterator
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
    public function getItems (); 

    /**
     * Create an AssessmentPublished based on an Assessment.
     * 
     * @param object Assessment $assessment
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
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function createAssessmentPublished ( Assessment $assessment ); 

    /**
     * Delete an AssessmentPublished.
     * 
     * @param object Id $assessmentPublishedId
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
    public function deleteAssessmentPublished ( Id $assessmentPublishedId ); 

    /**
     * Get the specified AssessmentPublished.
     * 
     * @param object Id $assessmentPublishedId
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
     *         UNIMPLEMENTED}, {@link
     *         org.osid.assessment.AssessmentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.assessment.AssessmentException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getAssessmentPublished ( Id $assessmentPublishedId ); 

    /**
     * Get all the Assessments published.
     *  
     * @return object AssessmentPublishedIterator
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
    public function getAssessmentsPublished (); 

    /**
     * Get all the Assessment Types.
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
    public function getAssessmentTypes (); 

    /**
     * Get all the Section Types.
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
    public function getSectionTypes (); 

    /**
     * Get all the Item Types.
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
    public function getItemTypes (); 

    /**
     * Get all the Evaluation Types.
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
    public function getEvaluationTypes (); 
}

?>