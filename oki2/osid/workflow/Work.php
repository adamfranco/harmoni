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
class Work
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
     * @public
     */
    function updateDisplayName ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function updateDescription ( $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function getDescription () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getQualifierId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getPropertyTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getNextStepsForRole ( &$roleId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getNextSteps () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function updateStepOutputState ( &$stepId, $outputState ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getHistory () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
     * @public
     */
    function &getProperties () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>