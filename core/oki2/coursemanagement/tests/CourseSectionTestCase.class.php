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
    
    class CourseSectionTestCase extends UnitTestCase {
      
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
    		$cmm =& Services::getService("CourseManagement");
    		$title = "Introduction to Computer Science";
    		$number = "CS101";
    		$description = "Oh, buggle buggle";
    		$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
    		$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "Highly recommended");
    		$credits = "3.14159";
    		
    		$canonicalCourse = $cmm->createCanonicalCourse($title, $number, $description, $courseType,
														   $courseStatusType, $credits);
			
			$termType =& new Type("CourseManagement", "edu.middlebury", "Fall 2006");
          	$schedule = "2006-2007";
          	$term =& $cmm->createTerm($termType, $schedule);
          	$termId =& $term->getId();
          	$offeringType = $courseType;
          	$offeringStatusType = $courseStatusType;
          	$courseGradeType = new Type("CourseManagement", "edu.middlebury", "LetterGrade");
			
			$courseOffering = $canonicalCourse->createCourseOffering($title, $number, $description, $termId,
			  														 $offeringType, $offeringStatusType, 
																	 $courseGradeType);
			
			$sectionType = new Type("CourseManagement", "edu.middlebury", "A", "CSCI");
			$sectionStatusType = new Type("CourseManagement", "edu.middlebury", "Open", "You can still register");
			$location = "Bicentennial Hall 505";
			$courseSectionA = $courseOffering->createCourseSection($title, $number, $description, $sectionType, 
																   $sectionStatusType, $location);
																   
			$sectionType = new Type("CourseManagement", "edu.middlebury", "B", "CSCI");
			$sectionStatusType = new Type("CourseManagement", "edu.middlebury", "Full", "Closed");
			$courseSectionB = $courseOffering->createCourseSection($title, $number, $description, $sectionType, 
																   $sectionStatusType, $location);
			
			$this->assertEqual($courseSectionA->getTitle(), "Introduction to Computer Science");
			$this->assertEqual($courseSectionA->getTitle(), $courseSectionB->getTitle());
          	$this->assertEqual($courseSectionA->getDescription(), $courseSectionB->getDescription());
          	$this->assertEqual($courseSectionA->getDisplayName(), $courseSectionB->getDisplayName());
          	$this->assertEqual($courseSectionA->getNumber(), $courseSectionB->getNumber());
          	$this->assertFalse($courseSectionB->getDescription() == "Intro to Sociocultural Anthropology");
          	$this->assertFalse($courseSectionA->getDescription() == "Newtonian Physics");
          	$this->assertFalse($courseSectionB->getDescription() == "Yeah!  Buggles!.");
          	$this->assertTrue($courseSectionB->getDescription() == "Oh, buggle buggle");
          	$this->assertEqual($courseSectionB->getNumber(), "CS101");
          	$this->assertNotEqualTypes($courseSectionA->getSectionType(), $courseSectionB->getSectionType());
          	$this->assertNotEqualTypes($courseSectionA->getStatus(), 
			  						   $courseSectionB->getStatus());
			$this->assertEqual($courseSectionA->getLocation(), "Bicentennial Hall 505");
			$location = "Bicentennial Hall 632";
			$courseSectionA->updateLocation($location);
			$this->assertNotEqual($courseSectionA->getLocation(), "Bicentennial Hall 505");
			$this->assertNotEqual($courseSectionA->getLocation(), $courseSectionB->getLocation());
                    		
			// Create enrollment statuses
			$enrollmentStatusTypeA =& new Type("CourseManagement", "edu.middlebury", "Registered");
			$enrollemntStatusTypeB =& new Type("CourseManagement", "edu.middlebury", "Audited");
			
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
			$propertiesTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesB =& new HarmoniProperties($propertiesTypeB);
			$name = "John Lee";
			$propertiesB->addProperty('student_name', $name);
			$propertiesB->addProperty('student_year', $class);	
			
			$agentTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentB =& $agentHandler->createAgent("John Lee", $agentTypeB, $propertiesB);
			
			$propertiesTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesC =& new HarmoniProperties($propertiesTypeC);
			$name = "Magdalena Widjaja";
			$propertiesC->addProperty('student_name', $name);
			$propertiesC->addProperty('student_year', $class);	
			
			$agentTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentC =& $agentHandler->createAgent("John Lee", $agentTypeC, $propertiesC);
			
			$agentIdA =& $agentA->getId();
			$agentIdB =& $agentB->getId();
			$agentIdC =& $agentC->getId();
			
			// Add students to course section
			$courseSectionA->addStudent($agentIdA, $enrollmentStautsTypeA);
			$courseSectionA->addStudent($agentIdB, $enrollmentStautsTypeB);
			$courseSectionA->addStudent($agentIdC, $enrollmentStatusTypeA);
			
			$roster = $courseSectionA->getRoster();
			print "\n";
			print_r($roster);
			
			// Should print Tim and Mag
			$registerRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeA);
			print "\n";
			print_r($registerRoster);
			// Should print only John
			$auditRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeB);
			print "\n";
			print_r($auditRoster);
			
			$courseSectionA->changeStudent($agentIdA, $enrollmentStatusTypeB);
			
			// Should print only Mag
			$registerRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeA);
			print "\n";
			print_r($registerRoster);
			// Should print Tim and John
			$auditRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeB);
			print "\n";
			print_r($auditRoster);
			
			$courseSectionA->removeStudent($agentIdA);
			$courseSectionA->getRoster();
			print "\n";
			print_r($roster);
			
			$courseSectionA->removeStudent($agentIdB);
			$courseSectionA->getRoster();
			print "\n";
			print_r($roster);
			
			$courseSectionA->removeStudent($agentIdC);
			$courseSectionA->getRoster();
			print "\n";
			print_r($roster);
			
			$properties = $courseSectionA->getProperties();
			print_r($properties);
			
			$propertyTypes = $courseSectionA->getPropertyTypes();
			print_r($propertyTypes);
								
			$courseOffering->deleteCourseSection($courseSectionA->getId());
          	$courseOffering->deleteCourseSection($courseSectionB->getId());
          	$canonicalCourse->deleteCourseOffering($courseOffering->getId());
          	$cmm->deleteCanonicalCourse($canonicalCourse->getId());  
						            
            /*tests*/
				
		/**
	
	function addAsset ( &$assetId ) { 
	
	function removeAsset ( &$assetId ) { 
	
	function &getAssets () {  
	
*/
		}
		
		function assertEqualTypes(&$typeA, &$typeB) {
			$this->assertEqual($typeA->getDomain(), $typeB->getDomain());
			$this->assertEqual($typeA->getAuthority(), $typeB->getAuthority());
			$this->assertEqual($typeA->getKeyword(), $typeB->getKeyword());
		}
		
		function assertNotEqualTypes(&$typeA, &$typeB) {  
			$this->assertTrue($typeA->getDomain() != $typeB->getDomain() ||	
							  $typeA->getAuthority() != $typeB->getAuthority() ||
							  $typeA->getKeyword() != $typeB->getKeyword()); 
		}
    }
?>