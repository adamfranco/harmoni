<?

	/**
	 * CanonicalCourse is designed to capture general information about a course.  This is in contrast to the CourseOffering which is designed to capture information about a concrete offering of this course in a specific term and with identified people and roles.  The CourseSection is the third and most specific course-related object.  The section includes information about the location of the class as well as the roster of students.  CanonicalCourses can contain other CanonicalCourses and may be organized hierarchically, in schools, departments, for majors, and so on.  For each CanonicalCourse, there are zero or more offerings and for each offering, zero or more sections.  All three levels have separate data for Title, Number, Description, and Id.  This information can be the same or different as implementations choose and applications require. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.classmanagement
	 */
class HarmoniCanonicalCourse // :: API interface
//	extends java.io.Serializable
{
	
	var $_asset;
	var $_dataSet;
	var $_mgr;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 */
	function HarmoniCanonicalCourse(&$classMgr, &$asset, &$dataSet)
	{
		$this->_asset =& $asset;
		$this->_dataSet =& $dataSet;
		$this->_mgr =& $classMgr;
	}

	/**
	 * Get the title for this CanonicalCourse.
	 * @return object String the title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getTitle() {
		return $this->_dataSet->getStringValue("title");
	}

	/**
	 * Update the title for this CanonicalCourse.
	 * @param object title
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateTitle($title) {
		$this->_asset->updateDisplayName($title . " " . $this->_dataSet->getStringValue("number"));
		$this->_dataSet->setValue("title", new ShortStringDataType($title));
	}

	/**
	 * Get the number for this CanonicalCourse.
	 * @return object String the number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getNumber() {
		return $this->_dataSet->getStringValue("number");
	}

	/**
	 * Update the number for this CanonicalCourse.
	 * @param object number
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateNumber($number) {
		$this->_asset->updateDisplayName($this->_dataSet->getStringValue("title") . " " . $number);
		$this->_dataSet->setValue("number", new ShortStringDataType($number));
	}

	/**
	 * Get the description for this CanonicalCourse.
	 * @return string the name
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getDescription() {
		return $this->_asset->getDescription();
	}

	/**
	 * Update the description for this CanonicalCourse.
	 * @param string description
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateDescription($description) {
		$this->_asset->updateDescription($description);
	}

	/**
	 * Get the Unique Id for this CanonicalCourse.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getId() {
		return $this->_asset->getId();
	}

	/**
	 * Get the Course Type for this CanonicalCourse.  This Type is meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getCourseType() {
		$valObj =& $this->_dataSet->getValue("type");
		return $valObj->getTypeObject();
	}

	/**
	 * Create a new CanonicalCourse.
	 * @param object title
	 * @param object number
	 * @param string description
	 * @param object courseType
	 * @param object courseStatusType
	 * @param object credits
	 * @return object CanonicalCourse with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function & createCanonicalCourse($title, $number, $description, & $courseType, & $courseStatusType, $credits) {
		$newCourse =& $this->_mgr->createCanonicalCourse($title, $number, $description, $courseType, $courseStatusType, $credits);
		$this->_asset->addAsset($newCourse->_asset);
	}
	// :: full java declaration :: CanonicalCourse createCanonicalCourse
	/**
	 * Delete a CanonicalCourse.
	 * @param object canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCanonicalCourse(& $canonicalCourseId) {
		$DR =& Services::getService("DR");
		$DR->deleteAsset($canonicalCourseId);
	}
	// :: full java declaration :: void deleteCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses.
	 * @return object CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getCanonicalCourses() {
		// wait for Asset::getAssetsByType() function
		// @todo
	}
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCourses()

	/**
	 * Get all CanonicalCourses of the specified Type.
	 * @param object courseType
	 * @return object CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function & getCanonicalCoursesByType(& $courseType) {
		
	}
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCoursesByType(osid.shared.Type courseType)

	/**
	 * Create a new CourseOffering.
	 * @param object title
	 * @param object number
	 * @param string description
	 * @param object termId
	 * @param object offeringType
	 * @param object offeringStatusType
	 * @param object gradeType
	 * @return object CourseOffering with its name, description, and Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function & createCourseOffering($title, $number, $description, & $termId, & $offeringType, & $offeringStatusType, & $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering createCourseOffering
	/**
	 * Delete a CourseOffering.
	 * @param object courseOfferingId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseOffering(& $courseOfferingId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseOffering(osid.shared.Id courseOfferingId)

	/**
	 * Get all CourseOfferingsc.
	 * @return object CourseOfferingIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getCourseOfferings() { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferings()

	/**
	 * Get all CourseOfferings of the specified Type.
	 * @param object offeringType
	 * @return object CourseOfferingIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function & getCourseOfferingsByType(& $offeringType) { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferingsByType(osid.shared.Type offeringType)

	/**
	 * Add an equivalent course which are for mapping courses across departments, schools, or institutions as well as for providing new courses that map to previous ones.  This can be used for cross-listening.  Note that if course A is equivalent to course B it does not necessarily follow that course B is equivalent to course A.  Course A could cover a superset of the mateiral in course B.
	 * @param object canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addEquivalentCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void addEquivalentCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Remove a equivalent courses for this CanonicalCourse.
	 * @param object canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function removeEquivalentCourse(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: void removeEquivalentCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all equivalent courses for this CanonicalCourse.
	 * @return object CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getEquivalentCourses() { /* :: interface :: */ }
	// :: full java declaration :: CanonicalCourseIterator getEquivalentCourses()

	/**
	 * Add a Topic for this CanonicalCourse.
	 * @param object topic
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#ALREADY_ADDED ALREADY_ADDED}
	 * @package osid.classmanagement
	 */
	function addTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: void addTopic(String topic)

	/**
	 * Remove a Topic for this CanonicalCourse.
	 * @param object topic
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function removeTopic($topic) { /* :: interface :: */ }
	// :: full java declaration :: void removeTopic(String topic)

	/**
	 * Get all Topics for this CanonicalCourse.
	 * @return object osid.shared.StringIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getTopics() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getTopics()

	/**
	 * Get the credits for this CanonicalCourse.
	 * @return object float credits
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function getCredits() { /* :: interface :: */ }

	/**
	 * Update the credits for this CanonicalCourse.
	 * @param object credits
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.classmanagement
	 */
	function updateCredits($Credits) { /* :: interface :: */ }

	/**
	 * Get the Status for this CanonicalCourse.
	 * @return object osid.shared.Type
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function & getStatus() { /* :: interface :: */ }

	/**
	 * Update the Status for this CanonicalCourse.
	 * @param object statusType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function updateStatus(& $statusType) { /* :: interface :: */ }
	// :: full java declaration :: void updateStatus(osid.shared.Type statusType)
}

?>