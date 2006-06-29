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
    
    class CanonicalTestCase extends UnitTestCase {
      
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

		//--------------the tests ----------------------
        /*
        function testOfFalse() {
            $this->assertFalse(true, "True is not false");        // Fail.
            $this->assertFalse(false, "False is false");
        }
        function testOfNull() {
            $this->assertNull(null);
            $this->assertNull(false);        // Fail.
            $this->assertNotNull(null);        // Fail.
            $this->assertNotNull(false);
        }
        function testOfType() {
            $this->assertIsA("hello", "string");
            $this->assertIsA(14, "string");        // Fail.
            $this->assertIsA($this, "TestOfUnitTestCase");
            $this->assertIsA($this, "UnitTestCase");
            $this->assertIsA(14, "TestOfUnitTestCase");        // Fail.
            $this->assertIsA($this, "TestHTMLDisplay");        // Fail.
        }
        function testOfEquality() {
            $this->assertEqual("0", 0);
            $this->assertEqual(1, 2);        // Fail.
            $this->assertNotEqual("0", 0);        // Fail.
            $this->assertNotEqual(1, 2);
        }
        function testOfIdentity() {
            $a = "fred";
            $b = $a;
            $this->assertIdentical($a, $b);
            $this->assertNotIdentical($a, $b);       // Fail.
            $a = "0";
            $b = 0;
            $this->assertIdentical($a, $b);        // Fail.
            $this->assertNotIdentical($a, $b);
        }
        function testOfReference() {
            $a = "fred";
            $b = &$a;
            $this->assertReference($a, $b);
            $this->assertCopy($a, $b);        // Fail.
            $c = "Hello";
            $this->assertReference($a, $c);        // Fail.
            $this->assertCopy($a, $c);
        }
        function testOfPatterns() {
            $this->assertWantedPattern('/hello/i', "Hello there");
            $this->assertNoUnwantedPattern('/hello/', "Hello there");
            $this->assertWantedPattern('/hello/', "Hello there");            // Fail.
            $this->assertNoUnwantedPattern('/hello/i', "Hello there");      // Fail.
        }
        */
        
        function TestOfCanonicalCourse() {
          	/* First test case */
          	$title = "Intro to Computer Science";
          	$number = "CS101";
          	$description = "Yeah!  Buggles!";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "3.14159";
          	
          	$courseManagementManager =& Services::getService("CourseManagement");
          	$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
          	$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
          	
          	//$this->assertReference($canonicalCourseA, $canonicalCourseB);
          	$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($canonicalCourseA->getCredits(), $canonicalCourseB->getCredits());
          	$this->assertEqual($canonicalCourseA->getDescription(), $canonicalCourseB->getDescription());
          	$this->assertEqual($canonicalCourseA->getDisplayName(), $canonicalCourseB->getDisplayName());
          	$this->assertEqual($canonicalCourseA->getNumber(), $canonicalCourseB->getNumber());
          	$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($canonicalCourseA->getTitle(), "Intro to Computer Science");
          	$this->assertEqual($canonicalCourseB->getCredits(), "3.14159");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Intro to Sociocultural Anthropology");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Yeah!  Buggles!.");
          	$this->assertTrue($canonicalCourseB->getDescription() == "Yeah!  Buggles!");
          	$this->assertEqual($canonicalCourseB->getNumber(), "CS101");
          	
          	
          	$courseManagementManager->deleteCanonicalCourse($canonicalCourseA->getId());
          	
          	// Second test case
          	$title = "Intro to Sociocultural Anthropology";
          	$number = "SOAN103";
          	$description = "Life is a mystery";
          	$courseType =& new Type("CourseManagement", "edu.middlbeury", "SOC");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Full", "No students allowed.");
          	$credits = "1.00";
          	
  		  	$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
          	$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($canonicalCourseA->getTitle(), "Intro to Sociocultural Anthropology");
          	$this->assertTrue($canonicalCourseB->getCredits() == "1.00");
          	$this->assertTrue($canonicalCourseB->getDescription() == "Life is a mystery");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Life is a mystery.");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Intro to Computer Science");
			
          	$courseManagementManager->deleteCanonicalCourse($canonicalCourseB->getId());
          	
			// Third test case
			print "third test";
			
			$title = "Dynamic Earth";
			$number = "GEOL170";
			$description = "Rocks for jocks?";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "SCI");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Not recommended.");
			$credits = "1.00";
			
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			$canonicalCourseD =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
			$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
			$this->assertEqual($canonicalCourseD->getTitle(), $canonicalCourseB->getTitle());
			$this->assertNotEqual($canonicalCourseB->getCredits(), "3.14159");
			$this->assertEqualTypes($canonicalCourseB->getStatus(),$canonicalCourseA->getStatus());
			$this->assertEqualTypes($canonicalCourseB->getCourseType(),$canonicalCourseA->getCourseType());
			
			$courseManagementManager->deleteCanonicalCourse($canonicalCourseD->getId());
			
			// Fourth test case - getting canonical course by type 
			
			print "fourth test";
			
			$title = "Real Analaysis";
			$number = "MA323";
			$description = "Arguably the hardest there is";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "DED");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Highly recommended.");
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$courseIterator =& $courseManagementManager->getCanonicalCoursesByType($canonicalCourseA->getCourseType());
			$canonicalCourseB =& $courseIterator->nextCanonicalCourse();
			
		
			$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($canonicalCourseA->getCredits(), $canonicalCourseB->getCredits());
          	$this->assertEqual($canonicalCourseA->getDescription(), $canonicalCourseB->getDescription());
          	$this->assertEqual($canonicalCourseA->getDisplayName(), $canonicalCourseB->getDisplayName());
			$this->assertEqualTypes($canonicalCourseA->getStatus(),$canonicalCourseB->getStatus());
			$this->assertEqualTypes($canonicalCourseA->getCourseType(),$canonicalCourseB->getCourseType());
			
			$this->assertEqual($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
			$this->assertEqual($canonicalCourseA->getDescription(), "Arguably the hardest there is");
			
			
			$courseManagementManager->deleteCanonicalCourse($canonicalCourseA->getId());
			// Fifth test - making sure course type and course id yield equal search results.
			
			print "fifth test";
			
			$title = "Microbiology";
			$number = "BI310";
			$description = "Learn about little things";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "SCI");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Wait till next year.");
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$iterator =& $courseManagementManager->getCanonicalCoursesByType($canonicalCourseA->getCourseType());
			$canonicalCourseB =& $iterator->nextCanonicalCourse();
			$canonicalCourseC =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
			//$this->assertReference($canonicalCourseB, $canonicalCourseC);
			$this->assertEqual($canonicalCourseC->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($canonicalCourseC->getCredits(), $canonicalCourseB->getCredits());
          	$this->assertEqual($canonicalCourseC->getDescription(), $canonicalCourseB->getDescription());
          	$this->assertEqual($canonicalCourseC->getDisplayName(), $canonicalCourseB->getDisplayName());
			$this->assertEqualTypes($canonicalCourseC->getStatus(),$canonicalCourseB->getStatus());
			$this->assertEqualTypes($canonicalCourseC->getCourseType(),$canonicalCourseB->getCourseType());
			
			$this->assertEqual($canonicalCourseB->getId(), $canonicalCourseC->getId());
			$this->assertEqual($canonicalCourseB->getTitle(), $canonicalCourseC->getTitle());
			$this->assertEqual($canonicalCourseB->getTitle(), "Microbiology");
			$this->assertTrue($canonicalCourseB->getNumber() == "BI310");
			$this->assertEqual($canonicalCourseC->getNumber(), "BI310");
			$this->assertFalse($canonicalCourseC->getTitle() == "Real Analaysis");
			
			// Sixth test - modifying various attributes of canonical course (will use previous values)
			print "sixth test";
			
			// $canonicalCourseD is the very first test case - this should not have changed.
			// $canonicalCourseB AND $canonicalCourseC (as well as $canonicalCourseA) should be updated.
			$canonicalCourseB->updateTitle("Economic Statistics");
			$canonicalCourseB->updateNumber("ECON210");
			$canonicalCourseB->updateDescription("Snore");
			//$this->assertNotReference($canonicalCourseD, $canonicalCourseB);
			//$this->assertReference($canonicalCourseB, $canonicalCourseC);
			$this->assertEqual($canonicalCourseB->getTitle(), "Economic Statistics");
			$this->assertEqual($canonicalCourseB->getNumber(), "ECON210");
			$this->assertEqual($canonicalCourseB->getDescription(), "Snore");
			$this->assertEqual($canonicalCourseC->getTitle(), "Economic Statistics");
			
			$courseManagementManager->deleteCanonicalCourse($canonicalCourseB->getId());
			
		}
		
		
		function assertEqualTypes(&$typeA,&$typeB){
			
			$this->assertEqual($typeA->getDomain(),$typeB->getDomain());
			$this->assertEqual($typeA->getAuthority(),$typeB->getAuthority());
			$this->assertEqual($typeA->getKeyword(),$typeB->getKeyword());
			$this->assertEqual($typeA->getDescription(),$typeB->getDescription());
		}
		
		/*
		function testCourseOffering() {
		  	$courseManagementManager =& Services::getService("CourseManagement");
		  	
		  	// First test case
		  	$title = "CS101";
          	$number = "cs101";
          	$description = "Intro to Computer Science";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "3.1415927";
		  	
			$courseSectionA =& $courseManagementManager->createCourseSection($title, $number, $description, 
			  																$courseType, $courseStatusType,
												                            $credits);
			$courseSectionB =& $courseManagementManager->getCourseSection($courseSectionA->getId());
		
			$this->assertReference($canonicalCourseA, $canonicalCourseB);
			
			// Second test case
			$title = "LIT";
          	$number = "101";
          	$description = "Intro to Literature";
          	$courseType =& new Type("CourseManagement", "edu.middlbeury", "LIT");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available");
          	$credits = "1.00";
          	
  		  	$courseSectionA =& $courseManagementManager->createCourseSection($title, $number, $description, 
			  																$courseType, $courseStatusType,
												                            $credits);
			$courseSectionB =& $courseManagementManager->getCourseSection($canonicalCourseA->getId());
			
          	$this->assertEquals($courseSectionA->getTitle(), $courseSectionB->getTitle());
          	$this->assertFalse($canonicalCourseB->getTitle() == "SOAN");
          	$this->assertTrue($canonicalCourseB->getTitle() == "LIT");
          	$this->assertReference($canonicalCourseA, $canonicalCourseB);
		}
		*/
    }
?>