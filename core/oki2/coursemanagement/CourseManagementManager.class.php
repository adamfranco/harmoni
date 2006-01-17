<?php 

require_once(OKI2."/osid/coursemanagement/CourseManagementManager.php");

require_once(HARMONI."oki2/coursemanagement/CanonicalCourse.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseGradeRecord.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseGradeRecordIterator.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseGroup.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseGroupIterator.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseOffering.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseOfferingIterator.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseSection.class.php");
require_once(HARMONI."oki2/coursemanagement/CourseSectionIterator.class.php");
require_once(HARMONI."oki2/coursemanagement/EnrollmentRecord.class.php");
require_once(HARMONI."oki2/coursemanagement/EnrollmentRecordIterator.class.php");
require_once(HARMONI."oki2/coursemanagement/Term.class.php");
require_once(HARMONI."oki2/coursemanagement/TermIterator.class.php");

/**
 * <p>
 * CourseManagementManager handles creating and deleting
 * 
 * <ul>
 * <li>
 * CanonicalCourse,
 * </li>
 * <li>
 * CourseGradeRecord,
 * </li>
 * <li>
 * CourseGroup,
 * </li>
 * <li>
 * Term;
 * </li>
 * </ul>
 * 
 * and gets:
 * 
 * <ul>
 * <li>
 * CanonicalCourse,
 * </li>
 * <li>
 * CourseGradeRecord,
 * </li>
 * <li>
 * CourseGroup,
 * </li>
 * <li>
 * CourseOffering,
 * </li>
 * <li>
 * CourseSection,
 * </li>
 * <li>
 * Term,
 * </li>
 * <li>
 * various implementation Types.
 * </li>
 * </ul>
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
 * @package harmoni.osid_v2.coursemanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CourseManagementManager.class.php,v 1.5 2006/01/17 20:06:22 adamfranco Exp $
 */
