<?php
/**
 * @package osid.scheduling
 */

/**
 * @ignore
 */
require_once(OKI."/osid.interface.php");

	/**
	 * SchedulingManager creates, deletes, and gets ScheduleItems.  Items include Agent Commitments (e.g. Calendar events).  The Manager also enumerates the commitment Status Types supported by the implementation. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.scheduling
	 */
class SchedulingManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a ScheduleItem.  The masterIdentifier argument is optional.    A Master Identifier is a key, rule, or function that can be used to associated more than one ScheduleItem together.  An example can be recurring items where each recurring item has the same Master Identifier.  An Unique Id is generated for this ScheduleItem by the implementation.
	 * @param string displayName
	 * @param string description
	 * @param object agents
	 * @param object start
	 * @param object end
	 * @param object masterIdentifier
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}, {@link SchedulingException#END_BEFORE_START END_BEFORE_START}
	 */
	function &createScheduleItem($displayName, $description, & $agents, & $start, & $end, $masterIdentifier) { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItem createScheduleItem(String displayName, String description, osid.shared.Id[] agents, java.util.Calendar start, java.util.Calendar end, String masterIdentifier)

	/**
	 * Delete a ScheduleItem by Unique Id.
	 * @param object scheduleItemId
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteScheduleItem(& $scheduleItemId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteScheduleItem(osid.shared.Id scheduleItemId)

	/**
	 * Get the Timespans during which all Agents are uncommitted.
	 * @param object agents
	 * @param object start
	 * @param object end
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}, {@link SchedulingException#END_BEFORE_START END_BEFORE_START}
	 */
	function &getAvailableTimes(& $agents, & $start, & $end) { /* :: interface :: */ }
	// :: full java declaration :: TimespanIterator getAvailableTimes(osid.shared.Id[] agents, java.util.Calendar start, java.util.Calendar end)

	/**
	 * Get a ScheduleItem by Unique Id.
	 * @param object scheduleItemId
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getScheduleItem(& $scheduleItemId) { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItem getScheduleItem(osid.shared.Id scheduleItemId)

	/**
	 * Get all the ScheduleItems for any Agent, with the specified Item Status and that start or end between the start and end specified, inclusive.
	 * @param object start
	 * @param object end
	 * @param object status
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link SchedulingException#END_BEFORE_START END_BEFORE_START}
	 */
	function &getScheduleItems(& $start, & $end, & $status) { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItemIterator getScheduleItems(java.util.Calendar start, java.util.Calendar end, osid.shared.Type status)

	/**
	 * Get all the ScheduleItems for the specified Agents, with the specified Item Status and that start or end between the start and end specified, inclusive.
	 * @param object start
	 * @param object end
	 * @param object status
	 * @param object agents
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link SchedulingException#END_BEFORE_START END_BEFORE_START}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getScheduleItemsForAgents(& $start, & $end, & $status, & $agents) { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItemIterator getScheduleItemsForAgents(java.util.Calendar start, java.util.Calendar end, osid.shared.Type status, osid.shared.Id[] agents)

	/**
	 * Get all ScheduleItems with the specified master identifier reference.  A Master Identifier is a key, rule, or function that can be used to associated more than one ScheduleItem together.  An example can be recurring items where each recurring item has the same Master Identifier.
	 * @param object masterIdentifier
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function &getScheduleItemsByMasterId($masterIdentifier) { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItemIterator getScheduleItemsByMasterId(String masterIdentifier)

	/**
	 * Get the Status Types for ScheduleItem supported by the implementation.
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getItemStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getItemStatusTypes()

	/**
	 * Get the Status Types for Agents' Commitment supported by the implementation.
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getCommitmentStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCommitmentStatusTypes()
}


	/**
	 * AgentCommitment joins an Agent to a Status Type.  This is the Status of the Commitment and not the Status of the Agent.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.scheduling
	 */
class AgentCommitment // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Agent associated with this Commitment.
	 * @return object osid.shared.Agent
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAgent() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Agent getAgent()

	/**
	 * Get the Status associated with this Commitment.  For example, if the commitment is a meeting, each particpant might have one of the Status Type values "invited", "confirmed", "declined".
	 * @return object osid.shared.Type
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getStatus() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getStatus()
}


	/**
	 * ScheduleItem contains a set of AgentCommitments (e.g. calendar events) as well as the creator of the ScheduleItem and some date information.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.scheduling
	 */
class ScheduleItem // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this ScheduleItem.  The Unique Id is set when the ScheduleItem is created.
	 * @return object osid.shared.Id
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the DisplayName of this ScheduleItem.
	 * @return object String
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the DisplayName of this ScheduleItem.
	 * @param string displayName
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description of this ScheduleItem.
	 * @return object String
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Get the description of this ScheduleItem.
	 * @param string description
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id of the cd Agent that created this ScheduleItem.
	 * @return object osid.shared.Id
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getCreator() { /* :: interface :: */ }

	/**
	 * Get the Start for this ScheduleItem.
	 * @return object java.util.Calendar
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getStart() { /* :: interface :: */ }

	/**
	 * Get the End for this ScheduleItem.
	 * @return object java.util.Calendar
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getEnd() { /* :: interface :: */ }

	/**
	 * Update the Start for this ScheduleItem.
	 * @param object start
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateStart(& $Start) { /* :: interface :: */ }

	/**
	 * Update the End for this ScheduleItem.
	 * @param object end
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateEnd(& $End) { /* :: interface :: */ }

	/**
	 * Get the Status Type for this ScheduleItem.
	 * @return object osid.shared.Type
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status Type for this ScheduleItem.
	 * @param object status
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SchedulingException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function updateStatus(& $Status) { /* :: interface :: */ }

	/**
	 * Get the Master Identifier for this ScheduleItem.  A Master Identifier is a key, rule, or function that can be used to associated more than one ScheduleItem together.  An example can be recurring items where each recurring item has the same Master Identifier.
	 * @return object String
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getMasterIdentifier() { /* :: interface :: */ }

	/**
	 * Get all the Agent commitments for this ScheduleItem.
	 * @return object AgentCommitmentIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAgentCommitments() { /* :: interface :: */ }
	// :: full java declaration :: AgentCommitmentIterator getAgentCommitments()

	/**
	 * Change a previously added Agent commitment for this ScheduleItem.
	 * @param object agentId
	 * @param object agentStatus
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}, {@link SchedulingException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function changeAgentCommitment(& $agentId, & $agentStatus) { /* :: interface :: */ }
	// :: full java declaration :: void changeAgentCommitment(osid.shared.Id agentId, osid.shared.Type agentStatus)

	/**
	 * Add an Agent commitment to this ScheduleItem.
	 * @param object agentId
	 * @param object agentStatus
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#UNKNOWN_ID UNKNOWN_ID}, {@link SchedulingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link SharedException#ALREADY_ADDED ALREADY_ADDED}
	 */
	function addAgentCommitment(& $agentId, & $agentStatus) { /* :: interface :: */ }
	// :: full java declaration :: void addAgentCommitment(osid.shared.Id agentId, osid.shared.Type agentStatus)
}


	/**
	 * Timespan defines a time span in terms of a start and end date and time. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.scheduling
	 */
