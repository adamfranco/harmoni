<?php 
 
/**
 * Function is composed of Id, a displayName, a description, a category, and a
 * QualifierType.  Ids in Authorization are externally defined and their
 * uniqueness is enforced by the implementation.
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
 * @package org.osid.authorization
 */
interface FunctionInterface
{
    /**
     * Get the unique Id for this Function.
     *  
     * @return object Id
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getId (); 

    /**
     * Get the permanent reference name for this Function.
     *  
     * @return string
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getReferenceName (); 

    /**
     * Get the description for this Function.
     *  
     * @return string
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDescription (); 

    /**
     * Get the FunctionType for this Function.
     *  
     * @return object Type
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getFunctionType (); 

    /**
     * Get the QualifierHierarchyId for this Function.
     *  
     * @return object Id
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getQualifierHierarchyId (); 

    /**
     * Update the description for this Function.
     * 
     * @param string $description
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authorization.AuthorizationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDescription ( $description ); 
}

?>