<?php
/**
 * @package osid.assessment
 */


/**
 * @ignore
 */
require_once(OKI."/osid.interface.php");

	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a new Assessment and add it to the Assessment Bank.
	 * @param string name
	 * @param string description
	 * @param object assessmentType
	 * @return object Item with its name, description, and Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &createAssessment($name, $description, & $assessmentType) { /* :: interface :: */ }
	// :: full java declaration :: Assessment createAssessment(String name, String description, osid.shared.Type assessmentType)

	/**
	 * Delete an Assessment from the Assessment Bank.
	 * @param object assessmentId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteAssessment(& $assessmentId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteAssessment(osid.shared.Id assessmentId)

	/**
	 * Get the Assessment with the specified Unique Id
	 * @param object assessmentId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function &getAssessment(& $assessmentId) { /* :: interface :: */ }
	// :: full java declaration :: Assessment getAssessment(osid.shared.Id assessmentId)

	/**
	 * Get all the Assessments of a specific Type.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object assessmentType
	 * @return object AssessmentIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getAssessmentsByType(& $assessmentType) { /* :: interface :: */ }
	// :: full java declaration :: AssessmentIterator getAssessmentsByType(osid.shared.Type assessmentType)

	/**
	 * Get all the Assessments in the Assessment Bank.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssessmentIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessments() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentIterator getAssessments()

	/**
	 * Create a new Section and add it to the Section Bank.
	 * @param string displayName
	 * @param string description
	 * @param object sectionType
	 * @return object Item with its name, description, and Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &createSection($name, $description, & $sectionType) { /* :: interface :: */ }
	// :: full java declaration :: Section createSection(String name, String description, osid.shared.Type sectionType)

	/**
	 * Delete a Section from the Section Bank.
	 * @param object sectionId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} , {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteSection(& $sectionId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteSection(osid.shared.Id sectionId)

	/**
	 * Get the Section with the specified Unique Id
	 * @param object sectionId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function &getSection(& $sectionId) { /* :: interface :: */ }
	// :: full java declaration :: Section getSection(osid.shared.Id sectionId)

	/**
	 * Get all the Sections of a specific Type.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object sectionType
	 * @return object SectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getSectionsByType(& $sectionType) { /* :: interface :: */ }
	// :: full java declaration :: SectionIterator getSectionsByType(osid.shared.Type sectionType)

	/**
	 * Get all the Sections in the Section Bank  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object SectionIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSections() { /* :: interface :: */ }
	// :: full java declaration :: SectionIterator getSections()

	/**
	 * Create a new Item  and add it to the Item Bank.
	 * @param string displayName
	 * @param string description
	 * @param object itemType
	 * @return object Item with its name, description, and Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &createItem($name, $description, & $itemType) { /* :: interface :: */ }
	// :: full java declaration :: Item createItem(String name, String description, osid.shared.Type itemType)

	/**
	 * Delete a Item from the Item Bank.
	 * @param object itemId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteItem(& $itemId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteItem(osid.shared.Id itemId)

	/**
	 * Get the Item with the specified Unique Id
	 * @param object itemId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function &getItem(& $itemId) { /* :: interface :: */ }
	// :: full java declaration :: Item getItem(osid.shared.Id itemId)

	/**
	 * Get all the Items of a specific Type.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object itemType
	 * @return object ItemIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getItemsByType(& $itemType) { /* :: interface :: */ }
	// :: full java declaration :: ItemIterator getItemsByType(osid.shared.Type itemType)

	/**
	 * Get all the Items in the Item Bank.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object ItemIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItems() { /* :: interface :: */ }
	// :: full java declaration :: ItemIterator getItems()

	/**
	 * Create an AssessmentPublished based on an Assessment.
	 * @param object assessment
	 * @return object AssessmentPublished with its Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function &createAssessmentPublished(& $assessment) { /* :: interface :: */ }
	// :: full java declaration :: AssessmentPublished createAssessmentPublished(Assessment assessment)

	/**
	 * Delete an AssessmentPublished.
	 * @param object assessmentPublishedId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteAssessmentPublished(& $assessmentPublishedId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteAssessmentPublished(osid.shared.Id assessmentPublishedId)

	/**
	 * Get the specified AssessmentPublished.
	 * @param object assessmentPublishedId
	 * @return object AssessmentPublishedIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function &getAssessmentPublished(& $assessmentPublishedId) { /* :: interface :: */ }
	// :: full java declaration :: AssessmentPublished getAssessmentPublished(osid.shared.Id assessmentPublishedId)

	/**
	 * Get all the Assessments published.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssessmentPublishedIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentsPublished() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentPublishedIterator getAssessmentsPublished()

	/**
	 * Get all the Assessment Types.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getAssessmentTypes()

	/**
	 * Get all the Section Types.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSectionTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSectionTypes()

	/**
	 * Get all the Item Types.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItemTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getItemTypes()

	/**
	 * Get all the Evaluation Types.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getEvaluationTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getEvaluationTypes()
}


	/**
	 * Assessment includes zero or more Sections which in turn contain zero or more Items. The Sections added to a Assessment  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class Assessment // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this Assessment.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Assessment.
	 * @param string displayName
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this Assessment.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this Assessment.
	 * @param string description
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this Assessment.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the AssessmentType for this Assessment.  AssessmentType The structure of the Data is not defined in the SID.
	 * @return object osid.shared.Type
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentType() { /* :: interface :: */ }

	/**
	 * Get the Topic for this
	 * @return object String the Topic Assessment
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getTopic() { /* :: interface :: */ }

	/**
	 * Update the Topic for this
	 * @param object topic Assessment
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateTopic($Topic) { /* :: interface :: */ }

	/**
	 * Add a Section to this Assessment. The Sections added to an Assessment are returned first in, first out (FIFO).  Sections can be ordered explicitly using the orderSections method.
	 * @param object section
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#ALREADY_ADDED ALREADY_ADDED}
	 	 */
	function addSection(& $section) { /* :: interface :: */ }
	// :: full java declaration :: void addSection(Section section)

	/**
	 * Remove a Section from this Assessment.
	 * @param object sectionId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function removeSection(& $sectionId) { /* :: interface :: */ }
	// :: full java declaration :: void removeSection(osid.shared.Id sectionId)

	/**
	 * Get all the Sections in the Assessment.  The Sections added to a Assessment are returned first in, first out (FIFO).  Sections can be ordered explicitly using the orderSections method.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object SectionIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSections() { /* :: interface :: */ }
	// :: full java declaration :: SectionIterator getSections()

	/**
	 * Change the order of the  Sections in the Assessment.  Sections normally are returned first in, first out (FIFO).  This ordering, which has important pedagogical implications, is changed to match the order in the  Sections array.  Additional added Sections are returned first in, first out (FIFO) after the ordered Sections.
	 * @param object sections
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_SECTION UNKNOWN_SECTION}
	 	 */
	function orderSections(& $sections) { /* :: interface :: */ }
	// :: full java declaration :: void orderSections(Section[] sections)

	/**
	 * Get the serializable Data for this Assessment.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this Assessment.  The structure of the Data is not defined in the SID.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }
}


	/**
	 * Section includes zero or more Items and can also contain other Sections.  The Items added to a Section are returned first in, first out (FIFO).  Items can be ordered explicitly using the orderItems method.  The Sections added to a Section are returned first in, first out (FIFO).  Sections can be ordered explicitly using the orderSections method. SectionType is meaningful to an application and not specifically defined in the SID.. The Unique Id is set by the AssessmentManager's createSection method's implementation. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class Section // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this Section.
	 * @return string The name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Section.
	 * @param string displayName
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this Section.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this Section.
	 * @param string description
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this Item.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the SectionType for this Section.  is meaningful to an application and not specifically defined in the SID.
	 * @return object osid.shared.Type
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSectionType() { /* :: interface :: */ }

	/**
	 * Add an Item to this Section.  The Items added to a Section are returned first in, first out (FIFO).  Items can be ordered explicitly using the orderItems method.
	 * @param object item
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#ALREADY_ADDED ALREADY_ADDED}
	 	 */
	function addItem(& $item) { /* :: interface :: */ }
	// :: full java declaration :: void addItem(Item item)

	/**
	 * Remove an Item from this Section.
	 * @param object itemId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function removeItem(& $itemId) { /* :: interface :: */ }
	// :: full java declaration :: void removeItem(osid.shared.Id itemId)

	/**
	 * Get all the Items in the Section.  The Items added to a Section are returned first in, first out (FIFO).  Items can be ordered explicitly using the orderItems method.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object ItemIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItems() { /* :: interface :: */ }
	// :: full java declaration :: ItemIterator getItems()

	/**
	 * Change the order of the  Items in the Section.  Items normally are returned first in, first out (FIFO).  This ordering, which has important pedagogical implications, is changed to match the order in the  Items array.  Additional added Items are returned first in, first out (FIFO) after the ordered Items.
	 * @param object items
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ITEM UNKNOWN_ITEM}
	 	 */
	function orderItems(& $items) { /* :: interface :: */ }
	// :: full java declaration :: void orderItems(Item[] items)

	/**
	 * Add a Section to this Section. The Sections added to a Section are returned first in, first out (FIFO).  Sections can be ordered explicitly using the orderSections method.
	 * @param object section
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#ALREADY_ADDED ALREADY_ADDED}
	 	 */
	function addSection(& $section) { /* :: interface :: */ }
	// :: full java declaration :: void addSection(Section section)

	/**
	 * Remove a Section from this Section.
	 * @param object sectionId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function removeSection(& $sectionId) { /* :: interface :: */ }
	// :: full java declaration :: void removeSection(osid.shared.Id sectionId)

	/**
	 * Get all the Sections in the Section.  The Sections added to a Section are returned first in, first out (FIFO).  Sections can be ordered explicitly using the orderSections method.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object SectionIterator
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSections() { /* :: interface :: */ }
	// :: full java declaration :: SectionIterator getSections()

	/**
	 * Change the order of the  Sections in the Section.  Sections normally are returned first in, first out (FIFO).  This ordering, which has important pedagogical implications, is changed to match the order in the  Sections array.  Additional added Sections are returned first in, first out (FIFO) after the ordered Sections.
	 * @param object sections
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_SECTION UNKNOWN_SECTION}
	 	 */
	function orderSections(& $sections) { /* :: interface :: */ }
	// :: full java declaration :: void orderSections(Section[] sections)

	/**
	 * Get the serializable Data for this Section.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this Section.  The structure of the Data is not defined in the SID.
	.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }
}


	/**
	 * Item includes the question, set of responses, answer, and any supporting instructions and media.  These elements are all contained in a serializable Data object whose content is not specified in the SID. Items are characterized by their response type, for example multiple-choice.  ItemType is meaningful to an application and not specifically defined in the SID.. The Unique Id for an item is set by the AssessmentManager's createItem method's implementation.  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class Item // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this Item.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Item.
	 * @param string displayName
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this Item.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this Item.
	 * @param string description
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this Item.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the ItemType for this Item.  ItemType The structure of the Data is not defined in the SID.
	 * @return object osid.shared.Type
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItemType() { /* :: interface :: */ }

	/**
	 * Get the serializable Data for this Item. This may include the question, responses, answer, instructions, media, etc.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this Item. This may include the question, responses, answer, instructions, media, etc.  The structure of the Data is not defined in the SID.
	 * @param object data
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }
}


	/**
	 * AssessmentPublished includes an Assessment as well as additional data relating to the availability of the Assessment.   <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentPublished // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this AssessmentPublished.
	 * @return string the name
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this AssessmentPublished.
	 * @param string displayName
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this AssessmentPublished.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this AssessmentPublished.
	 * @param string description
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this AssessmentPublished.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the date the Assessment was published.
	 * @return object osid.shared.Calendar
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getDate() { /* :: interface :: */ }

	/**
	 * Get the Assessment being published.
	 * @return object Assessment
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessment() { /* :: interface :: */ }

	/**
	 * Get the Unique Id of the Assignment associated with this AssessmentPublished, if any.  The Unique Id refers to an object created through the Grading SID.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getGradingAssignmentId() { /* :: interface :: */ }

	/**
	 * Set the Unique Id of the Assignment associated with this AssessmentPublished, if any.  The Unique Id refers to an object created through the Grading SID.
	 * @param object gradingAssignmentId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function updateGradingAssignmentId(& $gradingAssignmentId) { /* :: interface :: */ }

	/**
	 * Get the Unique Id of the Course Section associated with this AssessmentPublished, if any.  The Unique Id refers to an object created through the Classadmin SID.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getCourseSectionId() { /* :: interface :: */ }

	/**
	 * Set the Unique Id of the Course Section associated with this AssessmentPublished, if any.  The Unique Id refers to an object created through the Classadmin SID.
	 * @param object courseSectionId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function updateCourseSectionId(& $courseSectionId) { /* :: interface :: */ }

	/**
	 * Get the serializable Data for this AssessmentPublished. The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this AssessmentPublished. The structure of the Data is not defined in the SID.
	.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }

	/**
	 * Create an AssessmentTaken based on an AssessmentPublished and Agent.
	 * @param object agent
	 * @return object AssessmentTaken with its Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function &createAssessmentTaken(& $agent) { /* :: interface :: */ }
	// :: full java declaration :: AssessmentTaken createAssessmentTaken(osid.shared.Agent agent)

	/**
	 * Delete an AssessmentTaken.
	 * @param object assessmentTakenId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteAssessmentTaken(& $assessmentTakenId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteAssessmentTaken(osid.shared.Id assessmentTakenId)

	/**
	 * Get all the Assessments taken.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssessmentTakenIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentsTaken() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentTakenIterator getAssessmentsTaken()

	/**
	 * Get all the Assessments taken by a specific Agent.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object agentId
	 * @return object AssessmentTakenIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentsTakenBy(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: AssessmentTakenIterator getAssessmentsTakenBy(osid.shared.Id agentId)

	/**
	 * Get all the Evaluations for this Item.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getEvaluations() { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluations()

	/**
	 * Get the Evaluations of the specified Type for this Assessment.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object evaluationType
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getEvaluationsByType(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluationsByType(osid.shared.Type evaluationType)
}


	/**
	 * AssessmentTaken includes a AssessmentPublished, the student (Agent) who took it, the Sections taken within which are the Items taken, and the Evaluations for the Assessment.  There is also any supporting data.  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentTaken // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this AssessmentTaken.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the AssessmentPublished that was taken.
	 * @return object AssessmentPublished
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentPublished() { /* :: interface :: */ }

	/**
	 * Get the student who took the Assessment.
	 * @return object osid.shared.Agent
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAgent() { /* :: interface :: */ }

	/**
	 * Create a SectionTaken based on an AssessmentPublished and Agent.
	 * @param object section
	 * @return object SectionTaken with its Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_SECTION UNKNOWN_SECTION}
	 	 */
	function &createSectionTaken(& $section) { /* :: interface :: */ }
	// :: full java declaration :: SectionTaken createSectionTaken(Section section)

	/**
	 * Delete a SectionTaken.
	 * @param object sectionTakenId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteSectionTaken(& $sectionTakenId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteSectionTaken(osid.shared.Id sectionTakenId)

	/**
	 * Get all the Sections taken for this Assessment.  SectionsTaken are returned first in, first out (FIFO).  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object SectionTakenIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSectionsTaken() { /* :: interface :: */ }
	// :: full java declaration :: SectionTakenIterator getSectionsTaken()

	/**
	 * Create an Evaluation of the specified Type for this Assessment.
	 * @param object evaluationType
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &createEvaluation(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: Evaluation createEvaluation(osid.shared.Type evaluationType)

	/**
	 * Delete this Evaluation from this Assessment.
	 * @param object evaluationId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteEvaluation(& $evaluationId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteEvaluation(osid.shared.Id evaluationId)

	/**
	 * Get the Evaluations of the specified Type for this Assessment.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object evaluationType
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getEvaluationsByType(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluationsByType(osid.shared.Type evaluationType)

	/**
	 * Get all the Evaluations for this Assessment.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getEvaluations() { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluations()

	/**
	 * Get the date the Assessment was taken.
	 * @return object osid.shared.Calendar
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getDate() { /* :: interface :: */ }

	/**
	 * Get the serializable Data for this AssessmentTaken.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this AssessmentTaken.  The structure of the Data is not defined in the SID.
	.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }
}


	/**
	 * SectionTaken includes all the Items taken and any Evaluations for the Section.  There is also any supporting data.  <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class SectionTaken // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this SectionTaken.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the SectionTaken to which this ItemTaken belongs.
	 * @return object Section
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSection() { /* :: interface :: */ }

	/**
	 * Create an ItemTaken based on a SectionTaken.
	 * @param object item
	 * @return object ItemTaken with its Unique Id set
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ITEM UNKNOWN_ITEM}
	 	 */
	function &createItemTaken(& $item) { /* :: interface :: */ }
	// :: full java declaration :: ItemTaken createItemTaken(Item item)

	/**
	 * Delete an ItemTaken.
	 * @param object itemTakenId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteItemTaken(& $itemTakenId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteItemTaken(osid.shared.Id itemTakenId)

	/**
	 * Get all the Items taken for this Section.  ItemsTaken are returned first in, first out (FIFO).  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object ItemsTakenIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItemsTaken() { /* :: interface :: */ }
	// :: full java declaration :: ItemIterator getItemsTaken()

	/**
	 * Create an Evaluation of the specified Type for this Section.
	 * @param object evaluationType
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &createEvaluation(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: Evaluation createEvaluation(osid.shared.Type evaluationType)

	/**
	 * Delete this Evaluation from this Section.
	 * @param object evaluationId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteEvaluation(& $evaluationId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteEvaluation(osid.shared.Id evaluationId)

	/**
	 * Get the Evaluations of the specified Type for this Section.   Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object evaluationType
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getEvaluationsByType(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluationsByType(osid.shared.Type evaluationType)

	/**
	 * Get all the Evaluations for this Section.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getEvaluations() { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluations()

	/**
	 * Get the serializable Data for this SectionTaken.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this AssessmentTaken.  The structure of the Data is not defined in the SID.
	.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }

	/**
	 * Get the AssessmentTaken to which this SectionTaken belongs.
	 * @return object AssessmentTaken
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getAssessmentTaken() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentTaken getAssessmentTaken()
}


	/**
	 * ItemTaken includes the Item, the Submitted Response, and any Evaluation of the SubmittedResponse. There is also any supporting data. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class ItemTaken // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this ItemTaken.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Item taken.
	 * @return object Item
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getItem() { /* :: interface :: */ }

	/**
	 * Create an Evaluation of the specified Type for this Item.
	 * @param object evaluationType
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function createEvaluation(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: void createEvaluation(osid.shared.Type evaluationType)

	/**
	 * Delete this Evaluation from this Item.
	 * @param object evaluationId
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_ID UNKNOWN_ID}
	 	 */
	function deleteEvaluation(& $evaluationId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteEvaluation(osid.shared.Id evaluationId)

	/**
	 * Get the Evaluations of the specified Type for this Item.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param object evaluationType
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AssessmentException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 	 */
	function &getEvaluationsByType(& $evaluationType) { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluationsByType(osid.shared.Type evaluationType)

	/**
	 * Get all the Evaluations for this Item.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object EvaluationIterator Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getEvaluations() { /* :: interface :: */ }
	// :: full java declaration :: EvaluationIterator getEvaluations()

	/**
	 * Get the serializable Data for this ItemTaken.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this ItemTaken.  The structure of the Data is not defined in the SID.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }

	/**
	 * Get the SectionTaken to which this ItemTaken belongs.
	 * @return object SectionTaken
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getSectionTaken() { /* :: interface :: */ }
	// :: full java declaration :: SectionTaken getSectionTaken()
}


	/**
	 * Evaluation has a specific Type.  There is also supporting data which contains the evaluation that is meaningful to the application and is not specified by the SID. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}..
	 * @package osid.assessment
	 */
