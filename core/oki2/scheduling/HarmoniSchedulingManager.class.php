<?php 
 
require_once(OKI2."/osid/scheduling/SchedulingManager.php");

require_once(HARMONI."oki2/scheduling/HarmoniTimespan.class.php");
require_once(HARMONI."oki2/scheduling/HarmoniTimespanIterator.class.php");
require_once(HARMONI."oki2/scheduling/HarmoniAgentCommitment.class.php");
require_once(HARMONI."oki2/scheduling/HarmoniAgentCommitmentIterator.class.php");
require_once(HARMONI."oki2/scheduling/HarmoniScheduleItem.class.php");
require_once(HARMONI."oki2/scheduling/HarmoniScheduleItemIterator.class.php");

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
        
    	if($start>$end){
			throwError(new Error(SchedulingException::END_BEFORE_START(), "HarmoniSchedulingManager", true));
		}
    	
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		
		if(!isset($masterIdentifier)|| is_null($masterIdentifier)){
			$masterIdentifier = $id->getIdString();
		}
		

		$dbManager=& Services::getService("DBHandler");
		$query=& new InsertQuery;
		$query->setTable('sc_item');
		$query->setColumns(array('id','name','description','start','end','master_id'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes($displayName)."'";
		$values[]="'".addslashes($description)."'";
		$values[]="'".addslashes($start)."'";
		$values[]="'".addslashes($end)."'";
		$values[]="'".addslashes($masterIdentifier)."'";
		$query->addRowOfValues($values);

		$dbManager->query($query);
    	
    	$ret =& new HarmoniScheduleItem($id);
    	return $ret; 
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
	$dbHandler =& Services::getService("DBHandler");
	$query=& new DeleteQuery;
	$query->setTable('sc_item');
	$query->addWhere("id=".addslashes($scheduleItemId->getIdString()));
	$dbHandler->query($query); 
    } 

    /**
     * Get the Timespans during which all Agents are uncommitted.  
     * The time complexity may not be great on this one.
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
      	//get all schedule item rows with the appropriate time and agents
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_item');
		$query->addTable('sc_commit', INNER_JOIN, "sc_item.id=sc_commit.fk_sc_item");
		$query->addColumn('sc_item.id');
		
		$where = "(end >= '".addslashes($start)."'";
		$where .= " OR start <= '".addslashes($end)."') AND (";
		$firstElement =true;
		foreach($agents as $agentId){
			if(!$firstElement){			
				$where .= " OR ";
			}else{
			  	$firstElement=false;
			}
			
		
			$where .= ("sc_commit.fk_agent_id='".addslashes($agentId->getIdString())."'");
		}
		
		$where .= ")";
		$query->addOrderBy('sc_item.id');
		$query->addWhere($where);
		$res=& $dbHandler->query($query);

		//find times not conflictted by these items
		$array[$start] = new HarmoniTimeSpan($start,$end);
		$idManager =& Services::getService("IdManager");
		
		$lastId = "";
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();			
			$idString = $row['id'];
			if($lastId!=$idString){
				$id =& $idManager->getId($idString);
				$item =& $this->getScheduleItem($id);
				$array = $this->_restrict($array,$item);
				$lastId=$idString;
			}
		}
		
		ksort($array);
		
		$ret =& new  TimespanIterator($array);
		return $ret;
    } 
    
    /**
     * This helper function takes a ScheduleItem and 
     * and array of timespans and returns the array of 
     *timespans that donot conflict with the event, but
     * which contain as much of the original time as possible.
     **/
    function  &_restrict($arrayOfTimeSpans, $scheduleItem){
    	$start = $scheduleItem->getStart();
    	$end = $scheduleItem->getEnd();
    	foreach($arrayOfTimespans as $key ->$timespan){
    		$start2 = $timespan->getStart();
    		$end2 = $timespan->getEnd();
    		if($start>=$end2 || $end<=$start2){
    			$arrayOfTimeSpans2[$key]=$timespan;
    			continue;//do nothing.  the time intervals do not overlap.
    			//this actually should not happen if called from getAvailableTimes()
    		}
    		if ($end <= $end2){
    			
    			
    			if ($start >= $start2){//Item fully overlaps item
    				
    				//unset($arrayOfTimeSpans[$key]);
    			
    			
    			
    			}else{
    				$arrayOfTimeSpans2[$end]=new HarmoniTimespan($end,$end2);
    			
    			}
    			
    			
    		}else{
    			
    			if ($start >= $start2){
    			
    				$arrayOfTimeSpans2[$start2]=new HarmoniTimespan($start2,$start);
    			
    			
    			
    			}else{
    			
    				$arrayOfTimeSpans2[$start2]=new HarmoniTimespan($start2,$start);
    				$arrayOfTimeSpans2[$end]=new HarmoniTimespan($end,$end2);
    			
    			}
    			
    		}
    	
    	}
    	return $arrayOfTimeSpans2;
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
		$ret =& new HarmoniScheduleItem($scheduleItemId);
		return $ret;
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
        //get the index for the type
		$typeIndex = $this->_typeToIndex('item_stat',$courseType);

		//get all schedule item rows with the appropriate type
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');
		$where = "fk_sc_item_stat_type='".addslashes($typeIndex)."'";
		$where .= "AND (end >= ".addslashes($start)."'";
		$where .= "OR start <= ".addslashes($end)."')";
		$query->addWhere($where);
		//$query->addWhere("start <= ".addslashes($typeIndex)."'");
		//$query->addWhere("end >= ".addslashes($typeIndex)."'");
		$res=& $dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager =& Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$array[] =& $this->getScheduleItem($id);
		}
		
		//convert to an iterator
		$ret =& new  HarmoniScheduleItemIterator($array);
		return $ret;
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
         //get the index for the type
		$typeIndex = $this->_typeToIndex('item_stat',$courseType);

		//get all schedule item rows with the appropriate type
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');
		$where = "fk_sc_item_stat_type='".addslashes($typeIndex)."'";
		$where .= "AND (end >= ".addslashes($start)."'";
		$where .= "OR start <= ".addslashes($end)."') AND (";
		$firstElement =true;
		foreach($agents as $agent){
			if($firstElement){
				$firstElement=false;
				$where .= " OR ";
			}
			$id =& $agent->getId();
			$where .= ("'".addslashes($id->getIdString())."'=fk_agent_id");
		}
		
		$where .= ")";
		$query->addWhere($where);
		//$query->addWhere("start <= ".addslashes($typeIndex)."'");
		//$query->addWhere("end >= ".addslashes($typeIndex)."'");
		$res=& $dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager =& Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$array[] =& $this->getScheduleItem($id);
		}
		
		//convert to an iterator
		$ret =& new  HarmoniScheduleItemIterator($array);
		return $ret;
       
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
       //get the index for the type
		$typeIndex = $this->_typeToIndex('item_stat',$courseType);

		//get all schedule item rows with the appropriate type
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');
		$where = "master_id='".addslashes($masterIdentifier)."'";
		$res=& $dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager =& Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$array[] =& $this->getScheduleItem($id);
		}
		
		//convert to an iterator
		$ret =& new  HarmoniScheduleItemIterator($array);
		return $ret;
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
        return $this->_getTypes('item_stat');
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
         return $this->_getTypes('item_stat');
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