class HarmoniCourseManagementManager
	extends CourseManagementManager
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
	 * 
	 * @param string $title
	 * @param string $number
	 * @param string $description
	 * @param object Type $courseType
	 * @param object Type $courseStatusType
	 * @param float $credits
	 *	
	 * @return object CanonicalCourse
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createCanonicalCourse ( $title, $number, $description, &$courseType, &$courseStatusType, $credits ) { 
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
		
		$obj =& new HarmoniCanonicalCourse($this, $asset, $dataSet);
		
		return $obj;
	}
	
	/**
	 * Delete a CanonicalCourse.
	 * 
	 * @param object Id $canonicalCourseId
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteCanonicalCourse ( &$canonicalCourseId ) { 
		$this->_dr->deleteAsset($canonicalCourseId);
	}

	/**
	 * Get all CanonicalCourses.
	 *	
	 * @return object CanonicalCourseIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCanonicalCourses () { 
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
		
		$obj =& new HarmoniIterator($courses);
		
		return $obj;
	}

	/**
	 * Get a CanonicalCourse by Id.
	 * 
	 * @param object Id $canonicalCourseId
	 *	
	 * @return object CanonicalCourse
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCanonicalCourse ( &$canonicalCourseId ) { 
		$asset =& $this->_dr->getAsset($canonicalCourseId);
		
		$id =& $asset->getId();
		
		$mgr =& Services::getService("DataManager");
		
		$dataSet =& $mgr->fetchDataSet($id->getIdString(), true);
		
		$obj =& new HarmoniCanonicalCourse($this,$asset,$dataSet);
		
		return $obj;
	}

	/**
	 * Get all CanonicalCourses of the specified Type.
	 * 
	 * @param object Type $courseType
	 *	
	 * @return object CanonicalCourseIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getCanonicalCoursesByType ( &$courseType ) { 
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
		
		$obj =& new HarmoniIterator($courses);
		
		return $obj;
	}

	/**
	 * Get a CourseOffering by unique Id.
	 * 
	 * @param object Id $courseOfferingId
	 *	
	 * @return object CourseOffering
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseOffering ( &$courseOfferingId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true));
	} 

	/**
	 * Get a CourseSection by unique Id.
	 * 
	 * @param object Id $courseSectionId
	 *	
	 * @return object CourseSection
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseSection ( &$courseSectionId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true));
	} 

	/**
	 * Get all the Sections in which the specified Agent is enrolled.
	 * 
	 * @param object Id $agentId
	 *	
	 * @return object CourseSectionIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseSections ( &$agentId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the Offerings in which the specified Agent is enrolled.
	 * 
	 * @param object Id $agentId
	 *	
	 * @return object CourseOfferingIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseOfferings ( &$agentId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Create a new Term with a specific type and Schedule.	 Schedules are
	 * defined in the scheduling OSID.
	 * 
	 * @param object Type $termType
	 * @param object ScheduleItem[] $schedule
	 *	
	 * @return object Term
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createTerm ( &$termType, &$schedule ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Delete a Term by unique Id.
	 * 
	 * @param object Id $termId
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteTerm ( &$termId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get a Term by unique Id.
	 * 
	 * @param object Id $termId
	 *	
	 * @return object Term
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getTerm ( &$termId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the Terms.
	 *	
	 * @return object TermIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getTerms () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the Terms that contain this date.
	 * 
	 * @param int $date
	 *	
	 * @return object TermIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getTermsByDate ( $date ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Course Types.  These Types are meaningful to the
	 * implementation and applications and are not specified by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Canonical Course Status Types.  These Types are
	 * meaningful to the implementation and applications and are not specified
	 * by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseStatusTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Course Offering Status Types.  These Types are
	 * meaningful to the implementation and applications and are not specified
	 * by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getOfferingStatusTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Course Section Status Types.	 These Types are
	 * meaningful to the implementation and applications and are not specified
	 * by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getSectionStatusTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Offering Types.	These Types are meaningful to the
	 * implementation and applications and are not specified by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getOfferingTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Section Types.  These Types are meaningful to the
	 * implementation and applications and are not specified by the OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getSectionTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined Enrollment Status Types.	 These Types are meaningful
	 * to the implementation and applications and are not specified by the
	 * OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getEnrollmentStatusTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the defined CourseGrade Types.  GradeTypes are defined in the
	 * grading OSID.  These Types are meaningful to the implementation and
	 * applications and are not specified by the grading OSID.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseGradeTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the TermTypes.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getTermTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Create a CourseGradeRecord for the specified Agent (student),
	 * CourseOffering, CourseGradeType, and CourseGrade.  Note that the intent
	 * is that this is a summative grade.
	 * 
	 * @param object Id $agentId
	 * @param object Id $courseOfferingId
	 * @param object Type $courseGradeType
	 * @param object mixed $courseGrade (original type: java.io.Serializable)
	 *	
	 * @return object CourseGradeRecord
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &createCourseGradeRecord ( &$agentId, &$courseOfferingId, &$courseGradeType, &$courseGrade ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Delete the specified CourseGradeRecord by Id. courseGradeRecordId
	 * 
	 * @param object Id $courseGradeRecordId
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteCourseGradeRecord ( &$courseGradeRecordId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the CourseGradeRecords, optionally including only those for a
	 * specific Student, CourseOffering, or CourseGradeType.
	 * 
	 * @param object Id $agentId
	 * @param object Id $courseOfferingId
	 * @param object Type $courseGradeType
	 *	
	 * @return object CourseGradeRecordIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseGradeRecords ( &$agentId, &$courseOfferingId, &$courseGradeType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Create a CourseGroup of a particular CourseGroupType.  CourseGroups can
	 * be used to model prerequisites, corequisites, majors, minors,
	 * sequences, etc.
	 * 
	 * @param object Type $courseGroupType
	 *	
	 * @return object CourseGroup
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createCourseGroup ( &$courseGroupType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Delete a CourseGroup by unique Id.
	 * 
	 * @param object Id $courseGroupId
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteCourseGroup ( &$courseGroupId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get a CourseGroup by unique Id.
	 * 
	 * @param object Id $courseGroupId
	 *	
	 * @return object CourseGroup
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseGroup ( &$courseGroupId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the CourseGroups of a given CourseGroupType.
	 * 
	 * @param object Type $courseGroupType
	 *	
	 * @return object CourseGroupIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getCourseGroupsByType ( &$courseGroupType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the CourseGroups that contain the specified CanoncialCourse.
	 * 
	 * @param object Id $canonicalCourseId
	 *	
	 * @return object CourseGroupIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getCourseGroups ( &$canonicalCourseId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * Get all the CourseGroupTypes supported by this implementation.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseGroupTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 

	/**
	 * This method indicates whether this implementation supports
	 * CourseManagementManager methods: createCanonicalCourse,
	 * createCourseGradeRecord, createCourseGroup, createTerm,
	 * deleteCanonicalCourse, deleteCourseGradeRecord, deleteCourseGroup,
	 * deleteTerm. CanonicalCourse methods: addEquivalentCourse, addTopic,
	 * createCanonicalCourse, createCourseOffering, deleteCourseOffering.
	 * CourseGroup methods: addCourse, removeCourse, updateDisplayName.
	 * CourseOffering methods: addAsset, addStudent, createCourseSection,
	 * deleteCourseSection, removeAsset, removeStudent, updateCourseGradeType,
	 * updateDescription, updateDisplayName, updateStatus, updateTitle.
	 * CourseSection methods: addAsset, addStudent, changeStudent.
	 *	
	 * @return boolean
	 * 
	 * @throws object CourseManagementException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.coursemanagement.CourseManagementException may be
	 *		   thrown:	{@link
	 *		   org.osid.coursemanagement.CourseManagementException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.coursemanagement.CourseManagementException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function supportsUpdate () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseManagementManager", true)); 
	} 
}

?>