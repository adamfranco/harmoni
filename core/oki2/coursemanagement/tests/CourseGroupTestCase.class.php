<?php
    // Tests by Tim Bahls
    
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
    
    class CourseGroupTestCase extends OKIUnitTestCase{
      
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
        
        function TestOfCourseGroup() {
        	
        	
        	$cm =& Services::getService("CourseManagement");
        	
        	$this->write(7,"CourseGroup Test");
        	
        	
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	
          	
          	$deptGroupType =& new Type("CourseManagement", "edu.middlebury", "Department", "These courses are in one department");
          	$buddyGroupType =& new Type("CourseManagement", "edu.middlebury", "Buddies", "These courses are all buddies");
          	$fakeGroupType =& new Type("CourseManagement", "edu.middlebury", "__FAKE!!!!?!?!?!?!__", "No group has this type");
          	
          	
          	$deptGroup1 =& $cm->createCourseGroup($deptGroupType);
          	$deptGroup2 =& $cm->createCourseGroup($deptGroupType);
          	$buddyGroup1 =& $cm->createCourseGroup($buddyGroupType);
          	$buddyGroup2 =& $cm->createCourseGroup($buddyGroupType);
          	
        
         
   		
          	$this->write(4,"Test of basic get methods");   
          	
         
          	$this->assertEqualTypes($deptGroup1->getType(),$deptGroupType);
          	$this->assertEqualTypes($deptGroup2->getType(),$deptGroupType);
          	$this->assertEqualTypes($buddyGroup1->getType(),$buddyGroupType);
          	
          	
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	
         	
          	
          	$deptGroup1->updateDisplayName("Computer Science");
          	$deptGroup2->updateDisplayName("Art");  
          	$buddyGroup1->updateDisplayName("Intro Courses");  
          	$buddyGroup2->updateDisplayName("Related to 3D modeling");    
          	
          	
     
			
			$this->assertEqual($deptGroup1->getDisplayName(),"Computer Science");	
			$this->assertEqual($deptGroup2->getDisplayName(),"Art");	
			$this->assertEqual($buddyGroup1->getDisplayName(),"Intro Courses");	
			$this->assertEqual($buddyGroup2->getDisplayName(),"Related to 3D modeling");
			
          	         	
          	$this->write(4,"Test of getCourseGroup()");
          	
          	$deptGroup1a =& $cm->getCourseGroup($deptGroup1->getID());
          	$buddyGroup2a =& $cm->getCourseGroup($buddyGroup2->getID());
          	
          	
          	$this->assertEqual($deptGroup1->getID(),$deptGroup1a->getID());
          	$this->assertEqual($deptGroup1->getDisplayName(),$deptGroup1a->getDisplayName());
          	$this->assertEqualTypes($deptGroup1->getType(),$deptGroup1a->getType());
          	
          	
          	$this->assertEqual($buddyGroup2->getID(),$buddyGroup2a->getID());
          	$this->assertEqual($buddyGroup2->getDisplayName(),$buddyGroup2a->getDisplayName());
          	$this->assertEqualTypes($buddyGroup2->getType(),$buddyGroup2a->getType());
          	
          	
          	
          	$this->write(4,"Test of adding and removing courses");
          	
          	
          	
          	
          	
       
          	$cs1 =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$courseType, $courseStatusType,1);
          	$cs2 =& $cm->createCanonicalCourse("Computer Graphics", "CSCI367", "",$courseType, $courseStatusType,1);
          	
          	$ar1 =& $cm->createCanonicalCourse("Intro to Art", "ART101", "",$courseType, $courseStatusType,1);
          	$ar2 =& $cm->createCanonicalCourse("Learning computer animation", "ART432", "",$courseType, $courseStatusType,1);
          	
          	
          	$deptGroup1->addCourse($cs1->getId());
          	$deptGroup1->addCourse($cs2->getId());
          	
          	$deptGroup2->addCourse($ar1->getId());
          	$deptGroup2->addCourse($ar2->getId());
          	
          	$buddyGroup1->addCourse($cs1->getId());
          	$buddyGroup1->addCourse($ar1->getId());
          	
          	$buddyGroup2->addCourse($cs2->getId());
          	$buddyGroup2->addCourse($ar2->getId());
          	
          	
          	
          	
          	$this->write(1,"Group A");
          	
          	$iter1 =& $deptGroup1->getCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs1);
			$this->assertIteratorHasItemWithId($iter1, $cs2);
			$this->assertIteratorLacksItemWithId($iter1, $ar1);
			$this->assertIteratorLacksItemWithId($iter1, $ar2);
			$iter1 =& $deptGroup2->getCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs1);
			$this->assertIteratorLacksItemWithId($iter1, $cs2);
			$this->assertIteratorHasItemWithId($iter1, $ar1);
			$this->assertIteratorHasItemWithId($iter1, $ar2);
			$iter1 =& $buddyGroup1->getCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs1);
			$this->assertIteratorLacksItemWithId($iter1, $cs2);
			$this->assertIteratorHasItemWithId($iter1, $ar1);
			$this->assertIteratorLacksItemWithId($iter1, $ar2);
			$iter1 =& $buddyGroup2->getCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs1);
			$this->assertIteratorHasItemWithId($iter1, $cs2);
			$this->assertIteratorLacksItemWithId($iter1, $ar1);
			$this->assertIteratorHasItemWithId($iter1, $ar2);
	
          	
			$deptGroup1->removeCourse($cs1->getId());
          	$deptGroup1->removeCourse($cs2->getId());
          	
          	$deptGroup2->removeCourse($ar1->getId());
          	
          	$this->write(1,"Group B");
          	
          	$iter1 =& $deptGroup1->getCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs1);
			$this->assertIteratorLacksItemWithId($iter1, $cs2);
			$this->assertIteratorLacksItemWithId($iter1, $ar1);
			$this->assertIteratorLacksItemWithId($iter1, $ar2);
			$iter1 =& $deptGroup2->getCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs1);
			$this->assertIteratorLacksItemWithId($iter1, $cs2);
			$this->assertIteratorLacksItemWithId($iter1, $ar1);
			$this->assertIteratorHasItemWithId($iter1, $ar2);
			$iter1 =& $buddyGroup1->getCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs1);
			$this->assertIteratorLacksItemWithId($iter1, $cs2);
			$this->assertIteratorHasItemWithId($iter1, $ar1);
			$this->assertIteratorLacksItemWithId($iter1, $ar2);
			$iter1 =& $buddyGroup2->getCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs1);
			$this->assertIteratorHasItemWithId($iter1, $cs2);
			$this->assertIteratorLacksItemWithId($iter1, $ar1);
			$this->assertIteratorHasItemWithId($iter1, $ar2);
			
			$deptGroup1->addCourse($cs1->getId());
          	$deptGroup1->addCourse($cs2->getId());
          	
          	$deptGroup2->addCourse($ar1->getId());

    
          		
          	
          	$this->write(4,"Test of getCourseGroups(), getCourseGroupsByType(), and getCourseGroupTypes()");
          	
          	
          	$this->write(1,"Group A");
          	
          	$iter =& $cm->getCourseGroupTypes();
          	$this->assertTrue($this->typeIteratorHas($iter,$buddyGroupType));
          	$this->assertTrue($this->typeIteratorHas($iter,$deptGroupType));
          	$this->assertTrue(!$this->typeIteratorHas($iter,$fakeGroupType));
          	
          	$this->write(1,"Group B");
          	
			
			$iter =& $cm->getCourseGroupsByType($deptGroupType);
			$this->assertIteratorHasItemWithId($iter, $deptGroup1);
			$this->assertIteratorHasItemWithId($iter, $deptGroup2);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup1);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup2);
			$iter =& $cm->getCourseGroupsByType($buddyGroupType);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup1);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup2);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup1);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup2);
			$iter =& $cm->getCourseGroupsByType($fakeGroupType);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup1);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup2);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup1);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup2);
		

          	$this->write(1,"Group C");
          	
          	$iter =& $cm->getCourseGroups($cs1->getId());
			$this->assertIteratorHasItemWithId($iter, $deptGroup1);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup2);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup1);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup2);
          	$iter =& $cm->getCourseGroups($cs2->getId());
			$this->assertIteratorHasItemWithId($iter, $deptGroup1);
			$this->assertIteratorLacksItemWithId($iter, $deptGroup2);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup1);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup2);
			$iter =& $cm->getCourseGroups($ar1->getId());
			$this->assertIteratorLacksItemWithId($iter, $deptGroup1);
			$this->assertIteratorHasItemWithId($iter, $deptGroup2);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup1);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup2);
			$iter =& $cm->getCourseGroups($ar2->getId());
			$this->assertIteratorLacksItemWithId($iter, $deptGroup1);
			$this->assertIteratorHasItemWithId($iter, $deptGroup2);
			$this->assertIteratorLacksItemWithId($iter, $buddyGroup1);
			$this->assertIteratorHasItemWithId($iter, $buddyGroup2);
          	
          	
          	
          	/*
          	
          	
          	 	$title = "Intro to Computer Science";
          	$number = "CS101";
          	$description = "Yeah!  Buggles!";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "3.14159";
          	
       
          	$cs101 =& $cm->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
          	
          	
          	
			$this->write(4,"Test of topics");
			
			$iter =& $cs101->getTopics();
			$this->assertTrue(!$this->stringIteratorHas($iter, "Buggles"));
			$this->assertTrue(!$this->stringIteratorHas($iter, "Computers"));
			$this->assertTrue(!$this->stringIteratorHas($iter, "ScharBraid"));
			
			$cs101->addTopic("Buggles");
			$cs101->addTopic("Computers");
			$cs101->addTopic("ScharBraid");
			
			$iter =& $cs101->getTopics();
			$this->assertTrue($this->stringIteratorHas($iter, "Buggles"));
			$this->assertTrue($this->stringIteratorHas($iter, "Computers"));
			$this->assertTrue($this->stringIteratorHas($iter, "ScharBraid"));
			
			
			$cs101->removeTopic("Buggles");
			$cs101->removeTopic("Computers");
			
			$iter =& $cs101->getTopics();
			$this->assertTrue(!$this->stringIteratorHas($iter, "Buggles"));
			$this->assertTrue(!$this->stringIteratorHas($iter, "Computers"));
			$this->assertTrue($this->stringIteratorHas($iter, "ScharBraid"));
			
			$cs101->removeTopic("ScharBraid");
			
			$iter =& $cs101->getTopics();
			$this->assertTrue(!$this->stringIteratorHas($iter, "Buggles"));
			$this->assertTrue(!$this->stringIteratorHas($iter, "Computers"));
			$this->assertTrue(!$this->stringIteratorHas($iter, "ScharBraid"));
			
			$this->write(4,"Test of equivalent courses");
			
			$title = "Comp sci numbers";
          	$number = "CS102";
          	$description = "Just be a math major, okay";
          	$courseType2 =& new Type("CourseManagement", "edu.middlebury", "Nastiness", "Free roadkill");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "1";
          	
       
          	$cs102 =& $cs101->createCanonicalCourse($title, $number, $description, 
			  																	$courseType2, $courseStatusType,
												                                $credits);
												                                
			$title = "Not a course";
          	$number = "CS103";
          	$description = "No really";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "0";
          	
       
          	$cs103 =& $cs101->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
			
			$this->write(1,"Group A:");									                                
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			$this->write(1,"Group B:");	
			
			$cs101->addEquivalentCourse($cs102->getId());								                                
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->write(1,"Group C:");	
			$cs101->removeEquivalentCourse($cs102->getId());	
			

			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			$this->write(1,"Group D:");	
			$cs102->addEquivalentCourse($cs101->getId());								                                
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			$this->write(1,"Group E:");	
			$cs103->addEquivalentCourse($cs101->getId());
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			$this->write(1,"Group F:");	
			
			
			$cs102->removeEquivalentCourse($cs101->getId());
			
			
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			$this->write(1,"Group G:");	
			
			$cs102->addEquivalentCourse($cs101->getId());
			$cs103->removeEquivalentCourse($cs103->getId());
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs102->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			
			
												                                
			$title = "Also Not a course";
          	$number = "CS104";
          	$description = "No really really";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "0";
          	
       
          	$cs104 =& $cs102->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);												                                
												                                
			$cs103->addEquivalentCourse($cs104->getId());
			
			$this->write(1,"Group H:");	
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			

			$cs103->addEquivalentCourse($cs102->getId());
			  
			$this->write(1,"Group I:");	
			
			
			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			
			$cs104->removeEquivalentCourse($cs101->getId());
			
			$this->write(1,"Group J:");	

			$iter1 =& $cs101->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$iter1 =& $cs103->getEquivalentCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			  
			
			$this->write(4,"Test of hierarchical CanonicalCourses and getting by Type");
			
			
			
			$title = "Lone course";
          	$number = "CS105";
          	$description = "Only the lonely";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "2";
          	
       
          	$cs105 =& $cm->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);		
			
			$this->write(1,"Group A:");										                                


			$iter1 =& $cm->getCanonicalCourses();
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			$this->assertIteratorHasItemWithId($iter1, $cs105);
			$iter1 =& $cs101->getCanonicalCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs102->getCanonicalCourses();
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs103->getCanonicalCourses();
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs104->getCanonicalCourses();
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs105->getCanonicalCourses();
			$this->assertFalse($iter1->hasNext());
			
			$this->write(1,"Group B:");										                                

			$iter1 =& $cm->getCanonicalCoursesByType($courseType);
			$this->assertIteratorHasItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			$this->assertIteratorHasItemWithId($iter1, $cs105); 
			$iter1 =& $cs101->getCanonicalCoursesByType($courseType);
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorHasItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs102->getCanonicalCoursesByType($courseType);
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorHasItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs103->getCanonicalCoursesByType($courseType);
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs104->getCanonicalCoursesByType($courseType);
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs105->getCanonicalCoursesByType($courseType);
			$this->assertFalse($iter1->hasNext());
			
			$this->write(1,"Group C:");										                                

			$iter1 =& $cm->getCanonicalCoursesByType($courseType2);
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs101->getCanonicalCoursesByType($courseType2);
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorHasItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs102->getCanonicalCoursesByType($courseType2);
			$this->assertIteratorLacksItemWithId($iter1, $cs101);
			$this->assertIteratorLacksItemWithId($iter1, $cs102);
			$this->assertIteratorLacksItemWithId($iter1, $cs103);
			$this->assertIteratorLacksItemWithId($iter1, $cs104);
			$this->assertIteratorLacksItemWithId($iter1, $cs105);
			$iter1 =& $cs103->getCanonicalCoursesByType($courseType2);
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs104->getCanonicalCoursesByType($courseType2);
			$this->assertFalse($iter1->hasNext());
			$iter1 =& $cs105->getCanonicalCoursesByType($courseType2);
			$this->assertFalse($iter1->hasNext());
			
			
			
			$cm->deleteCanonicalCourse($cs105->getId());
			$cm->deleteCanonicalCourse($cs104->getId());
			$cm->deleteCanonicalCourse($cs103->getId());
			$cm->deleteCanonicalCourse($cs102->getId());
			$cm->deleteCanonicalCourse($cs101->getId());
			
			*/
			
			$cm->deleteCourseGroup($deptGroup1->getId());
			$cm->deleteCourseGroup($deptGroup2->getId());
			$cm->deleteCourseGroup($buddyGroup1->getId());
			$cm->deleteCourseGroup($buddyGroup2->getId());
			
			
			
			
		}
		
		
		
		
    }
?>