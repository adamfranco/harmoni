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
        
        function TestOfCanonicalCourse() {
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
          	print "course offering3";
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	print "course offering4";
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");
          	$schedule = "2006-2007";
          	print "course offering5";
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	print "course offering6";
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	print "course offering7";
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	print "course offering8";
          	
          	$courseOfferingA =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);
          	$courseOfferingB =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	print "course offering9";
          	
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
          	
          	$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
          	$courseManagementManager->deleteCanonicalCourse($canonicalCourseA->getId());
          	
          	// Second test case
          	// Canonical course test
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
        
          	// Course offering test
          	$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Spring 2006");
          	$schedule = "2005-2006";
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	
          	$courseOfferingA =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);
          	$courseOfferingB =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	
          	$this->assertEqual($courseOfferingA->getTitle(), $canonicalCourseB->getTitle());
          	$this->assertEqual($courseOfferingA->getTitle(), "Intro to Sociocultural Anthropology");
          	$this->assertTrue($courseOfferingB->getDescription() == "Life is a mystery");
          	$this->assertFalse($courseOfferingB->getDescription() == "Life is a mystery.");
          	$this->assertFalse($courseOfferingB->getDescription() == "Intro to Computer Science");
			
			$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
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
			
			// Course offering test
			$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Spring 2007");
          	$schedule = "2006-2007";
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	
          	$courseOfferingA =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);
          	$courseOfferingB =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	$courseOfferingD =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	
          	$this->assertEqual($courseOfferingA->getTitle(), $courseOfferingB->getTitle());
			$this->assertEqual($courseOfferingD->getTitle(), $courseOfferingB->getTitle());
			$this->assertEqualTypes($courseOfferingB->getStatus(),$courseOfferingA->getStatus());
			$this->assertEqualTypes($courseOfferingB->getOfferingType(),$courseOfferingA->getOfferingType());
			
			$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
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
			
			// Course offering test
			$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2007");
          	$schedule = "2007-2008";
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
			$this->assertEqualTypes($courseOfferingA->getStatus(),$courseOfferingB->getStatus());
			$this->assertEqualTypes($courseOfferingA->getOfferingType(),$courseOfferingB->getOfferingType());
			
			$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
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
				print "5B test";
			$this->assertEqual($canonicalCourseB->getId(), $canonicalCourseC->getId());
			$this->assertEqual($canonicalCourseB->getTitle(), $canonicalCourseC->getTitle());
			$this->assertEqual($canonicalCourseB->getTitle(), "Microbiology");
			$this->assertTrue($canonicalCourseB->getNumber() == "BI310");
				print "5C test";
			$this->assertEqual($canonicalCourseC->getNumber(), "BI310");
			$this->assertFalse($canonicalCourseC->getTitle() == "Real Analaysis");
			
			// Sixth test - modifying various attributes of canonical course (will use previous values)
			print "sixth test";
			
			// $canonicalCourseD is the third test case - this should not have changed.
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
			$title = $canonicalCourseB->getTitle();
          	$number = $canonicalCourseB->getNumber();
          	$description = $canonicalCourseB->getDescription();
          	$credits = $canonicalCourseB->getCredits();
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Spring 2007");
          	$schedule = "2006-2007";
          	$term =& $courseManagementManager->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
          	
          	$courseOfferingA =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);
			$title = "Intro to Microeconomics";
			$courseOfferingB =& $canonicalCourseB->createCourseOffering($title, $number, $description, $termId,
			  															$offeringType, $offeringStatusType, 
																		$courseGradeType);								
																		
          	$courseOfferingB =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
          	$offeringType =& $courseOfferingA->getOfferingType();
          	$iterator =& $canonicalCourseB->getCourseOfferingsByType($offeringType);
			$courseOfferingD =& $iterator->nextCourseOffering();
			$courseOfferingC =& $courseManagementManager->getCourseOffering($courseOfferingA->getId());
			// CourseOfferingC is equal to CourseOfferingA
			
			$this->assertEqual($courseOfferingD->getTitle(), "Intro to Microeconomics");
			// CourseOfferingD should be the same as CourseOfferingB - the next course offering with the same type.
			
			$courseOfferingB->updateTitle("Economic Statistics");
			$courseOfferingB->updateNumber("ECON210");
			$courseOfferingB->updateDescription("Snore");
			//$this->assertNotReference($canonicalCourseD, $canonicalCourseB);
			//$this->assertReference($canonicalCourseB, $canonicalCourseC);
			$this->assertEqual($courseOfferingB->getTitle(), "Economic Statistics");
			$this->assertEqual($courseOfferingB->getNumber(), "ECON210");
			$this->assertEqual($courseOfferingB->getDescription(), "Snore");
			$this->assertEqual($courseOfferingC->getTitle(), "Economic Statistics");
			
			$canonicalCourseB->deleteCourseOffering($courseOfferingD->getId());
			$canonicalCourseB->deleteCourseOffering($courseOfferingA->getId());
			
			// Make new type that cannot be searched
			$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "PassFail");
			$courseOfferingIterator = $canonicalCourseA->getCourseOfferingsByType($courseStatusType);
			$this->assertFalse($courseOfferingIterator->hasNextCourseOffering());	
				
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