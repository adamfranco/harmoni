<?php 
 
/**
 * Work is a set of Steps that are associated with one or more roles.
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
 * @package org.osid.workflow
 */
interface Work
{
    /**
     * Update the DisplayName of this Work.
     * 
     * @param string $displayName
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.workflow.WorkflowException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDisplayName ( $displayName ); 

    /**
     * Get the description of this Work.
     * 
     * @param string $description
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.workflow.WorkflowException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDescription ( $description ); 

    /**
     * Get the unique Id for this Work.  The unique Id is set when the Work is
     * created by a Process.
     *  
     * @return object Id
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getId (); 

    /**
     * Get the DisplayName of this Work.
     *  
     * @return string
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDisplayName (); 

    /**
     * Get the description of this Work.
     *  
     * @return string
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDescription (); 

    /**
     * Get the Qualifier unique Id that was set when this Work was created in a
     * Process.
     *  
     * @return object Id
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getQualifierId (); 

    /**
     * Get all the Property Types for  Work.
     *  
     * @return object TypeIterator
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown: {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getPropertyTypes (); 

    /**
     * Get the next Steps for a specific role this body of Work.
     * 
     * @param object Id $roleId
     *  
     * @return object StepIterator
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.workflow.WorkflowException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.workflow.WorkflowException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getNextStepsForRole ( Id $roleId ); 

    /**
     * Get the next Steps for any role for this body of Work.
     *  
     * @return object StepIterator
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getNextSteps (); 

    /**
     * Update the OutputState for a Step in this body of Work.  The
     * implementation will support a set of these Output States.  When a Step
     * is designed, the appropriate subset of the possible Output States can
     * be updated.  This method updates the Output State of this Step to one
     * of those defined for the Step.
     * 
     * @param object Id $stepId
     * @param string $outputState
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.workflow.WorkflowException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.workflow.WorkflowException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.workflow.WorkflowException#UNKNOWN_OUTPUT_STATE
     *         UNKNOWN_OUTPUT_STATE}
     * 
     * @access public
     */
    public function updateStepOutputState ( Id $stepId, $outputState ); 

    /**
     * Get the series of Work Events that have occured in the context of this
     * body of work.
     *  
     * @return object WorkEventIterator
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown:  {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getHistory (); 

    /**
     * Get the Properties of this Type associated with this Work.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown: {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.workflow.WorkflowException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.workflow.WorkflowException#UNKNOWN_TYPE UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getPropertiesByType ( Type $propertiesType ); 

    /**
     * Get the Properties associated with this Work.
     *  
     * @return object PropertiesIterator
     * 
     * @throws object WorkflowException An exception with one of the
     *         following messages defined in
     *         org.osid.workflow.WorkflowException may be thrown: {@link
     *         org.osid.workflow.WorkflowException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.workflow.WorkflowException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.workflow.WorkflowException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.workflow.WorkflowException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getProperties (); 
}

?>