class Evaluation // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this Evaluation.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the EvaluationType for this Evaluation.  EvaluationType The structure of the Data is not defined in the SID.
	 * @return object osid.shared.Type
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getType() { /* :: interface :: */ }

	/**
	 * Get the Id for the object taken.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getObjectTaken() { /* :: interface :: */ }

	/**
	 * Get the serializable Data for this Evaluation.  The structure of the Data is not defined in the SID.
	 * @return object java.io.Serializable the Data.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getData() { /* :: interface :: */ }

	/**
	 * Update the data for this Evaluation.  The structure of the Data is not defined in the SID.
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AssessmentException#NULL_ARGUMENT NULL_ARGUMENT}
	 	 */
	function updateData(& $Data) { /* :: interface :: */ }

	/**
	 * Get the Agent who modified this Evaluation.
	 * @return object osid.shared.Agent
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getModifiedBy() { /* :: interface :: */ }

	/**
	 * Get the date when this Evaluation was modified.
	 * @return object java.util.Calendar
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function &getModifiedDate() { /* :: interface :: */ }
}


	/**
	 * AssessmentIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}..
	 * @package osid.assessment
	 */
class AssessmentIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Assessments ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Assessment.
	 * @return object Assessment
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Assessment next()
}


	/**
	 * SectionIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}..
	 * @package osid.assessment
	 */
class SectionIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Sections ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Section.
	 * @return object Section
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Section next()
}


	/**
	 * ItemIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class ItemIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  Items ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Item.
	 * @return object Item
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Item next()
}


	/**
	 * AssessmentPublishedIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentPublishedIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  AssessmentsPublished ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next AssessmentsPublished.
	 * @return object AssessmentPublished
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentPublished next()
}


	/**
	 * AssessmentTakenIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentTakenIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  AssessmentsTaken ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next AssessmentTaken.
	 * @return object AssessmentTaken
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: AssessmentTaken next()
}


	/**
	 * SectionTakenIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class SectionTakenIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  SectionsTaken ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next SectionTaken.
	 * @return object SectionTaken
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: SectionTaken next()
}


	/**
	 * ItemTakenIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class ItemTakenIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  ItemsTaken ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next ItemTaken.
	 * @return object ItemTaken
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: ItemTaken next()
}


	/**
	 * EvaluationIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class EvaluationIterator // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return <code>true</code> if there are additional  Evaluations ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED}
	 	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Evaluation.
	 * @return object Evaluation
	 * @throws osid.assessment.AssessmentException An exception with one of the following messages defined in osid.assessment.AssessmentException:  {@link AssessmentException#OPERATION_FAILED OPERATION_FAILED}, {@link AssessmentException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AssessmentException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AssessmentException#UNIMPLEMENTED UNIMPLEMENTED} Throws an exception with the message osid.OsidException.NO_MORE_ELEMENTS if all objects have already been returned.
	 	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Evaluation next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.assessment
	 */
class AssessmentException // :: normal class
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
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Permission denied
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Object already added
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");

	/**
	 * Configuration error
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unknown Section
	 */
	// :: defined globally :: define("UNKNOWN_SECTION","Unknown Section ");

	/**
	 * Unknown Item
	 */
	// :: defined globally :: define("UNKNOWN_ITEM","Unknown Item ");
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
 * string: Null argument 
 * @name NULL_ARGUMENT
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * string: Permission denied 
 * @name PERMISSION_DENIED
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * string: Object already added 
 * @name ALREADY_ADDED
 */
define("ALREADY_ADDED", "Object already added ");

/**
 * string: Configuration error 
 * @name CONFIGURATION_ERROR
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * string: Unknown Section 
 * @name UNKNOWN_SECTION
 */
define("UNKNOWN_SECTION", "Unknown Section ");

/**
 * string: Unknown Item 
 * @name UNKNOWN_ITEM
 */
define("UNKNOWN_ITEM", "Unknown Item ");

?>