class Timespan // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Start date and time of this Timespan.
	 * @return object java.util.Calendar
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getStart() { /* :: interface :: */ }

	/**
	 * Get the End date and time of this Timespan.
	 * @return object java.util.Calendar
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getEnd() { /* :: interface :: */ }
}


	/**
	 * AgentCommitmentIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	 * @package osid.scheduling
	 */
class AgentCommitmentIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  AgentCommitment objects; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next AgentCommitment.
	 * @return object AgentCommitment
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: AgentCommitment next()
}


	/**
	 * TimespanIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	 * @package osid.scheduling
	 */
class TimespanIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  Timespan objects; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Timespan.
	 * @return object Timespan
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Timespan next()
}


	/**
	 * ScheduleItemIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	 * @package osid.scheduling
	 */
class ScheduleItemIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  ScheduleItem objects; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next ScheduleItem.
	 * @return object ScheduleItem
	 * @throws osid.scheduling.SchedulingException An exception with one of the following messages defined in osid.scheduling.SchedulingException:   {@link SchedulingException#OPERATION_FAILED OPERATION_FAILED}, {@link SchedulingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SchedulingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SchedulingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SchedulingException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: ScheduleItem next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.scheduling
	 */
class SchedulingException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown or unsupported Type
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Operation failed
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Null argument
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argumen ");

	/**
	 * Permission denied
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Configuration error
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * End before Start
	 */
	// :: defined globally :: define("END_BEFORE_START","End cannot precede Start ");

	/**
	 * Object already added
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");
}

// :: post-declaration code ::
/**
 * string: Unknown Id 
 * @name UNKNOWN_ID
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * string: Unknown Type 
 * @name UNKNOWN_TYPE
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * string: Operation failed 
 * @name OPERATION_FAILED
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * string: Iterator has no more elements 
 * @name NO_MORE_ITERATOR_ELEMENTS
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * string: Null argumen 
 * @name NULL_ARGUMENT
 */
define("NULL_ARGUMENT", "Null argumen ");

/**
 * string: Permission denied 
 * @name PERMISSION_DENIED
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * string: Configuration error 
 * @name CONFIGURATION_ERROR
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * string: Unimplemented method 
 * @name UNIMPLEMENTED
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * string: End cannot precede Start 
 * @name END_BEFORE_START
 */
define("END_BEFORE_START", "End cannot precede Start ");

/**
 * string: Object already added 
 * @name ALREADY_ADDED
 */
define("ALREADY_ADDED", "Object already added ");

?>
