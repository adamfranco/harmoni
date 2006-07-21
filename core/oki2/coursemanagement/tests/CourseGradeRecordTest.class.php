<?php
    // John Lee
    
    // NOTE..
    // Some of these tests are designed to fail! Do not be alarmed.
    //                         ----------------
    
    // The following tests are a bit hacky. Whilst Kent Beck tried to
    // build a unit tester with a unit tester I am not that brave.
    // Instead I have just hacked together odd test scripts until
    // I have enough of a tester to procede more formally.
    //
    // The proper tests start in all_tests.php
    
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
    
    class CourseGradeRecordTest extends OKIUnitTestCase {
      
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
        
        function TestOfCourseGradeRecord() {

        	
        	
        	$this->write(7,"Test of Course Grade Record");
        	
          	$cm =& Services::getService("CourseManagement");
        	$sm =& Services::getService("Scheduling");
        	$am =& Services::getService("Agent");
        	

        	
        	$canType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType =& new Type("CourseManagement", "edu.middlebury", "Still offered", "Offerd sometimes");          	
          	$offerType =& new Type("CourseManagement", "edu.middlebury", "default", "");         	
          	$offerStatType =& new Type("CourseManagement", "edu.middlebury", "Full", "You can't still register.");
          	$gradeType =& new Type("CourseManagement", "edu.middlebury", "AutoFail", "Sucks to be you");
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall");         	         
			$propertiesType =& new Type("CourseManagement", "edu.middlebury", "properties");
			$agentType =& new Type("CourseManagement", "edu.middlebury", "student");
			$gradeType1 =&  new Type("GradeType", "edu.middlebury", "LetterGrade");
			$gradeType2 =&  new Type("GradeType", "edu.middlebury", "Pass/Fail");
			                   	
          	$cs1 =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);
          	$cs2 =& $cm->createCanonicalCourse("Computer Graphics", "CSCI367", "descrip",$canType, $canStatType,1);
          	
          	       
          	$agents = array();
          	 	
			$scheduleItemA1 =& $sm->createScheduleItem("Fall 2005 range", "", $agents, 300, 900, null);
			$scheduleItemA2 =& $sm->createScheduleItem("Thanksgiving", "", $agents, 350, 400, null);
			$scheduleItemA3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $agents, 500, 600, null);
			
			
			$scheduleA = array($scheduleItemA1,$scheduleItemA2,$scheduleItemA3);
			
			$term1 =& $cm->createTerm($termType, $scheduleA);
			$term1->updateDisplayName("Fall 2005");
					
          	$cs1_05 =& $cs1->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType1);         
          	$cs2_05 =& $cs2->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType2);

			$properties =& new HarmoniProperties($propertiesType);
			$agent1 =& $am->createAgent("Gladius", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent2 =& $am->createAgent("Madga", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent3 =& $am->createAgent("nood8?jood8", $agentType, $properties);
			
			$A = "A";
			$B = "B";
			$C = "C";
			$pass = "Pass";
			$fail = "Fail";
			
			$null = null;
			
			$rec1 =& $cm->createCourseGradeRecord($agent1->getId(), $cs1_05->getID(), $null, $C);
			$rec2 =& $cm->createCourseGradeRecord($agent2->getId(), $cs1_05->getID(), $null, $B);
			$rec3 =& $cm->createCourseGradeRecord($agent3->getId(), $cs1_05->getID(), $null, $A);
			$rec4 =& $cm->createCourseGradeRecord($agent1->getId(), $cs2_05->getID(), $null, $fail);
			$rec5 =& $cm->createCourseGradeRecord($agent2->getId(), $cs2_05->getID(), $null, $pass);
			$rec6 =& $cm->createCourseGradeRecord($agent3->getId(), $cs2_05->getID(), $null, $pass);
			
			
			
			
			$this->write(4,"Test of basic get methods");   
          	
         $this->write(1,"Group A");
         
         	$this->assertHaveEqualIds($rec1->getAgent(),$agent1);
         	$this->assertEqual($rec1->getCourseGrade(), $C);
         	$this->assertHaveEqualIds($rec1->getCourseOffering(),$cs1_05);
         	$this->assertEqualTypes($rec1->getType(),$gradeType1);
         	$this->assertDoesNotCrashTheSystem($rec1->getDisplayName());
         	
         	$this->write(1,"Group B");
         
         	$this->assertHaveEqualIds($rec2->getAgent(),$agent2);
         	$this->assertEqual($rec2->getCourseGrade(), $B);
         	$this->assertHaveEqualIds($rec2->getCourseOffering(),$cs1_05);
         	$this->assertEqualTypes($rec2->getType(),$gradeType1);
         	$this->assertDoesNotCrashTheSystem($rec2->getDisplayName());
         	
         	$this->write(1,"Group C");
         
         	$this->assertHaveEqualIds($rec6->getAgent(),$agent3);
         	$this->assertEqual($rec6->getCourseGrade(), $pass);
         	$this->assertHaveEqualIds($rec6->getCourseOffering(),$cs2_05);
         	$this->assertEqualTypes($rec6->getType(),$gradeType2);
         	$this->assertDoesNotCrashTheSystem($rec6->getDisplayName());
         	
         
          	   
         	$this->write(4,"Test of basic update methods");
          	
          	$rec4->updateDisplayName("Tim's graphics grade");          	
			$rec4->updateCourseGrade($pass);
			
			$rec2->updateDisplayName("Magda's intro grade");          	
			$rec2->updateCourseGrade($A);					
			
			
			
			$this->assertEqual($rec4->getDisplayName(),"Tim's graphics grade");	
			$this->assertEqual($rec4->getCourseGrade(),$pass);	
		
			$this->assertEqual($rec2->getDisplayName(),"Magda's intro grade");	
			$this->assertEqual($rec2->getCourseGrade(),$A);	
			
			
			$rec1->updateDisplayName("Tim's inrto grade");
			$rec3->updateDisplayName("John's intro grade");
			$rec5->updateDisplayName("Magda's Graphics grade");
			$rec6->updateDisplayName("John's  Graphics grade");
			
					
          
         
        	/////////////////////@TODO only one grade record per agent
			
			
			
			$cm->deleteCourseGradeRecord($rec1->getId());
			$cm->deleteCourseGradeRecord($rec2->getId());
			$cm->deleteCourseGradeRecord($rec3->getId());
			$cm->deleteCourseGradeRecord($rec4->getId());
			$cm->deleteCourseGradeRecord($rec5->getId());
			$cm->deleteCourseGradeRecord($rec6->getId());
			
			$am->deleteAgent($agent1->getId());
			$am->deleteAgent($agent2->getId());
			$am->deleteAgent($agent3->getId());
          	
        	$cs1->deleteCourseOffering($cs1_05->getId());
        	$cs1->deleteCourseOffering($cs2_05->getId());
       
        	
        	$cm->deleteCanonicalCourse($cs1->getId());
        	$cm->deleteCanonicalCourse($cs2->getId());
        	
        	
        	$sm->deleteScheduleItem($scheduleItemA1->getId());
			$sm->deleteScheduleItem($scheduleItemA2->getId());
			$sm->deleteScheduleItem($scheduleItemA3->getId());
		
        	
        	
        	$cm->deleteTerm($term1->getId());
			
			
			
			/*
        	
			
        	$courseGradeRecordA =& $cmm->createCourseGradeRecord($agentId, $courseOfferingId, $courseGradeType, 
																 $courseGrade);
			
			$agentA =& $courseGradeRecordA->getAgent();
			$agentIdA = $agentA->getId();
			$courseOfferingA =& $courseGradeRecordA->getCourseOffering();
			$courseOfferingIdA = $courseOfferingA->getId();
			$this->assertEqual($agentId, $agentIdA);
			$this->assertEqual($courseOfferingId, $courseOfferingIdA);
			$this->assertEqualTypes($courseGradeRecordA->getCourseGradeType(), $courseGradeType);
			$this->assertEqual($courseGradeRecordA->getCourseGrade(), "B+");
					
			$newGrade = "A+";
			$courseGradeRecordA->updateCourseGrade($newGrade);
			$this->assertEqual($courseGradeRecordA->getCourseGrade(), $newGrade);
			
			$cmm->deleteCourseGradeRecord($courseGradeRecordA->getId());
			$courseGradeRecordIterator =& $cmm->getCourseGradeRecords($agentId, $courseOfferingId, $courseGradeType);
			$this->assertFalse($courseGradeRecordIterator->hasNext());
			
			$canonicalCourse->deleteCourseOffering($courseOffering->getId());
			$cmm->deleteCanonicalCourse($canonicalCourse->getId());
			$agentHandler->deleteAgent($agentId);*/
        }
		
		
		
		
		
    }
?>