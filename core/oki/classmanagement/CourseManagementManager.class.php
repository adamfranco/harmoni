<?

/**
 * A {@link HarmoniType} for DR Assets that will define CanonicalCourses.
 *
 * @package harmoni.osid_v1.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CourseManagementManager.class.php,v 1.6 2005/01/19 22:28:05 adamfranco Exp $
 */
class CanonicalCourseAssetType extends HarmoniType {

	function CanonicalCourseAssetType() {
		parent::HarmoniType("Harmoni","ClassManagement","CanonicalCourse");
	}
}


	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes. <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid_v1.coursemanagement
	 */
class HarmoniCourseManagementManager
//	extends OsidManager
{
	
	/**
	 * @variable object $_dr A reference to a {@link HarmoniDigitalRepository} object.
	 * @access private
	 **/
	var $_dr;
	
	/**
	 * @param ref object $drId A {@link HarmoniId} referencing our DR.
	 */
	function HarmoniCourseManagementManager ( &$drId ) {
		$manager =& Services::getService("DR");
		
		$this->_dr =& $manager->getDigitalRepository($drId);
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
	 * @package harmoni.osid_v1.coursemanagement
	 */
	function &createCanonicalCourse($title, $number, $description, & $courseType, & $courseStatusType, $credits) {
		$asset =& $this->_dr->createAsset($title . " " . $number, $description, new CanonicalCourseAssetType());
		
		// ----------------------------------------------------------------------------------------
		// -- This code is not implementing the DR directly. Instead, it is using the Asset's ID to
		// get the DataSetGroup associated with the Asset. If the Harmoni implementation changes,
		// then this will be using the DataManager disconnected from the DR.
		// ----------------------------------------------------------------------------------------
		
		$dataSetMgr =& Services::getService("DataSetManager");
		$assetId =& $asset->getId();
		$dataSetGroup =& $dataSetMgr->fetchDataSetGroup($assetId->getIdString());
		
		$dataSet =& $dataSetMgr->newDataSet(new CanonicalCourseDataSetType());
		
		$dataSet->setValue("title", new ShortStringDataType($title));
		$dataSet->setValue("number", new ShortStringDataType($number));
//		$dataSet->setValue("description", new StringDataType($description)); // this is stored in the asset.
		$dataSet->setValue("type", new OKITypeDataType($courseType));
		$dataSet->setValue("statusType", new OKITypeDataType($courseStatusType));
		$dataSet->setValue("credits", new FloatDataType($credits));
		
		$dataSetGroup->addDataSet($dataSet);
		$dataSetGroup->commit();
		
		return new HarmoniCanonicalCourse($this, $asset, $dataSet);
	}
	
	// :: full java declaration :: CanonicalCourse createCanonicalCourse
	/**
	 * Delete a CanonicalCourse.
	 * @param object canonicalCourseId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCanonicalCourse(& $canonicalCourseId) {
		$this->_dr->deleteAsset($canonicalCourseId);
	}
	// :: full java declaration :: void deleteCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses.
	 * @return object CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourses() {
		$assets =& $this->_dr->getAssetsByType( new CanonicalCourseAssetType() );
		$courses = array();
		
		$mgr =& Services::getService("DataManager");
		// in order to save time on fetching datasets, we're going to pre-load all of the datasets.
		$ids = array();
		foreach (array_keys($assets) as $key) {
			$id =& $assets[$key]->getId();
			$ids[] = $id->getIdString();
		}
		$dataSets =& $mgr->fetchArrayOfIDs($ids,true);
		
		foreach (array_keys($assets) as $key) {
			$id =& $assets[$key]->getId();
			$courses[] =& new HarmoniCanonicalCourse($this, $assets[$key], $dataSets[$id->getIdString()]);
		}
		
		return new HarmoniIterator($courses);
	}
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCourses()

	/**
	 * Get a CanonicalCourse by Id.
	 * @param object canonicalCourseId
	 * @return object CanonicalCourse
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCourse(& $canonicalCourseId) {
		$asset =& $this->_dr->getAsset($canonicalCourseId);
		
		$id =& $asset->getId();
		
		$mgr =& Services::getService("DataManager");
		
		$dataSet =& $mgr->fetchDataSet($id->getIdString(), true);
		
		return new HarmoniCanonicalCourse($this,$asset,$dataSet);
	}
	// :: full java declaration :: CanonicalCourse getCanonicalCourse(osid.shared.Id canonicalCourseId)

	/**
	 * Get all CanonicalCourses of the specified Type.
	 * @param object courseType
	 * @return object CanonicalCourseIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCanonicalCoursesByType(& $courseType) {
		// we'll have to search the dataManager and get all the datasets for which the type field = $courseType
		// then, find all the datasetgroups to which those datasets belong, and fetch those assets and create
		// canonical course objects for them.
		
		$mgr =& Services::getService("DataManager");
		$search =& new OnlyThisSearch(new FieldValueSearch(new CanonicalCourseDataSetType(), "type", new OKITypeDataType($courseType)));
		
		$ids =& $mgr->selectIDsBySearch($search);
		$dataSets =& $mgr->fetchArrayOfIDs($ids,true);
		
		// now, we find all the dataset groups in which these IDs appear
		$groups = array();
		$map = array();
		foreach ($ids as $id) {
			$tmp = $mgr->getGroupIdsForDataSet($id);
			$groups = array_merge($groups, $tmp);
			foreach ($tmp as $t) { $map[$t] = $id; }
		}
		
		$groups = array_unique($groups);
		
		$courses = array();
		foreach ($groups as $group) {
			$courses[] =& new HarmoniCanonicalCourse($this, $this->_dr->getAsset(new HarmoniId($group)),
				$dataSets[$map[$group]]);
		}
		
		return new HarmoniIterator($courses);
	}
	// :: full java declaration :: CanonicalCourseIterator getCanonicalCoursesByType(osid.shared.Type courseType)

	/**
	 * Get a CourseOffering by Unique Id.
	 * @param object courseOfferingId
	 * @return object CourseOffering
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseOffering(& $courseOfferingId) { /* :: interface :: */ }
	// :: full java declaration :: CourseOffering getCourseOffering(osid.shared.Id courseOfferingId)

	/**
	 * Get a CourseSection by Unique Id.
	 * @param object courseSectionId
	 * @return object CourseSection
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseSection(& $courseSectionId) { /* :: interface :: */ }
	// :: full java declaration :: CourseSection getCourseSection(osid.shared.Id courseSectionId)

	/**
	 * Get all the Sections in which the specified Agent is enrolled.
	 * @param object agentId
	 * @return object CourseSectionIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseSections(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: CourseSectionIterator getCourseSections(osid.shared.Id agentId)

	/**
	 * Get all the Offerings in which the specified Agent is enrolled.
	 * @param object agentId
	 * @return object CourseOfferingIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseOfferings(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: CourseOfferingIterator getCourseOfferings(osid.shared.Id agentId)

	/**
	 * Create a new Term with a specific type and Schedule.  Schedules are defined in the Scheduling SID.
	 * @param object termType
	 * @param object schedule
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createTerm(& $termType, & $schedule) { /* :: interface :: */ }
	// :: full java declaration :: Term createTerm(osid.shared.Type termType, osid.scheduling.ScheduleItem[] schedule)

	/**
	 * Delete a Term by Unique Id.
	 * @param object termId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteTerm(& $termId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteTerm(osid.shared.Id termId)

	/**
	 * Get a Term by Unique Id.
	 * @param object termId
	 * @return object Term
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getTerm(& $termId) { /* :: interface :: */ }
	// :: full java declaration :: Term getTerm(osid.shared.Id termId)

	/**
	 * Get all the Terms.
	 * @return object TermIterator Terms are returned in chronological order by increasing start date.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTerms() { /* :: interface :: */ }
	// :: full java declaration :: TermIterator getTerms()

	/**
	 * Get all the defined Course Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseTypes()

	/**
	 * Get all the defined Canonical Course Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseStatusTypes()

	/**
	 * Get all the defined Course Offering Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getOfferingStatusTypes()

	/**
	 * Get all the defined Course Section Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSectionStatusTypes()

	/**
	 * Get all the defined Offering Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getOfferingTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getOfferingTypes()

	/**
	 * Get all the defined Section Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getSectionTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSectionTypes()

	/**
	 * Get all the defined Enrollment Status Types.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getEnrollmentStatusTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getEnrollmentStatusTypes()

	/**
	 * Get all the defined Grade Types.  Grading is defined in the osid.grading OSID.  These Types are meaningful to the implementation and applications and is not specified by the OSID.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getGradeTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getGradeTypes()

	/**
	 * Get all the TermTypes.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getTermTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getTermTypes()

	/**
	 * Create a GradeRecord for the specified Agent (student), CourseOffering, GradeType, and Grade.  Note that the intent is that this is a summative grade.
	 * @param object agentId
	 * @param object courseOfferingId
	 * @param object gradeType
	 * @param object grade
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &createGradeRecord(& $agentId, & $courseOfferingId, & $gradeType, & $grade) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecord createGradeRecord(osid.shared.Id agentId,osid.shared.Id courseOfferingId,osid.shared.Type gradeType,java.io.Serializable grade)

	/**
	 * Delete the specified GradeRecord by Id.
	 * gradeRecordId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteGradeRecord(& $gradeRecordId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteGradeRecord(osid.shared.Id gradeRecordId)

	/**
	 * Get all the GradeRecords, optionally including only those for a specific Student, CourseOffering, or GradeType.
	 * @param object agentId
	 * @param object courseOfferingId
	 * @param object gradeType
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getGradeRecords(& $agentId, & $courseOfferingId, & $gradeType) { /* :: interface :: */ }
	// :: full java declaration :: GradeRecordIterator getGradeRecords(osid.shared.Id agentId,osid.shared.Id courseOfferingId,osid.shared.Type gradeType)

	/**
	 * Create a CourseGroup of a particular CourseGroupType.  CourseGroups can be used to model prerequisites, corequisites, majors, minors, sequences, etc.
	 * @param object courseGroupType
	 * @return object CourseGroup with its Unique Id set
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &createCourseGroup(& $courseGroupType) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroup createCourseGroup(osid.shared.Type courseGroupType)

	/**
	 * Delete a CourseGroup by Unique Id.
	 * @param object courseGroupId
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function deleteCourseGroup(& $courseGroupId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteCourseGroup(osid.shared.Id courseGroupId)

	/**
	 * Get a CourseGroup by Unique Id.
	 * @param object courseGroupId
	 * @return object CourseGroup
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseGroup(& $courseGroupId) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroup getCourseGroup(osid.shared.Id courseGroupId)

	/**
	 * Get all the CourseGroups of a given CourseGroupType.
	 * @param object courseGroupType
	 * @return object CourseGroupIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.classmanagement
	 */
	function &getCourseGroupsByType(& $courseGroupType) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroupIterator getCourseGroupsByType(osid.shared.Type courseGroupType)

	/**
	 * Get all the CourseGroups that contain the specified CanoncialCourse.
	 * @param object canonicalCourseId
	 * @return object CourseGroupIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}, {@link CourseManagementException#NULL_ARGUMENT NULL_ARGUMENT}, {@link CourseManagementException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.classmanagement
	 */
	function &getCourseGroups(& $canonicalCourseId) { /* :: interface :: */ }
	// :: full java declaration :: CourseGroupIterator getCourseGroups(osid.shared.Id canonicalCourseId)

	/**
	 * Get all the CourseGroupTypes supported by this implementation.
	 * @return object osid.shared.TypeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.coursemanagement.CourseManagementException An exception with one of the following messages defined in osid.coursemanagement.CourseManagementException:  {@link CourseManagementException#OPERATION_FAILED OPERATION_FAILED}, {@link CourseManagementException#PERMISSION_DENIED PERMISSION_DENIED}, {@link CourseManagementException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link CourseManagementException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.classmanagement
	 */
	function &getCourseGroupTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getCourseGroupTypes()
}
