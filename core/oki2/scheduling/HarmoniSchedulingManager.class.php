<?php 
 
require_once(OKI2."/osid/scheduling/SchedulingManager.php");

/**
 * <p>
 * SchedulingManager creates, deletes, and gets ScheduleItems.  Items include
 * Agent Commitments (e.g. Calendar events).  The Manager also enumerates the
 * commitment Status Types supported by the implementation.
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
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package org.osid.scheduling
 */
class HarmoniSchedulingManager
    extends SchedulingManager
{
	
	
	
	
	
	/**
	* @variable object OsidContext $_osidContext the OSID context.
	* @access private
	* @variable object Properties $_configuration the configuration for the CourseManagementManager.
	* @access private
	**/
	var $_osidContext;
	var $_configuration;




	/**
	* @param ref object $drId A {@link HarmoniId} referencing our DR.
	*/
	function HarmoniCourseManagementManager () {


	}



	/**
	* Assign the configuration of this Manager. Valid configuration options are as
	* follows:
	*	database_index			integer
	*	database_name			string
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
		
		/*
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

		*/
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
     * Create a ScheduleItem.  The masterIdentifier argument is optional.    A
     * Master Identifier is a key, rule, or function that can be used to
     * associated more than one ScheduleItem together.  An example can be
     * recurring items where each recurring item has the same Master
     * Identifier.   An unique Id is generated for this ScheduleItem by the
     * implementation.
     * 
     * @param string $displayName
     * @param string $description
     * @param object Id[] $agents
     * @param int $start
     * @param int $end
     * @param string $masterIdentifier
     *  
     * @return object ScheduleItem
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    function &createScheduleItem ( $displayName, $description, &$agents, $start, $end, $masterIdentifier ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Delete a ScheduleItem by unique Id.
     * 
     * @param object Id $scheduleItemId
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function deleteScheduleItem ( &$scheduleItemId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Timespans during which all Agents are uncommitted.
     * 
     * @param object Id[] $agents
     * @param int $start
     * @param int $end
     *  
     * @return object TimespanIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    function &getAvailableTimes ( &$agents, $start, $end ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get a ScheduleItem by unique Id.
     * 
     * @param object Id $scheduleItemId
     *  
     * @return object ScheduleItem
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function &getScheduleItem ( &$scheduleItemId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the ScheduleItems for any Agent, with the specified Item Status
     * and that start or end between the start and end specified, inclusive.
     * 
     * @param int $start
     * @param int $end
     * @param object Type $status
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    function &getScheduleItems ( $start, $end, &$status ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the ScheduleItems for the specified Agents, with the specified
     * Item Status and that start or end between the start and end specified,
     * inclusive.
     * 
     * @param int $start
     * @param int $end
     * @param object Type $status
     * @param object Id[] $agents
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function &getScheduleItemsForAgents ( $start, $end, &$status, &$agents ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all ScheduleItems with the specified master identifier reference.  A
     * Master Identifier is a key, rule, or function that can be used to
     * associated more than one ScheduleItem together.  An example can be
     * recurring items where each recurring item has the same Master
     * Identifier.
     * 
     * @param string $masterIdentifier
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    function &getScheduleItemsByMasterId ( $masterIdentifier ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Status Types for ScheduleItem supported by the implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getItemStatusTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Status Types for Agents' Commitment supported by the
     * implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getCommitmentStatusTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
    
    




	function &_getTypes($typename){
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);
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
		$ret =& new HarmoniTypeIterator($array);
		return $ret;
	}


	function &_getType(&$id, $table, $typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below
		$index=$this->_getField($id,$table,"fk_sc_".$typename."_type");
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addWhere("id=".$index);
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);
		$row = $res->getCurrentRow();
		if(is_null($row['description'])){
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword']);
		}else{
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
		}
		return $the_type;

	}


	function _typeToIndex($typename, &$type){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addWhere("domain='".$type->getDomain()."'");
		$query->addWhere("authority='".$type->getAuthority()."'");
		$query->addWhere("keyword='".$type->getKeyword()."'");
		$query->addColumn('id');
		$res=& $dbHandler->query($query);



		if($res->getNumberOfRows()==0){
			$query=& new InsertQuery;
			$query->setTable('sc_'.$typename.'_type');
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

			$row = $res->getCurrentRow();
			$the_index = $row['id'];
			return $the_index;

		}else{
			print "\n<b>Warning!<\b> The Type with domain ".$type->getDomain().", authority ".$type->getAuthority().", and keyword ".$type->getKeyword()." is not unique--there are ".$res->getNumberOfRows()." copies.\n";


			$row = $res->getCurrentRow();
			$the_index = $row['id'];
			return $the_index;

		}

	}

	function _setField(&$id, $table, $key, $value)
	{
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;
		$query->setTable($table);


		$query->addWhere("id='".addslashes($id->getIdString())."'");


		$query->setColumns(array(addslashes($key)));
		$query->setValues(array("'".addslashes($value)."'"));

		$dbHandler->query($query);


	}

	function _getField(&$id, $table, $key)
	{
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable($table);
		$query->addWhere("id='".addslashes($id->getIdString())."'");
		$query->addColumn(addslashes($key));
		$res=& $dbHandler->query($query);
		$row = $res->getCurrentRow();
		$ret=$row[$key];
		return $ret;
	}
    
} 

?>