<?php
     // Tests by Tim Bahls

     //----------------
    
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
    
    class CanonicalCourseTestCase extends OKIUnitTestCase{
      
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
        	
        	
        	$cm =& Services::getService("CourseManagement");
        	
        	$this->write(7,"Canonical Course Test");
        	
        	
          
          	$title = "Intro to Computer Science";
          	$number = "CS101";
          	$description = "Yeah!  Buggles!";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "3.14159";
          	
       
          	$cs101 =& $cm->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
   		
          	$this->write(4,"Test of basic get methods");   
          	
         
          	$this->assertEqual($cs101->getTitle(), "Intro to Computer Science");
          	$this->assertEqual($cs101->getDisplayName(), "Intro to Computer Science");
          	$this->assertEqual($cs101->getCredits(), "3.14159");
          	$this->assertEqual($cs101->getDescription(), "Yeah!  Buggles!");
          	$this->assertEqual($cs101->getNumber(), "CS101");   	
          	$this->assertEqualTypes($cs101->getCourseType(),$courseType);
          	$this->assertEqualTypes($cs101->getStatus(),$courseStatusType);
          	
          	
          	$this->write(4,"Test of getCanonicalCourse()");
          	
          	$cs101a =& $cm->getCanonicalCourse($cs101->getID());
          	
          	
          	$this->assertEqual($cs101->getID(),$cs101a->getID());
          	$this->assertEqual($cs101a->getTitle(), "Intro to Computer Science");
          	$this->assertEqual($cs101a->getDisplayName(), "Intro to Computer Science");
          	$this->assertEqual($cs101a->getCredits(), "3.14159");
          	$this->assertEqual($cs101a->getDescription(), "Yeah!  Buggles!");
          	$this->assertEqual($cs101a->getNumber(), "CS101");   	
          	$this->assertEqualTypes($cs101a->getCourseType(),$courseType);
          	$this->assertEqualTypes($cs101a->getStatus(),$courseStatusType);   
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	$courseStatusType2 =& new Type("CourseManagement", "edu.middlebury", "No longer offered", "You're out of luck");
         	
          	$cs101->updateDisplayName("Economic Statistics");          	
			$cs101->updateTitle("Snore");					
			$cs101->updateCredits("1234");
			$cs101->updateDescription("Boring stuff");
			$cs101->updateNumber("EC123");			
			$cs101->updateStatus($courseStatusType2);
			
			$this->assertEqual($cs101->getDisplayName(),"Economic Statistics");			
          	$this->assertEqual($cs101->getTitle(), "Snore");
          	$this->assertEqual($cs101->getCredits(), "1234");
          	$this->assertEqual($cs101->getDescription(), "Boring stuff");
          	$this->assertEqual($cs101->getNumber(), "EC123");   	
          	$this->assertEqualTypes($cs101->getStatus(),$courseStatusType2);
			
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
			
			
			$this->write(4,"Test of getting Types");
			
			$iter1 =& $cm->getCourseTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $courseType));
			$this->assertTrue($this->typeIteratorHas($iter1, $courseType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			$iter1 =& $cm->getCourseStatusTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $courseStatusType));
			$this->assertTrue($this->typeIteratorHas($iter1, $courseStatusType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			
			
			$cm->deleteCanonicalCourse($cs105->getId());
			$cm->deleteCanonicalCourse($cs104->getId());
			$cm->deleteCanonicalCourse($cs103->getId());
			$cm->deleteCanonicalCourse($cs102->getId());
			$cm->deleteCanonicalCourse($cs101->getId());
			
			
			$this->write(4,"I guess I need to test this somewhere");
			
			$this->assertTrue($cm->supportsUpdate());
			
			
		}
		
		
    }
?>