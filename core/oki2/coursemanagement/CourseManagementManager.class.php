<?php 

/**
* @package harmoni.osid_v2.coursemanagement
*
* @copyright Copyright &copy; 2006, Middlebury College
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
*
* @version $Id: CourseManagementManager.class.php,v 1.39 2006/07/20 19:37:56 sporktim Exp $
*/

require_once(OKI2."/osid/coursemanagement/CourseManagementManager.php");

require_once(HARMONI."oki2/coursemanagement/CanonicalCourse.class.php");
require_once(HARMONI."oki2/coursemanagement/CanonicalCourseIterator.class.php");
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
* @version $Id: CourseManagementManager.class.php,v 1.39 2006/07/20 19:37:56 sporktim Exp $
*/
class HarmoniCourseManagementManager
extends CourseManagementManager
{

	/**
	* @variable object OsidContext $_osidContext the OSID context.
	* @access private
	* @variable object Properties $_configuration the configuration for the CourseManagementManager.
	* @access private
	* @variable object Hierarchy $_hierarchy the hierarchy
	* @access private
	* @variable object Id $_canonicalCoursesId the hierarchy
	* @access private
	* @variable object Id $_courseGroupsId the hierarchy
	* @access private
	**/
	var $_osidContext;
	var $_configuration;
	var $_hierarchy;
	var $_canonicalCoursesId;
	var $_courseGroupsId;



	function HarmoniCourseManagementManager () {


	}



	/**
	* Assign the configuration of this Manager. Valid configuration options are as
	* follows:
	*	hierarchy_id				string
	*	root_id						string
	*	course_management_id		string
	*	canonical_courses_id		string
	*	course_groups_id			string
	*
	* @param object Properties $configuration (original type: java.util.Properties)
	*
	* @throws object OsidException An exception with one of the following
	*		   messages defined in org.osid.OsidException:	{@link
	*		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	*		   {@link org.osid.OsidException#PERMISSION_DENIED
	*		   PERMISSION_DENIED}, {@link
	*		   org.osid.OsidException#CONFIGURATION_ERROR
	*		   CONFIGURATION_ERROR}, {@link
	*		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	*		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	*
	* @access public
	*/
	function assignConfiguration ( &$configuration ) {
		$this->_configuration =& $configuration;

		$hierarchyId =& $configuration->getProperty('hierarchy_id');
		$rootId =& $configuration->getProperty('root_id');
		$courseManagementId =& $configuration->getProperty('course_management_id');
		$canonicalCoursesId =& $configuration->getProperty('canonical_courses_id');
		$courseGroupsId =& $configuration->getProperty('course_groups_id');


		// ** parameter validation
		ArgumentValidator::validate($hierarchyId, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($rootId, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($courseManagementId, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($canonicalCoursesId, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($courseGroupsId, StringValidatorRule::getRule(), true);
		// ** end of parameter validation



		//convert to ids
		$idManager =& Services::getService("Id");

		$hierarchyId =& $idManager->getId($hierarchyId);
		$rootId =& $idManager->getId($rootId);
		$courseManagementId =& $idManager->getId($courseManagementId);
		$canonicalCoursesId =& $idManager->getId($canonicalCoursesId);
		$courseGroupsId =& $idManager->getId($courseGroupsId);



		$hierarchyManager =& Services::getService("Hierarchy");
		$this->_hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);




		//initialize nodes
		$type =& new Type("CourseManagement","edu.middlebury","CourseManagement","These are top level nodes in the CourseManagement part of the Hierarchy");
		if(!$this->_hierarchy->nodeExists($courseManagementId)){
			$this->_hierarchy->createNode($courseManagementId,  $rootId, $type,"Course Management","This node is the ancestor of all information about course management in the hierarchy");
		}
		if(!$this->_hierarchy->nodeExists($canonicalCoursesId)){
			$this->_hierarchy->createNode($canonicalCoursesId,$courseManagementId,$type,"Canonical Courses","This node is the parent of all root level canonical courses");
		}
		if(!$this->_hierarchy->nodeExists($courseGroupsId)){
			$this->_hierarchy->createNode($courseGroupsId,$courseManagementId,$type,"Course Groups","This node is the parent of all course groups in the hierarchy");
		}


		$this->_canonicalCoursesId =& $canonicalCoursesId;
		$this->_courseGroupsId =& $courseGroupsId;

		//$this->_hierarchyId = $idManager->getId($hierarchyId);

		//$hierarchyManager =& Services::getService("Hierarchy");
		//$this->_hierarchy =& $hierarchyManager->getHierarchy($this->_hierarchyId);


	}

	/**
	* Return context of this OsidManager.
	*
	* @return object OsidContext
	*
	* @throws object OsidException
	*
	* @access public
	*/
	function &getOsidContext () {
		return $this->_osidContext;
	}

	/**
	* Assign the context of this OsidManager.
	*
	* @param object OsidContext $context
	*
	* @throws object OsidException An exception with one of the following
	*		   messages defined in org.osid.OsidException:	{@link
	*		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	*
	* @access public
	*/
	function assignOsidContext ( &$context ) {
		$this->_osidContext =& $context;
	}


	/**
	* Create a new CanonicalCourse.  The display name defaults to the title, but this can be changed later.
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
		//make id
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		//make node
		$type =& new Type("CourseManagement","edu.middlebury", "CanonicalCourse");
		$node =& $this->_hierarchy->createNode($id,$this->_canonicalCoursesId,$type,$title,$description);

		//prepare insert query
		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;
		$query->setTable('cm_can');

		//ready values
		$query->setColumns(array('id','number','credits','equivalent','fk_cm_can_type','title','fk_cm_can_stat_type'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes($number)."'";
		$values[]="'".addslashes($credits)."'";
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".$this->_typeToIndex('can',$courseType)."'";
		$values[]="'".addslashes($title)."'";
		$values[]="'".$this->_typeToIndex('can_stat',$courseStatusType)."'";
		$query->addRowOfValues($values);


		//query
		$dbManager->query($query);

		//make object
		$ret =& new HarmoniCanonicalCourse($id, $node);
		return $ret;

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
	function deleteCanonicalCourse ( &$canonicalCourseId ) { //fixthis ambiguous
	$node =& $this->_hierarchy->getNode($canonicalCourseId);
	$iterator =& $node->getChildren();
	if($iterator->hasNextNode()){
		print "<b>Warning!</b>  Can't delete CanonicalCourses without deleting the CourseOfferings and the CanonicalCourse children first.";
		return;
	}
	$this->_hierarchy->deleteNode($canonicalCourseId);


	$dbManager =& Services::getService("DatabaseManager");
	$query=& new DeleteQuery;
	$query->setTable('cm_can');
	$query->addWhere("id=".addslashes($canonicalCourseId->getIdString()));
	$dbManager->query($query);
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


		$dbManager =& Services::getService("DatabaseManager");
		$idManager =& Services::getService("Id");
		$query=& new SelectQuery;


		$query->addTable('cm_can');
		$query->addColumn('id');
		$res=& $dbManager->query($query);

		$canonicalCourseArray = array();

		while($res->hasMoreRows()){

			$row = $res->getCurrentRow();
			$res->advanceRow();
			$canonicalIdString = $row['id'];
			$canonicalId =& $idManager->getId($canonicalIdString);
			$canonicalCourseArray[] = $this->getCanonicalCourse($canonicalId);

		}
		$ret =& new HarmoniCanonicalCourseIterator($canonicalCourseArray);
		return $ret;

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
		$node =& $this->_hierarchy->getNode($canonicalCourseId);
		$ret =& new HarmoniCanonicalCourse($canonicalCourseId, $node);
		return $ret;

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
		//get the index for the type
		$typeIndex = $this->_typeToIndex('can',$courseType);

		//get all canonical courses with the appropriate type
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_can');
		$query->addColumn('id');
		$query->addWhere("fk_cm_can_type='".addslashes($typeIndex)."'");
		$res=& $dbManager->query($query);

		//convert results to array of Canonical Courses
		$canonicalCourseArrayByType = array();
		$idManager =& Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$canonicalCourseArrayByType[] =& $this->getCanonicalCourse($id);
		}

		//convert to an iterator
		$ret =& new  HarmoniCanonicalCourseIterator($canonicalCourseArrayByType);
		return $ret;
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


		$node =& $this->_hierarchy->getNode($courseOfferingId);
		$ret =& new HarmoniCourseOffering($courseOfferingId, $node);
		return $ret;





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

		$node =& $this->_hierarchy->getNode($courseSectionId);
		$ret =& new HarmoniCourseSection($courseSectionId, $node);
		return $ret;
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


		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addColumn('fk_cm_section');
		$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");


		$res=& $dbManager->query($query);
		$array=array();
		$idManager =& Services::getService('IdManager');
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$course = $this->getCourseSection($idManager->getId($row['id']));

			$array[]=$course;
			//}
		}
		$ret =& new CourseSectionIterator($array);
		return $ret;
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



		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addColumn('fk_cm_section');
		$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");


		$res=& $dbManager->query($query);
		$array=array();
		$idManager =& Services::getService('IdManager');
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$courseSection = $this->getCourseSection($idManager->getId($row['id']));
			$courseOffering = $courseSection->getCourseOffering();
			$courseOfferingId=$courseOffering->getId();
			foreach($array as $value){
				if($courseOfferingId->isEqualTo($value->getId())){
					continue 2;
				}
			}
			$array[] =& $node->getType();
		}
		$ret =& new CourseOfferingIterator($array);
		return $ret;




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

		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;

		$query->setTable('cm_term');

		$query->setColumns(array('id','name','fk_cm_term_type'));

		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="''";
		$values[]="'".$this->_typeToIndex('term',$termType)."'";


		$query->addRowOfValues($values);

		$dbManager->query($query);


		if(count($schedule)>0){
			//query to add schedule items
			$query=& new InsertQuery;
			$query->setTable('cm_schedule');
			$query->setColumns(array('fk_id','fk_sc_item'));
			$idString = "'".addslashes($id->getIdString())."'";


			//iterate through array
			foreach($schedule as $scheduleItem){
				$values = array();
				$values[]= $idString;
				$scheduleId =& $scheduleItem->getId();
				$values[]="'".addslashes($scheduleId->getIdString())."'";
				$query->addRowOfValues($values);

			}
			$dbManager->query($query);
		}
		$ret =& new HarmoniTerm($id);
		return $ret;
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


		$dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;
		$query->setTable('cm_term');
		$query->addWhere("id=".addslashes($termId->getIdString()));
		$dbManager->query($query);
		
		$query=& new DeleteQuery;
		$query->setTable('cm_schedule');
		$query->addWhere("fk_id=".addslashes($termId->getIdString()));
		$dbManager->query($query);

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
		$ret =& new HarmoniTerm($termId);
		return $ret;
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

		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_term');
		$query->addColumn('id');
		$res=& $dbManager->query($query);
		$array=array();
		$idManager =& Services::getService('IdManager');
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$array[]=$this->getTerm($idManager->getId($row['id']));
		}
		$ret =& new HarmoniTermIterator($array);
		return $ret;
	}

	/**
	* Get all the Terms that contain this date.
	*
	* The implementation is probably pretty slow.  If I was convinced it was more useful,
	* I might make it faster.
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
		$terms =&$this->getTerms();
		$array = array();
		//iterate through all terms
		while($terms->hasNextTerm()){
			$term=&$terms->nextTerm();
			$scheduleItems =& $term->getSchedule();

			//iterate through all ScheduleItems
			while($scheduleItems->hasNextScheduleItem()){
				$scheduleItem =& $scheduleItems->nextScheduleItem();
				$start = $scheduleItem->getStart();
				$end = $scheduleItem->getEnd();

				//if we found a ScheduleItem that overlaps, add it to the array
				if($date>=$start && $date<=$end){
					$array[] =& $term;
					break;
				}
			}

		}

		//make iterator
		$ret =& new HarmoniTermIterator($array);
		return $ret;
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

		return $this->_getTypes('can');

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

		return $this->_getTypes('can_stat');
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
		return $this->_getTypes('offer_stat');
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
		return $this->_getTypes('section_stat');
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
		return $this->_getTypes('offer');
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
		return $this->_getTypes('section');
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
		return $this->_getTypes('enroll_stat');
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
		return $this->_getTypes('grade');
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
		return $this->_getTypes('term');
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
		$idManager =& Services::getService("IdManager");



		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;

		$query->setTable('cm_grade_rec');

		$query->setColumns(array('fk_student_id','fk_cm_offer','name','grade','fk_cm_grade_type'));

		$values[]="'".addslashes($agentId->getIdString())."'";
		$values[]="'".addslashes($courseOfferingId->getIdString())."'";
		$values[]="'CourseGradeRecord'";
		$values[]="'".addslashes($courseGrade)."'";
		$values[]="'".$this->_typeToIndex('grade',$courseGradeType)."'";

		$query->addRowOfValues($values);
		$query->setAutoIncrementColumn('id','id_sequence');

		$result =&  $dbManager->query($query);
		$id = $result->getLastAutoIncrementValue();

		$ret =& new HarmoniCourseGradeRecord($idManager->getId($id));
		return $ret;
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


		$dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;


		$query->setTable('cm_grade_rec');

		$query->addWhere("id=".addslashes($courseGradeRecordId->getIdString()));
		$dbManager->query($query);
	}

	/**
	* Get all the CourseGradeRecords, optionally including only those for a
	* specific Student, CourseOffering, or CourseGradeType.  Put null if you don't wish to include these.
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


		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;




		$query->addTable('cm_grade_rec');
		$query->addColumn('id');

		if(!is_null($courseGradeType)){
			$courseGradeType=$this->_typeToIndex('can',$courseGradeType);
			$query->addWhere("fk_cm_grade_type='".addslashes($courseGradeType)."'");
		}
		if(!is_null($agentId)){
			$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");
		}
		if(!is_null($courseOfferingId)){

			$query->addWhere("fk_cm_offer='".addslashes($courseOfferingId->getIdString())."'");
		}




		$res =& $dbManager->query($query);

		$array = array();
		$idManager= & Services::getService("IdManager");

		while($res->hasMoreRows()){

			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$array[] =& new HarmoniCourseGradeRecord($id);

		}
		$ret =& new  HarmoniCourseGradeRecordIterator($array);
		return $ret;

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
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		$node =& $this->_hierarchy->createNode($id,$this->_courseGroupsId,$courseGroupType,"","A group for CanonicalCourses");



		$ret =& new HarmoniCourseGroup($node);
		return $ret;

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
		//we can't delete non-root nodes, so first break all the connections
		$node =& $this->_hierarchy->getNode($courseGroupId);
		$nodeIterator = $node->getChildren();		
		while($nodeIterator->hasNextNode()){
			$child =& $nodeIterator->nextNode();			
			$child->removeParent($courseGroupId);
		}
		
		//now we can delete the node
		$this->_hierarchy->deleteNode($courseGroupId);
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
		$node =& $this->_hierarchy->getNode($courseGroupId);
		$ret =& new HarmoniCourseGroup($node);
		return $ret;


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
		$parent =& $this->_hierarchy->getNode($this->_courseGroupsId);
		$nodeIterator =& $parent->getChildren();
		$arrayOfGroups = array();
		while($nodeIterator->hasNextNode()){
			$node =& $nodeIterator->nextNode();
			if($courseGroupType->isEqualTo($node->getType())){
				$arrayOfGroups[] =& $this->getCourseGroup($node->getId());
			}
		}
		$ret =& new HarmoniCourseGroupIterator($arrayOfGroups);
		return $ret;
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



		$childNode =& $this->_hierarchy->getNode($canonicalCourseId);
		$nodeIterator =& $childNode->getParents();
		$arrayOfGroups = array();
		while($nodeIterator->hasNextNode()){
			$parentNode=&$nodeIterator->nextNode();
			$grandparents = $parentNode->getParents();
			if(!$grandparents->hasNextNode()){
				print "<b>Warning!</b> The CanonicalCourse with id ".$canonicalCourseId." is a root node";
				continue;
			}
			$grandparentNode = $grandparents->nextNode();
			if($this->_courseGroupsId->isEqual($grandparentNode->getId())){
				$arrayOfGroups[] =& $this->getCourseGroup($parentNode->getId());
			}
		}
		$ret =& new HarmoniCourseGroupIterator($arrayOfGroups);
		return $ret;
	}

	/**
	* Get all the CourseGroupTypes supported by this implementation.  This can be innefficient if there
	* is a tremendous number of Types and course groups.
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


		$parent =& $this->_hierarchy->getNode($this->_courseGroupsId);
		$nodeIterator =& $parent->getChildren();
		$arrayOfTypes = array();
		while($nodeIterator->hasNextNode()){
			$node=&$nodeIterator->nextNode();
			foreach($arrayOfTypes as $value){
				if($value->isEqual($node->getType())){
					continue 2;
				}
			}
			$arrayOfTypes[] =& $node->getType();
		}
		$ret =& new HarmoniTypeIterator($arrayOfTypes);
		return $ret;
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
		return true;
	}







	/**
	* Get all the Types from the table specified
	*
	* @param string $typename the type of Types to get
	*
	* @return object HarmoniTypeIterator
	*
	* @access private
	*/
	function &_getTypes($typename){

		//query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_'.$typename."_type");
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);

		//iterate through results and add to an array
		$array=array();
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			if(is_null($row['description'])){
				$the_type =& new Type($row['domain'],$row['authority'],$row['keyword']);
			}else{
				$the_type =& new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
			}
			$array[] = $the_type;
		}

		//convert to an iterator
		$ret =& new HarmoniTypeIterator($array);
		return $ret;
	}

	/**
	* For object in table $table with id $id, get the Type with type $typename
	*
	* @param object Id $id the Id of the object in question
	* @param string $table the table our object resides in
	* @param string $typename the type of Type to get
	*
	* @return object Type
	*
	* @access private
	*/
	function &_getType(&$id, $table, $typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		//get the index for the type
		$index = $this->_getField($id,$table,"fk_cm_".$typename."_type");

		//query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_'.$typename."_type");
		$query->addWhere("id=".$index);
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);

		//There should be exactly one result.  Convert it to a type and return it
		//remember that the description is optional
		$row = $res->getCurrentRow();
		if(is_null($row['description'])){
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword']);
		}else{
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
		}
		return $the_type;

	}

	/**
	* Find the index for our Type of type $type in its table.  If it is not there,
	* put it into the table and return the index.
	*
	* @param string $typename the type of Type that is passed in.
	* @param object Type $type the Type itself
	*
	* @return object Type
	*
	* @access private
	*/
	function _typeToIndex($typename, &$type){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		//validate the Type
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"), true);

		//query to see if it exists
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_'.$typename."_type");
		$query->addWhere("domain='".$type->getDomain()."'");
		$query->addWhere("authority='".$type->getAuthority()."'");
		$query->addWhere("keyword='".$type->getKeyword()."'");
		$query->addColumn('id');
		$res=& $dbHandler->query($query);



		if($res->getNumberOfRows()==0){
			//if not query to create it
			$query=& new InsertQuery;
			$query->setTable('cm_'.$typename.'_type');
			$values[]="'".addslashes($type->getDomain())."'";
			$values[]="'".addslashes($type->getAuthority())."'";
			$values[]="'".addslashes($type->getKeyword())."'";
			if(is_null($type->getDescription())){
				$query->setColumns(array('domain','authority','keyword'));
			}else{
				$query->setColumns(array('domain','authority','keyword','description'));
				$values[]="'".addslashes($type->getDescription())."'";
			}

			$query->addRowOfValues($values);
			$query->setAutoIncrementColumn('id','id_sequence');


			$result =& $dbHandler->query($query);

			return $result->getLastAutoIncrementValue();
		}elseif($res->getNumberOfRows()==1){
			//if it does exist, create it
			$row = $res->getCurrentRow();
			$the_index = $row['id'];
			return $the_index;

		}else{
			//print a warning if there is more than one such type.  Should never happen.
			print "\n<b>Warning!<\b> The Type with domain ".$type->getDomain().", authority ".$type->getAuthority().", and keyword ".$type->getKeyword()." is not unique--there are ".$res->getNumberOfRows()." copies.\n";


			//return either one anyway.
			$row = $res->getCurrentRow();
			$the_index = $row['id'];
			return $the_index;

		}

	}

	/**
	* Given the object in table $table with id $id, change the field with name $key to $value
	*
	* @param object Id $id The Id of the object in question
	* @param string $table The table that our object resides in
	* @param string $key The name of the field
	* @param mixed $value The value to pass in
	*
	*
	* @access private
	*/
	function _setField(&$id, $table, $key, $value)
	{
		//just an update query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;
		$query->setTable($table);
		$query->addWhere("id='".addslashes($id->getIdString())."'");
		$query->setColumns(array(addslashes($key)));
		$query->setValues(array("'".addslashes($value)."'"));
		$dbHandler->query($query);


	}

	/**
	* Given the object in table $table with id $id, get the field with name $key
	*
	* @param object Id $id The Id of the object in question
	* @param string $table The table that our object resides in
	* @param string $key The name of the field
	*
	* @return string
	*
	* @access private
	*/
	function _getField(&$id, $table, $key)
	{
		$idString = $id->getIdString();
		
		//just a select query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable($table);
		$query->addWhere("id='".addslashes($idString)."'");
		$query->addColumn(addslashes($key));
		$res=& $dbHandler->query($query);
		$row = $res->getCurrentRow();
		$ret=$row[$key];
		return $ret;
	}

}

?>