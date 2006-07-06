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
    
    class CourseOfferingTestCase extends UnitTestCase {
      
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
        
        function TestOfCourseOffering() {
          	/* First test case */
          	// Canonical course test
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
          	
          	// Course offering test
          	
          	$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	
          	$courseOfferingA =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);
          	$courseOfferingB =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	
          	$this->assertEqual($courseOfferingA->getTitle(), $courseOfferingB->getTitle());
          	$this->assertEqual($courseOfferingA->getDescription(), $courseOfferingB->getDescription());
          	$this->assertEqual($courseOfferingA->getDisplayName(), $courseOfferingB->getDisplayName());
          	$this->assertEqual($courseOfferingA->getNumber(), $courseOfferingB->getNumber());
          	$this->assertEqual($courseOfferingA->getTitle(), $courseOfferingB->getTitle());
          	$this->assertEqual($courseOfferingA->getTitle(), "Intro to Computer Science");
          	$this->assertFalse($courseOfferingB->getDescription() == "Intro to Sociocultural Anthropology");
          	$this->assertFalse($courseOfferingB->getDescription() == "Yeah!  Buggles!.");
          	$this->assertTrue($courseOfferingB->getDescription() == "Yeah!  Buggles!");
          	$this->assertEqual($courseOfferingB->getNumber(), "CS101");
          	
          	$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	
          	$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
          	$courseManagementManager->deleteCanonicalCourse($canonicalCourseA->getId());
		}
		
		function assertEqualTypes(&$typeA,&$typeB){
			
			$this->assertEqual($typeA->getDomain(),$typeB->getDomain());
			$this->assertEqual($typeA->getAuthority(),$typeB->getAuthority());
			$this->assertEqual($typeA->getKeyword(),$typeB->getKeyword());
			$this->assertEqual($typeA->getDescription(),$typeB->getDescription());
		}
    }
?>