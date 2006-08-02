<?php 
 
require_once(OKI2."/osid/grading/GradeRecord.php");

/**
 * GradeRecord includes a reference to a gradable object, an Agent Id, a Grade,
 * and GradeType.
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
 * @package org.osid.grading
 */
class HarmoniGradeRecord
extends GradeRecord
{
	
	
	/**
	 * @variable object $_id the unique id for this GradeRecord.
	 * @access private
	 * @variable object $_table the GradeRecord table.
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
	function HarmoniGradeRecord(&$id)
	{
		$this->_id =& $id;
		$this->_table = 'gr_record';
		
	}
	
	
    /**
     * Update the value for this Grade.
     * 
     * @param object mixed $gradeValue (original type: java.io.Serializable)
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function updateGradeValue ( &$gradeValue ) { 
        $this->_setField("value",$gradeValue);
        $this->_setModifiedDateAndAgent();
    } 

    /**
     * Get the unique Id for this GradeRecord's GradableObject.
     *  
     * @return object Id
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getGradableObject () {       
    	$idManager =& Services::getService("Id");
    	$idString = $this->_getField("fk_gr_gradable");
    	return $idManager->getId($idString);  	
    } 

    /**
     * Get the Agent Id associated with this GradeRecord.  The Agent in this
     * context is not the person who took the test nor, necessarily, the
     * person who is grading.  It is the person whose "GradeBook" this is, for
     * example the CourseSection instructor.
     *  
     * @return object Id
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getAgentId () { 
    	$idManager =& Services::getService("Id");
    	$idString = $this->_getField("fk_agent_id");	
    	return $idManager->getId($idString);  ; 
    } 

    /**
     * Get the value for this Grade.
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getGradeValue () { 
        $ret = $this->_getField("value");
         return $ret;
    } 

    /**
     * Get the Id of the Agent who modified this GradeRecord.
     *  
     * @return object Id
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getModifiedBy () { 
         $agentId =& $this->_getField("fk_modified_by_agent");
    	if(""==$agentId){
    		return null;	
    	}   	 
    	$idManager =& Services::getService("Id"); 
    	return $idManager->getId($agentId);  
    } 

    /**
     * Get the date when this GradeRecord was modified, using the UNIX timestamp.
     *  
     * @return long
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function getModifiedDate () { 
        return $this->_getField("modified_date");
    } 

    /**
     * Get the GradeRecordType for this GradeRecord.  This is the Type of the
     * GradeRecord, which is distinct from the Type of Grade.  A GradeRecord
     * Type might be advisory, mid-term, final, etc, while a Grade Type might
     * be letter, numeric, etc.
     *  
     * @return object Type
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getGradeRecordType () { 
        return $this->_getType("record");
    } 

    /**
     * Get the GradeType associated with the GradableObject and Grade.
     *  
     * @return object Type
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getGradeType () {
    	 $grManager =& Services::getService("Grading");
    	$id =&  $this->getGradableObject();
    	$gradableObject =& $grManager->getGradableObject($id);  	
        return $gradableObject->getGradeType();
    } 

    /**
     * Get all the Property Types for  GradeRecord.
     *  
     * @return object TypeIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getPropertyTypes () { 
        $type =& $this->getGradeRecordType();
		$propertiesType =& new Type("PropertiesType", $type->getAuthority(), "properties"); 	
		$array = array($propertiesType);
		$typeIterator =& new HarmoniTypeIterator($array);
		return $typeIterator;
    } 

    /**
     * Get the Properties of this Type associated with this GradeRecord.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.grading.GradingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.grading.GradingException#UNKNOWN_TYPE UNKNOWN_TYPE}
     * 
     * @access public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
        $type =& $this->getGradeRecordType();
		$propType =& new Type("PropertiesType", $type->getAuthority(), "properties"); 		
		if($propertiesType->isEqualTo($propType)){
			return $this->_getProperties();
		}
		return null;
    } 

    /**
     * Get the Properties associated with this GradeRecord.
     *  
     * @return object PropertiesIterator
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:  {@link
     *         org.osid.grading.GradingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.grading.GradingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.grading.GradingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.grading.GradingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getProperties () { 
         $array = array($this->_getProperties());
		$ret = new HarmoniPropertiesIterator($array);		
		return $ret;//return the iterator
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
		$dbManager =& Services::getService("DatabaseManager");
		$query =& new SelectQuery();
		$query->addTable('gr_record');
		$query->addColumn("*");
		$query->addWhere("id='".addslashes($this->_id->getIdString())."'");				
		$res=& $dbManager->query($query);
		
		

		
		//make sure we can find that record
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of GradeRecord with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row		
		
		//make a type
		$type =& $this->getGradeRecordType();
		$propertiesType =& new Type("PropertiesType", $type->getAuthority(), "properties"); 
		
	
		
		//create a custom Properties object		
		$idManager =& Services::getService("Id");
		$property =& new HarmoniProperties($propertiesType);
		$property->addProperty('id', $this->_id);
		$property->addProperty('value', $row['value']);
		$property->addProperty('gradable_object_id', $idManager->getId($row['fk_gr_gradable']));
		$property->addProperty('agent_id', $idManager->getId($row['fk_agent_id']));
		$property->addProperty('modified_by_agent_id', $idManager->getId($row['fk_modified_by_agent']));
		$property->addProperty('modified_date', $row['modified_date']);
		$recordType =& $this->getGradeRecordType();
		$property->addProperty('type', $recordType);
	
		$res->free();	
		return $property;
		
		
	}
	
		
	function _setModifiedDateAndAgent(){
		$this->_setField('modified_date',time()*1000);	
		//@TODO use the timestamp feature in SQL?
		
		//try to get the creator of this ScheduleItem
		$authN =& Services::getService("AuthN");
		$authNTypesIterator =& $authN->getAuthenticationTypes();
		if($authNTypesIterator->hasNextType()){
			$authNType1 =& $authNTypesIterator->nextType();
			//hopefully the first one is the right one to choose.
			$creatorId =& $authN->getUserId($authNType1);
			$creatorIdString = $creatorId->getIdString();
		}else{
			$creatorIdString = "";
		}
		$this->_setField('fk_modified_by_agent',$creatorIdString);

		
	}
    
    
     function _typeToIndex($typename, &$type)
	{	
		$gm=Services::getService("Grading");
		return $gm->_typeToIndex($typename, $type);
	}
	
	function &_getTypes($typename)
	{	
		$gm=Services::getService("Grading");
		return $gm->_getTypes($typename);
	}
	
	function _getField($key)
	{
		$gm=Services::getService("Grading");
		return $gm->_getField($this->_id,$this->_table,$key);
	}
	
	
	function &_getType($typename){
		$gm=Services::getService("Grading");
		return $gm->_getType($this->_id,$this->_table,$typename);
	}
	
	function _setField($key, $value)
	{
		$gm=Services::getService("Grading");
		return $gm->_setField($this->_id,$this->_table,$key, $value);		
	}
    
    
    
}

?>