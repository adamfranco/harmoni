<?php

require_once(OKI."/osid.interface.php");

	/**
	 * The Manager sends and receives messages and returns the Types of messages and delivery supported by the implementation.  A message is not created explicitly; it is created when it is sent.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.usermessaging
	 */
class UsermessagingManager // :: API interface
	extends OsidManager
{

	/**
	 * Get all the Types of Messages supported by this implementation.  Examples of these Types are instant, store and forward, and attempt to deliver once.
	 * @return object osid.shared.TypeIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDeliveryTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getDeliveryTypes()

	/**
	 * Get all the Types of Messages supported by this implementation.  Examples of these are rich-text and MIME.
	 * @return object osid.shared.TypeIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getMessageTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getMessageTypes()

	/**
	 * Get all the Topics supported by this implementation.  This might also be all the currently available Topics in the case of an implementation that allows applications to add Topics by sending a Message with a new Topic.
	 * @return object osid.shared.StringIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getTopics() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getTopics()

	/**
	 * Get all the current subscribers to this Service.
	 * @return object osid.shared.AgentIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getSubscribers() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.AgentIterator getSubscribers()

	/**
	 * Get all the current subscribers to this Service for a specific Topic.
	 * @param object topic
	 * @return object osid.shared.AgentIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getSubscribersByTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.AgentIterator getSubscribersByTopic(String topic)

	/**
	 * Subscribe an Agent for a particular topic.
	 * @param object agentId
	 * @param object topic
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#UNKNOWN_TOPIC UNKNOWN_TOPIC}
	 */
	function subscribe(& $agentId, $topic) { /* :: interface :: */ }
	// :: full java declaration :: void subscribe(osid.shared.Id agentId, String topic)

	/**
	 * Unsubscribe an Agent for a particular topic.
	 * @param object agentId
	 * @param object topic
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#UNKNOWN_TOPIC UNKNOWN_TOPIC}
	 */
	function unsubscribe(& $agentId, $topic) { /* :: interface :: */ }
	// :: full java declaration :: void unsubscribe(osid.shared.Id agentId, String topic)

	/**
	 * Unsubscribe an Agent for all topics.
	 * @param object agentId
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NOT_SUBSCRIBED NOT_SUBSCRIBED}
	 */
	function unsubscribeAll(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: void unsubscribeAll(osid.shared.Id agentId)

	/**
	 * Send a Message to a recipient.  The Topic is optional and should be ignored if null.
	 * @param object agents
	 * @param object content
	 * @param object messageType
	 * @param object deliveryType
	 * @param object topic
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link UsermessagingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link UsermessagingException#UNKNOWN_TOPIC UNKNOWN_TOPIC}, {@link UsermessagingException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function send(& $agents, & $content, & $messageType, & $deliveryType, $topic) { /* :: interface :: */ }
	// :: full java declaration :: void send(osid.shared.Id[] agents, java.io.Serializable content, osid.shared.Type messageType, osid.shared.Type deliveryType, String topic)

	/**
	 * Send a Message to all subscribers.  The Topic is optional and should be ignored if null.
	 * @param object content
	 * @param object messageType
	 * @param object deliveryType
	 * @param object topic
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link UsermessagingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link UsermessagingException#UNKNOWN_TOPIC UNKNOWN_TOPIC}, {@link UsermessagingException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function sendToAll(& $content, & $messageType, & $deliveryType, $topic) { /* :: interface :: */ }
	// :: full java declaration :: void sendToAll(java.io.Serializable content, osid.shared.Type messageType, osid.shared.Type deliveryType, String topic)

	/**
	 * Get all Messages for a specific Topic.
	 * @return object MessageIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &receiveForTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: MessageIterator receiveForTopic(String topic)

	/**
	 * Get all Messages of a specific Message Type.
	 * @return object MessageIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &receiveForMessageType(& $messageType) { /* :: interface :: */ }
	// :: full java declaration :: MessageIterator receiveForMessageType(osid.shared.Type messageType)

	/**
	 * Get all Messages.
	 * @return object MessageIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &receive() { /* :: interface :: */ }
	// :: full java declaration :: MessageIterator receive()

	/**
	 * Delete a Message for the user.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function deleteMessage(& $message) { /* :: interface :: */ }
	// :: full java declaration :: void deleteMessage(Message message)

	/**
	 * Delete a Message for all subscribers.
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function purgeMessage(& $message) { /* :: interface :: */ }
	// :: full java declaration :: void purgeMessage(Message message)

	/**
	 * Delete all Messages for the user.  Include only Messages before a date, on a Topic, and of a specific MessageType if those values are supplied.
	 * @param object before
	 * @param object messageType
	 * @param object topic
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function deleteMessages(& $before, & $messageType, $topic) { /* :: interface :: */ }
	// :: full java declaration :: void deleteMessages(java.util.Calendar before, osid.shared.Type messageType, String topic)
}


	/**
	 * Messages contain a set of get-only attributes.  Note that the information in the message does not contain when a message was delivered.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.usermessaging
	 */
class Message // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the content of the Message.
	 * @return object java.io.Serializable
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getContent() { /* :: interface :: */ }

	/**
	 * Get the Type of the Message.
	 * @return object  osid.shared.Type
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getMessageType() { /* :: interface :: */ }

	/**
	 * Get the Type of the Delivery for this Message.
	 * @return object  osid.shared.Type
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDeliveryType() { /* :: interface :: */ }

	/**
	 * Get the time the Message was sent.
	 * @return object java.util.Calendar
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getMessageTimestamp() { /* :: interface :: */ }

	/**
	 * Get the Topic of the Message. Note that the Topic is not necessarily the subject of the Message.  The subject can be embedded in the Content.  The intent is that the Topic is the same Topic used in CourseManagement to refer to an area of interest.
	 * @return object String
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getTopic() { /* :: interface :: */ }

	/**
	 * Get the Agent that sent the Message.
	 * @return object osid.shared.Id
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getSender() { /* :: interface :: */ }
}


	/**
	 * MessageIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	 * @package osid.usermessaging
	 */
class MessageIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Message objects; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Message.
	 * @return object Message
	 * @throws osid.usermessaging.UsermessagingException An exception with one of the following messages defined in osid.usermessaging.UsermessagingException:   {@link UsermessagingException#OPERATION_FAILED OPERATION_FAILED}, {@link UsermessagingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link UsermessagingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link UsermessagingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link UsermessagingException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Message next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.usermessaging
	 */
class UsermessagingException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown or unsupported Type
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Unknown or unsupported Topic
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("UNKNOWN_TOPIC","Unknown Topic ");

	/**
	 * Operation failed
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Null argument
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Permission denied
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Configuration error
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * Not currently subscribed to this Topic
	 * @package osid.usermessaging
	 */
	// :: defined globally :: define("NOT_SUBSCRIBED","Not currently subscribed to this Topic ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.usermessaging
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.usermessaging
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string UNKNOWN_TOPIC public static final String UNKNOWN_TOPIC = "Unknown Topic "
 * @package osid.usermessaging
 */
define("UNKNOWN_TOPIC", "Unknown Topic ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.usermessaging
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.usermessaging
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.usermessaging
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.usermessaging
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.usermessaging
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.usermessaging
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string NOT_SUBSCRIBED public static final String NOT_SUBSCRIBED = "Not currently subscribed to this Topic "
 * @package osid.usermessaging
 */
define("NOT_SUBSCRIBED", "Not currently subscribed to this Topic ");

?>
