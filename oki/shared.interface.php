<?php

require_once(OKI."/osid.interface.php");

	/**
	 * SharedManager creates, deletes, and gets Agents and Groups and creates and gets Ids.  Group subclasses Agent and Groups may contain other Groups as well as Agents.  Note that this implementation uses a serialization approach that is simple rather than scalable.  Agents, Groups, and Ids are all lumped together into a single Vector that gets serialized.  The SharedManager interface provides for the creation, removal, and return of a variety of basic O.K.I.  objects.  Agents, Groups which extend Agents, and Ids are used in many different contexts throughout the OSIDs.  As with other Managers, use the OsidLoader to load an implementation of this interface.  All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes.   <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class SharedManager // :: API interface
	extends OsidManager
{

	/**
	 * Create an Agent with the display name and Type specified.  Both are immutable.
	 * @param string displayName
	 * @param object agentType
	 * @return object Agent
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function &createAgent($displayName, & $agentType) { /* :: interface :: */ }
	// :: full java declaration :: public Agent createAgent(String displayName, Type agentType)

	/**
	 * Delete the Agent with the specified Unique Id.
	 * @param object id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.shared
	 */
	function deleteAgent(& $id) { /* :: interface :: */ }
	// :: full java declaration :: public void deleteAgent(Id id)

	/**
	 * Get the Agent with the specified Unique Id. Getting an Agent by name is not supported since names are not guaranteed to be unique.
	 * @param object id
	 * @return object Agent
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.shared
	 */
	function &getAgent(& $id) { /* :: interface :: */ }
	// :: full java declaration :: public Agent getAgent(Id id)

	/**
	 * Return an iterator containing all the Agents.  An iterator provides access to the Agents one at a time.  Iterators have a method hasNext() which returns <code>true</code> if there are more Agents available and a method next() which returns the next Agent.
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getAgents() { /* :: interface :: */ }
	// :: full java declaration :: public AgentIterator getAgents()

	/**
	 * Return an iterator containing all the Agent Types.  An iterator provides access to the Agent Types from this implementation one at a time.  Iterators have a method hasNext() which returns true if there are more Agent Types available and a method next() which returns the next Agent Type.
	 * @return object TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getAgentTypes() { /* :: interface :: */ }
	// :: full java declaration :: public TypeIterator getAgentTypes()

	/**
	 * Create a Group with the display name and Type specified.  Both are immutable.
	 * @param string displayName
	 * @param object groupType
	 * @param string description
	 * @return object Group
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function &createGroup($displayName, & $groupType, $description) { /* :: interface :: */ }
	// :: full java declaration :: public Group createGroup(String displayName, Type groupType, String description)

	/**
	 * Delete the Group with the specified Unique Id.
	 * @param object id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.shared
	 */
	function deleteGroup(& $id) { /* :: interface :: */ }
	// :: full java declaration :: public void deleteGroup(Id id)

	/**
	 * Gets the Group with the specified Unique Id. Getting a Group by name is not supported since names are not guaranteed to be unique.
	 * @param object id
	 * @return object Group
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.shared
	 */
	function &getGroup(& $id) { /* :: interface :: */ }
	// :: full java declaration :: public Group getGroup(Id id)

	/**
	 * Get all the Groups.  Note since Groups subclass Agents, we are returning an AgentIterator and there is no GroupIterator. An iterator provides access to the Groups one at a time.  Iterators have a method hasNext() which returns true if there are more Groups available and a method next() which returns the next Group.
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getGroups() { /* :: interface :: */ }
	// :: full java declaration :: public AgentIterator getGroups()

	/**
	 * Return an iterator containing all the Group Types.  An iterator provides access to the Group Types from this implementation one at a time.  Iterators have a method hasNext() which returns true if there are more Group Types available and a method next() which returns the next Group Type.
	 * @return object TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getGroupTypes() { /* :: interface :: */ }
	// :: full java declaration :: public TypeIterator getGroupTypes()

	/**
	 * Create a new unique identifier.
	 * @return object Id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &createId() { /* :: interface :: */ }
	// :: full java declaration :: public Id createId()

	/**
	 * Get the Unique Id with this String representation or create a new Unique Id with this representation.
	 * @param object idString
	 * @return object Id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function &getId($idString) { /* :: interface :: */ }
	// :: full java declaration :: public Id getId(String idString)

	/**
	 * Get all the Agents of the specified Type.
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function &getAgentsByType(& $agentType) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getAgentsByType(osid.shared.Type agentType)

	/**
	 * Get all the Groups of the specified Type.
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function &getGroupsByType(& $groupType) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getGroupsByType(osid.shared.Type groupType)
}


	/**
	 * Agents are an abstraction for a principal or group.  The Agent may be granted authorization to perform specific functions.  Agents are created through implementations of osid.shared.SharedManager and have an immutable name, Type, and Unique Id. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class Agent // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name of this Agent.
	 * @return object String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: public String getDisplayName()

	/**
	 * Get the id of this Agent.
	 * @return object id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: public osid.shared.Id getId()

	/**
	 * Get the type of this Agent.
	 * @return object Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getType() { /* :: interface :: */ }
	// :: full java declaration :: public osid.shared.Type getType()

	/**
	 * Get all the Properties associated with this Agent.
	 * @return object PropertiesIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getProperties() { /* :: interface :: */ }
	// :: full java declaration :: PropertiesIterator getProperties()

	/**
	 * Get the Properties of this Type associated with this Agent.
	 * @return object Properties
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.shared
	 */
	function &getPropertiesByType(& $propertiesType) { /* :: interface :: */ }
	// :: full java declaration :: Properties getPropertiesByType(Type propertiesType)

	/**
	 * Get the Properties Types supported by the implementation.
	 * @return object TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getPropertiesTypes() { /* :: interface :: */ }
	// :: full java declaration :: TypeIterator getPropertiesTypes()
}


	/**
	 * Properties is a mechanism for returning read-only data about an Agent.  Each Agent can have data associated with a PropertiesType.  For each PropertiesType, there are Properties which are Serializable values identified by a key.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class Properties // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Type associated with these Properties. Properties
	 * @return object Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getType() { /* :: interface :: */ }
	// :: full java declaration :: Type getType()

	/**
	 * Get the Property associated with this key.
	 * @return object java.io.Serializable
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#UNKNOWN_KEY UNKNOWN_KEY}
	 * @package osid.shared
	 */
	function &getProperty(& $key) { /* :: interface :: */ }
	// :: full java declaration :: java.io.Serializable getProperty(java.io.Serializable key)

	/**
	 * Get the Keys associated with these Properties.
	 * @return object ObjectIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getKeys() { /* :: interface :: */ }
	// :: full java declaration :: SerializableObjectIterator getKeys()
}


	/**
	 *     The Group may contain Members (Agents) as well as other Groups.  There are management methods for adding, removing, and getting members and Groups.  There are also methods for testing if a Group or member is contained in a Group, and returning all Members in a Group, all Groups in a Group, or all Groups containing a specific Member. Many methods include an argument that specifies whether to include all subgroups or not.  This allows for more flexible maintenance and interrogation of the structure. Note that there is no specification for persisting the Group or its content -- this detail is left to the implementation. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class Group // :: API interface
	extends Agent
{

	/**
	 * Get the DisplayName of this Group as stored.
	 * @return object the String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: public String getDisplayName()

	/**
	 * Get the Description of this Group as stored.
	 * @return object String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the Description of this Group as stored.
	 * @param string description
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id of this Group as stored.
	 * @return object Id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Update the Type of this Group as stored.
	 * @return object Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getType() { /* :: interface :: */ }
	// :: full java declaration :: public osid.shared.Type getType()

	/**
	 * Add an Agent member or a Group to this Group.  The Member or Group will not be added if it already exists in the group.
	 * @param object memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#ALREADY_ADDED ALREADY_ADDED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function add(& $memberOrGroup) { /* :: interface :: */ }
	// :: full java declaration :: void add(Agent memberOrGroup)

	/**
	 * Remove an Agent member or a Group from this Group. If the Member or Group is not in the group no action is taken and no exception is thrown.
	 * @param object memberOrGroup
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function remove(& $memberOrGroup) { /* :: interface :: */ }
	// :: full java declaration :: void remove(Agent memberOrGroup)

	/**
	 * Get all the Members of this group and optionally all the Members from all subgroups. Duplicates are not returned.
	 * @param object includeSubgroups
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getMembers($includeSubgroups) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getMembers(boolean includeSubgroups)

	/**
	 * Get all the Groups in this group and optionally all the subgroups in this group. Note since Groups subclass Agents, we are returning an AgentIterator and there is no GroupIterator.
	 * @param object includeSubgroups
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function &getGroups($includeSubgroups) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getGroups(boolean includeSubgroups)

	/**
	 * Get all the Groups, including subgroups, containing the Member. Note since Groups subclass Agents, we are returning an AgentIterator and there is no GroupIterator.
	 * @param object member
	 * @return object AgentIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function &getGroupsContainingMember(& $member) { /* :: interface :: */ }
	// :: full java declaration :: AgentIterator getGroupsContainingMember(Agent member)

	/**
	 * Return <code>true</code> if the Member or Group is in the Group, optionally including subgroups, <code>false</code> otherwise.
	 * @param object memberOrGroup
	 * @param object searchSubgroups
	 * @return object boolean
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function contains(& $memberOrGroup, $searchSubgroups) { /* :: interface :: */ }
	// :: full java declaration :: boolean contains(Agent memberOrGroup , boolean searchSubgroups)
}


	/**
	 *  The Type class captures the fundamental concept of categorizing an object.  Type are designed to be shared among various SIDs and Managers.  The exact meaning of a particular type is left to the developers who use a given Type subclass.  The form of the Type class enables categorization. There are four Strings that make up the Type class: authority, domain, keyword, and description.  The first three of these Strings are used by the isEqual method to determine if two instance of the Type class are equal.  The fourth String, description, is used to clarify the semantic meaning of the instance.<p>An example of a FunctionType instance:<p><br />  - authority is "higher ed"<br />  - domain is "authorization"<br />  - keyword is "writing checks"<br />  - description is "This is the FunctionType for writing checks"<p>This Type could be used with the authorization SID.  It could also be used with the dictionary SID to determine the text to display for a given locale (for example, CANADA_FRENCH).  The dictionary SID could use the FunctionType instance as a key to find the display text, but it could also use just the keyword string from the FunctionType as a key.  By using the keyword the same display text could then be used for other FunctionTypes such as: <br />  - authority is "mit"<br />  - domain is "accounting"<br />  - keyword is "writing checks"<br />  - description is "A/P check writing type"<br />An instance of the Type class can be used in a variety of ways to categorize information either as a complete object or as one of its parts (ie authority, domain, keyword). <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class TypeInterface // :: abstract
//	implements java.io.Serializable
{
	/**
	 * @var string $domain private String domain
	 */
	var $_domain;
	/**
	 * @var string $authority private String authority
	 */
	var $_authority;
	/**
	 * @var string $keyword private String keyword
	 */
	var $_keyword;
	/**
	 * @var string $description private String description
	 */
	var $_description;

	/**
	 * Construct a Type object for this domain, authority and keyword.
	 * @param object domain
	 * @param object authority
	 * @param object keyword
	 * @package osid.shared
	 */
	function &Type($domain, $authority, $keyword) { /* :: interface :: */ }
	// :: full java declaration :: public Type(String domain, String authority, String keyword)

	/**
	 * Construct a Type object for this domain, authority, keyword, and description.
	 * @param object domain
	 * @param object authority
	 * @param object keyword
	 * @param string description
	 * @package osid.shared
	 */
