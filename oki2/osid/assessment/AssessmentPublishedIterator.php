<?php 
 
/**
 * AssessmentPublishedIterator provides access to these objects sequentially,
 * one at a time.  The purpose of all Iterators is to to offer a way for OSID
 * methods to return multiple values of a common type and not use an array.
 * Returning an array may not be appropriate if the number of values returned
 * is large or is fetched remotely.  Iterators do not allow access to values
 * by index, rather you must access values in sequence. Similarly, there is no
 * way to go backwards through the sequence unless you place the values in a
 * data structure, such as an array, that allows for access by index.
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
class AssessmentPublishedIterator
{
    /**
     * Return true if there is an additional  AssessmentPublished ; false
     * otherwise.
     *  
     * @return boolean
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
    function hasNextAssessmentPublished () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Return the next AssessmentPublished.
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
     *         UNIMPLEMENTED} Throws an exception with the message
     *         org.osid.OsidException.NO_MORE_ELEMENTS if all objects have
     *         already been returned.
     * 
     * @public
     */
    function &nextAssessmentPublished () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>