<?php 
 
/**
 * MessageIterator provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.  Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.  Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
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
 * @package org.osid.usermessaging
 */
interface MessageIterator
{
    /**
     * Return true if there is an additional  Message ; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object UsermessagingException An exception with
     *         one of the following messages defined in
     *         org.osid.usermessaging.UsermessagingException may be thrown:
     *         {@link
     *         org.osid.usermessaging.UsermessagingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.usermessaging.UsermessagingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.usermessaging.UsermessagingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function hasNextMessage (); 

    /**
     * Return the next Message.
     *  
     * @return object Message
     * 
     * @throws object UsermessagingException An exception with
     *         one of the following messages defined in
     *         org.osid.usermessaging.UsermessagingException may be thrown:
     *         {@link
     *         org.osid.usermessaging.UsermessagingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.usermessaging.UsermessagingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.usermessaging.UsermessagingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.usermessaging.UsermessagingException#NO_MORE_ITERATOR_ELEMENTS
     *         NO_MORE_ITERATOR_ELEMENTS}
     * 
     * @access public
     */
    public function nextMessage (); 
}

?>