//	 :: this function hidden due to previous declaration
//	function &Type($domain, $authority, $keyword, $description) { /* :: interface :: */ }
//	 :: end
	// :: full java declaration :: public Type(String domain, String authority, String keyword, String description)

	/**
	 * Compare the specified Type with this Type for equality.<p>Two Types are equal if the domain, authority and keyword are equal.
	 * @param object type2
	 * @return object boolean
	 * @package osid.shared
	 */
	function isEqual(& $type2) { /* :: interface :: */ }
	// :: full java declaration :: public final boolean isEqual(Type type2)

	/**
	 * Get the domain part of this Type.  The domain is a String representing the domain which
	 * @return object String
	 * @package osid.shared
	 */
	function getDomain() { /* :: interface :: */ }
	// :: full java declaration :: public final String getDomain()

	/**
	 * Get the authority part of this Type.<p>The authority is a String representing the naming authority which gives meaning to the keyword, representing the vocabulary defining the keyword, or equivalent function.
	 * @return object String
	 * @package osid.shared
	 */
	function getAuthority() { /* :: interface :: */ }
	// :: full java declaration :: public final String getAuthority()

	/**
	 * Return the keyword part of the Type.<p>The keyword is a String uniquely defining this Type within the scope of the authority.
	 * @return object String
	 * @package osid.shared
	 */
	function getKeyword() { /* :: interface :: */ }
	// :: full java declaration :: public final String getKeyword()

	/**
	 * Get description part of the Type.<p>The description is a String which further qualifies this instance of a Type.  Two Types which differ only by description are still identical.
	 * @return object String
	 * @package osid.shared
	 */
	function getDescription() { /* :: interface :: */ }
	// :: full java declaration :: public final String getDescription()
}


	/**
	 * Id creates and manages unique identifiers.  The identifier is created with createId().  A String representation of the identifier is available with getIdString().  To convert from a String to the identifier, use getId(String). <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class Id // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return the String representation of this Unique Id.
	 * @return object String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function getIdString() { /* :: interface :: */ }
	// :: full java declaration :: String getIdString()

	/**
	 * Tests if an Unique Id equals this Unique Id.
	 * @param object id
	 * @return object boolean
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.shared
	 */
	function isEqual(& $id) { /* :: interface :: */ }
	// :: full java declaration :: boolean isEqual(osid.shared.Id id)
}


	/**
	 * AgentIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class AgentIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Agents; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Agents; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Agent.
	 * @return object Agent
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Agent next()
}


	/**
	 * PropertiesIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class PropertiesIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Properties; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Properties; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Properties.
	 * @return object Properties
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Properties next()
}


	/**
	 * TypeIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class TypeIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Types; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Types; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Type
	 * @return object Type
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Type next()
}


	/**
	 * IdIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class IdIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Ids; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Ids; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Id
	 * @return object Id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Id next()
}


	/**
	 * Stringiterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class StringIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Strings; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Strings; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next String
	 * @return object String
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function next() { /* :: interface :: */ }
	// :: full java declaration :: String next()
}


	/**
	 * IntValueIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class IntValueIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional ints; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional ints; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next int
	 * @return object int
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function next() { /* :: interface :: */ }
	// :: full java declaration :: int next()
}


	/**
	 * ByteValueIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class ByteValueIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional bytes; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional bytes; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next byte
	 * @return object byte
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: byte next()
}


	/**
	 * CharValueIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class CharValueIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional chars; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional chars; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next char
	 * @return object char
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function next() { /* :: interface :: */ }
	// :: full java declaration :: char next()
}


	/**
	 * ObjectIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class ObjectIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Objects; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Objects; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Object
	 * @return object object
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Object next()
}


	/**
	 * CalendarIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class CalendarIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Calendars; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Calendars; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Calendar
	 * @return object next Calendar
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar next()
}


	/**
	 * SerializableObjectIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.  To maximize reuse and implementation substitutability, it is important not to reference a class in one OSID implementation directly in another.  Interfaces should be used and new called only on objects in the implementation package.  To avoid binding a specific implementation of Shared to a specific implementaiton of some other OSID, implementations TypeIterator and the other primitative-type Iterators should reside in each OSID that requires them and not in an implementation of Shared.  For example, if an implementation of osid.logging.LoggingManager needs a class that implements osid.shared.StringIterator, the class should be in the package implementing Logging.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class SerializableObjectIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional Objects; <code>false</code> otherwise.
	 * Return <code>true</code> if there are additional Object; <code>false</code> otherwise.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.shared
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Object
	 * @return object next Object
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.shared
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: java.io.Serializable next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.shared
	 */
