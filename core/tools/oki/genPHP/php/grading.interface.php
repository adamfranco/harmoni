<?php


	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes. The Manager supports creating a Gradable Object.  This focuses a reference to some external object such as an Assessment or something else.  Grade Records associate a Gradable Object with its Grade and for whom (an Agent).  Grades are a composite of the Grade, a Type of Grade, the Scale for the Grade, and the Scoring Definition against which to interpret the Grade. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradingManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a new GradableObject which includes all the elements for grading something for a CourseSection.  The type of grade and other grade characteristics are also specified.
	 * @param displayName
	 * @param description
	 *   CourseSectionId - CourseSections are defined in the CourseManagement OSID.
	 *   ExternalReferenceId - the Unique Id of something to be graded such as an Assessment.
	 *  GradeType
	 *  ScoringDefinition
	 *  GradeScale
	 * @return GradableObject
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.grading
	 */
	function &createGradableObject($displayName, $description, & $courseSectionId, & $externalReferenceId, & $gradeType, & $scoringDefinition, & $gradeScale) { /* :: interface :: */ }
	// :: full java declaration :: GradableObject createGradableObject
	 * Delete a GradableObject.
	 *  gradableObjectId
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.grading
	 */
	function deleteGradableObject(& $assignmentId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteGradableObject(osid.shared.Id assignmentId)

	/**
	 * Get a GradableObject by Unique Id.
	 *   gradableObjectId
	 * @return GradableObject
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.grading
	 */
	function &getGradableObject(& $gradableObjectId) { /* :: interface :: */ }
	// :: full java declaration :: GradableObject getGradableObject(osid.shared.Id gradableObjectId)

	/**
	 * Get all the GradableObjects, optionally including only those for a specific CourseSection or External Reference to what is being graded.  If any parameter is null, what is returned is not filtered by that parameter.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 *   CourseSectionId - CourseSections are defined in the CourseManagement OSID.
	 *   ExternalReferenceId - the Unique Id of something to be graded such as an Assessment.
	 * @return AssignmentIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.grading
	 */
	function &getGradableObjects(& $courseSectionId, & $externalReferenceId) { /* :: interface :: */ }
	// :: full java declaration :: GradableObjectIterator getGradableObjects
	 * Create a new GradeRecord for an Agent and with a Grade and GradeRecordType.   The GradeRecordType is they Type of GradeRecord not the Type of Grade contained in it.  GradeRecord Types might indicate a mid-term, partial, or final grade while GradeTypes might be letter, numeric, etc.  The Agent in this context is not the
	 *  GradableObjectId - the Unique Id of the GradableObject created by the createGradableObject method.
	 * null
	 *  gradeValue
	 *  gradeRecordType
	 * @return GradeRecord
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.grading
	 */
	function &createGradeRecord(& $gradbaleObjectId, & $agent, & $gradeValue, & $gradeRecordType) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecord createGradeRecord
	 * Delete a GradableObject.
	 *  gradableObjectId
	 * null
	 * null
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.grading
	 */
	function deleteGradeRecord(& $gradableObjectId, & $agent, & $gradeRecordType) { /* :: interface :: */ }
	// :: full java declaration :: void deleteGradeRecord(osid.shared.Id gradableObjectId, osid.shared.Agent agent, osid.shared.Type gradeRecordType)

	/**
	 * Get all the GradeRecords, optionally including only those for a specific CourseSection, GradableObject, External Reference to what is being graded, GradeRecordType, or Agent.  If any parameter is null, what is returned is not filtered by that parameter.  For example, getGradeRecords(xyzCourseSectionId,null,null,null,null) returns all GradeRecords for the xyzCourseSection; and getGradeRecords(xyzCourseSectionId,null,null,myAgent,quizGradeRecordType) returns all GradeRecords for quizzes taken by myAgent in the xyzCourseSection.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * null
	 * null
	 * null
	 * null
	 * null
	 * @return GradeRecordIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_ID UNKNOWN_ID}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.grading
	 */
	function &getGradeRecords(& $courseSectionId, & $externalReferenceId, & $gradableObjectId, & $agent, & $gradeRecordType) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecordIterator getGradeRecords
	 * Get all GradeRecordTypes.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeRecordTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getGradeRecordTypes()

	/**
	 * Get all GradeTypes.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getGradeTypes()

	/**
	 * Get all ScoringDefinitions.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getScoringDefinitions() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getScoringDefinitions()

	/**
	 * Get all GradeScales.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeScales() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getGradeScales()
}


	/**
	 * GradableObject includes a Name, Description, Id, GradeType, CourseSection reference, and External Reference to what is being graded.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradableObject // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this GradableObject.
	 * @return String the name
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Assignment.
	 * @param displayName
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function updateDisplayName($DisplayName) { /* :: interface :: */ }

	/**
	 * Get the description for this GradableObject.
	 * @return String the name
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this GradableObject.
	 * @param description
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function updateDescription($Description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this GradableObject.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Unique Id with a CourseSection.  CourseSections are created and managed through the
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getCourseSection() { /* :: interface :: */ }

	/**
	 * Get the Unique Id associated with some object that is being graded such as an Assessment.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getExternalReference() { /* :: interface :: */ }

	/**
	 * Get the GradeType associated with the GradableObject and Grade.  GradeType
	 * @return osid.shared.Type
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeType() { /* :: interface :: */ }

	/**
	 * Get the ScoringDefinition associated with the GradableObject and Grade.
	 * @return osid.shared.Type
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getScoringDefinition() { /* :: interface :: */ }

	/**
	 * Get the GradeScale associated with the GradableObject and Grade.
	 * @return osid.shared.Type
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeScale() { /* :: interface :: */ }
}


	/**
	 * GradeRecord includes a reference to a gradable object, an Agent, a Grade, and GradeType.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradeRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this GradeRecord's GradableObject.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradableObject() { /* :: interface :: */ }

	/**
	 * Get the Agent associated with this GradeRecord.  The Agent in this context is not the
	 * @return osid.shared.Agent
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getAgent() { /* :: interface :: */ }

	/**
	 * Get the value for this Grade.
	 * @return java.io.Serializable
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeValue() { /* :: interface :: */ }

	/**
	 * Update the value for this Grade.
	 * null
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function updateGradeValue(& $GradeValue) { /* :: interface :: */ }

	/**
	 * Get the Agent who modified this GradeRecord.
	 * @return osid.shared.Agent
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getModifiedBy() { /* :: interface :: */ }

	/**
	 * Get the date when this GradeRecord was modified.
	 * @return java.util.Calendar
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getModifiedDate() { /* :: interface :: */ }

	/**
	 * Get the GradeRecordType for this GradeRecord.  This is the Type of the GradeRecord, which is distinct from the Type of Grade.  A GradeRecord Type might be advisory, mid-term, final, etc, while a Grade Type might be letter, numeric, etc.
	 * @return osid.shared.Type
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeRecordType() { /* :: interface :: */ }

	/**
	 * Get the GradeType associated with the GradableObject and Grade.
	 * @return osid.shared.Type
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function &getGradeType() { /* :: interface :: */ }
}


	/**
	 * GradableObjectIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradableObjectIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  GradableObject ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next GradableObject.
	 * @return GradableObject
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.grading
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: GradableObject next()
}


	/**
	 * GradeRecordIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradeRecordIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  GradeRecords ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.grading
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next GradeRecord.
	 * @return GradeRecord
	 * @throws osid.grading.GradingException An exception with one of the following messages defined in osid.grading.GradingException:  {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.grading
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: GradeRecord next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.grading
	 */
class GradingException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 * @package osid.grading
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown or unsupported Type
	 * @package osid.grading
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Operation failed
	 * @package osid.grading
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 * @package osid.grading
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Configuration error
	 * @package osid.grading
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.grading
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.grading
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.grading
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.grading
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.grading
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.grading
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.grading
 */
define("UNIMPLEMENTED", "Unimplemented method ");

?>
