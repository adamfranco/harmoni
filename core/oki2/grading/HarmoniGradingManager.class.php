<?php 
 
require_once(OKI2."/osid/grading/GradingManager.php");


require_once(HARMONI."oki2/grading/HarmoniGradableObject.class.php");
require_once(HARMONI."oki2/grading/HarmoniGradeRecord.class.php");
require_once(HARMONI."oki2/grading/HarmoniGradableObjectIterator.class.php");
require_once(HARMONI."oki2/grading/HarmoniGradeRecordIterator.class.php");



/**
 * <p>
 * GradingManager handles creating and deleting:
 * 
 * <ul>
 * <li>
 * GradableObject,
 * </li>
 * <li>
 * GradeRecord
 * </li>
 * </ul>
 * 
 * and getting:
 * 
 * <ul>
 * <li>
 * GradableObject,
 * </li>
 * <li>
 * GradeRecords,
 * </li>
 * <li>
 * various implementation Types.
 * </li>
 * </ul>
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
 * @package org.osid.grading
 */
class HarmoniGradingManager
    extends GradingManager
{
	
	
	
	
	
	
	/**
	* @variable object OsidContext $_osidContext the OSID context.
	* @access private
	**/
	var $_osidContext;





	/**
	* @param ref object $drId A {@link HarmoniId} referencing our DR.
	*/
	function HarmoniCourseManagementManager () {


	}



	/**
	* Assign the configuration of this Manager. There are no valid configuration options for
	* this manager.
	* 
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
     * Create a new GradableObject which includes all the elements for grading
     * something for a CourseSection.  The type of grade and other grade
     * characteristics are also specified.
     * 
     * @param string $displayName
     * @param string $description
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     * @param object Type $gradeType
     * @param object Type $scoringDefinition
     * @param object Type $gradeScale
     * @param int $gradeWeight
     *  
     * @return object GradableObject
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
    function &createGradableObject ( $displayName, $description, &$courseSectionId, &$externalReferenceId, &$gradeType, &$scoringDefinition, &$gradeScale, $gradeWeight ) { 
        //make id
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		//prepare insert query
		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;
		$query->setTable('gr_gradable');

		//ready values
		$query->setColumns(array('id','fk_gr_scoring_type','fk_gr_grade_type','fk_gr_gradescale_type','description','name','fk_reference_id','fk_cm_section','weight'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".$this->_typeToIndex('scoring',$scoringDefinition)."'";
		$values[]="'".$this->_typeToIndex('grade',$gradeType)."'";
		$values[]="'".$this->_typeToIndex('gradescale',$gradeScale)."'";
		$values[]="'".addslashes($description)."'";
		$values[]="'".addslashes($displayName)."'";
		$values[]="'".addslashes($externalReferenceId->getIdString())."'";
		$values[]="'".addslashes($courseSectionId->getIdString())."'";
		$values[]="'".addslashes($gradeWeight)."'";
		$query->addRowOfValues($values);


		//query
		$dbManager->query($query);

		//make object and update
		$ret =& new HarmoniGradableObject($id);
		$ret->_setModifiedDateAndAgent();
		return $ret; 
    } 

    /**
     * Delete a GradableObject.
     * 
     * @param object Id $gradableObjectId
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function deleteGradableObject ( &$gradableObjectId ) {        
		$dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;
		$query->setTable('gr_gradable');
		$query->addWhere("id=".addslashes($gradableObjectId->getIdString()));
		$dbManager->query($query);
    } 

    /**
     * Get a GradableObject by unique Id.
     * 
     * @param object Id $gradableObjectId
     *  
     * @return object GradableObject
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function &getGradableObject ( &$gradableObjectId ) { 
        $ret =& new HarmoniGradableObject($gradableObjectId);	 
		return $ret; 
    } 

    /**
     * Get all the GradableObjects, optionally including only those for a
     * specific CourseSection or External Reference to what is being graded.
     * If any parameter is null, what is returned is not filtered by that
     * parameter.
     * 
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     *  
     * @return object GradableObjectIterator
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function &getGradableObjects ( &$courseSectionId, &$externalReferenceId ) { 
        //set up query
    	$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('gr_gradable');
	
		$query->addColumn('id');
		
		
		//add appropriate wheres
		if(!is_null($courseSectionId)){
			$query->addWhere("fk_cm_section = '".addslashes($courseSectionId->getIdString())."'");		
		}
		if(!is_null($externalReferenceId)){
			$query->addWhere("fk_reference_id = '".addslashes($externalReferenceId->getIdString())."'");	
		}
	
		
		$res =& $dbManager->query($query);

		//get results in array
		$array = array();
		$idManager= & Services::getService("IdManager");
		while($res->hasMoreRows()){
			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['id']);
			$array[] =& new HarmoniGradableObject($id);

		}
		
		//convert and return
		$ret =& new  HarmoniGradableObjectIterator($array);
		return $ret;
    } 

    /**
     * Create a new GradeRecord for an Agent and with a Grade and
     * GradeRecordType.   The GradeRecordType is they Type of GradeRecord not
     * the Type of Grade contained in it.  GradeRecord Types might indicate a
     * mid-term, partial, or final grade while GradeTypes might be letter,
     * numeric, etc.  The Agent in this context is not the person who took the
     * test nor, necessarily, the person who is grading.  It is the person
     * whose "GradeBook" this is, for example the CourseSection instructor.
     * 
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object mixed $gradeValue (original type: java.io.Serializable)
     * @param object Type $GradeRecordType
     *  
     * @return object GradeRecord
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.grading.GradingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function &createGradeRecord ( &$gradableObjectId, &$agentId, &$gradeValue, &$GradeRecordType ) { 
        //make id
		$idManager =& Services::getService("IdManager");
		$id=$idManager->createId();

		//prepare insert query
		$dbManager=& Services::getService("DatabaseManager");
		$query=& new InsertQuery;
		$query->setTable('gr_record');

		//ready values
		$query->setColumns(array('id','value','fk_gr_gradable','fk_agent_id','fk_gr_record_type'));
		$values[]="'".addslashes($id->getIdString())."'";
		$values[]="'".addslashes($gradeValue)."'";
		$values[]="'".addslashes($gradableObjectId->getIdString())."'";
		$values[]="'".addslashes($agentId->getIdString())."'";
		$values[]="'".$this->_typeToIndex('scoring',$GradeRecordType)."'";
		$query->addRowOfValues($values);


		//query
		$dbManager->query($query);

		//make object and update
		$ret =& new HarmoniGradeRecord($id);
		$ret->_setModifiedDateAndAgent();
		return $ret;  
    } 

    /**
     * Delete a GradeRecord.
     * 
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object Type $GradeRecordType
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function deleteGradeRecord ( &$gradableObjectId, &$agentId, &$GradeRecordType ) { 
        $dbManager =& Services::getService("DatabaseManager");
		$query=& new DeleteQuery;
		$query->setTable('gr_gradable');
		$where = "fk_gr_gradable='".addslashes($gradableObjectId->getIdString())."'";
		$where .= "fk_gr_gradable='".addslashes($agentId->getIdString())."'";
		$where .= "fk_gr_record_type='".addslashes($this->_typeToIndex('record',$GradeRecordType))."'";
		$query->addWhere($where);
		$dbManager->query($query);
    } 

    /**
     * Get all the GradeRecords, optionally including only those for a specific
     * CourseSection, GradableObject, External Reference to what is being
     * graded, GradeRecordType, or Agent.  If any parameter is null, what is
     * returned is not filtered by that parameter.  For example,
     * getGradeRecords(xyzCourseSectionId,null,null,null,null) returns all
     * GradeRecords for the xyzCourseSection; and
     * getGradeRecords(xyzCourseSectionId,null,null,myAgent,quizGradeRecordType)
     * returns all GradeRecords for quizzes taken by myAgent in the
     * xyzCourseSection.
     * 
     * @param object Id $courseSectionId
     * @param object Id $externalReferenceId
     * @param object Id $gradableObjectId
     * @param object Id $agentId
     * @param object Type $GradeRecordType
     *  
     * @return object GradeRecordIterator
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
     *         org.osid.grading.GradingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.grading.GradingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function &getGradeRecords ( &$courseSectionId, &$externalReferenceId, &$gradableObjectId, &$agentId, &$GradeRecordType ) {         
    	//set up query
    	$dbManager =& Services::getService("DatabaseManager");
		$query=& new SelectQuery;
		$query->addTable('gr_record');
		
		//inner join?
		if(!is_null($externalReferenceId) || !is_null($courseSectionId)){
			$query->addTable('gr_gradable',INNER_JOIN,"gr_gradable.id=gr_record.fk_gr_gradable");
		}
		
		
		$query->addColumn('gr_record.id');
		
		
		//add appropriate wheres
		if(!is_null($courseSectionId)){
			$query->addWhere("gr_gradable.fk_cm_section = '".addslashes($courseSectionId->getIdString())."'");		
		}
		if(!is_null($externalReferenceId)){
			$query->addWhere("gr_gradable.fk_reference_id = '".addslashes($externalReferenceId->getIdString())."'");	
		}
		if(!is_null($gradableObjectId)){			
			$query->addWhere("gr_gradable.fk_gr_gradable = '".addslashes($gradableObjectId->getIdString())."'");
		}
		if(!is_null($agentId)){			
			$query->addWhere("gr_gradable.fk_agent_id='".addslashes($agentId->getIdString())."'");
		}
		if(!is_null($GradeRecordType)){			
			$query->addWhere("gr_gradable.fk_gr_record_type='".addslashes($this->_typeToIndex('record',$GradeRecordType))."'");
		}
		
		$res =& $dbManager->query($query);

		//get results in array
		$array = array();
		$idManager= & Services::getService("IdManager");
		while($res->hasMoreRows()){

			$row = $res->getCurrentRow();
			$res->advanceRow();
			$id =& $idManager->getId($row['gr_record.id']);
			$array[] =& new HarmoniGradeRecord($id);

		}
		
		//convert and return
		$ret =& new  HarmoniGradeRecordIterator($array);
		return $ret;
    } 

    /**
     * Get all GradeRecordTypes.
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
    function &getGradeRecordTypes () { 
        return $this->_getTypes("record"); 
    } 

    /**
     * Get all GradeTypes.
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
    function &getGradeTypes () { 
       return $this->_getTypes("grade");
    } 

    /**
     * Get all ScoringDefinitions.
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
    function &getScoringDefinitions () { 
        return $this->_getTypes("scoring"); 
    } 

    /**
     * Get all GradeScales.
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
    function &getGradeScales () { 
        return $this->_getTypes("gradescale");
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
	function &_getTypes($typename){
		
		//query 
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('gr_'.$typename."_type");
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);
		
		//iterate through results and add to an array
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
		
		//convert to an iterator
		$ret =& new HarmoniTypeIterator($array);
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
	function &_getType(&$id, $table, $typename){
		//the appropriate table names and fields must be given names according to the pattern indicated below
		
		//get the index for the type
		$index=$this->_getField($id,$table,"fk_gr_".$typename."_type");
		
		//query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('gr_'.$typename."_type");
		$query->addWhere("id=".$index);
		$query->addColumn('domain');
		$query->addColumn('authority');
		$query->addColumn('keyword');
		$query->addColumn('description');
		$res=& $dbHandler->query($query);
		
		//There should be exactly one result.  Convert it to a type and return it
		//remember that the description is optional
		$row = $res->getCurrentRow();
		if(is_null($row['description'])){
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword']);
		}else{
			$the_type =& new Type($row['domain'],$row['authority'],$row['keyword'],$row['description']);
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
	function _typeToIndex($typename, &$type){
		//the appropriate table names and fields must be given names according to the pattern indicated below

		//validate the Type
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"), true);
		
		//query to see if it exists
		$dbHandler =& Services::getService("DBHandler");
		$query=& new SelectQuery;
		$query->addTable('gr_'.$typename."_type");
		$query->addWhere("domain='".$type->getDomain()."'");
		$query->addWhere("authority='".$type->getAuthority()."'");
		$query->addWhere("keyword='".$type->getKeyword()."'");
		$query->addColumn('id');
		$res=& $dbHandler->query($query);


		
		if($res->getNumberOfRows()==0){
			//if not query to create it
			$query=& new InsertQuery;
			$query->setTable('gr_'.$typename.'_type');
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
	function _setField(&$id, $table, $key, $value)
	{
		//just an update query
		$dbHandler =& Services::getService("DBHandler");
		$query=& new UpdateQuery;
		$query->setTable($table);
		$query->addWhere("id='".addslashes($id->getIdString())."'");
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
	function _getField(&$id, $table, $key)
	{
		
		//just a select query
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