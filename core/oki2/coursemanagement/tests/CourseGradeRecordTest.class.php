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
			
			$grade1 = "A";
			
			$rec1 =& $cm->createCourseGradeRecord($agent1->getId(), $cs1_05->getID(), null,$grade1 = "C-");
			$rec1 =& $cm->createCourseGradeRecord($agent2->getId(), $cs1_05->getID(), null,$grade2 = "B+");
			$rec1 =& $cm->createCourseGradeRecord($agent3->getId(), $cs1_05->getID(), null,$grade3 = "A-");
			$rec1 =& $cm->createCourseGradeRecord($agent1->getId(), $cs1_05->getID(), null,$grade4 = "Fail");
			$rec1 =& $cm->createCourseGradeRecord($agent2->getId(), $cs1_05->getID(), null,$grade5 = "Pass");
			$rec1 =& $cm->createCourseGradeRecord($agent3->getId(), $cs1_05->getID(), null,$grade6 = "Pass");
			
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