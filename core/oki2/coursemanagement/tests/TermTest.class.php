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
    
    class TermTest extends OKIUnitTestCase {
      
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
          	$this->write(7, "Term Test");
          	
        	$cm =& Services::getService("CourseManagement");
        	$sm =& Services::getService("Scheduling");
			
        
          	$termType1 =& new Type("CourseManagement", "edu.middlebury", "ItsTheFall");
          	$termType2 =& new Type("Coursemanagement", "edu.middlebury", "ItsAlsoTheFall","contains Smarch and Febtober");               	
          	        	
			$scheduleItemA1 =& $sm->createScheduleItem("Fall 2006 range", "", $agents, 300, 900, null);
			$scheduleItemA2 =& $sm->createScheduleItem("Thanksgiving", "", $agents, 350, 400, null);
			$scheduleItemA3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $agents, 500, 600, null);
			
			$scheduleItemB1 =& $sm->createScheduleItem("Fall 2006 range", "", $agents, 1300, 1900, null);
			$scheduleItemB2 =& $sm->createScheduleItem("Thanksgiving", "", $agents, 1350, 1400, null);
			$scheduleItemB3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $agents, 1500, 1600, null);				
			
			$scheduleItemC1 =& $sm->createScheduleItem("Funky time", "", $agents, 100, 500, null);
			$scheduleItemC2 =& $sm->createScheduleItem("Dance party", "", $agents, 700, 1400, null);
	
			
			$scheduleA = array($scheduleItemA1,$scheduleItemA2,$scheduleItemA3);
			$scheduleB = array($scheduleItemB1,$scheduleItemB2,$scheduleItemB3);
			$scheduleC = array($scheduleItemC1,$scheduleItemC2);
			$scheduleD = array($scheduleItemA1,$scheduleItemB1,$scheduleItemC1,$scheduleItemC2);
			
						
			$term1 =& $cm->createTerm($termType1, $scheduleA);		
			$term2 =& $cm->createTerm($termType2, $scheduleB,"The Fall of 2006");
			$term3 =& $cm->createTerm($termType1, $scheduleC);
			$term4 =& $cm->createTerm($termType1, $scheduleD);
	   	
        	
        	$this->write(4,"Test of basic get and update methods");   
          	
         $this->write(2,"Get");
         
          	$this->assertDoesNotCrashTheSystem($term1->getDisplayName());
          	$this->assertEqualTypes($term1->getType(), $termType1);
 
          	 
          	$this->assertEqual($term2->getDisplayName(), "The Fall of 2006");
          	$this->assertEqualTypes($term2->getType(), $termType2);
          	
          	    $this->write(2,"Update");
          	    
          	$term1->updateDisplayName("The Fall of 2005");
			//$term2->updateDisplayName("The Fall of 2006");    
			$term3->updateDisplayName("par-tay");
			$term4->updateDisplayName("Everything"); 
          	
          	$this->assertEqual($term1->getDisplayName(), "The Fall of 2005");   
          	$this->assertEqual($term2->getDisplayName(), "The Fall of 2006");
          	
          	
          $this->write(4,"Test of getSchedule()");   
        	$iter =& $term1->getSchedule();
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			
			$iter =& $term2->getSchedule();
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
        	
        	$this->write(4,"Test of getTerm() getTerms()");
          	
        		$this->write(1,"Group A");
        	
          	$term1a =& $cm->getTerm($term1->getID());     	
          	$this->assertHaveEqualIds($term1a,$term1);
          	$this->assertEqual($term1a->getDisplayName(), "The Fall of 2005");
          	$this->assertEqualTypes($term1a->getType(),$termType1);
        	
        		$this->write(1,"Group B");
          	
          	$iter =& $cm->getTerms();
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorHasItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			
				
				
				$this->write(4,"Test of getTermsByDate()");
					
			$this->write(1,"Group A");		
			$iter =& $cm->getTermsByDate(50);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorLacksItemWithId($iter, $term3);
			$this->assertIteratorLacksItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);	
					
			$this->write(1,"Group B");		
			$iter =& $cm->getTermsByDate(100);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group C");		
			$iter =& $cm->getTermsByDate(325);
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);

			
			$this->write(1,"Group D");		
			$iter =& $cm->getTermsByDate(375);
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group E");		
			$iter =& $cm->getTermsByDate(500);
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group F");		
			$iter =& $cm->getTermsByDate(600);
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorLacksItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group G");		
			$iter =& $cm->getTermsByDate(700);
			$this->assertIteratorHasItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			
			
			$this->write(1,"Group H");		
			$iter =& $cm->getTermsByDate(1000);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group I");		
			$iter =& $cm->getTermsByDate(1300);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorHasItemWithId($iter, $term2);
			$this->assertIteratorHasItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group J");		
			$iter =& $cm->getTermsByDate(1500);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorHasItemWithId($iter, $term2);
			$this->assertIteratorLacksItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
				
          	$this->write(1,"Group K");		
			$iter =& $cm->getTermsByDate(1900);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorHasItemWithId($iter, $term2);
			$this->assertIteratorLacksItemWithId($iter, $term3);
			$this->assertIteratorHasItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			$this->write(1,"Group L");		
			$iter =& $cm->getTermsByDate(1901);
			$this->assertIteratorLacksItemWithId($iter, $term1);
			$this->assertIteratorLacksItemWithId($iter, $term2);
			$this->assertIteratorLacksItemWithId($iter, $term3);
			$this->assertIteratorLacksItemWithId($iter, $term4);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			
			
			
			
        	$this->write(4,"Test of getting Types");
			
					
			$iter =& $cm->getTermTypes();
			$this->assertTrue($this->typeIteratorHas($iter, $termType1));
			$this->assertTrue($this->typeIteratorHas($iter, $termType2));
			$this->assertTrue(!$this->typeIteratorHas($iter,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			
			$sm->deleteScheduleItem($scheduleItemA1->getId());
			$sm->deleteScheduleItem($scheduleItemA2->getId());
			$sm->deleteScheduleItem($scheduleItemA3->getId());
			$sm->deleteScheduleItem($scheduleItemB1->getId());
			$sm->deleteScheduleItem($scheduleItemB2->getId());
			$sm->deleteScheduleItem($scheduleItemB3->getId());
			$sm->deleteScheduleItem($scheduleItemC1->getId());
			$sm->deleteScheduleItem($scheduleItemC2->getId());
		
        	
        	$cm->deleteTerm($term1->getId());
			$cm->deleteTerm($term2->getId());
			$cm->deleteTerm($term3->getId());
			$cm->deleteTerm($term4->getId());
	
        	
        	
        
        }
		
    }
?>