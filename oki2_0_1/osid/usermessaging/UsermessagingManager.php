<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * The Manager sends and receives messages and returns the Types of messages
 * and delivery supported by the implementation.  A message is not created
 * explicitly; it is created when it is sent.
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
 * @package org.osid.usermessaging
 */
interface UsermessagingManager
    extends OsidManager
{
    /**
     * Get all the Types of Messages supported by this implementation.
     * Examples of these Types are instant, store and forward, and attempt to
     * deliver once.
     *  
     * @return object TypeIterator
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
    public function getDeliveryTypes (); 

    /**
     * Get all the Types of Messages supported by this implementation.
     * Examples of these are rich-text and MIME.
     *  
     * @return object TypeIterator
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
    public function getMessageTypes (); 

    /**
     * Get all the Topics supported by this implementation.  This might also be
     * all the currently available Topics in the case of an implementation
     * that allows applications to add Topics by sending a Message with a new
     * Topic.
     *  
     * @return object StringIterator
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
    public function getTopics (); 

    /**
     * Get all the current subscribers to this Service.
     *  
     * @return object IdIterator
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
    public function getSubscribers (); 

    /**
     * Get all the current subscribers to this Service for a specific Topic.
     * 
     * @param string $topic
     *  
     * @return object IdIterator
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
    public function getSubscribersByTopic ( $topic ); 

    /**
     * Subscribe an agentId for a particular topic.
     * 
     * @param object Id $agentId
     * @param string $topic
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
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TOPIC
     *         UNKNOWN_TOPIC}
     * 
     * @access public
     */
    public function subscribe ( Id $agentId, $topic ); 

    /**
     * Unsubscribe an agentId for a particular topic.
     * 
     * @param object Id $agentId
     * @param string $topic
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
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TOPIC
     *         UNKNOWN_TOPIC}
     * 
     * @access public
     */
    public function unsubscribe ( Id $agentId, $topic ); 

    /**
     * Unsubscribe an agentId for all topics.
     * 
     * @param object Id $agentId
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
     *         org.osid.usermessaging.UsermessagingException#NOT_SUBSCRIBED
     *         NOT_SUBSCRIBED}
     * 
     * @access public
     */
    public function unsubscribeAll ( Id $agentId ); 

    /**
     * Send a Message to a recipient.  The Topic is optional and should be
     * ignored if null.
     * 
     * @param object array $agents
     * @param object mixed $content (original type: java.io.Serializable)
     * @param object Type $messageType
     * @param object Type $deliveryType
     * @param string $topic
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
     *         org.osid.usermessaging.UsermessagingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TOPIC
     *         UNKNOWN_TOPIC}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function send ( array $agents, $content, Type $messageType, Type $deliveryType, $topic ); 

    /**
     * Send a Message to all subscribers.  The Topic is optional and should be
     * ignored if null.
     * 
     * @param object mixed $content (original type: java.io.Serializable)
     * @param object Type $messageType
     * @param object Type $deliveryType
     * @param string $topic
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
     *         org.osid.usermessaging.UsermessagingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_TOPIC
     *         UNKNOWN_TOPIC}, {@link
     *         org.osid.usermessaging.UsermessagingException#UNKNOWN_ID
     *         UNKNOWN_ID}
     * 
     * @access public
     */
    public function sendToAll ( $content, Type $messageType, Type $deliveryType, $topic ); 

    /**
     * Get all Messages for a specific Topic.
     * 
     * @param string $topic
     *  
     * @return object MessageIterator
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
    public function receiveForTopic ( $topic ); 

    /**
     * Get all Messages of a specific Message Type.
     * 
     * @param object Type $messageType
     *  
     * @return object MessageIterator
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
    public function receiveForMessageType ( Type $messageType ); 

    /**
     * Get all Messages.
     *  
     * @return object MessageIterator
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
    public function receive (); 

    /**
     * Delete a Message for the user.
     * 
     * @param object Message $message
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
     *         org.osid.usermessaging.UsermessagingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function deleteMessage ( Message $message ); 

    /**
     * Delete a Message for all subscribers.
     * 
     * @param object Message $message
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
     *         org.osid.usermessaging.UsermessagingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function purgeMessage ( Message $message ); 

    /**
     * Delete all Messages for the user.  Include only Messages before a date,
     * on a Topic, and of a specific MessageType if those values are supplied.
     * 
     * @param int $before
     * @param object Type $messageType
     * @param string $topic
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
     *         org.osid.usermessaging.UsermessagingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function deleteMessages ( $before, Type $messageType, $topic ); 
}

?>