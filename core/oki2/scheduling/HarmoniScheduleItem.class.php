<?php 
 
 
require_once(OKI2."/osid/scheduling/ScheduleItem.php");

/**
 * ScheduleItem contains a set of AgentCommitments (e.g. calendar events) as
 * well as the creator of the ScheduleItem and some date information.
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
class HarmoniScheduleItem
extends ScheduleItem
{
	
	
	
	
	
	
	/**
	 * @variable object $_id the unique id for this ScheduleItem.
	 * @access private
	 * @variable object $_table the ScheduleItem table.
	 * @access private
	 **/
	var $_id;
	var $_table;
	
	/**
	 * The constructor.
	 * 
	 * @param object Id $id
	 * 
	 * @access public
	 * @return void
	 */
	function HarmoniScheduleItem(&$id)
	{
		
		
		
		$this->_id =& $id;
		$this->_table = 'sc_item';
		
	}
	
	
	
    /**
     * Update the DisplayName of this ScheduleItem.
     * 
     * @param string $displayName
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
    function updateDisplayName ( $displayName ) { 
       	$this->setField('name', $displayName);
    } 

    /**
     * Get the description of this ScheduleItem.
     * 
     * @param string $description
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
    function updateDescription ( $description ) { 
        $this->setField('description', $description);
    } 

    /**
     * Update the Start for this ScheduleItem.
     * 
     * @param int $start
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
    function updateStart ( $start ) { 
       $this->setField('start', $start);
    } 

    /**
     * Update the End for this ScheduleItem.
     * 
     * @param int $end
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
    function updateEnd ( $end ) { 
        $this->setField('end', $end);
    } 

    /**
     * Update the Status Type for this ScheduleItem.
     * 
     * @param object Type $status
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
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function updateStatus ( &$status ) { 
       $this->setType('item_stat', $description);
    } 

    /**
     * Get the unique Id for this ScheduleItem.  The unique Id is set when the
     * ScheduleItem is created.
     *  
     * @return object Id
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
    function &getId () { 
        return $this->_id;
    } 

    /**
     * Get the DisplayName of this ScheduleItem.
     *  
     * @return string
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
    function getDisplayName () { 
       return $this->_getField('name');
    } 

    /**
     * Get the description of this ScheduleItem.
     *  
     * @return string
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
    function getDescription () { 
        return $this->_getField('description');
    } 

    /**
     * Get the unique Id of the Agent that created this ScheduleItem.
     *
     *  
     * @return object Id
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
    function &getCreator () { 
        throwError(new Error(SchedulingExeption::UNIMPLEMENTED(), "Scheduling", true));
    } 

    /**
     * Get the Start for this ScheduleItem.
     *  
     * @return int
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
    function getStart () { 
        return $this->_getField('start');
    } 

    /**
     * Get the End for this ScheduleItem.
     *  
     * @return int
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
    function getEnd () { 
       return $this->_getField('end');
    } 

    /**
     * Get the Status Type for this ScheduleItem.
     *  
     * @return object Type
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
    function &getStatus () { 
        return $this->_getType('item_stat');
    } 

    /**
     * Get the Master Identifier for this ScheduleItem.  A Master Identifier is
     * a key, rule, or function that can be used to associated more than one
     * ScheduleItem together.  An example can be recurring items where each
     * recurring item has the same Master Identifier.
     *  
     * @return string
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
    function getMasterIdentifier () { 
         return $this->_getField('masterid');
    } 

    /**
     * Get all the Property Types for  ScheduleItem.
     *  
     * @return object TypeIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:  {@link
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
    function &getPropertyTypes () { 
        $type =& $this->getStatus();
		$propertiesType =& new Type($type->getDomain(), $type->getAuthority(), "properties");
		$array = array($propertiesType);
		$typeIterator =& new HarmoniTypeIterator($array);
		return $typeIterator;
    } 

    /**
     * Get all the Agent commitments for this ScheduleItem.
     *  
     * @return object AgentCommitmentIterator
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
    function &getAgentCommitments () { 
        $dbHandler =& Services::getService("DBHandler");

		$array=array();

	

			$query=& new SelectQuery;
			$query->setTable('sc_commit');
			$query->addColumn('id');
			$query->addWhere("fk_sc_item='".addslashes($this->_id->getIdString())."'");


			$res=& $dbHandler->query($query);
			$idManager =& Services::getService("id");
			while($res->hasMoreRows()){
				$row =& $res->getCurrentRow();
				$res->advanceRow();
				
				$array[] =& new HarmoniAgentCommitment($idManager->getId($row['id']));
			}
		$ret =& new HarmoniAgentCommitmentIterator($array);
		return $ret;
    } 

    /**
     * Change a previously added Agent commitment for this ScheduleItem.
     * 
     * @param object Id $agentId
     * @param object Type $agentStatus
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
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function changeAgentCommitment ( &$agentId, &$agentStatus ) { 
        $typeIndex = $this->_typeToIndex('commit_stat',$agentStatus);
		
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;
		$query->setTable('sc_commit');

		
		
		$query->addWhere("fk_sc_item='".addslashes($this->_id->getIdString())."'");
		$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");
		
		$query->setColumns(array('fk_sc_commit_stat_type'));
		$query->setValues(array("'".addslashes($typeIndex)."'"));

		$dbHandler->query($query);
    } 

    /**
     * Add an Agent commitment to this ScheduleItem.
     * 
     * @param object Id $agentId
     * @param object Type $agentStatus
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
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.shared.SharedException#ALREADY_ADDED ALREADY_ADDED}
     * 
     * @access public
     */
    function addAgentCommitment ( &$agentId, &$agentStatus ) { 
        
    	
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('sc_commit');
		$query->addWhere("fk_sc_item='".addslashes($this->_id->getIdString())."'");
		$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");
		//$query->addColumn('id');
		$res=& $dbHandler->query($query);
		if($res->getNumberOfRows()==0){
			$typeIndex = $this->_typeToIndex('commit_stat',$agentStatus);
			
			$query=& new InsertQuery;
			$query->setTable('sc_commit');
			$values[]="'".addslashes($agentId->getIdString())."'";
			$values[]="'".addslashes($typeIndex)."'";
			$values[]="'".addslashes($this->_id->getIdString())."'";
			$query->setColumns(array('fk_agent_id','fk_sc_commit_stat_type','fk_sc_item'));
			$query->addRowOfValues($values);
			$query->setAutoIncrementColumn('id','id_sequence');
			$dbHandler->query($query);		
		}else{
			print "<b>Warning!</b> Agent with id ".$agentId->getIdString()."is already added to ScheduleItem ".$this->getDisplayName().".  Use changeAgentCommitment() to change the commitment status.";
		}
			
    	
    	
    } 
    
    
        /**
     * Delete a previously added Agent commitment for this ScheduleItem.
     * 
     * <b>Warning!</b> Not in the OSID.  Use at your own risk.
     *  
     * @param object Id $agentId
     * @param object Type $agentStatus
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
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function removeAgentCommitment ( &$agentId) { 
      
		$dbHandler =& Services::getService("DBHandler");
		$query=& new DeleteQuery;


		$query->addTable('sc_commit');
		$query->addWhere("fk_sc_item='".addslashes($this->_id->getIdString())."'");
		$query->addWhere("fk_student_id='".addslashes($agentId->getIdString())."'");
		
		$dbHandler->query($query);
    } 
    

    /**
     * Get the Properties of this Type associated with this ScheduleItem.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:  {@link
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
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
    	$type =& $this->getStatus();
		$propertiesType =& new Type($type->getDomain(), $type->getAuthority(), "properties");	
		if($propertiesType->isEqualTo($propertiesType)){
			return $this->_getProperties();
		}
		return null;
       
    } 

    /**
     * Get the Properties associated with this ScheduleItem.
     *  
     * @return object PropertiesIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:  {@link
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
    function &getProperties () { 
    	$array = array($this->_getProperties());
         $ret = new PropertiesIterator($array);		
		return $ret;//return the iterator
    } 
    
    
    function &_getProperties(){
		
		$dbHandler =& Services::getService("DBHandler");
		
		//get the record
		$query =& new SelectQuery();
		$query->addTable('sc_item');
		$query->addColumn("*");
		$query->addWhere("id='".addslashes($this->_id)."'");				
		$res=& $dbHandler->query($query);
		
		//make a type
		$type =& $this->getStatus();
		$propertiesType =& new Type($type->getDomain(), $type->getAuthority(), "properties");	
		
		//make sure we can find that course
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of ScheduleItem with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row		
		$property =& new HarmoniProperties($propertiesType);
				
		//create a custom Properties object
		
		$property->addProperty('display_name', $this->getDisplayName());
		$property->addProperty('description', $this->getDescription());	
		$property->addProperty('id', $row['id']);		
		$property->addProperty('start', $row['start']);
		$property->addProperty('end', $row['end']);		
		$property->addProperty('master_identifier', $row['master_id']);
		$property->addProperty('status_type', $type->getKeyword());

		
		$res->free();	
		return $property;
		
		
	}
	
    
    
    
    // function &getStatus () { 
    //    return $this->_getType('commit_stat');
    //} 
    
    function _typeToIndex($typename, &$type)
	{	
		$sc=Services::getService("Scheduling");
		return $sc->_typeToIndex($typename, $type);
	}
	
	function &_getTypes($typename)
	{	
		$sc=Services::getService("Scheduling");
		return $sc->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$sc=Services::getService("Scheduling");
		return $sc->_getField($this->_id,$this->_table,$key);
	}
	
	
	function &_getType($typename){
		$sc=Services::getService("Scheduling");
		return $sc->_getType($this->_id,$this->_table,$typename);
	}
	
	function _setField($key, $value)
	{
		$sc=Services::getService("Scheduling");
		return $sc->_setField($this->_id,$this->_table,$key, $value);		
	}
    
    
    
    
}

?>