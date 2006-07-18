<?php

require_once(OKI2."/osid/coursemanagement/CanonicalCourse.php");
require_once(HARMONI."oki2/coursemanagement/CanonicalCourseIterator.class.php");
require_once(HARMONI."oki2/shared/HarmoniStringIterator.class.php");


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
 * @version $Id: CanonicalCourse.class.php,v 1.25 2006/07/18 21:37:26 sporktim Exp $
 */
class HarmoniCanonicalCourse
	extends CanonicalCourse
{
	
	
	/**
	 * @variable object $_node the node in the hierarchy.
	 * @access private
	 * @variable object $_id the unique id for the canonical course.
	 * @access private
	 * @variable object $_table the canonical course table.
	 * @access private
     * @variable object Id $_canonicalCoursesId the hierarchy
	 * @access private
	 **/
	var $_node;
	var $_id;
	var $_table;
	var $_hierarchy;
	
	
	
	
	/**
	 * The constructor.
	 * 
	 * @param object Id $id
	 * @param object Node $node
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniCanonicalCourse(&$id, &$node)
	{
		$this->_id =& $id;
		$this->_node =& $node;
		$this->_table = 'cm_can';
		$cm =& Services::getService("CourseManagement");
		$this->_hierarchy =& $cm->_hierarchy;
		
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
	
		
			return $this->_getField('title');
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

		$this->_setField('title',$title);
		
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
		
		
		
		
		return $this->_getField('number');
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
	
		
	$this->_setField('number',$number);
	
		
		
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
		return $this->_node->getDisplayName();
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
		return $this->_id;
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
	
		
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();


		$type =& new Type("CourseManagement","edu.middlebury", "CanonicalCourse");
		$node=&$this->_hierarchy->createNode($id,$this->_id,$type,$title,$description);

		$dbManager=& Services::getService("DatabaseManager");
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
	 * Create a new CourseOffering.  The default display name is the title of the course.
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
		
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();


		$type =& new Type("CourseManagement","edu.middlebury", "CourseOffering");
		$node=&$this->_hierarchy->createNode($id,$this->_id,$type,$title,$description);

		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;

		$query->setTable('cm_offer');

		$query->setColumns(array('id','fk_cm_grade_type','fk_cm_term',
								'fk_cm_offer_stat_type','fk_cm_offer_type','title','number'));

		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".$this->_typeToIndex('grade',$courseGradeType)."'";
		$values[]="'".addslashes($termId->getIdString())."'";
		$values[]="'".$this->_typeToIndex('offer_stat',$offeringStatusType)."'";
		$values[]="'".$this->_typeToIndex('offer',$offeringType)."'";
		$values[]="'".addslashes($title)."'";
		$values[]="'".addslashes($number)."'";
		
		$query->addRowOfValues($values);

		$dbManager->query($query);

		$ret =& new HarmoniCourseOffering($id, $node);
		return $ret;

		
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
	  
	  $node =& $this->_hierarchy->getNode($courseOfferingId);

	$iterator =& $node->getChildren();
	
	if($iterator->hasNextNode()){
	  print "<b>Warning!</b> Can't delete CourseOfferings without deleting their CourseSections";
	  return;
	}
	  
	  
		$this->_hierarchy->deleteNode($courseOfferingId);



		$dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;


		$query->setTable('cm_can');

		$query->addWhere("id=".addslashes($courseOfferingId->getIdString()));
		$dbManager->query($query);
	} 

	/**
	 * Get all CourseOfferings that belong to this CanonicalCourse.
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
		

		
		$nodeIterator =& $this->_node->getChildren();
		
		$array = array();
		$idManager= & Services::getService("IdManager");
		$cm= & Services::getService("CourseManagement");
		//$typeIndex=$cm->_typeToIndex('offer',$sectionType);
		
		while($nodeIterator->hasNextNode()){
			$childNode =& $nodeIterator->nextNode();
			$nodeType =& $childNode->getType();
			if($nodeType->getKeyWord()!="CourseOffering"){
				continue;	
			}	
			$courseOffering = $cm->getCourseOffering($childNode->getId());			
			$array[] =& $courseOffering;
		}
		$ret =& new  HarmoniCourseOfferingIterator($array);
		return $ret;
	} 

	/**
	 * Get all CourseOfferings of the specified Type that belong to this CanonicalCourse.
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
	
		$nodeIterator =& $this->_node->getChildren();
		
		$array = array();
		$idManager= & Services::getService("IdManager");
		$cm= & Services::getService("CourseManagement");
		$typeIndex=$cm->_typeToIndex('offer',$offeringType);
		
		while($nodeIterator->hasNextNode()){
			$childNode =& $nodeIterator->nextNode();
			$nodeType =& $childNode->getType();
			if($nodeType->getKeyWord()!="CourseOffering"){
				continue;	
			}	
			$courseOffering = $cm->getCourseOffering($childNode->getId());
			if($typeIndex == $courseOffering->_getField('fk_cm_offer_type')){
				$array[] =& $courseOffering;
			}
		}
		$ret =& new  HarmoniCourseOfferingIterator($array);
		return $ret;

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
		//Courses are equivalent if they have the same id in the equivalent field
		//The id chosen is the lowest of the ids
		//getField()
		

		$cm =& Services::getService("CourseManagement");
		
		$course =& $cm->getCanonicalCourse($canonicalCourseId);
		$courseEquivalent = $course->_getField('equivalent');
		$thisEquivalent = $this->_getField('equivalent');
		$comp = strcasecmp($courseEquivalent,$thisEquivalent);
		if($comp==0){
			return;	
		} elseif ($comp > 0){
			$min = $thisEquivalent;
			$courseIterator =& $course->getEquivalentCourses();
			$course->_setField('equivalent',$min);
		}else{
			$min = $courseEquivalent;
			$courseIterator =& $this->getEquivalentCourses();
			$this->_setField('equivalent',$min);
			
		}
		while($courseIterator->hasNextCanonicalCourse()){
			$course = $courseIterator->nextCanonicalCourse();
			$course->_setField('equivalent', $min);
		}
	
	} 

	/**
	 * Assures that the course passed in as a parameter is no longer 
	 * equivalent to any other courses.  It does not matter which course 
	 * calls the function.  In fact, it may make the most sense for courses to
	 * call the function on themselves.
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
		$cm =& Services::getService("CourseManagement");		
		$course =& $cm->getCanonicalCourse($canonicalCourseId);		
		$courseIterator =& $course->getEquivalentCourses();	

			
		if(!$courseIterator->hasNextCanonicalCourse()){
			return;	
		}
		
		
		$courseEquivalent = $course->_getField('equivalent');
		$idString=$canonicalCourseId->getIdString();
		
		
				
		if($courseEquivalent!=$idString){
			$course->_setField('equivalent',$idString);
			return;
		}
		
		//Hahahahaa!  I crack myself up.
		$first =true;
		while($courseIterator->hasNextCanonicalCourse()){
			$currCourse =& $courseIterator->nextCanonicalCourse();
			$currId =& $currCourse->getId();
			
			
			
			
			$currIdString = $currId->getIdString();		
			
			if($first || strcasecmp($currIdString,$minSoFar) < 0){
				$minSoFar = $currIdString;		
				$first=false;		
			}	
		}
		
		
		
		$courseIterator =& $course->getEquivalentCourses();
		
		while($courseIterator->hasNextCanonicalCourse()){
			
			
			$course =& $courseIterator->nextCanonicalCourse();
			$course->_setField('equivalent',$minSoFar);		
		}
		
		
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
		
		$dbManager =& Services::getService("DatabaseManager");
		$cm =& Services::getService("CourseManagement");
		$query=& new SelectQuery;
		$query->addTable($this->_table);
		$query->addColumn('id');
		$query->addWhere("equivalent ='".$this->_getField('equivalent')."'");
		$res=& $dbManager->query($query);
		$array=array();
		$idManager=& Services::getService('IdManager');
		$myIdString = $this->_id->getIdString();
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			if($row['id']==$myIdString){
				continue;
			}
			$array[] = $cm->getCanonicalCourse($idManager->getId($row['id']));
		}
		$ret =& new HarmoniCanonicalCourseIterator($array);
		return $ret;
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
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_topics');
		$query->addWhere("fk_cm_can='".$this->_id->getIdString()."'");
		$query->addWhere("topic='".addslashes($topic)."'");
		//not really needed, but it keeps this from crashing.
		$query->addColumn('topic');
		$res=& $dbManager->query($query);



		if($res->getNumberOfRows()==0){
			$query=& new InsertQuery;
			$query->setTable('cm_topics');
			$values[]="'".addslashes($this->_id->getIdString())."'";
			$values[]="'".addslashes($topic)."'";	
			$query->setColumns(array('fk_cm_can','topic'));	
					
			$query->addRowOfValues($values);			
			$result =& $dbManager->query($query);
		}elseif($res->getNumberOfRows()==1){
			//do nothing
		}else{
			print "\n<b>Warning!<\b> The Topic with course ".$this->getDisplayName()." and description ".$topic." is not unique--there are ".$res->getNumberOfRows()." copies.\n";

		}
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
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;
		$query->setTable('cm_topics');
		$query->addWhere("fk_cm_can='".$this->_id->getIdString()."'");
		$query->addWhere("topic='".addslashes($topic)."'");
		$dbManager->query($query);

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
		
		
		
		
		
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('cm_topics');
		$query->addWhere("fk_cm_can='".$this->_id->getIdString()."'");
		$query->addColumn('topic');
		$res=& $dbManager->query($query);
		$array=array();
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$array[]=$row['topic'];
		}
		$ret =& new HarmoniStringIterator($array);
		return $ret;
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
		
		return $this->_getField('credits');
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
		return $this->_getType('can_stat');
		
	
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

		$index = $this->_typeToIndex('can_stat',$statusType);
		$this->_setField('fk_cm_can_stat_type',$index);
	} 
	
	/**
	 * Get all the Property Types for  CanonicalCourse.  There is is only 
	 * One type of property associated with each course object.
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
		$courseType =& $this->getCourseType();
		$propertiesType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties");
		$array = array($propertiesType);
		$typeIterator =& new HarmoniTypeIterator($array);
		return $typeIterator;
	} 

	/**
	 * Get the Properties associated with this CanonicalCourse.  There is is only 
     * One type of property associated with each course object.
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
		$array = array($this->_getProperties());
		$ret = new PropertiesIterator($array);		
		return $ret;//return the iterator
		
	} 
	
	
	
	/**
	* Get the Properties of this Type associated with this CanonicalCourse.  There is is only 
	* One type of property associated with each course object.
	*
	* @param object Type $propertiesType
	*
	* @return object Properties
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
	function &getPropertiesByType ( &$propertiesType ) {
		$courseType =& $this->getCourseType();
		$propType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties"); 		
		if($propertiesType->isEqualTo($propType)){
			return $this->_getProperties();
		}
		return null;
		
		
		
	}
	
	
	/**
	* Get a Properties object with the information about this object.
	*
	* @return object Properties
	*
	* @access private
	*/
	function &_getProperties(){
		
		
		//get the record
		$query =& new SelectQuery();
		$query->addTable('cm_can');
		$query->addColumn("*");
		$query->addWhere("id='".addslashes($this->_id->getIdString())."'");				
		$res=& $dbManager->query($query);
		
		
		
		//make sure we can find that course
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of Course with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row		
		
		//make a type
		$courseType =& $this->getCourseType();	
		$propertiesType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties"); 
				
		//create a custom Properties object
		$idManager =& Services::getService("Id");
		$property =& new HarmoniProperties($propertiesType);
		$property->addProperty('display_name', $this->_node->getDisplayName());
		$property->addProperty('description', $this->_node->getDescription());	
		$property->addProperty('id', $idManager->getId($row['id']));
		$property->addProperty('number', $row['number']);
		$property->addProperty('credits', $row['credits']);
		$property->addProperty('equivalent_id', $idManager->getId($row['equivalent']));
		$property->addProperty('type', $courseType->getKeyword());
		$property->addProperty('title', $row['']);
		$statusType =& $this->getStatus();
		$property->addProperty('status_type', $statusType->getKeyword());

		
		$res->free();	
		return $property;
		
		
	}
	
	
	
	
	
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
		return $cm->_getField($this->_id,$this->_table,$key);
	}
	
	
	function &_getType($typename){
		$cm=Services::getService("CourseManagement");
		return $cm->_getType($this->_id,$this->_table,$typename);
	}
	
	function _setField($key, $value)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_setField($this->_id,$this->_table,$key, $value);		
	}
	
	
	
	
	
	
}

?>