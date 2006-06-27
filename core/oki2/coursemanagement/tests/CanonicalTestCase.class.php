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
			
			/*
			// Get canonical course
			$testCase = $canonicalTest->getCanonicalCourse( $testId );
						                                           
			$this->assertEqual($testCase->$courseType, "DED");
			$this->assertEqual($testCase->$courseStatusType, "Available");
			$this->assertEqual($testCase->$title, "CS101");
			$this->assertEqual($testCase->$number, "cs101");
			
			// Second test case 
			$title = "SOAN";
          	$number = "103";
          	$description = "Intro to Sociocultural Anthropology";
          	$courseType = "SOC";
          	$courseStatusType = "Full";
          	
          	$canonicalTest = new CourseManagementManager();
          	
          	$canonicalTest->&createCanonicalCourse ( $title, $number, $description, &$courseType, &$courseStatusType,
			  										 $credits );
			// Retrive canonical course id
			$testCase = $canonicalTest->getCanonicalCourse( $testId );
			
			// Get canonical course
			$canonicalTest->getCanonicalCourse( $testId );
						                                           
			$this->assertTrue($testCase->courseType == "SOAN");
			$this->assertFalse($testCase->courseType == "DED");
			$this->assertTrue($testCase->courseStatusType == "Full");
			$this->assertFalse($testCase->courseStatusType == "Available");
			$this->assertNotEquals($testCase->$courseStatusType, "Available");
			$this->assertFalse($testCase->$title, "CS101");
			$this->assertEqual($testCase->$number, "103");
			
			// Delete canonical course
			$canonicalTest->deleteCanonicalCourse( &testId );
			
			// Third test case 
			$title = "MA200";
			$description = "Linear Algebra";
			$courseType = "Mathematics";
			$courseStatusType = "NA";
			
			$canonicalTest->&createCanonicalCourse ( $title, $number, $description, &$courseType, &$courseStatusType,
			  										 $credits );
			// Retrive canonical course id
			$testId = $canonicalTest->$id;
			
			// Get canonical course
			$testCase = $canonicalTest->getCanonicalCourse( $testId );
			
			$this->assertEquals($testCase->&$title, $title);
			$this->assertEquals($testCase->$description, $description);
			
			// Delete canonical course
			$canonicalTest->deleteCanonicalCourse( &testId );	
			
			// Fourth test case - getting canonical course by type 
			$description = "Real Analaysis";
			$title = "MA323";
			$canonicalTest->&createCanonicalCourse ( $title, $number, $description, &$courseType, &$courseStatusType,
			  										 $credits );
			$testId = $canonicalTest->$id;
			
			// Retrive canonical course id
			$testType = $canonicalTest->$courseType;
			
			// Get canonical course by type
			$testCase = $canonicalTest->getCanonicalCourseByType( $testType );
			
			$this->assertTrue($testCase->$description == "Real Analysis");
			
			// Delete canonical course
			$canonicalTest->deleteCanonicalCourse( &testId );
			
			// Delete very first added canonical course
			$canonicalTest->deleteCanonicalCourse( &testId1 );
			
			// Fifth test - making sure course type and course id yield equal search results.
			$title = "Microbiology";
			$description = "Germs";
			$canonicalTest->&createCanonicalCourse ( $title, $number, $description, &$courseType, &$courseStatusType,
			  										 $credits );
			  										 
			$testId = $canonicalTest->$id;
			$testType = $canonicalTest->$courseType;
			
			$this->assertReference($canonicalTest->getCanonicalCourseByType( $testType ), 
								   $canonicalTest->getCanonicalCourse( $testId ) );
								   
			// Delete canonical course
			$canonicalTest->deleteCanonicalCourse( &testId );
			
			// This should kill the program
			$canonicalTest->getCanonicalCourse($testId) or die();
			// This should throw an error
			$canonicalTest->deleteCanonicalCourse(&testId1); or die();	
			*/
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