class SharedException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 * @package osid.shared
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown or unsupported Type
	 * @package osid.shared
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Operation failed
	 * @package osid.shared
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 * @package osid.shared
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Circular operation
	 * @package osid.shared
	 */
	// :: defined globally :: define("CIRCULAR_OPERATION","Circular operation not allowed ");

	/**
	 * Null argument
	 * @package osid.shared
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Permission denied
	 * @package osid.shared
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Object already added
	 * @package osid.shared
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");

	/**
	 * Configuration error
	 * @package osid.shared
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.shared
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * Unknown key
	 * @package osid.shared
	 */
	// :: defined globally :: define("UNKNOWN_KEY","Unknown key ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.shared
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.shared
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.shared
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.shared
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string CIRCULAR_OPERATION public static final String CIRCULAR_OPERATION = "Circular operation not allowed "
 * @package osid.shared
 */
define("CIRCULAR_OPERATION", "Circular operation not allowed ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.shared
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.shared
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string ALREADY_ADDED public static final String ALREADY_ADDED = "Object already added "
 * @package osid.shared
 */
define("ALREADY_ADDED", "Object already added ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.shared
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.shared
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string UNKNOWN_KEY public static final String UNKNOWN_KEY = "Unknown key "
 * @package osid.shared
 */
define("UNKNOWN_KEY", "Unknown key ");

?>
