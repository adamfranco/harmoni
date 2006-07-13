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
    
    class TermTest extends UnitTestCase {
      
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
        
        function TestOfTerm() {
          	// Create canonical course
        	$cmm =& Services::getService("CourseManagement");
        	$scheduling =& Services::getService("Scheduling");
        	$canonicalCourse = $cmm->createCanonicalCourse($title, $number, $description, $courseType, 
														   $courseStatusType, $credits);
			
			// Create new student 1
			$propertiesTypeA =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesA =& new HarmoniProperties($propertiesTypeA);
			$name = "Sporktim Bahls";
			$class = "2006";
			$propertiesA->addProperty('student_name', $name);
			$propertiesA->addProperty('student_year', $class);	
			
			$agentTypeA =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentHandler =& Services::getService("Agent");
			$agentA =& $agentHandler->createAgent("Gladius", $agentTypeA, $propertiesA);
			
			// Create new student 2
			$this->write(2,"John");
			$propertiesTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesB =& new HarmoniProperties($propertiesTypeB);
			$name = "John Lee";
			$propertiesB->addProperty('student_name', $name);
			$propertiesB->addProperty('student_year', $class);	
			
			$agentTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentB =& $agentHandler->createAgent("jood8", $agentTypeB, $propertiesB);
			
			// Create new student 3
			$this->write(2,"Magda");
			$propertiesTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesC =& new HarmoniProperties($propertiesTypeC);
			$name = "Magdalena Widjaja";
			$propertiesC->addProperty('student_name', $name);
			$propertiesC->addProperty('student_year', $class);	
			
			$agentTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentC =& $agentHandler->createAgent("Mags", $agentTypeC, $propertiesC);
			
			$agentIdA =& $agentA->getId();
			$agentIdB =& $agentB->getId();
			$agentIdC =& $agentC->getId();
			
			$agents = [$agentIdA, $agentIdB, $agentIdC];
			
			$start = "September 11, 2006";
			$end = "December 20, 2006";
			$schedulingItem = $scheduling->createScheduleItem("Fall 2006", "2006-2007", $agents, $start, $end);
			$availableTimes = $scheduling->getAvailableTime($agents, $start, $end);
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