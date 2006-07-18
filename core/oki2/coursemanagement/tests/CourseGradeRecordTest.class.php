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
    
    class CourseGradeRecordTest extends UnitTestCase {
      
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
        	
          	// Create canonical course
        	$cmm =& Services::getService("CourseManagement");
        	$title = "Introduction to Microeconomics";
        	$number = "EC155";
        	$description = "Economics in a micro scale, duh!";
        	$courseType =& new Type("CourseManagement", "edu.middlebury", "SOC");
        	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Open");
        	$credits = "1.00";
        	$canonicalCourse = $cmm->createCanonicalCourse($title, $number, $description, $courseType, 
														   $courseStatusType, $credits);
			
			// Create course offering											   
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");
          	
          	$scheduleManager =& Services::GetService("Scheduling");
          	
          	$schedule[] =& $scheduleManager->createScheduleItem("Term", "The whole shebang",$arr=array(),200,1000,null);
          	$schedule[] =& $scheduleManager->createScheduleItem("Halloween", "Boo!",$arr=array(),250,300,null);
          	$schedule[] =& $scheduleManager->createScheduleItem("Christmas", "Unfortunately secular!",$arr=array(),700,800,null);
          	
          	$term =& $cmm->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
			$courseOffering =& $canonicalCourse->createCourseOffering($title, $number, $description, $termId,
																	 $offeringType, $offeringStatusType,
																	 $courseGradeType);
																	 
			$courseOfferingId = $courseOffering->getId();
			$courseGrade = "B+";
		
			// Create agent	
			$propertiesTypeA =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesA =& new HarmoniProperties($propertiesTypeA);
			$name = "Sporktim Bahls";
			$class = "2006";
			$propertiesA->addProperty('student_name', $name);
			$propertiesA->addProperty('student_year', $class);	
			
			$agentTypeA =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentHandler =& Services::getService("Agent");
			$agent =& $agentHandler->createAgent("Gladius", $agentTypeA, $propertiesA);
			$agentId = $agent->getId();
			
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
			$agentHandler->deleteAgent($agentId);
        }
		
		
		function assertEqualTypes(&$typeA,&$typeB){
			
			$this->assertEqual($typeA->getDomain(),$typeB->getDomain());
			$this->assertEqual($typeA->getAuthority(),$typeB->getAuthority());
			$this->assertEqual($typeA->getKeyword(),$typeB->getKeyword());
			$this->assertEqual($typeA->getDescription(),$typeB->getDescription());
		}
		
		
		function write($size, $text){
			
			print "<p align=center><font size=".$size." color=#8888FF>".$text."</font></p>\n";
			
			
		} 
		
		
		//This method only works if the items have a getDisplaName() method.
		//Relies extensively on weak typing
		function iteratorHas($iter, $name){
			$bool=false;
			print "(";
			while($iter->hasNext()){
				
					$item =& $iter->next();
				print $item->getDisplayName().",";
					if($name == $item->getDisplayName()){
						$bool=true;;
					}
					
				}
			print ")";
			print "has ".$name."? --> ".$bool;
				return $bool;
			/*
				while($iter->hasNext()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->next();
					if($name == $item->getDisplayName()){
						return true;
					}
				}
				return false;*/
		}
		
		
		
    }
?>