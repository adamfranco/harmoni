<?php
   //this tests all of grading in one go.  Hooray!
   //@TODO I need to figure out how to test the last modifiying agent methods.
    
    if (!defined("SIMPLE_TEST")) {
        define("SIMPLE_TEST", "../");
    }
    
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'simple_html_test.php');
    require_once(OKI2."/osid/coursemanagement/CourseManagementManager.php");
	require_once(HARMONI."oki2/coursemanagement/CanonicalCourse.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseGradeRecord.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseGradeRecordIterator.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseGroup.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseGroupIterator.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseOffering.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseOfferingIterator.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseSection.class.php");
	require_once(HARMONI."oki2/coursemanagement/CourseSectionIterator.class.php");
	require_once(HARMONI."oki2/coursemanagement/EnrollmentRecord.class.php");
	require_once(HARMONI."oki2/coursemanagement/EnrollmentRecordIterator.class.php");
	require_once(HARMONI."oki2/coursemanagement/Term.class.php");
	require_once(HARMONI."oki2/coursemanagement/TermIterator.class.php");
    
    class GradingTestCase extends OKIUnitTestCase {
      
      	/**
		 *	  Sets up unit test wide variables at the start
		 *	  of each test method.
		 *	  @access public
		 */
		function setUp() {
			// Set up the database connection
		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->agent);
		}
        
        function TestOfScheduling() {
        	
        	
        	
        	$this->write(7, "Grading Test");
        	
        	
        	
        	
          	$gm =& Services::getService("Grading");
        	$cm =& Services::getService("CourseManagement");
        	$idManager =& Services::getService("Id");
        	$am =& Services::getService("Agent");
			
        	
        	
        	
        	
        	
        	
        
                     	
          	$propertiesType =& new Type("PropertiesType", "edu.middlebury", "properties");              	
          	$agentType =& new Type("AgentType", "edu.middlebury", "student");              	           	        	      
          	$canType =& new Type("CanonicalCourseType", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType =& new Type("CanonicalCourseStatusType", "edu.middlebury", "Still offered");          	
          	$offerType =& new Type("CourseOfferingType", "edu.middlebury", "default", "");         	
          	$offerStatType =& new Type("CourseOfferingStatusType", "edu.middlebury", "Full");        	
          	$termType =& new Type("TermType", "edu.middlebury", "Fall");	
          	$sectionType =& new Type("CourseSectionType", "edu.middlebury", "lecture", "");	 	          	         	
          	$sectionStatType =& new Type("CourseSectionStatusType", "edu.middlebury", "Slots open", "register, baby!");


          	$gradeType1 =& new Type("GradeType", "edu.middlebury", "Number grade", "Mathish");
          	$gradeType2 =& new Type("GradeType", "edu.middlebury", "Letter grade", "with plusses and minuses");
          	
          	$scoring1 =& new Type("ScoringDefinitionType", "edu.middlebury", "Number grade");
          	$scoring2 =& new Type("ScoringDefinitionType", "edu.middlebury", "Letter grade");
          	
          	$scale1 =& new Type("GradeScaleType", "edu.middlebury", "1-10");
          	$scale2 =& new Type("GradeScaleType", "edu.middlebury", "1-100");
          	$scale3 =& new Type("GradeScaleType", "edu.middlebury", "A-F");
  
          	
          	$recType1 =& new Type("GradeRecordType", "edu.middlebury", "Final");
          	$recType2 =& new Type("GradeRecordType", "edu.middlebury", "suggested");
          	
          	$can =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);   	       
          	$array = array();		
			$term =& $cm->createTerm($termType, $array);
          	
			$offer =& $can->createCourseOffering(null,null,null, $term->getId(),$offerType,$offerStatType,$gradeType1);

          	$loc = "Bihall 514";
                   	
          	$sec1 =& $offer->createCourseSection(null,null,null, $sectionType, $sectionStatType,$loc);
          	$sec2 =& $offer->createCourseSection(null,null,null, $sectionType, $sectionStatType,$loc);

          	
          	$ref1 =& $idManager->createId();     	
          	$ref2 =& $idManager->createId();     	
          	   	
				
			$properties =& new HarmoniProperties($propertiesType);
			$agent1 =& $am->createAgent("Gladius", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent2 =& $am->createAgent("MadgaTheAmazingFiancee", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);			
			$agent3 =& $am->createAgent("nood8?jood8", $agentType, $properties); 				    
			
			
        	$this->write(6, "Test of GradableObject");
        	
        	$gradable1 =& $gm->createGradableObject("RugBuggle","Use recursion, not loops", 
        							$sec1->getId(), $ref1, $gradeType1, $scoring2, $scale1, 5);
	       	$gradable2 =& $gm->createGradableObject("HurdleBuggle","define x: x", 
        							$sec1->getId(), $ref1, $gradeType2, $scoring2, $scale2, 3);				
	       	$gradable3 =& $gm->createGradableObject("PooBuggle","No TP", 
        							$sec2->getId(), $ref2, $gradeType1, $scoring1, $scale3, 8);		
						
  
        	$this->write(4,"Test of basic get methods");   
          	
 	
        	$this->write(1,"Group A");   
          
        	$this->assertEqualIds($gradable1->getId(),$gradable1->getId());
          	$this->assertEqual($gradable1->getDisplayName(), "RugBuggle");
          	$this->assertEqual($gradable1->getDescription(), "Use recursion, not loops");
          	$this->assertEqualIds($gradable1->getCourseSection(), $sec1->getId());
          	$this->assertEqualIds($gradable1->getExternalReference(), $ref1);
          	$this->assertEqualTypes($gradable1->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradable1->getScoringDefinition(),$scoring2);
          	$this->assertEqualTypes($gradable1->getGradeScale(),$scale1);
          	$this->assertEqual($gradable1->getGradeWeight(), 5);
          	
          	$this->write(1,"Group B");   
          
        	$this->assertEqualIds($gradable2->getId(),$gradable2->getId());
          	$this->assertEqual($gradable2->getDisplayName(), "HurdleBuggle");
          	$this->assertEqual($gradable2->getDescription(), "define x: x");
          	$this->assertEqualIds($gradable2->getCourseSection(), $sec1->getId());
          	$this->assertEqualIds($gradable2->getExternalReference(), $ref1);
          	$this->assertEqualTypes($gradable2->getGradeType(),$gradeType2);
          	$this->assertEqualTypes($gradable2->getScoringDefinition(),$scoring2);
          	$this->assertEqualTypes($gradable2->getGradeScale(),$scale2);
          	$this->assertEqual($gradable2->getGradeWeight(), 3);
          	
          	$this->write(1,"Group C");   
          
        	$this->assertEqualIds($gradable3->getId(),$gradable3->getId());
          	$this->assertEqual($gradable3->getDisplayName(), "PooBuggle");
          	$this->assertEqual($gradable3->getDescription(), "No TP");
          	$this->assertEqualIds($gradable3->getCourseSection(), $sec2->getId());
          	$this->assertEqualIds($gradable3->getExternalReference(), $ref2);
          	$this->assertEqualTypes($gradable3->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradable3->getScoringDefinition(),$scoring1);
          	$this->assertEqualTypes($gradable3->getGradeScale(),$scale3);
          	$this->assertEqual($gradable3->getGradeWeight(), 8);
          
          	
          	$this->write(4,"Test of getGradableObject()");
          	
          	$gradable1a =& $gm->getGradableObject($gradable1->getID());
          	
          	
          	$this->assertEqualIds($gradable1a->getID(),$gradable1->getID());
          	$this->assertEqual($gradable1a->getDisplayName(), "RugBuggle");
          	$this->assertEqual($gradable1a->getDescription(), "Use recursion, not loops");
          	$this->assertEqualIds($gradable1a->getCourseSection(), $sec1->getID());
          	$this->assertEqualIds($gradable1a->getExternalReference(), $ref1);
          	$this->assertEqualTypes($gradable1a->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradable1a->getScoringDefinition(),$scoring2);
          	$this->assertEqualTypes($gradable1a->getGradeScale(),$scale1);
          	$this->assertEqual($gradable1a->getGradeWeight(), 5);
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	
          	$courseStatusType2 =& new Type("CourseManagement", "edu.middlebury", "No longer offered", "You're out of luck");
         	
          	
          	
          	$gradable1a->updateDisplayName("BuggledyBuggle");          	
			$gradable1->updateDescription("ChikaChanged");
			$gradable2->updateDisplayName("FunBuggle");          	
			$gradable2->updateDescription("AlsoChikaChanged");	

			
			$this->assertEqual($gradable1->getDisplayName(), "BuggledyBuggle");
          	$this->assertEqual($gradable1->getDescription(),"ChikaChanged");
          	$this->assertEqual($gradable2->getDisplayName(), "FunBuggle");
          	$this->assertEqual($gradable2->getDescription(),"AlsoChikaChanged");
      
				
			$this->write(4,"Test of GradableObject Properties 1");			
			$this->goTestPropertiesFunctions1($gradable1);
			$this->write(4,"Test of GradableObject Properties 2");
			$this->goTestPropertiesFunctions1($gradable2);
			$this->write(4,"Test of GradableObject Properties 3");
			$this->goTestPropertiesFunctions1($gradable3);
			
			$this->write(4, "Test of GetGradableObjects");
			
			$iter =& $gm->getGradableObjects($sec1->getID(),$ref1);
			$this->assertIteratorHasItemWithId($iter, $gradable1);
			$this->assertIteratorHasItemWithId($iter, $gradable2);
			$this->assertIteratorLacksItemWithId($iter, $gradable3);
			
			$iter =& $gm->getGradableObjects($sec2->getID(),$ref1);
			$this->assertIteratorLacksItemWithId($iter, $gradable1);
			$this->assertIteratorLacksItemWithId($iter, $gradable2);
			$this->assertIteratorLacksItemWithId($iter, $gradable3);
			
			$iter =& $gm->getGradableObjects($sec1->getID(),$ref2);
			$this->assertIteratorLacksItemWithId($iter, $gradable1);
			$this->assertIteratorLacksItemWithId($iter, $gradable2);
			$this->assertIteratorLacksItemWithId($iter, $gradable3);
			
			$iter =& $gm->getGradableObjects($sec2->getID(),$ref2);
			$this->assertIteratorLacksItemWithId($iter, $gradable1);
			$this->assertIteratorLacksItemWithId($iter, $gradable2);
			$this->assertIteratorHasItemWithId($iter, $gradable3);
			
			
			$this->write(6, "Test of GradeRecord");
			
			
			
			$gradeRec1 =& $gm->createGradeRecord($gradable1->getId(),$agent1->getId(),$p1="4",$recType1);
			$gradeRec2 =& $gm->createGradeRecord($gradable1->getId(),$agent2->getId(),$p2="9",$recType2);
			$gradeRec3 =& $gm->createGradeRecord($gradable1->getId(),$agent3->getId(),$p3="10",$recType1);
			$gradeRec4 =& $gm->createGradeRecord($gradable2->getId(),$agent1->getId(),$p4="85",$recType2);
			$gradeRec5 =& $gm->createGradeRecord($gradable2->getId(),$agent2->getId(),$p5="97",$recType1);
			$gradeRec6 =& $gm->createGradeRecord($gradable3->getId(),$agent3->getId(),$p6="D+",$recType2);
	
						
  
        	$this->write(4,"Test of basic get methods");   
          	
 	
        	$this->write(1,"Group A");   
          
        	$this->assertEqual($gradeRec1->getGradeValue(),"4");          	
          	$this->assertEqualIds($gradeRec1->getGradableObject(), $gradable1->getId());
          	$this->assertEqualIds($gradeRec1->getAgentId(), $agent1->getId());
          	$this->assertEqualTypes($gradeRec1->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradeRec1->getGradeRecordType(),$recType1);
          	
          	$this->write(1,"Group B");   
          
        	$this->assertEqual($gradeRec2->getGradeValue(),"9");          	
          	$this->assertEqualIds($gradeRec2->getGradableObject(), $gradable1->getId());
          	$this->assertEqualIds($gradeRec2->getAgentId(), $agent2->getId());
          	$this->assertEqualTypes($gradeRec2->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradeRec2->getGradeRecordType(),$recType2);
          	
          	$this->write(1,"Group C");   
          
        	$this->assertEqual($gradeRec6->getGradeValue(),"D+");          	
          	$this->assertEqualIds($gradeRec6->getGradableObject(), $gradable3->getId());
          	$this->assertEqualIds($gradeRec6->getAgentId(), $agent3->getId());
          	$this->assertEqualTypes($gradeRec6->getGradeType(),$gradeType1);
          	$this->assertEqualTypes($gradeRec6->getGradeRecordType(),$recType2);
          
          	
          	$this->write(4,"Test of basic update methods");
          	
   
          	
                    	
			$gradeRec1->updateGradeValue($p7="7");
			$gradeRec4->updateGradeValue($p8="83");
			$gradeRec6->updateGradeValue($p9="C-");
		         		
			$this->assertEqual($gradeRec1->getGradeValue(),"7");
			$this->assertEqual($gradeRec4->getGradeValue(),"83");
			$this->assertEqual($gradeRec6->getGradeValue(),"C-");
			
			
			
			$this->write(4, "Test of GetGradeRecords");
			
			$null = null;
			
			$this->write(3, "Group A");
			
			$this->write(2, "Subgroup 1");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$gradable1->getId(),$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$gradable1->getId(),$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$gradable1->getId(),$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$gradable1->getId(),$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(2, "Subgroup 2");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$null,$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$null,$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1,$null,$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($sec1->getID(),$ref1, $null,$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(3, "Group B");
			
			$this->write(2, "Subgroup 1");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$gradable1->getId(),$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$gradable1->getId(),$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$gradable1->getId(),$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$gradable1->getId(),$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(2, "Subgroup 2");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$null,$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$null,$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null,$null,$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($sec1->getID(),$null, $null,$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			
			$this->write(3, "Group C");
			
			$this->write(2, "Subgroup 1");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($null,$ref1,$gradable1->getId(),$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($null,$ref1,$gradable1->getId(),$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($null,$ref1,$gradable1->getId(),$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($null,$ref1,$gradable1->getId(),$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(2, "Subgroup 2");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($null,$ref1,$null,$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($null,$ref1,$null,$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($null,$ref1,$null,$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($null,$ref1, $null,$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(3, "Group D");
			
			$this->write(2, "Subgroup 1");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($null,$null,$gradable1->getId(),$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($null,$null,$gradable1->getId(),$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($null,$null,$gradable1->getId(),$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($null,$null,$gradable1->getId(),$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(2, "Subgroup 2");
			
			$this->write(1, "Subsubgroup a");
			$iter =& $gm->getGradeRecords($null,$null,$null,$agent1->getId(),$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup b");
			$iter =& $gm->getGradeRecords($null,$null,$null,$agent1->getId(),$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
			
			$this->write(1, "Subsubgroup c");
			$iter =& $gm->getGradeRecords($null,$null,$null,$null,$recType1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec6);
	
			$this->write(1, "Subsubgroup d");
			$iter =& $gm->getGradeRecords($null,$null, $null,$null,$null);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec6);
			
			
			
			$this->write(5,"Test of GradeRecord Properties 1");			
			$this->goTestPropertiesFunctions2($gradeRec1);
			$this->write(5,"Test of GradeRecord Properties 2");
			$this->goTestPropertiesFunctions2($gradeRec2);
			$this->write(5,"Test of GradeRecord Properties 3");
			$this->goTestPropertiesFunctions2($gradeRec6);
			
			
			$this->write(5, "Test of deleting GradeRecords");
			
			$gm->deleteGradeRecord($gradable1->getId(),$agent1->getId(),$recType1);
			
			$this->write(1, "Group A");
			$iter =& $gm->getGradeRecords($null,$null,$null,$null,$null);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec6);
			
			$gm->deleteGradeRecord($gradable1->getId(),$agent3->getId(),$null);
	
			$this->write(1, "Group B");
			$iter =& $gm->getGradeRecords($null,$null, $null,$null,$null);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec5);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec6);
			
			$gm->deleteGradeRecord($gradable2->getId(),$agent2->getId());
	
			$this->write(1, "Group C");
			$iter =& $gm->getGradeRecords($null,$null, $null,$null,$null);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec1);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec2);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec3);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec4);
			$this->assertIteratorLacksGradeRecord($iter, $gradeRec5);
			$this->assertIteratorHasGradeRecord($iter, $gradeRec6);
			
			
			
			
			
			
			
			
			
			
			
			
			$this->write(4,"Test of getting Types");
			$this->write(1,"Group A");
			$iter =& $gm->getGradeRecordTypes();
			$this->assertTrue($this->typeIteratorHas($iter, $recType1));
			$this->assertTrue($this->typeIteratorHas($iter, $recType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale3));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $sectionStatType));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			$this->write(1,"Group B");
			$iter =& $gm->getGradeScales();
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType2));
			$this->assertTrue($this->typeIteratorHas($iter, $scale1));
			$this->assertTrue($this->typeIteratorHas($iter, $scale2));
			$this->assertTrue($this->typeIteratorHas($iter, $scale3));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $sectionStatType));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			$this->write(1,"Group C");
			$iter =& $gm->getScoringDefinitions();
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale3));
			$this->assertTrue($this->typeIteratorHas($iter, $scoring1));
			$this->assertTrue($this->typeIteratorHas($iter, $scoring2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $gradeType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $sectionStatType));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			$this->write(1,"Group D");
			$iter =& $gm->getGradeTypes();
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $recType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scale3));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $scoring2));
			$this->assertTrue($this->typeIteratorHas($iter, $gradeType1));
			$this->assertTrue($this->typeIteratorHas($iter, $gradeType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $sectionStatType));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
	
			
			$gm->deleteGradableObject($gradable1->getId());
			$gm->deleteGradableObject($gradable2->getId());
			$gm->deleteGradableObject($gradable3->getId());
			
			
			$offer->deleteCourseSection($sec1->getId());
			$offer->deleteCourseSection($sec2->getId());

			$can->deleteCourseOffering($offer->getId());

			$cm->deleteCanonicalCourse($can->getId());
			
			$cm->deleteTerm($term->getId());

			
			
          
			$am->deleteAgent($agent1->getId());
			$am->deleteAgent($agent2->getId());
			$am->deleteAgent($agent3->getId());
			
        }
		
        
        
		
		//This function's name can't start with test or it is called without parameters
		function goTestPropertiesFunctions1($itemToTest){
			$this->write(1,"Group A");
			$gradeType =& $itemToTest->getGradeType();
			$correctType =& new Type("PropertiesType", $gradeType->getAuthority(), "properties");  
			$propertyType =& $itemToTest->getPropertyTypes();
			$this->assertTrue($propertyType->hasNextType());
			if($propertyType->hasNextType()){
				$type1 =&  $propertyType->nextType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->assertFalse($propertyType->hasNextType());		
			}
			$this->write(1,"Group B");
			//multiple objects of type properties?  Propertiesies!
			$propertiesies =& $itemToTest->getProperties();
			$this->assertTrue($propertiesies->hasNextProperties());
			if($propertiesies->hasNextProperties()){
				$properties =&  $propertiesies->nextProperties();
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties1($properties,$itemToTest);
				$this->assertFalse($propertiesies->hasNextProperties());		
			}
			$this->write(1,"Group C");
			$properties =& $itemToTest->getPropertiesByType($correctType);
			$this->assertNotEqual($properties,null);
			if(!is_null($properties)){
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties1($properties,$itemToTest);
			}	
			
		}
		
		
			/*
		
			
		
		$property->addProperty('modified_date', $row['modified_date']);
		$property->addProperty('modified_by_agent_id', $idManager->getId($row['fk_modified_by_agent']));
		$property->addProperty('reference_id', $idManager->getId($row['fk_reference_id']));
		$property->addProperty('course_section_id', $idManager->getId($row['fk_cm_section']));
		$property->addProperty('weight', $row['weight']);
		$res->free();	
		return $property;
		*/
		
		//This function's name can't start with test or it is called without parameters
		function goTestProperties1($prop, $itemToTest){
			
			
			
			
			$idManager =& Services::getService("Id");
			
			
			$keys =& $prop->getKeys();
			
			$key = "display_name";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getDisplayName());
			}			
			
			$key = "description";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getDescription());
			}
			
			$key = "id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualIds($prop->getProperty($key),$itemToTest->getId());
			}
			
			$key = "scoring_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getScoringDefinition());
			}
			
			$key = "grade_scale";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getGradeScale());
			}
			
			$key = "grade_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getGradeType());
			}
			
			$key = "weight";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getGradeWeight());
			}
			
			$key = "reference_id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualIds($prop->getProperty($key),$itemToTest->getExternalReference());
			}
			
			$key = "course_section_id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualIds($prop->getProperty($key),$itemToTest->getCourseSection());
			}			
			
		
			
		}
		
	
		
		
		//This function's name can't start with test or it is called without parameters
		function goTestPropertiesFunctions2($itemToTest){
			$this->write(1,"Group A");
			$gradeType =& $itemToTest->getGradeRecordType();
			$correctType =& new Type("PropertiesType", $gradeType->getAuthority(), "properties");  
			$propertyType =& $itemToTest->getPropertyTypes();
			$this->assertTrue($propertyType->hasNextType());
			if($propertyType->hasNextType()){
				$type1 =&  $propertyType->nextType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->assertFalse($propertyType->hasNextType());		
			}
			$this->write(1,"Group B");
			//multiple objects of type properties?  Propertiesies!
			$propertiesies =& $itemToTest->getProperties();
			$this->assertTrue($propertiesies->hasNextProperties());
			if($propertiesies->hasNextProperties()){
				$properties =&  $propertiesies->nextProperties();
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties2($properties,$itemToTest);
				$this->assertFalse($propertiesies->hasNextProperties());		
			}
			$this->write(1,"Group C");
			$properties =& $itemToTest->getPropertiesByType($correctType);
			$this->assertNotEqual($properties,null);
			if(!is_null($properties)){
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties2($properties,$itemToTest);
			}	
			
		}
		
		
		
		/*
		
	
		$property->addProperty('modified_by_agent_id', $idManager->getId($row['fk_modified_by_agent']));
		$property->addProperty('modified_date', $row['modified_date']);
		
		
		*/
		
		//This function's name can't start with test or it is called without parameters
		function goTestProperties2($prop, $itemToTest){
			
			
			
			
			$idManager =& Services::getService("Id");
			
			
			$keys =& $prop->getKeys();
			
			$key = "id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->_id);
			}				
			
			$key = "value";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getGradeValue());
			}
			
			$key = "gradable_object_id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualIds($prop->getProperty($key),$itemToTest->getGradableObject());
			}
			
			$key = "agent_id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualIds($prop->getProperty($key),$itemToTest->getAgentId());
			}			
			
			$key = "type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getGradeRecordType());
			}
			
		}
		
				function assertIteratorHasGradeRecord($iter, $rec){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;		
				while($iter->hasNextGradeRecord()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->nextGradeRecord();
					
					if($item->_id == $rec->_id){
						$this->assertTrue(true);
						return;
					}
				}
				$this->assertTrue(false);
				return false;
		}
		
			function assertIteratorLacksGradeRecord($iter, $rec){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;		
				while($iter->hasNextGradeRecord()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->nextGradeRecord();
					
					if($item->_id == $rec->_id){
						$this->assertTrue(false);
						return;
					}
				}
				$this->assertTrue(true);
				return false;
		}
		
		
    }
?>