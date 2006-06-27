<?php

require_once(OKI2."/osid/coursemanagement/CanonicalCourse.php");

/**
 * CanonicalCourse contains general information about a course.	 This is in
 * contrast to the CourseOffering which contains information about a concrete
 * offering of this course in a specific term and with identified people and
 * roles.  The CourseSection is the third and most specific course-related
 * object.	The section includes information about the location of the class
 * as well as the roster of students.  CanonicalCourses can contain other
 * CanonicalCourses and may be organized hierarchically, in schools,
 * departments, for majors, and so on.	For each CanonicalCourse, there are
 * zero or more offerings and for each offering, zero or more sections.	 All
 * three levels have separate data for Title, Number, Description, and Id.
 * This information can be the same or different as implementations choose and
 * applications require.
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
 * @version $Id: CanonicalCourse.class.php,v 1.8 2006/06/27 21:07:13 sporktim Exp $
 */
class HarmoniCanonicalCourse
	extends CanonicalCourse
{
	
	//var $_asset;
	//var $_dataSet;
	//var $_mgr;
	/**
	 * @variable object $_node the node in the hierarchy.
	 * @access private
	 * @variable object $_id the unique id for the canonical course.
	 * @access private
	 * @variable object $_id the unique id for the canonical course.
	 * @access private
	 **/
	var $_node;
	var $_id;
	var $_table;
	
	/*
	 * The constructor.
	 * @access public
	 * @return void
	
	function HarmoniCanonicalCourse(&$classMgr, &$asset, &$dataSet)
	{
		$this->_asset =& $asset;
		$this->_dataSet =& $dataSet;
		$this->_mgr =& $classMgr;
	}
	*/
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 */
	function HarmoniCanonicalCourse($id, $node)
	{
		$this->_id = $id;
		$this->_node = $node;
		$this->_table = 'cm_can';
		
	}
	

	/**
	 * Get the title for this CanonicalCourse.
	 *	
	 * @return string
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
	function getTitle () { 
		//return $this->_dataSet->getStringValue("title");
		//return $this->_node->getDisplayName();
		
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		
		
		$query->addTable('cm_can_course');
		
		$query->addWhere("`id`=".addslashes($this->_id));		
		
		
		$query->addColumn('title');	
		
			
		$res=& $dbHandler->query($query);
		
		$row =& $res->getCurrentRow();
	
		$number=$row['title'];
		
		return $number;
	}

	/**
	 * Update the title for this CanonicalCourse.
	 * 
	 * @param string $title
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateTitle ( $title ) { 
		//$this->_node->updateDisplayName($title);
			$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;		
		$query->setTable('cm_can_course');
		
		
		$query->addWhere("`id`=".addslashes($this->_id));	
			
		$query->setColumns(array('title'));
		$query->setValues(array(addslashes($title)));
		
		
		
		$dbHandler->query($query);
		
	}

	/**
	 * Get the number for this CanonicalCourse.
	 *	
	 * @return string
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
	function getNumber () {
		
		
		
		
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		
		
		$query->addTable('cm_can_course');
		
		$query->addWhere("`id`=".addslashes($this->_id));		
		
		
		$query->addColumn('number');	
		
			
		$res=& $dbHandler->query($query);
		
		$row =& $res->getCurrentRow();
	
		$number=$row['number'];
		
		return $number;
		
		//return $this->_dataSet->getStringValue("number");
	}

	/**
	 * Update the number for this CanonicalCourse.
	 * 
	 * @param string $number
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateNumber ( $number ) { 
		//$this->_asset->updateDisplayName($this->_dataSet->getStringValue("title") . " " . $number);
		//$this->_dataSet->setValue("number", new ShortStringDataType($number));
		
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;		
		$query->setTable('cm_can_course');
		
		
		$query->addWhere("`id`=".addslashes($this->_id));	
			
		$query->setColumns(array('number'));
		$query->setValues(array(addslashes($number)));
		
		
		
		$dbHandler->query($query);
		
	
	
		
		
	}

	/**
	 * Get the description for this CanonicalCourse.  Returns null if no description exists
	 *	
	 * @return string
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
	function getDescription () { 
		return $this->_node->getDescription();
	}

	/**
	 * Update the description for this CanonicalCourse.
	 * 
	 * @param string $description
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		$this->_node->updateDescription($description);
	}
	
	/**
	 * Get the display name for this CanonicalCourse.
	 *	
	 * @return string
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
	function getDisplayName () { 
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
		$this->_node->getDisplayName();
	} 
	
	/**
	 * Update the display name for this CanonicalCourse.
	 * 
	 * @param string $displayName
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
		$this->_node->updateDisplayName($displayName);
	} 

	/**
	 * Get the unique Id for this CanonicalCourse.
	 *	
	 * @return object Id
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
	 
	 
	function &getId () { 
		return $this->_node->getId();
	}

	/**
	 * Get the Course Type for this CanonicalCourse.  This Type is meaningful
	 * to the implementation and applications and are not specified by the
	 * OSID.
	 *	
	 * @return object Type
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
	function &getCourseType () { 
		return $this->_getType('can');
		//$valObj =& $this->_dataSet->getValue("type");
		//return $valObj->getTypeObject();
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
	
		
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();


		$type = new Type("CourseManagement","edu.middlebury", "CanonicalCourse");
		$node=$this->_hierarchy->createNode($id,$this->_id,$type,$title,$description);

		$dbManager=& Services::getService("DBHandler");
		$query=& new InsertQuery;

		$query->setTable('cm_can');

		$query->setColumns(array('id','number','credits','equivalent','fk_cm_can_type','title','fk_cm_can_stat_type'));

		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes($number)."'";
		$values[]="'".addslashes($credits)."'";
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".$this->_typeToIndex('can',$courseType)."'";
		$values[]="'".addslashes($title)."'";
		$values[]="'".$this->_typeToIndex('can_stat',$courseStatusType)."'";
		$query->addRowOfValues($values);



		$dbManager->query($query);

		$ret =& new HarmoniCanonicalCourse($id, $node);
		return $ret;
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
		$cm = Services::getService("CourseManagement");
		return $cm->getCanonicalCourses ();
		
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
		$cm = Services::getService("CourseManagement");
		return $cm->getCanonicalCoursesByType ($courseType);
	} 

	/**
	 * Create a new CourseOffering.
	 * 
	 * @param string $title
	 * @param string $number
	 * @param string $description
	 * @param object Id $termId
	 * @param object Type $offeringType
	 * @param object Type $offeringStatusType
	 * @param object Type $courseGradeType
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
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createCourseOffering ( $title, $number, $description, &$termId, &$offeringType, &$offeringStatusType, &$courseGradeType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 
	
	/**
	 * Delete a CourseOffering.
	 * 
	 * @param object Id $courseOfferingId
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
	function deleteCourseOffering ( &$courseOfferingId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get all CourseOfferings.
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseOfferings () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get all CourseOfferings of the specified Type.
	 * 
	 * @param object Type $offeringType
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
	 *		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getCourseOfferingsByType ( &$offeringType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Add an equivalent course which are for mapping courses across
	 * departments, schools, or institutions as well as for providing new
	 * courses that map to previous ones.  This can be used for
	 * cross-listening.	 Note that if course A is equivalent to course B it
	 * does not necessarily follow that course B is equivalent to course A.
	 * Course A could cover a superset of the mateiral in course B.
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
	 *		   org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
	 *		   ALREADY_ADDED}
	 * 
	 * @access public
	 */
	function addEquivalentCourse ( &$canonicalCourseId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Remove a equivalent courses for this CanonicalCourse.
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
	function removeEquivalentCourse ( &$canonicalCourseId ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get all equivalent courses for this CanonicalCourse.
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
	function &getEquivalentCourses () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Add a Topic for this CanonicalCourse.
	 * 
	 * @param string $topic
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
	 *		   org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
	 *		   ALREADY_ADDED}
	 * 
	 * @access public
	 */
	function addTopic ( $topic ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Remove a Topic for this CanonicalCourse.
	 * 
	 * @param string $topic
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function removeTopic ( $topic ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get all Topics for this CanonicalCourse.
	 *	
	 * @return object StringIterator
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
	function &getTopics () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get the credits for this CanonicalCourse.
	 *	
	 * @return float
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
	function getCredits () { 
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
		$this->_getField('credits');
	} 

	/**
	 * Update the credits for this CanonicalCourse.
	 * 
	 * @param float $credits
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateCredits ( $credits ) { 
		$this->_setField('credits',$credits);
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get the Status for this CanonicalCourse.
	 *	
	 * @return object Type
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
	function &getStatus () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Update the Status for this CanonicalCourse.
	 * 
	 * @param object Type $statusType
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
	function updateStatus ( &$statusType ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 
	
	/**
	 * Get all the Property Types for  CanonicalCourse.
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
	function &getPropertyTypes () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 

	/**
	 * Get the Properties associated with this CanonicalCourse.
	 *	
	 * @return object PropertiesIterator
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
	function &getProperties () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CanonicalCourse", true)); 
	} 
	
	
	
	/*
	function _setField($key, $value)
	{
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;		
		$query->setTable(addslashes($_table));
		
		
		$query->addWhere("`id`=".addslashes($this->_id));	
			
		$query->setColumns(array(addslashes($key)));
		$query->setValues(array(addslashes($number)));

		$dbHandler->query($query);
		
		
	}
	
	function _getField($key)
	{
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;			
		$query->setTable('cm_can_course');		
		$query->addWhere("`id`=".addslashes($this->_id));						
		$query->addColumn(addslashes($key));						
		$res=& $dbHandler->query($query);		
		$row =& $res->getCurrentRow();	
		$ret=$row[$key];		
		return $ret;
	}
	
function _getType($typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below
		$index=getField("fk_cm_".$typename."_type");
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;			
		$query->setTable('cm_'.$typename."_type");		
		$query->addWhere("`id`=".$index);						
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');						
		$res=& $dbHandler->query($query);		
		$row =& $res->getCurrentRow();	
		if(is_null($row['description'])){
			$the_type = new Type($row['domain'],$row['authority'],$row['keyword']);
		}else{
			$the_type = new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
		}	
		return $the_type;
		
	}
	
	
	
	function _typeToIndex($typename, &$type){
		//the appropriate table names and fields must be given names according to the pattern indicated below
		//$index=getField("fk_cm_".$name."_type");
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;			
		$query->setTable('cm_'.$name."_type");		
		//$query->addWhere("`id`=".$index);
		$query->addWhere("`domain`='".$type->getDomain()."'");	
		$query->addWhere("`authority`='".$type->getAuthority()."'");	
		$query->addWhere("`keyword`='".$type->getKeyword()."'");							
		//$query->addColumn('domain');
		//$query->addColumn('authority');
		//$query->addColumn('keyword');
		$query->addColumn('id');						
		$res=& $dbHandler->query($query);
		if($res->getNumberOfRows()==0){
			$query=& new InsertQuery;
				$query->setTable('cm_'.$name."_type");	
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
			
			
			$dbHandler->query($query);
			
		$query=& new SelectQuery;			
		$query->setTable('cm_'.$name."_type");		
		//$query->addWhere("`id`=".$index);
		$query->addWhere("`domain`='".$type->getDomain()."'");	
		$query->addWhere("`authority`='".$type->getAuthority()."'");	
		$query->addWhere("`keyword`='".$type->getKeyword()."'");							
		$query->addColumn('id');						
		$res=& $dbHandler->query($query);							
		//$row =& $res->getCurrentRow();	
		//$the_index=$row['id'];
		
		
		}elseif($res->getNumberOfRows()>1){
				print "\n<b>Warning!<\b> The Type with domain ".$type->getDomain().", authority ".$type->getAuthority().", and keyword ".$type->getKeyword()." is not unique--there are ".$res->getNumberOfRows()."copies.\n";
			
			
		}
			
		
		//if(is_null($row['description'])){
		//	$the_type = new Type($row['domain'],$row['authority'],$row['keyword']);
		//}else{
		//	$the_type = new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
		//}	
		//return $the_type;
		
		$row =& $res->getCurrentRow();	
			$the_index=$row['id'];
		return $the_index;
		
	}
	*/
	
	
	function _typeToIndex($typename, &$type)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_typeToIndex($typename, $type);
	}
	
	function &_getTypes($typename)
	{	
		$cm=Services::getService("CourseManagement");
		return $cm->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_getType($typename);
	}
	
	
	function &_getType($typename){
		$cm=Services::getService("CourseManagement");
		return $cm->_getType($typename);
	}
	
	function _setField($key, $value)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_setField($key, $value);		
	}
	
	
	
	
	
	
}

?>