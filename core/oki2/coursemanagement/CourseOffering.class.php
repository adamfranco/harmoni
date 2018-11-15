<?php 

require_once(OKI2."/osid/coursemanagement/CourseOffering.php");

/**
* CourseOffering is a CanonicalCourse offered in a specific Term.
* CanonicalCourse contains general information about a course in general.
* The CourseSection is the third and most specific course-related object.
* The section includes information about the location of the class as well as
* the roster of students.	CanonicalCourses can contain other
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
* @version $Id: CourseOffering.class.php,v 1.28 2008/02/06 15:37:48 adamfranco Exp $
*/
class HarmoniCourseOffering
	implements CourseOffering
{








	/**
	* @variable object $_node the node in the hierarchy.
	* @access private
	* @variable object $_id the unique id for the course offering.
	* @access private
	* @variable object $_table the course offering table.
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
	function HarmoniCourseOffering($id, $node)
	{
		$this->_id =$id;
		$this->_node =$node;
		$this->_table = 'cm_offer';
		$cm = Services::getService("CourseManagement");
		$this->_hierarchy =$cm->_hierarchy;

	}



	/**
	* Update the title for this CourseOffering.
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
	* Update the number for this CourseOffering.
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
	* Update the description for this CourseOffering.
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
		$this->_node->updateDescription($description );
	}

	/**
	* Update the display name for this CourseOffering.
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
		$this->_node->updateDisplayName($displayName );
	}

	/**
	* Get the title for this CourseOffering.
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
	* Get the number for this CourseOffering.
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
	* Get the description for this CourseOffering.
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
	* Get the display name for this CourseOffering.
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
	* Get the unique Id for this CourseOffering.
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
	function getId () {
		return $this->_id;
	}

	/**
	* Get the Offering Type for this CourseOffering.  This Type is meaningful
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
	function getOfferingType () {
		return $this->_getType('offer');
	}

	/**
	* Get the CourseGradeType for this Offering.  GradingType is defined in
	* the grading OSID.  These Types are meaningful to the implementation and
	* applications and are not specified by the OSID.
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
	function getCourseGradeType () {
		$gm = Services::getService('Grading');
		return $gm->_getType($this->_id,$this->_table,'grade');
	}

	/**
	* Get a Term by unique Id.
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
	*		   UNIMPLEMENTED}
	*
	* @access public
	*/
	function getTerm () {
		$cm = Services::getService("CourseManagement");
		$idManager = Services::getService("Id");




		$termId = $this->_getField('fk_cm_term');
		
		
	
		return $cm -> getTerm($idManager->getId($termId));

	}

	/**
	* Get the Status for this CourseOffering.
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
	function getStatus () {
		return $this->_getType('offer_stat');
	}

	/**
	* Get all the Property Types for  CourseOffering.
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
	function getPropertyTypes () {
		$courseType =$this->getOfferingType();
		$propertiesType = new Type("PropertiesType", $courseType->getAuthority(), "properties");
		$array = array($propertiesType);
		$typeIterator = new HarmoniTypeIterator($array);
		return $typeIterator;
	}

	/**
	* Get the Properties associated with this CourseOffering.
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
	function getProperties () {
		$array = array($this->_getProperties());
		$ret = new HarmoniPropertiesIterator($array);		
		return $ret;//return the iterator
	}

	/**
	* Get the CanonicalCourse that contains this CourseOffering.
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
	*		   UNIMPLEMENTED}
	*
	* @access public
	*/
	function getCanonicalCourse () {
		$nodeIterator =$this->_node->getParents();
		if(!$nodeIterator->hasNextNode()){
			print "<b>Warning!</b> Course Offering ".$this->getDisplayName()." has no Canonical Parent.";
			return null;
		}
		$parentNode =$nodeIterator->nextNode();
		$cm = Services::getService("CourseManagement");
		return $cm -> getCanonicalCourse($parentNode->getID());
	}

	/**
	* Create a new CourseSection.  
	*
	* The display name defaults to the title.  If the title,
	* number or displayName are left null, they default to the values of the creating agent.
	* Niether of these defaults are in the OSID, however.
	*
	* @param string $title
	* @param string $number
	* @param string $description
	* @param object Type $sectionType
	* @param object Type $sectionStatusType
	* @param object mixed $location (original type: java.io.Serializable)
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
	*		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	*		   UNKNOWN_TYPE}
	*
	* @access public
	*/
	function createCourseSection ( $title, $number, $description, Type $sectionType, Type $sectionStatusType, $location ) {
		
		//set any defaults
		if(is_null($title)){
			$title = $this->getTitle();
		}
		if(is_null($number)){
			$number = $this->getNumber();
		}
		if(is_null($description)){
			$description = $this->getDescription();
		}
		
		
		//prepare
		$idManager = Services::getService("IdManager");
		$id=$idManager->createId();
		$type = new Type("CourseManagement","edu.middlebury", "CourseSection");
		$dbManager= Services::getService("DatabaseManager");
		
		//make node		
		$node=$this->_hierarchy->createNode($id,$this->_id,$type,$title,$description);
		
		//query
		$query= new InsertQuery;
		$query->setTable('cm_section');
		$query->setColumns(array('id','location','schedule','fk_cm_section_type','fk_cm_section_stat_type','title','number'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes("".$location)."'";
		$values[]="'unimplemented'";
		$values[]="'".$this->_typeToIndex('section',$sectionType)."'";
		$values[]="'".$this->_typeToIndex('section_stat',$sectionStatusType)."'";
		$values[]="'".addslashes($title)."'";
		$values[]="'".addslashes($number)."'";
		$query->addRowOfValues($values);
		$dbManager->query($query);

		
		//create object
		$ret = new HarmoniCourseSection($id, $node);
		return $ret;
	}

	/**
	* Delete a CourseSection.
	*
	* @param object Id $courseSectionId
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
	function deleteCourseSection ( Id $courseSectionId ) {	  	
		$this->_hierarchy->deleteNode($courseSectionId);
		$dbManager = Services::getService("DatabaseManager");
		$query= new DeleteQuery;
		$query->setTable('cm_section');
		$query->addWhereEqual("id", $courseSectionId->getIdString());
		$dbManager->query($query);
		
		$query= new DeleteQuery;
		$query->setTable('cm_schedule');
		$query->addWhereEqual("fk_id", $courseSectionId->getIdString());
		$dbManager->query($query);
	}

	/**
	* Get all CourseSections that belong to this CourseOffering.
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
	*		   UNIMPLEMENTED}
	*
	* @access public
	*/
	function getCourseSections () {

		$nodeIterator =$this->_node->getChildren();

		$array = array();
		$idManager=  Services::getService("IdManager");
		$cm=  Services::getService("CourseManagement");
		while($nodeIterator->hasNextNode()){
			$childNode =$nodeIterator->nextNode();
			$array[] =$cm->getCourseSection($childNode->getId());
		}
		$ret = new  HarmoniCourseSectionIterator($array);
		return $ret;

		/*$dbManager = Services::getService("DatabaseManager");
		$query= new SelectQuery;


		$query->addTable('cm_section');
		$query->addColumn('id');
		$res=$dbManager->query($query);

		$array = array();
		$idManager=  Services::getService("IdManager");
		$cm=  Services::getService("CourseManagement");
		while($res->hasMoreRows()){

		$row = $res->getCurrentRow();
		$res->advanceRow();
		$id =$idManager->getId($row['id']);
		$array[] =$cm->getCourseSection($id);

		}
		$ret = new  HarmoniCourseSectionIterator($array);
		return $ret;*/
	}

	/**
	* Get all CourseSections of the specified Type that belong to this CourseOffering.
	*
	* @param object Type $sectionType
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
	*		   org.osid.coursemanagement.CourseManagementException#UNKNOWN_TYPE
	*		   UNKNOWN_TYPE}
	*
	* @access public
	*/
	function getCourseSectionsByType ( Type $sectionType ) {


		$nodeIterator =$this->_node->getChildren();

		$array = array();
		$idManager=  Services::getService("IdManager");
		$cm=  Services::getService("CourseManagement");
		$typeIndex=$cm->_typeToIndex('section',$sectionType);

	
		while($nodeIterator->hasNextNode()){
			$childNode = $nodeIterator->nextNode();
			$courseSection =$cm->getCourseSection($childNode->getId());	
			if($typeIndex == $courseSection->_getField('fk_cm_section_type')){
				$array[] =$courseSection;
			}
		}
		$ret = new  HarmoniCourseSectionIterator($array);
		return $ret;

		/*
		$cm=  Services::getService("CourseManagement");
		$typeIndex=$cm->_typeToIndex('section',$sectionType);

		$dbManager = Services::getService("DatabaseManager");
		$query= new SelectQuery;


		$query->addTable('cm_sectopn');
		$query->addColumn('id');
		$query->addWhereEqual("fk_cm_section_type", $typeIndex));
		$res=$dbManager->query($query);

		$array = array();
		$idManager=  Services::getService("IdManager");

		while($res->hasMoreRows()){

		$row = $res->getCurrentRow();
		$res->advanceRow();
		$id =$idManager->getId($row['id']);
		$array[] =$cm->getCourseSection($id);

		}
		$ret = new  HarmoniCourseSectionIterator($array);
		return $ret;*/

	}

	/**
	* Add an Asset for this CourseOffering.  Does nothing if the course has a 
	* single copy of the asset and prints a warning if there is more than one
	* copy of that asset in one course.
	*
	* @param object Id $assetId
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
	*		   org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
	*		   ALREADY_ADDED}
	*
	* @access public
	*/
	function addAsset ( Id $assetId ) {
		
	$dbManager = Services::getService("DatabaseManager");
		$query= new SelectQuery;
		$query->addTable('cm_assets');
		$query->addWhereEqual("fk_course_id", $this->_id->getIdString());
		$query->addWhereEqual("fk_asset_id", $assetId->getIdString());
		$query->addColumn('fk_course_id');
		$res=$dbManager->query($query);



		if($res->getNumberOfRows()==0){
			$query= new InsertQuery;
			$query->setTable('cm_assets');
			$values[]="'".addslashes($this->_id->getIdString())."'";
			$values[]="'".addslashes($assetId->getIdString())."'";	
			$query->setColumns(array('fk_course_id','fk_asset_id'));			
			$query->addRowOfValues($values);			
			$result =$dbManager->query($query);
		}elseif($res->getNumberOfRows()==1){
			//do nothing
		}else{
			print "\n<b>Warning!<\b> The asset with course ".$this->getDisplayName()." and id ".$assetId->getIdString()." is not unique--there are ".$res->getNumberOfRows()." copies.\n";

		}

	}

	/**
	* Remove an Asset for this CourseOffering.
	*
	* @param object Id $assetId
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
	function removeAsset ( Id $assetId ) {
		$dbManager = Services::getService("DatabaseManager");
		$query= new DeleteQuery;
		$query->setTable('cm_assets');
		$query->addWhereEqual("fk_course_id", $this->_id->getIdString());
		$query->addWhereEqual("fk_asset_id", $assetId->getIdString());
		$dbManager->query($query);
	}

	/**
	* Get the Assets associated with this CourseOffering.
	*
	* @return object IdIterator
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
	function getAssets () {
		
		
		$dbManager = Services::getService("DatabaseManager");
		$query= new SelectQuery;
		$query->addTable('cm_assets');
		$query->addWhereEqual("fk_course_id", $this->_id->getIdString());
		$query->addColumn('fk_asset_id');
		$res=$dbManager->query($query);
		$array=array();
		$idManager = Services::getService("Id");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			
			$array[]=$idManager->getId($row['fk_asset_id']);
		}
		$ret = new HarmoniIdIterator($array);
		return $ret;
	}

	/**
	* Update the CourseGradeType for this Offering.  GradingType is defined in
	* the grading OSID.  These Types are meaningful to the implementation and
	* applications and are not specified by the OSID.
	*
	* @param object Type $courseGradeType
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
	function updateCourseGradeType ( Type $courseGradeType ) {		
		$gm = Services::getService('Grading');
		$typeIndex = $gm->_typeToIndex('grade',$courseGradeType);
		$this->_setField('fk_gr_grade_type',$typeIndex);
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
	function updateStatus ( Type $statusType ) {
		$this->_setField('fk_cm_offer_stat_type',$this->_typeToIndex('offer_stat',$statusType));
	}

	/**
	* Add a student to the roster and assign the specified Enrollment Status
	* Type.
	*
	* This method makes little sense in the context of CourseOffering and
	* remains unimplemented.  Use CourseSections addStudent() instead.
	*
	* @param object Id $agentId
	* @param object Type $enrollmentStatusType
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
	*		   org.osid.coursemanagement.CourseManagementException#ALREADY_ADDED
	*		   ALREADY_ADDED}
	*
	* @access public
	*/
	function addStudent ( Id $agentId, Type $enrollmentStatusType ) {
		throwError(new HarmoniError("addStudent() is not implemented for CourseOffering--it makes little sense", "CourseOffering", true));
	}

	/**
	* Change the Enrollment Status Type for the student on the roster.   
	*
	* This method makes little sense in the context of CourseOffering and
	* remains unimplemented.  Use CourseSections changeStudent() instead.
	*
	* @param object Id $agentId
	* @param object Type $enrollmentStatusType
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
	function changeStudent ( Id $agentId, Type $enrollmentStatusType ) {
		throwError(new HarmoniError("changeStudent() is not implemented for CourseOffering--it makes little sense", "CourseOffering", true));
	}

	/**
	* Remove a student from all of the course sections of this offering. 
	*
	* @param object Id $agentId
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
	function removeStudent ( Id $agentId ) {
		$courseSections =$this->getCourseSections();
		while ($courseSections->hasNextCourseSection()) {
			$courseSection =$courseSections->nextCourseSection();
			$courseSection->removeStudent($agentId);			
		}
	}

	/**
	* Get the student roster.  This returns all the enrollments of all the course 
	* sections.  Keep in mind that they will be ordered by the students that are in
	* section.  Each student may be enrolled in several courses.
	*
	* @return object EnrollmentRecordIterator
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
	function getRoster () {


		$idManager = Services::getService('IdManager');
		$dbManager = Services::getService("DatabaseManager");

		

		$courseSectionIterator = $this->getCourseSections();
		
		//quit out if there is not any CourseSection
		$array=array();
		if(!$courseSectionIterator->hasNextCourseSection()){
			$ret = new HarmoniEnrollmentRecordIterator($array);
			return $ret;
		}
		
		
		
		//set up a query
		$query= new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addColumn('id');
		
		//set up a where
		$where = "";
		$first = true;
		
		//add necesary or's
		while($courseSectionIterator->hasNextCourseSection()){
			if(!$first){
				$where .= " OR ";
			}			
			$first=false;
			$section = $courseSectionIterator->nextCourseSection();
			$sectionId = $section->getId();			
			$where .= "fk_cm_section='".addslashes($sectionId->getIdString())."'";				
		}
		
		//finish query
		$query->addWhere($where);	
		$query->addOrderBy('id');		
		$res=$dbManager->query($query);
		
		
		//add all EnrollmentRecords to an array
		while($res->hasMoreRows()){
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$array[] = new HarmoniEnrollmentRecord($idManager->getId($row['id']));
			}
			
			//return them as an iterator
		$ret = new HarmoniEnrollmentRecordIterator($array);
		return $ret;
	}

	/**
	* Get the student roster.	Include only students with the specified
	* Enrollment Status Type.  This returns all the enrollments of all the course 
	* sections.  Keep in mind that they will be ordered by the students that are in
	* section.  Each student may be enrolled in several CoursesSctions.
	*
	* @param object Type $enrollmentStatusType
	*
	* @return object EnrollmentRecordIterator
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
	function getRosterByType ( Type $enrollmentStatusType ) {
		
		$idManager = Services::getService('IdManager');
		$dbManager = Services::getService("DatabaseManager");

		

		$courseSectionIterator = $this->getCourseSections();
		
		//quit out if there is not any CourseSection
		$array=array();
		if(!$courseSectionIterator->hasNextCourseSection()){
			$ret = new HarmoniEnrollmentRecordIterator($array);
			return $ret;
		}
		
		
		
		//set up a query
		$query= new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addColumn('id');
		
		//set up a where
		$where = "(";
		$first = true;
		
		//add necesary or's
		while($courseSectionIterator->hasNextCourseSection()){
			if(!$first){
				$where .= " OR ";
			}			
			$first=false;
			$section = $courseSectionIterator->nextCourseSection();
			$sectionId = $section->getId();			
			$where .= "fk_cm_section='".addslashes($sectionId->getIdString())."'";			
		}
		
		//finish query
		$typeIndex = $this->_typeToIndex('enroll_stat',$enrollmentStatusType);
		$query->addWhere($where.") AND fk_cm_enroll_stat_type='".addslashes($typeIndex)."'");	
		$query->addOrderBy('id');		
		$res=$dbManager->query($query);
		
		
		//add all EnrollmentRecords to an array
		while($res->hasMoreRows()){
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$array[] = new HarmoniEnrollmentRecord($idManager->getId($row['id']));
			}
			
			//return them as an iterator
		$ret = new HarmoniEnrollmentRecordIterator($array);
		return $ret;
		
		//oldcode
		
		/*
		
		
		
		
		$idManager = Services::getService('IdManager');
		$dbManager = Services::getService("DatabaseManager");

		$query= new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addColumn('id');
		$typeIndex = $this->_typeToIndex('enroll_stat',$enrollmentStatusType);

		$courseSectionIterator = $this->getCourseSections();

		while($courseSectionIterator->hasNextCourseSection()){
			$section = $courseSectionIterator->nextCourseSection();
			$sectionId = $section->getId();			
			$query->addWhere("fk_cm_section='".addslashes($sectionId->getIdString())."' AND fk_cm_enroll_stat_type='".addslashes($typeIndex)."'");
		}
		$query->addOrderBy('id');
		
		$res=$dbManager->query($query);
		
		
		$array=array();
		while($res->hasMoreRows()){
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$array[] = new HarmoniEnrollmentRecord($idManager->getId($row['id']));
			}
		$ret = new HarmoniEnrollmentRecordIterator($array);
		return $ret;
		
		*/
		
		/*
		
		
		
		$dbManager = Services::getService("DatabaseManager");

		$array=array();

		$courseSectionIterator = $this->getCourseSections();
		
		$typeIndex = $this->_typeToIndex('enroll_stat',$enrollmentStatusType);

		while($courseSectionIterator->hasNextCourseSection()){
			$section = $courseSectionIterator->nextCourseSection();
			$sectionId = $section->getId();

			$query= new SelectQuery;
			$query->addTable('cm_enroll');
			//$query->addColumn('fk_student_id');
			$query->addColumn('id');			
			$query->addWhere("fk_cm_section='".addslashes($sectionId->getIdString())."' AND fk_cm_enroll_stat_type='".addslashes($typeIndex)."'");


			$res=$dbManager->query($query);
			$idManager = Services::getService('IdManager');
			while($res->hasMoreRows()){
				$row = $res->getCurrentRow();
				$res->advanceRow();
				
				$array[] = new HarmoniEnrollmentRecord($idManager->getId($row['id']));
			}
		}
		$ret = new HarmoniEnrollmentRecordIterator($array);
		return $ret;
		*/
	}

	/**
	* Get the Properties of this Type associated with this CourseOffering.
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
	function getPropertiesByType ( Type $propertiesType ) {
		$courseType =$this->getOfferingType();
		$propType = new Type("PropertiesType", $courseType->getAuthority(), "properties"); 		
		if($propertiesType->isEqualTo($propType)){
			return $this->_getProperties();
		}
		return null;
		
		
		
	}

	
	function _getProperties(){
		
		$dbManager = Services::getService("DatabaseManager");
		
		//get the record
		$query = new SelectQuery;
		$query->addTable('cm_offer');
		$query->addColumn("*");
		$query->addWhereEqual("id", $this->_id->getIdString());
		$res=$dbManager->query($query);
		
			
		
		//make sure we can find that course
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of Course with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row	
		
		//make a type
		$courseType =$this->getOfferingType();	
		$propertiesType = new Type("PropertiesType", $courseType->getAuthority(), "properties"); 	

				
		//create a custom Properties object
		$idManager = Services::getService("Id");
		$property = new HarmoniProperties($propertiesType);
		$property->addProperty('display_name', $this->_node->getDisplayName());
		$property->addProperty('title', $row['title']);
		$property->addProperty('description', $this->_node->getDescription());	
		$property->addProperty('id',  $idManager->getId($row['id']));
		$property->addProperty('number', $row['number']);
		$gradeType =$this->getCourseGradeType();
		$property->addProperty('grade_type', $gradeType);
		$term =$this->getTerm();
		$property->addProperty('term', $term);
		$property->addProperty('type', $courseType);
		$statusType =$this->getStatus();
		$property->addProperty('status_type', $statusType);

		
		$res->free();	
		return $property;
	}



	function _typeToIndex($typename, $type)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_typeToIndex($typename, $type);
	}

	function _getTypes($typename)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_getTypes($typename);
	}

	function _getField($key)
	{
		$cm=Services::getService("CourseManagement");
		return $cm->_getField($this->_id,$this->_table,$key);
	}


	function _getType($typename){
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