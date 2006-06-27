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
          	$title = "CS101";
          	$number = "cs101";
          	$description = "Intro to Computer Science";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "3.1415927";
          	
          	$courseManagementManager =& Services::getService("CourseManagement");
          	$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
          	$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
          	
          	$this->assertReference($canonicalCourseA, $canonicalCourseB);
          	
          	// Second test case
          	$title = "SOAN";
          	$number = "103";
          	$description = "Intro to Sociocultural Anthropology";
          	$courseType =& new Type("CourseManagement", "edu.middlbeury", "SOC");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Full", "No students allowed.");
          	$credits = "1.00";
          	
  		  	$canonicalCourseA =& $courseManagementManager->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
          	$this->assertEquals($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEquals($canonicalCourseA->getTitle(), "SOAN");
          	$this->assertTrue($canonicalCourseB->getcredits() == "1.00");
          	$this->assertTrue($canonicalCourseB->getDescription() == "Intro to Sociocultural Anthropology");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Intro to Sociocultural Anthropology.");
          	$this->assertFalse($canonicalCourseB->getDescription() == "Intro to Computer Science");
			
			// Third test case
			$title = "GEOL";
			$number = "170";
			$description = "Dynamic Earth";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "DED");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Not recommended.");
			$credits = "1.00";
			
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse(($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
			$this->assertReference($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
			$this->assertFalse($canonicalCourseB->getCredits() == "3.1415927");
			$this->assertTrue($canonicalCourseB->getCourseStatusType() == $courseStatusType);
			
			// Fourth test case - getting canonical course by type 
			$title = "MA";
			$number = "323";
			$description = "Real Analaysis";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "DED");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Highly recommended.");
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse(($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourseByType($canonicalCourseA->getCourseType());
			
			$this->assertReference($canonicalCourseA, $canonicalCourseB);
			$this->assertEquals($canonicalCourseA->getTitle(), $canonicalCourseB->getTitle());
			$this->assertEquals($canonicalCourseA->getDescription == "Real Analysis");
			
			// Fifth test - making sure course type and course id yield equal search results.
			$title = "BI";
			$number = "310";
			$description = "Microbiology";
			$courseType =& new Type("CourseManagement", "edu.middlebury", "SCI");
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Wait till next year.");
			$canonicalCourseA =& $courseManagementManager->createCanonicalCourse(($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourseByType($canonicalCourseA->getCourseType());
			$canonicalCourseB =& $courseManagementManager->getCanonicalCourse($canonicalCourseA->getId());
			
			$this->assertReference($canonicalCourseB, $canonicalCourseC);
			$this->assertReference($canonicalCourseB->getId(), $canonicalCourseC->getId());
			$this->assertEquals($canonicalCourseB->getTitle(), $canonicalCourseC->getTitle());
			$this->assertFalse($canonicalCourseC->getTitle() == "MA");
		}
		
		/*
		function testCourseOffering() {
			$courseSectionTest = new CourseManagementManager();
			$testCase = new CanonicalCourse();
			
			$canonicalTest->createCanonicalCourse( &$title, &$number, &$description, &$courseType, &$courseStatusType,
												   &$credits );
			$testId1 = $canonicalTest->$id;
		
			$courseSectionTest->canonicalCourse->courseSection();
			$sectionTest = $courseSectionTest->getCourseOffering();
		}
		*/
    }
?>