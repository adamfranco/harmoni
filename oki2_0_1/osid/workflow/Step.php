<?php 
 
/**
 * Step is a pivotal element in a Process. Processes are made up of Steps. A
 * Step is composed of links to other Steps, and has InputConditions and
 * OutputStates.
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
interface Step
{
    /**
     * Update the DisplayName of this Step.
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
     * Get the description of this Step.
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
     * Get the unique Id for this Step.  The unique Id is set when the Step is
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
     * Get the description of this Step.
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
     * Get the unique Id of the role associated with this Step.
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
    public function getRoleId (); 

    /**
     * Get the DisplayName of this Step.
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
     * Update the unique Id of the role associate with this Step.
     * 
     * @param object Id $roleId
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
    public function updateRoleId ( Id $roleId ); 

    /**
     * Returns true if this Step is the final one in the Process; false
     * otherwise.
     *  
     * @return boolean
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
    public function isTerminal (); 

    /**
     * Returns true if this Step is the first one in the Process; false
     * otherwise.
     *  
     * @return boolean
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
    public function isInitial (); 

    /**
     * Get all the immediate predecessor Steps for this Step.
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
    public function getPredecessors (); 

    /**
     * Get all the immediate successor Steps for this Step from among those
     * supported by the implementation.
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
    public function getSuccessors (); 

    /**
     * Get all the input conditions for this Step.
     *  
     * @return object ExpressionIterator
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
    public function getInputConditions (); 

    /**
     * Define the possible input conditions for this Step.
     * 
     * @param object array $inputConditions
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
     *         org.osid.workflow.WorkflowException#UNKNOWN_EXPRESSION
     *         UNKNOWN_EXPRESSION}
     * 
     * @access public
     */
    public function updateInputConditions ( array $inputConditions ); 

    /**
     * Define the possible output states for this Step from among those
     * supported by the implementation.
     * 
     * @param string $outputStates
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
     *         org.osid.workflow.WorkflowException#UNKNOWN_OUTPUT_STATE
     *         UNKNOWN_OUTPUT_STATE}
     * 
     * @access public
     */
    public function updateOutputStates ( $outputStates ); 

    /**
     * Get all the output states for this Step.
     *  
     * @return object StringIterator
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
    public function getOutputStates (); 

    /**
     * Add a Step as an immediate predecessor of this Step.  A Step cannot be
     * its own immediate predecessor, but looping is permitted.
     * 
     * @param object Id $stepId
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
     *         {@link org.osid.workflow.WorkflowException#INVALID_NETWORK
     *         INVALID_NETWORK}
     * 
     * @access public
     */
    public function addPredecessor ( Id $stepId ); 

    /**
     * Remove a Step that is an immediate predecessor of this Step.
     * 
     * @param object Id $stepId
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
     *         {@link org.osid.workflow.WorkflowException#INVALID_NETWORK
     *         INVALID_NETWORK}
     * 
     * @access public
     */
    public function removePredecessor ( Id $stepId ); 
}

?>