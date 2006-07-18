<?php 
 
require_once(OKI2."/osid/grading/GradableObject.php");


/**
 * GradableObject includes a Name, Description, Id, GradeType, CourseSection
 * reference, and External Reference to what is being graded.
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
class HarmoniGradableObject
extends GradableObject
{
	
	
	
	
	/**
	 * @variable object $_id the unique id for this GradableObject.
	 * @access private
	 * @variable object $_table the GradableObject table.
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
	function HarmoniGradableObject(&$id)
	{
		$this->_id =& $id;
		$this->_table = 'gr_gradable';
		
	}
	
	
	
	
	
	
    /**
     * Update the display name for this Assignment.
     * 
     * @param string $displayName
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
    function updateDisplayName ( $displayName ) { 
       $this->_setField("name",$displayName);
       $this->_setModifiedDateAndAgent();
    } 

    /**
     * Update the description for this GradableObject.
     * 
     * @param string $description
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
    function updateDescription ( $description ) { 
        $this->_setField("description",$description);
        $this->_setModifiedDateAndAgent();
    } 

    /**
     * Get the display name for this GradableObject.
     *  
     * @return string
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
    function getDisplayName () { 
    	return $this->_getField("name");
    } 

    /**
     * Get the description for this GradableObject.
     *  
     * @return string
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
    function getDescription () { 
         return $this->_getField("description");
    } 

    /**
     * Get the unique Id for this GradableObject.
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
    function &getId () { 
       return $this->_id;
    } 

    /**
     * Get the unique Id with a CourseSection. CourseSections are created and
     * managed through the CourseManagement OSID.
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
    function &getCourseSection () { 
    	$cm =& Services::getService("CourseManagement");
    	$idManager =& Services::getService("Id");
    	$idString = $this->_getField("fk_cm_section");
    	$id =& $idManager->getId($idString);  	
    	return $cm->getCourseSection($id);  	
    } 

    /**
     * Get the unique Id associated with some object that is being graded such
     * as an Assessment.
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
    function &getExternalReference () { 
    	$externalId =& $this->_getField("fk_reference_id");
    	if(is_null($externalId)){
    		return null;	
    	}   	 
    	$idManager =& Services::getService("Id"); 
    	return $idManager->getId($externalId);   	 
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
        return  $this->_getType("grade");
    } 

    /**
     * Get the ScoringDefinition associated with the GradableObject and Grade.
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
    function &getScoringDefinition () { 
       return  $this->_getType("scoring");
    } 

    /**
     * Get the GradeScale associated with the GradableObject and Grade.
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
    function &getGradeScale () { 
       return  $this->_getType("gradescale"); 
    } 

    /**
     * Get the gradeWeight of this GradableObject.
     *  
     * @return int
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
    function getGradeWeight () { 
        return $this->getField("weight");
    } 

    /**
     * Get the Properties of this Type associated with this GradableObject.
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
        $type =& $this->getGradeType();
		$propType =& new Type($type->getDomain(), $type->getAuthority(), "properties"); 		
		if($propertiesType->isEqualTo($propType)){
			return $this->_getProperties();
		}
		return null;
    } 

    /**
     * Get the Properties Types supported by this GradableObject.
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
        $type =& $this->getGradeType();
		$propertiesType =& new Type($type->getDomain(), $type->getAuthority(), "properties");
		$array = array($propertiesType);
		$typeIterator =& new HarmoniTypeIterator($array);
		return $typeIterator;
    } 

    /**
     * Get the Properties associated with this GradableObject.
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
		$ret = new PropertiesIterator($array);		
		return $ret;//return the iterator
    } 

    /**
     * Get the Id of the Agent who modified this GradableObject.
     *  
     * @return object Id
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:   {@link
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
    	if(is_null($agentId)){
    		return null;	
    	}   	 
    	$idManager =& Services::getService("Id"); 
    	return $idManager->getId($agentId);  
    } 

    /**
     * Get the date when this GradableObject was modified.
     *  
     * @return int
     * 
     * @throws object GradingException An exception with one of the
     *         following messages defined in org.osid.grading.GradingException
     *         may be thrown:   {@link
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
	* Get a Properties object with the information about this object.
	*
	* @return object Properties
	*
	* @access private
	*/
	function &_getProperties(){
		
		
		//get the record
		$query =& new SelectQuery();
		$query->addTable('gr_gradable');
		$query->addColumn("*");
		$query->addWhere("id='".addslashes($this->_id->getIdString())."'");				
		$res=& $dbManager->query($query);
		
		

		
		//make sure we can find that record
		if(!$res->hasMoreRows()){
			print "<b>Warning!</b>  Can't get Properties of GradableObject with id ".$this->_id." since that id wasn't found in the database.";
			return null;	
		}
		$row = $res->getCurrentRow();//grab (hopefully) the only row		
		
		//make a type
		$type =& $this->getRecordType();
		$propertiesType =& new Type($type->getDomain(), $type->getAuthority(), "properties"); 
		
	
		
		//create a custom Properties object		
		$idManager =& Services::getService("Id");
		$property =& new HarmoniProperties($propertiesType);
		$property->addProperty('id', $row['id']);
		$scoringType =& $this->getScoringDefinition();
		$property->addProperty('scoring_type', $scoringType->getKeyword());
		$gradeType =& $this->getGradeType();
		$property->addProperty('grade_type', $gradeType->getKeyword());
		$gradeScale =& $this->getGradeScale();
		$property->addProperty('grade_scale', $gradeScale->getKeyword());		
		$property->addProperty('description', $row['description']);
		$property->addProperty('display_name', $row['name']);
		$property->addProperty('modified_date', $row['modified_date']);
		$property->addProperty('modified_by_agent_id', $idManager->getId($row['fk_modified_by_agent']));
		$property->addProperty('reference_id', $idManager->getId($row['fk_reference_id']));
		$property->addProperty('course_section_id', $idManager->getId($row['fk_cm_section']));
		$property->addProperty('weight', $row['weight']);
		$res->free();	
		return $property;
		
		
	}
	
	
	function _setModifiedDateAndTime(){
		$this->_setField('modified_date',time()*1000);	
		//@TODO use the timestamp feature in SQL?
		//@TODO find out how to get the currently authenticated agent
		
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