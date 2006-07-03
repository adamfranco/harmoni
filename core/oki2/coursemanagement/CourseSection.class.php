<?php 

require_once(OKI2."/osid/coursemanagement/CourseSection.php");
 
/**
 * CourseSection is associated with a CourseOffering and is has a separate
 * roster and possibly a separate SectionType from any other Sections of the
 * Offering. CanonicalCourse contains general information about a course.
 * This is in contrast to the CourseOffering which contains information about
 * a concrete offering of this course in a specific term and with identified
 * people and roles.  The section includes information about the location of
 * the class as well as the roster of students.	 CanonicalCourses can contain
 * other CanonicalCourses and may be organized hierarchically, in schools,
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
 * @version $Id: CourseSection.class.php,v 1.9 2006/07/03 19:51:50 sporktim Exp $
 */
class HarmoniCourseSection
	extends CourseSection
{
	
	
	
	
	
	
	
	/**
	 * @variable object $_node the node in the hierarchy.
	 * @access private
	 * @variable object $_id the unique id for the course section.
	 * @access private
	 * @variable object $_table the course section table.
	 * @access private
	 **/
	var $_node;
	var $_id;
	var $_table;
	
	/**
	 * The constructor.
	 * 
	 * @param object Id $id
	 * @param object Node $node
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniCanonicalCourse($id, $node)
	{
		$this->_id = $id;
		$this->_node = $node;
		$this->_table = 'cm_section';
		
	}
	
	
	
	
	
	
	
	
	/**
	 * Update the title for this CourseSection.
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
	 * Update the number for this CourseSection.
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
	 * Update the description for this CourseSection.
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
	 * Update the display name for this CourseSection.
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
	 * Update the location may be a room address, a map, or any other object.
	 * 
	 * @param object mixed $location (original type: java.io.Serializable)
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
	function updateLocation ( &$location ) { 
		$this->_setField('location',$location);
	} 

	/**
	 * Get the title for this CourseSection.
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
	 * Get the number for this CourseSection.
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
	 * Get the description for this CourseSection.
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
		return $this->_node->getDescription($displayName );
	} 

	/**
	 * Get the display name for this CourseSection.
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
		return $this->_node->getDisplayName($displayName ); 
	} 

	/**
	 * Get the unique Id for this CourseSection.
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
	 * Get the Section Type for this CourseSection.	 This Type is meaningful to
	 * the implementation and applications and are not specified by the OSID.
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
	function &getSectionType () { 
		return _getType('section');
	} 

	/**
	 * Get the Schedule for this Section.  Schedules are defined in scheduling
	 * OSID.  ScheduleItems are returned in chronological order by increasing
	 * start date.
	 *	
	 * @return object ScheduleItemIterator
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
	function &getSchedule () { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseSection", true)); 
	} 

	/**
	 * Get the location may be a room address, a map, or any other object.
	 *	
	 * @return object mixed (original type: java.io.Serializable)
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
	function &getLocation () { 
		return $this->_getField('location'); 
	} 

	/**
	 * Get the Status for this CourseSection.
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
		return _getType('section_stat');
	} 

	/**
	 * Get all the Property Types for  CourseSection.
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
		$courseType =& $this->getSectionType();
		$propertiesType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties");
		$typeIterator =& new HarmoniTypeIterator(array($propertiesType));
		return $typeIterator;
	} 

	/**
	 * Get the Properties associated with this CourseSection.
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
		$ret = new PropertiesIterator(array($this->_getProperties()));		
		return $ret;//return the iterator
	} 

	/**
	 * Get the CourseOffering that contains this CourseSection.
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getCourseOffering () { 
		$nodeIterator = $this->_node->getParents();
		if(!$nodeIterator->hasNextNode()){
			print "<b>Warning!</b> Course Section ".$this->getDisplayName()." has no Course Offering Parent.";
			return null;	
		}
		$parentNode = $nodeIterator->nextNode();		
		$cm = Services::getService("CourseMangament");
		return $cm -> getCourseOffering($parentNode->getID()); 
	} 

	/**
	 * Add an Asset for this CourseSection.  Does nothing if the course has a 
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
	function addAsset ( &$assetId ) { 
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_asset');
		$query->addWhere("fk_course_id='".$this->_id->getIdString()."'");
		$query->addWhere("fk_asset_id='".addslashes($assetId->getIdString())."'");
		$res=& $dbHandler->query($query);



		if($res->getNumberOfRows()==0){
			$query=& new InsertQuery;
			$query->setTable('cm_asset');
			$values[]="'".addslashes($this->_id->getIdString())."'";
			$values[]="'".addslashes($assetId->getIdString())."'";	
			$query->setColumns(array('fk_course_id','fk_asset_id'));			
			$query->addRowOfValues($values);			
			$result =& $dbHandler->query($query);
		}elseif($res->getNumberOfRows()==1){
			//do nothing
		}else{
			print "\n<b>Warning!<\b> The asset with course ".$this->getDisplayName()." and id ".$assetId->getIdString()." is not unique--there are ".$res->getNumberOfRows()." copies.\n";

		}
	} 

	/**
	 * Remove an Asset for this CourseSection.
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
	function removeAsset ( &$assetId ) { 
			$dbHandler =& Services::getService("DBHandler");
		$query=& new DeleteQuery;
		$query->addTable('cm_asset');
		$query->addWhere("fk_course_id='".$this->_id->getIdString()."'");
		$query->addWhere("fk_asset_id='".addslashes($assetId->getIdString())."'");
		$dbHandler->query($query);
	} 

	/**
	 * Get the Assets associated with this CourseSection.
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
	function &getAssets () { 
			
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_asset');
		$query->addWhere("fk_course_id='".$this->_id->getIdString()."'");
		$query->addColumn('fk_asset_id');
		$res=& $dbHandler->query($query);
		$array=array();
		$idManager =& Services::getService("Id");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			
			$array[]=$idManager->getId($row['fk_asset_id']);
		}
		$ret =& new HarmoniIdIterator($array);
		return $ret;
	} 

	/**
	 * Update the Schedule for this Section.  Schedules are defined in
	 * scheduling OSID.
	 * 
	 * @param object ScheduleItem[] $scheduleItems
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
	function updateSchedule ( &$scheduleItems ) { 
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "CourseSection", true)); 
	} 

	/**
	 * Add a student to the roster and assign the specified Enrollment Status
	 * Type.
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
	function addStudent ( &$agentId, &$enrollmentStatusType ) { 
	

		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('cm_enroll');
		$query->addWhere("fk_cm_section='".$this->_id."'");
		$query->addWhere("fk_student_id='".$agentId->getIdString()."'");
		//$query->addColumn('id');
		$res=& $dbHandler->query($query);
		if($res->getNumberOfRows()==0){
			$typeIndex = $this->_typeToIndex($enrollmentStatusType);
			
			$query=& new InsertQuery;
			$query->setTable('cm_enroll');
			$values[]="'".addslashes($agentId->getIdString())."'";
			$values[]="'".addslashes($typeIndex)."'";
			$values[]="'".addslashes($this->_id)."'";
			$query->setColumns(array('fk_student_id','fk_cm_enroll_stat_type','fk_cm_section'));
			$query->addRowOfValues($values);
			$query->setAutoIncrementColumn('id','id_sequence');
			$dbHandler->query($query);		
		}else{
			print "<b>Warning!</b> Student with id ".$agentId->getIdString()."is already enrolled in section ".$this->getDisplayName().".";
		}
			
			
	//	$ret =& new HarmoniTerm($id);
	//	return $ret;
		
	} 

	/**
	 * Change the Enrollment Status Type for the student on the roster.
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
	function changeStudent ( &$agentId, &$enrollmentStatusType ) { 
		
		$typeIndex = $this->_typeToIndex($enrollmentStatusType);
		
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;
		$query->setTable('cm_enroll');

		
		
		$query->addWhere("fk_cm_section='".$this->_id."'");
		$query->addWhere("fk_student_id='".$agentId->getIdString()."'");
		
		$query->setColumns(array('fk_cm_enroll_stat_type'));
		$query->setValues(array("'".addslashes($typeIndex)."'"));

		$dbHandler->query($query);


	} 

	/**
	 * Remove a student from the roster.
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
	function removeStudent ( &$agentId ) { 
		$this->_hierarchy->deleteNode($canonicalCourseId);



		$dbHandler =& Services::getService("DBHandler");
		$query=& new DeleteQuery;


		$query->setTable('cm_enroll');

	
		$query->addWhere("fk_cm_section='".$this->_id."'");
		$query->addWhere("fk_student_id='".$agentId->getIdString()."'");
		
		$dbHandler->query($query);
	} 

	/**
	 * Get the student roster.
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
	function &getRoster () { 
		

		$dbHandler =& Services::getService("DBHandler");

		$array=array();

	

			$query=& new SelectQuery;
			$query->setTable('cm_enroll');
			//$query->addColumn('fk_student_id');
			$query->addColumn('id');
			$query->addWhere("fk_cm_section='".addslashes($this->_id)."'");


			$res=& $dbHandler->query($query);

			while($res->hasMoreRows()){
				$row =& $res->getCurrentRow();
				$res->advanceRow();
				//$courseSection = $cm->getCourseSection($row['id']);
				//$courseOffering = $courseSection->getCourseOffering();
				//$courseOfferingId=$courseOffering->getId();
				//foreach($array as $value){
				//	if($courseOfferingId->isEqualTo($value->getId())){
				//		continue 2;
				//	}
				//}
				//$array[] =& $node->getType();
				$array[] =& new HarmoniEnrollmentRecord($row['id']);
			}
		$ret =& new EnrollmentRecordIterator($array);
		return $ret;
	} 

	/**
	 * Get the student roster.	Include only students with the specified
	 * Enrollment Status Type.
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
	function &getRosterByType ( &$enrollmentStatusType ) { 
		$dbHandler =& Services::getService("DBHandler");
		
		$typeIndex = $this->_typeToIndex('enroll_stat',$enrollmentStatusType);

		$array=array();

	

			$query=& new SelectQuery;
			$query->setTable('cm_enroll');
			//$query->addColumn('fk_student_id');
			$query->addColumn('id');
			//$query->addWhere("fk_cm_section='".addslashes($this->_id)."'");
$query->addWhere("fk_cm_section='".addslashes($sectionId)."' AND fk_enroll_stat_type='".addslashes($typeIndex)."'");

			$res=& $dbHandler->query($query);

			while($res->hasMoreRows()){
				$row =& $res->getCurrentRow();
				$res->advanceRow();
				//$courseSection = $cm->getCourseSection($row['id']);
				//$courseOffering = $courseSection->getCourseOffering();
				//$courseOfferingId=$courseOffering->getId();
				//foreach($array as $value){
				//	if($courseOfferingId->isEqualTo($value->getId())){
				//		continue 2;
				//	}
				//}
				//$array[] =& $node->getType();
				$array[] =& new HarmoniEnrollmentRecord($row['id']);
			}
		$ret =& new EnrollmentRecordIterator($array);
		return $ret; 
	} 

	/**
	 * Update the Status for this CourseSection.
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
		$this->_setField('fk_cm_section_stat_type',$this->_typeToIndex($statusType));
	} 

	/**
	 * Get the Properties of this Type associated with this CourseSection.
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
		$courseType =& $this->getSectionType();
		$propertiesType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties"); 		
		if($propertiesType->isEqualTo($propertiesType)){
			return $this->_getProperties();
		}
		return null;
		
		
		
	} 
	
	
	
	
	function &_getProperties(){
		
		$dbHandler =& Services::getService("DBHandler");
		
		//get the record
		$query =& new SelectQuery();
		$query->addTable('cm_section');
		$query->addColumn("*");
		$query->addWhere("id='".addslashes($this->_id)."'");				
		$res=& $dbHandler->query($query);
		
		//make a type
		$courseType =& $this->getSectionType();	
		$propertiesType =& new Type($courseType->getDomain(), $courseType->getAuthority(), "properties"); 	
		
		//make sure we can find that course
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of Course with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row		
		$property =& new HarmoniProperties($propertiesType);
				
		//create a custom Properties object
		$property->addProperty('display_name', $this->_node->getDisplayName());
		$property->addProperty('description', $this->_node->getDescription());	
		$property->addProperty('id', $row['id']);
		$property->addProperty('number', $row['number']);
		$property->addProperty('type', $courseType->getKeyword());
		$property->addProperty('title', $row['']);
		$statusType =& $this->getStatus();
		$property->addProperty('status_type', $statusType->getKeyword());
		$property->addProperty('location', $row['location']);
	
		//add schedule?
		

		
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