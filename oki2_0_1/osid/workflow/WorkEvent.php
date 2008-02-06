<?php 
 
/**
 * A Work Event is an output State for a Step that is associated with an Agent
 * and point in time.
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
interface WorkEvent
{
    /**
     * Get when this Event happened.
     *  
     * @return int
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
    public function getTimestamp (); 

    /**
     * Get the unique Id of the Agent that performed this Event.
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
    public function getAgentId (); 

    /**
     * Get a Step by unique Id.
     *  
     * @return object Step
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
    public function getStep (); 

    /**
     * Get the Output State for this Event.
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
    public function getOutputState (); 
}

?>