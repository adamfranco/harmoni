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
        
        function TestOfSchedule() {
          	// Create canonical course
          	$this->write(7, "Scheduling Test");
          	
        	$scheduling =& Services::getService("Scheduling");
			
			$start = 300;
			$end = 600;
			$scheduleA =& $scheduling->createScheduleItem("Fall 2006", "2006-2007", $agents, $start, $end, null);
			$scheduleB =& $scheduling->getScheduleItem($scheduleA->getId());
			$schedule = array($scheduleA);
			
		
			
			$availableTimes =& $scheduling->getAvailableTimes($agents, $start, $end);
			
			
			
			
			$this->assertEqual($scheduleA->getDisplayName(), $scheduleB->getDisplayName());
			$this->assertEqual($scheduleA->getDescription(), $scheduleB->getDescription());
			$this->assertEqual($scheduleA->getAgentCommitments(), $scheduleB->getAgentCommitments());
			
			
			
			
			$this->assertEqual($scheduleA->getStart(), $scheduleB->getStart());
			$this->assertEqual($scheduleA->getEnd(), $scheduleB->getEnd());
			
			$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");

			$schedule = array($scheduleA);
			$termA =& $cmm->createTerm($termType, $schedule);

			$termB =& $cmm->getTerm($termA->getId());
			
			$this->assertEqualTypes($termA->getType(), $termB->getType());
			
			
			$scheduleIterator =& $termA->getSchedule();
			
			
			$this->assertTrue($scheduleIterator->hasNextScheduleItem());

			if ($scheduleIterator->hasNextScheduleItem()) {
				$scheduleC =& $scheduleIterator->nextScheduleItem();
				$this->assertTrue(!$scheduleIterator->hasNextScheduleItem());
			
				$this->assertEqual($scheduleA->getDisplayName(), $scheduleC->getDisplayName());
				$this->assertEqual($scheduleA->getDescription(), $scheduleC->getDescription());
				$this->assertEqual($scheduleA->getAgentCommitments(), $scheduleB->getAgentCommitments());
			
			}


			$this->assertEqual($scheduleA->getStart(), $scheduleC->getStart());
				$this->assertEqual($scheduleA->getEnd(), $scheduleC->getEnd());

			
			$scheduling->deleteScheduleItem($scheduleA->getId());
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
						$bool = true;
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