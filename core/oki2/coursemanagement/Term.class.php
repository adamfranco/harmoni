<?php 

require_once(OKI2."/osid/coursemanagement/Term.php");
 
/**
 * Term includes an unique Id assigned by the implementation, a display name, a
 * termType, and  a schedule.
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
 * @version $Id: Term.class.php,v 1.6 2006/06/27 21:07:13 sporktim Exp $
 */
class HarmoniTerm
	extends Term
{
	
	/**
	* @variable object Id $_id the unique id for this term.
	* @access private	
	**/
	
	var $_id;
	
	/**
	 * Update the display name for this Term.
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
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "Term", true)); 
		$this->_setField('name',$displayName);
	} 

	/**
	 * Get the display name for this Term.
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
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "Term", true)); 
		return $this->_getField('name');
	} 

	/**
	 * Get the unique Id for this Term.
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
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "Term", true)); 
		return _id;
	} 

	/**
	 * Get the Type for this Term.	This Type is meaningful to the
	 * implementation and applications and is not specified by the OSID.
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
	function &getType () { 
		//throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "Term", true)); 
		return $this->_getType('term');
	} 

	/**
	 * Get the Schedule for this Term.	Schedules are defined in scheduling
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
		throwError(new Error(CourseManagementExeption::UNIMPLEMENTED(), "Term", true)); 
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