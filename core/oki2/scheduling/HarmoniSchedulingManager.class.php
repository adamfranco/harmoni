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
	implements SchedulingManager
{





	/**
	* @variable object OsidContext $_osidContext the OSID context.
	* @access private
	* @variable string $_defaultAuthority the default authority for default types.
	* @access private
	**/
	var $_osidContext;
	var $_defaultAuthority;




	function HarmoniSchedulingManager () {


	}



	/**
	* Assign the configuration of this Manager. There are no valid configuration options for
	* this manager.
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
	function assignConfiguration ( Properties $configuration ) {
		$def = $configuration->getProperty('default_authority');


		// ** parameter validation
		ArgumentValidator::validate($def, StringValidatorRule::getRule(), true);
		// ** end of parameter validation

		$this->_defaultAuthority =$def;
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
	function getOsidContext () {
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
	function assignOsidContext ( OsidContext $context ) {
		$this->_osidContext =$context;
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
     * @param object array $agents
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
    public function createScheduleItem ( $displayName, $description, array $agents, $start, $end, $masterIdentifier ) {
		throw new UnimplmentedException;
	}
	/**
	* WARNING: NOT IN OSID -- This method is designed to comply with V3 of the OSIDs, at least
	* How Tom suggested they were headed 
	* <a href="http://okicommunity.mit.edu/forum/viewtopic.php?forum=1&showtopic=67&show=10&page=2">
	* here </a>.  Leave out the agent parameter, and add a statusType instead.
	*
	* Create a ScheduleItem.  The masterIdentifier argument is optional--it
	* can be set to null.  If master identifier is passed in as null, then the
	* id string will be used.  Master Identifier is a key, rule, or function that can be used to
	* associated more than one ScheduleItem together.  An example can be
	* recurring items where each recurring item has the same Master
	* Identifier.   An unique Id is generated for this ScheduleItem by the
	* implementation.
	*
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
	function v3_createScheduleItem ( $displayName, $description, Type $scheduleItemStatusType, $start, $end, $masterIdentifier = null ) {

		if($start>$end){
			throwError(new HarmoniError("The end of a ScheduleItem cannot come before the end", "HarmoniSchedulingManager", true));
		}

		$idManager = Services::getService("IdManager");
		$id=$idManager->createId();



		//try to get the creator of this ScheduleItem
		$authN = Services::getService("AuthN");
		$authNTypesIterator =$authN->getAuthenticationTypes();
		if($authNTypesIterator->hasNext()){
			$authNType1 =$authNTypesIterator->next();
			//hopefully the first one is the right one to choose.
			$creatorId =$authN->getUserId($authNType1);
			$creatorIdString = $creatorId->getIdString();
		}else{
			$creatorIdString = "";
		}


		if(func_num_args()<6 || is_null($masterIdentifier)){
			$masterIdentifier = $id->getIdString();
		}

		//set up a default item status type
		$defType = new Type("ScheduleItemStatusType",$this->_defaultAuthority,"default");
		$defIndex = $this->_typeToIndex('item_stat',$defType);

		//set up the query
		$dbManager= Services::getService("DBHandler");
		$query= new InsertQuery;
		$query->setTable('sc_item');
		$query->setColumns(array('id','name','description','start_date','end_date','fk_sc_item_stat_type','master_id','fk_creator_id'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes($displayName)."'";
		$values[]="'".addslashes($description)."'";
		$values[]="'".addslashes(intval($start))."'";
		$values[]="'".addslashes(intval($end))."'";
		$values[]="'".$this->_typeToIndex('item_stat',$scheduleItemStatusType)."'";
		$values[]="'".addslashes($masterIdentifier)."'";
		$values[]="'".addslashes($creatorIdString)."'";
		$query->addRowOfValues($values);

		$dbManager->query($query);

		$ret = new HarmoniScheduleItem($id);

	

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
	function deleteScheduleItem ( Id $scheduleItemId ) {
		$dbHandler = Services::getService("DBHandler");
		$query= new DeleteQuery;
		$query->setTable('sc_item');
		$query->addWhere("id=".addslashes($scheduleItemId->getIdString()));
		$dbHandler->query($query);
		$query2= new DeleteQuery;
		$query2->setTable('sc_commit');
		$query2->addWhere("fk_sc_item=".addslashes($scheduleItemId->getIdString()));
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
	function getAvailableTimes ( array $agents, $start, $end ) {
		
		if(count($agents)==0){
			$array[] = new HarmoniTimespan($start,$end);
			$ret = new  HarmoniTimespanIterator($array);
			return $ret;
		}
		
		//get all schedule item rows with the appropriate time and agents
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_item');
		$query->addTable('sc_commit', INNER_JOIN, "sc_item.id=sc_commit.fk_sc_item");
		$query->addColumn('sc_item.id');

		$where = "(end_date >= '".addslashes($start)."'";
		$where .= " OR start_date <= '".addslashes($end)."') AND (";
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
		$res=$dbHandler->query($query);

		//find times not conflicted by these items
		//yes I know $mister11 is a terible name for the variable.  Deal with it :-P.
		//We'll
		$availableTimes = array();
		$availableTimes[$start] = new HarmoniTimeSpan($start,$end);



		//print_r($thearray);

		$idManager = Services::getService("IdManager");

		$lastId = "";
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$idString = $row['id'];
			if($lastId!=$idString){
				$id =$idManager->getId($idString);
				$item =$this->getScheduleItem($id);

				$availableTimes = $this->_restrict($item,  $availableTimes);
				$lastId=$idString;
			}
		}
		//print_r($thearray);
		//ksort($thearray);

		$ret = new  HarmoniTimespanIterator($availableTimes);
		return $ret;
	}

	/**
	* This helper function takes a ScheduleItem and
	* and array of timespans and returns the array of
	*timespans that donot conflict with the event, but
	* which contain as much of the original time as possible.
	**/
	function  _restrict($scheduleItem, $mister11){
		//print "in";
		$start = $scheduleItem->getStart();
		$end = $scheduleItem->getEnd();

		$arrayOfTimeSpans2 =array();

		foreach(array_keys($mister11) as $key){
			$timespan =$mister11[$key];
			$start2 = $timespan->getStart();
			$end2 = $timespan->getEnd();
			if($start>=$end2 || $end<=$start2){
				$arrayOfTimeSpans2[$key]=$timespan;
				continue;//do nothing.  the time intervals do not overlap.
				//this actually should not happen if called from getAvailableTimes()
			}	
			if ($end2 <= $end){			
				if ($start2 >= $start){//Item fully overlaps item
					//do nothing
				}else{
					$arrayOfTimeSpans2[$end] = new HarmoniTimespan($start2,$start);
				}
			}else{
	
				if ($start2 >= $start){
	
					$arrayOfTimeSpans2[$start2] = new HarmoniTimespan($end,$end2);
				}else{
					$arrayOfTimeSpans2[$start2] = new HarmoniTimespan($start2,$start);
					$arrayOfTimeSpans2[$end] = new HarmoniTimespan($end,$end2);
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
	function getScheduleItem ( Id $scheduleItemId ) {
		$ret = new HarmoniScheduleItem($scheduleItemId);
		return $ret;
	}

	/**
	* Get all the ScheduleItems for any Agent, with the specified Item Status
	* and that start or end between the start and end specified, inclusive.
	*
	* Null will select all types of ScheduleItems
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
	function getScheduleItems ( $start, $end, Type $status ) {

		//get all schedule item rows with the appropriate type
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');


		$query->addWhere("end_date >= '".addslashes($start)."'");
		$query->addWhere("start_date <= '".addslashes($end)."'");

		if(!is_null($status)){
			//get the index for the type
			$typeIndex = $this->_typeToIndex('item_stat',$status);
			$query->addWhereEqual("fk_sc_item_stat_type", $typeIndex);
		}
		/*
		$where = "(end_date >= '".addslashes($start)."'";
		$where .= " OR start_date <= '".addslashes($end)."')";
		if(!is_null($status)){
		//get the index for the type
		$typeIndex = $this->_typeToIndex('item_stat',$status);
		$where .= " AND fk_sc_item_stat_type='".addslashes($typeIndex)."'";
		}
		$query->addWhere($where);*/
		//$query->addWhere("start_date <= ".addslashes($typeIndex)."'");
		//$query->addWhere("end_date >= ".addslashes($typeIndex)."'");
		$res=$dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager = Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =$idManager->getId($row['id']);
			$array[] =$this->getScheduleItem($id);
		}

		//convert to an iterator
		$ret = new  HarmoniScheduleItemIterator($array);
		return $ret;
	}

	/**
	* Get all the ScheduleItems for the specified Agents, with the specified
	* Item Status and that start or end between the start and end specified,
	* inclusive.
	*
	* Null will select all types of ScheduleItems
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
	function getScheduleItemsForAgents ( $start, $end, Type $status, array $agents ) {


		if(count($agents)==0){
			$array =array();
			$ret = new HarmoniScheduleItemIterator($array);
			return $ret;
		}

		$scheduleItems =$this->getScheduleItems($start,$end,$status);



		$array =array();

		while($scheduleItems->hasNextScheduleItem()){
			$scheduleItem =$scheduleItems->nextScheduleItem();


			$dbHandler = Services::getService("DBHandler");
			$query= new SelectQuery;
			$query->addTable('sc_commit');
			$query->addColumn('id');//@TODO switch this to just a count


			$where = "fk_sc_item='".$scheduleItem->_id->getIdString()."' AND (";
			$firstElement =true;

			foreach($agents as $agentId){


				if(!$firstElement){
					$where .= "OR ";
				}else{
					$firstElement=false;
				}
				$where .= "'".addslashes($agentId->getIdString())."'=fk_agent_id ";
			}

			$where .= ")";
			$query->addWhere($where);

			$res=$dbHandler->query($query);

			if($res->getNumberOfRows()>0){
				$array[] =  $scheduleItem;
			}

		}



		//convert to an iterator
		$ret = new  HarmoniScheduleItemIterator($array);
		return $ret;

		/*
		//get all schedule item rows with the appropriate type
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');

		$where = "(end_date >= '".addslashes($start)."'";
		$where .= " OR start_date <= '".addslashes($end)."')";
		if(!is_null($status)){
		//get the index for the type
		$typeIndex = $this->_typeToIndex('item_stat',$status);
		$where .= " AND fk_sc_item_stat_type = '".addslashes($typeIndex)."'";
		}
		$where .= " AND (";
		//$where = "fk_sc_item_stat_type='".addslashes($typeIndex)."'";
		//$where .= "AND (end_date >= ".addslashes($start)."'";
		//$where .= "OR start_date <= ".addslashes($end)."') AND (";
		$firstElement =true;
		foreach($agents as $agent){
		if(!$firstElement){
		$where .= "OR ";
		}else{
		$firstElement=false;
		}
		$id =$agent->getId();
		$where .= "'".addslashes($id->getIdString())."'=fk_agent_id ";
		}

		$where .= ")";
		$query->addWhere($where);
		//$query->addWhere("start_date <= ".addslashes($typeIndex)."'");
		//$query->addWhere("end_date >= ".addslashes($typeIndex)."'");
		$res=$dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager = Services::getService("IdManager");
		while($res->hasMoreRows()){
		$row = $res->getCurrentRow();
		$res->advanceRow();
		$id =$idManager->getId($row['id']);
		$array[] =$this->getScheduleItem($id);
		}

		//convert to an iterator
		$ret = new  HarmoniScheduleItemIterator($array);
		return $ret;

		*/

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
	function getScheduleItemsByMasterId ( $masterIdentifier ) {
		;

		//get all schedule item rows with the appropriate type
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_item');
		$query->addColumn('id');
		$query->addWhereEqual("master_id", $masterIdentifier);
		$res=$dbHandler->query($query);

		//convert results to array of ScheduleItems
		$array = array();
		$idManager = Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =$idManager->getId($row['id']);
			$array[] =$this->getScheduleItem($id);
		}

		//convert to an iterator
		$ret = new  HarmoniScheduleItemIterator($array);
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
	function getItemStatusTypes () {
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
	function getItemCommitmentStatusTypes () {
		return $this->getCommitmentStatusTypes();
	}

	/**
	* Get the Status Types for Agents' Commitment supported by the
	* implementation.
	*
	* Warning: not in OSID
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
	function getCommitmentStatusTypes () {
		return $this->_getTypes('commit_stat');
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
	function _getTypes($typename){

		//query
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=$dbHandler->query($query);

		//iterate through results and add to an array
		$array=array();
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			if(is_null($row['description'])){
				$the_type = new Type($row['domain'],$row['authority'],$row['keyword']);
			}else{
				$the_type = new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
			}
			$array[] = $the_type;
		}

		//convert to an iterator
		$ret = new HarmoniTypeIterator($array);
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
	function _getType($id, $table, $typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		//get the index for the type
		$index = $this->_getField($id,$table,"fk_sc_".$typename."_type");

		
		return $this->_indexToType($index,$typename);

	}
	
	
	/**
	* For get the Type with type $typename with id $index
	*
	* @param string $index the index of the type
	* @param string $typename the type of Type to get
	*
	* @return object Type
	*
	* @access private
	*/
	function _indexToType($index, $typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		//query
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addWhere("id=".$index);
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=$dbHandler->query($query);


		if(!$res->hasMoreRows()){
			throwError(new HarmoniError("No Type has Id '".$index."' in table 'sc_".$typename."_type'","CourseManagement", true));
		}

		//There should be exactly one result.  Convert it to a type and return it
		//remember that the description is optional
		$row = $res->getCurrentRow();
		if(is_null($row['description'])){
			$the_type = new Type($row['domain'],$row['authority'],$row['keyword']);
		}else{
			$the_type = new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
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
	function _typeToIndex($typename, $type){
		//the appropriate table names and fields must be given names according to the pattern indicated below


		//validate the Type
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"), true);



		//query to see if it exists
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable('sc_'.$typename."_type");
		$query->addWhereEqual("domain", $type->getDomain());
		$query->addWhereEqual("authority", $type->getAuthority());
		$query->addWhereEqual("keyword", $type->getKeyword());
		$query->addColumn('id');
		$res=$dbHandler->query($query);



		if($res->getNumberOfRows()==0){
			//if not query to create it
			$query= new InsertQuery;
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
			$query->setAutoIncrementColumn('id','sc_'.$typename.'_type_id_seq');


			$result =$dbHandler->query($query);

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
	function _setField($id, $table, $key, $value)
	{
		//just an update query
		$dbHandler = Services::getService("DBHandler");
		$query= new UpdateQuery;
		$query->setTable($table);
		$query->addWhereEqual("id", $id->getIdString());
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
	function _getField($id, $table, $key)
	{

		//just a select query
		$dbHandler = Services::getService("DBHandler");
		$query= new SelectQuery;
		$query->addTable($table);
		$query->addWhereEqual("id", $id->getIdString());
		$query->addColumn(addslashes($key));
		$res=$dbHandler->query($query);
		$row = $res->getCurrentRow();
		$ret=$row[$key];
		return $ret;
	}
	
	/**
     * Verify to OsidLoader that it is loading
     * 
     * <p>
     * OSID Version: 2.0
     * </p>
     * .
     * 
     * @throws object OsidException 
     * 
     * @access public
     */
    public function osidVersion_2_0 () {}

}

?>