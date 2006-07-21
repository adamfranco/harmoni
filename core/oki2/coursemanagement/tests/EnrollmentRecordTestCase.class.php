<?php
   	//tests by Tim Bahls
    
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
    
    class EnrollmentRecordTestCase extends OKIUnitTestCase {
      
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
        
        function TestOfEnrollmentRecord() {
        	
      		$cm =& Services::getService("CourseManagement");
        	$sm =& Services::getService("Scheduling");
        	$am =& Services::getService("Agent");
        	
        	$this->write(7, "Test EnrollmentRecord");

        	
        	$canType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType =& new Type("CourseManagement", "edu.middlebury", "Still offered", "Offerd sometimes");          	
          	$offerType =& new Type("CourseManagement", "edu.middlebury", "default", "");         	
          	$offerStatType =& new Type("CourseManagement", "edu.middlebury", "Full", "You can't still register.");
          	$gradeType =& new Type("CourseManagement", "edu.middlebury", "AutoFail", "Sucks to be you");
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall");         	
          	$sectionType1 =& new Type("CourseManagement", "edu.middlebury", "lecture", "");
          	$sectionType2 =& new Type("CourseManagement", "edu.middlebury", "lab", "");         	          	         	
          	$sectionStatType =& new Type("CourseManagement", "edu.middlebury", "Slots open", "register, baby!");
			$propertiesType =& new Type("CourseManagement", "edu.middlebury", "properties");
			$agentType =& new Type("CourseManagement", "edu.middlebury", "student");
          	$enrollStatType1 =& new Type("CourseManagement", "edu.middlebury", "attending", ""); 
          	$enrollStatType2 =& new Type("CourseManagement", "edu.middlebury", "auditing", "");   
			  
          	
          	
          	$cs1 =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);
          	$cs2 =& $cm->createCanonicalCourse("Computer Graphics", "CSCI367", "descrip",$canType, $canStatType,1);
          	
          	       
          	$agents = array();
          	 	
			$scheduleItemA1 =& $sm->createScheduleItem("Fall 2006 range", "", $agents, 300, 900, null);
			$scheduleItemA2 =& $sm->createScheduleItem("Thanksgiving", "", $agents, 350, 400, null);
			$scheduleItemA3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $agents, 500, 600, null);
			
			
			$scheduleA = array($scheduleItemA1,$scheduleItemA2,$scheduleItemA3);
			
			
			
						
			$term1 =& $cm->createTerm($termType, $scheduleA);
			$term1->updateDisplayName("Fall 2005");
			
			
			
          	$cs1_05 =& $cs1->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType);         
          	$cs2_05 =& $cs2->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType);

          	
          	$loc = "Bihall 632";
          	
          	$cs1A_05 =& $cs1_05->createCourseSection("intro to CS A",null,null, $sectionType1, $sectionStatType,$loc);
          	$cs1Z_05 =& $cs1_05->createCourseSection("intro to CS Z",null,null, $sectionType2, $sectionStatType,$loc);
          	$cs2A_05 =& $cs2_05->createCourseSection("Graphics Z",null,null, $sectionType2, $sectionStatType,$loc);
          	
          	
        	
        	
			
			
			$properties =& new HarmoniProperties($propertiesType);
			$agent1 =& $am->createAgent("Gladius", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent2 =& $am->createAgent("Madga", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent3 =& $am->createAgent("nood8?jood8", $agentType, $properties);
        	
			
			
          	$cs1A_05->addStudent($agent3->getId(), $enrollStatType1);         	
			$cs1Z_05->addStudent($agent1->getId(), $enrollStatType1);
			$cs2A_05->addStudent($agent3->getId(), $enrollStatType2);			
		
			
			$roster1 =& $cs1A_05->getRoster();
			$roster2 =& $cs1Z_05->getRoster();
			$roster3 =& $cs2A_05->getRoster();
			
			$this->write(4,"Test of basic get methods");  
			
			$this->assertTrue($roster1->hasNextEnrollmentRecord());
			if($roster1->hasNextEnrollmentRecord()){
				$record =& $roster1->nextEnrollmentRecord();
				$this->assertEqualTypes($record->getStatus(),$enrollStatType1);
				$this->assertEqualIds($record->getStudent(),$agent3->getId());	    	
          		$this->assertHaveEqualIds($record->getCourseSection(),$cs1A_05);					
			}
			
			$this->assertTrue($roster2->hasNextEnrollmentRecord());
			if($roster2->hasNextEnrollmentRecord()){
				$record =& $roster2->nextEnrollmentRecord();
				$this->assertEqualTypes($record->getStatus(),$enrollStatType1);
				$this->assertEqualIds($record->getStudent(),$agent1->getId());					  	
          		$this->assertHaveEqualIds($record->getCourseSection(),$cs1Z_05);					
			}
			
			$this->assertTrue($roster3->hasNextEnrollmentRecord());
			if($roster3->hasNextEnrollmentRecord()){
				$record =& $roster3->nextEnrollmentRecord();
				$this->assertEqualTypes($record->getStatus(),$enrollStatType2);
				$this->assertEqualIds($record->getStudent(),$agent3->getId());	    	
          		$this->assertHaveEqualIds($record->getCourseSection(),$cs2A_05);					
			}
			
          	
			 
          	
       		
         
       	
          	//$this->assertEqualTypes($cs1A_05->getSectionType(),$sectionType1);         	
          	//$this->assertHaveEqualIds($cs1A_05->getCourseOffering(),$cs1_05);		
			
			
          	
			$this->write(4,"Test of adding and getRoster and getRosterByType");
          	
			
			
          	$cs1A_05->addStudent($agent1->getId(), $enrollStatType2);
			$cs1Z_05->addStudent($agent2->getId(), $enrollStatType2);
			$cs2A_05->addStudent($agent2->getId(), $enrollStatType1);
          	
          	
          	
			
			
			$this->write(1,"Group A");
          	$toGet =& $cs1A_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));          	
          	
        	$this->write(1,"Group B");
          	$toGet =& $cs1Z_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group C");
          	$toGet =& $cs2A_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group D");
          	$toGet =& $cs1_05;
			$roster =& $toGet->getRoster();			
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);				
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group E");
          	$toGet =& $cs2_05;
			$roster =& $toGet->getRoster();	
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));
       	
			
			$this->write(4,"Test getting courses by agent");
			
			
			
			$this->write(1,"Group A");
        	$iter =& $cm->getCourseOfferings($agent1->getId());
        	$this->assertIteratorHasItemWithId($iter, $cs1_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_05);

			$this->write(1,"Group B");
        	$iter =& $cm->getCourseOfferings($agent2->getId());
        	$this->assertIteratorHasItemWithId($iter, $cs1_05);
        	$this->assertIteratorHasItemWithId($iter, $cs2_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_05);
        	
        	$this->write(1,"Group C");
        	$iter =& $cm->getCourseOfferings($agent3->getId());
        	$this->assertIteratorHasItemWithId($iter, $cs1_05);
        	$this->assertIteratorHasItemWithId($iter, $cs2_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_05);
        	
        	$this->write(1,"Group D");
        	$iter =& $cm->getCourseSections($agent1->getId());
        	$this->assertIteratorLacksItemWithId($iter, $cs1_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1A_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_05);
        	
        	$this->write(1,"Group E");
        	$iter =& $cm->getCourseSections($agent2->getId());
        	$this->assertIteratorLacksItemWithId($iter, $cs1_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorHasItemWithId($iter, $cs2A_05);
        	
        	$this->write(1,"Group F");
        	$iter =& $cm->getCourseSections($agent3->getId());
        	$this->assertIteratorLacksItemWithId($iter, $cs1_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs2_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorHasItemWithId($iter, $cs2A_05);
			
			
          	$this->write(4,"Test of removeStudent and ChangeStudent");
          	
			
			
          	$cs2A_05->addStudent($agent1->getId(), $enrollStatType2);
			$cs2A_05->changeStudent($agent2->getId(), $enrollStatType2);
			$cs1Z_05->changeStudent($agent2->getId(), $enrollStatType1);
          	
          	$cs1A_05->removeStudent($agent3->getId());
          	
          	$cs1_05->removeStudent($agent1->getId()); 	
          	
			$this->write(1,"Group A");
          	$toGet =& $cs1A_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));          	
          	
        	$this->write(1,"Group B");
          	$toGet =& $cs1Z_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group C");
          	$toGet =& $cs2A_05;
			$roster =& $toGet->getRoster();
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group D");
          	$toGet =& $cs1_05;
			$roster =& $toGet->getRoster();			
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);				
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			
			$this->write(1,"Group E");
          	$toGet =& $cs2_05;
			$roster =& $toGet->getRoster();	
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));			
			$roster =& $toGet->getRosterByType($enrollStatType1);					
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,$agent3));
			$roster =& $toGet->getRosterByType($enrollStatType2);					
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent1));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent2));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,$agent3));

     
          	

       	 	$cs1_05->removeStudent($agent1->getId());
       		$cs1_05->removeStudent($agent2->getId());
        	$cs1_05->removeStudent($agent3->getId());
        
        	$cs2_05->removeStudent($agent1->getId());
        	$cs2_05->removeStudent($agent2->getId());
        	$cs2_05->removeStudent($agent3->getId());
        	
        	$this->write(1,"Group F");
			$roster =& $cs1A_05->getRoster();
			$this->assertTrue(!$roster->hasNextEnrollmentRecord());
        	$roster =& $cs1Z_05->getRoster();
			$this->assertTrue(!$roster->hasNextEnrollmentRecord());
			$roster =& $cs2A_05->getRoster();
			$this->assertTrue(!$roster->hasNextEnrollmentRecord());
			$roster =& $cs1_05->getRoster();
			$this->assertTrue(!$roster->hasNextEnrollmentRecord());
			$roster =& $cs2_05->getRoster();
			$this->assertTrue(!$roster->hasNextEnrollmentRecord());
        	
        		
        	$this->write(4,"Test of getting Types");
		
			$iter1 =& $cm->getSectionTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionType1));
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
		
        	
			
          	
          	$cs1_05->deleteCourseSection($cs1A_05->getId());
        	$cs1_05->deleteCourseSection($cs1Z_05->getId());
        	$cs1_05->deleteCourseSection($cs2A_05->getId());
          	
        	$cs1->deleteCourseOffering($cs1_05->getId());
        	$cs1->deleteCourseOffering($cs2_05->getId());
       
        	
        	$cm->deleteCanonicalCourse($cs1->getId());
        	$cm->deleteCanonicalCourse($cs2->getId());
        	
        	
        	$sm->deleteScheduleItem($scheduleItemA1->getId());
			$sm->deleteScheduleItem($scheduleItemA2->getId());
			$sm->deleteScheduleItem($scheduleItemA3->getId());
	
        	
        	$cm->deleteTerm($term1->getId());

			
        	
        	
        	/*
        	$this->write(7,"Test Course Section");
        	
        	$this->write(3,"Making courses");
        	

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
          	$scheduleManager =& Services::GetService("Scheduling");
          	
          	$schedule[] =& $scheduleManager->createScheduleItem("Term", "The whole shebang",$arr=array(),200,1000,null);
          	$schedule[] =& $scheduleManager->createScheduleItem("Halloween", "Boo!",$arr=array(),250,300,null);
          	$schedule[] =& $scheduleManager->createScheduleItem("Christmas", "Unfortunately secular!",$arr=array(),700,800,null);
          	
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
			$this->write(3,"update location");
			$courseSectionA->updateLocation($location);
			$this->assertNotEqual($courseSectionA->getLocation(), "Bicentennial Hall 505");
			$this->assertNotEqual($courseSectionA->getLocation(), $courseSectionB->getLocation());
    					
			// Create enrollment statuses
			$enrollmentStatusTypeA =& new Type("CourseManagement", "edu.middlebury", "Registered");
			$enrollmentStatusTypeB =& new Type("CourseManagement", "edu.middlebury", "Audited");
			
			$this->write(5,"Making students");
			//$this->write(2,"SporkTim");
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
			//$this->write(2,"John");
			$propertiesTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesB =& new HarmoniProperties($propertiesTypeB);
			$name = "John Lee";
			$propertiesB->addProperty('student_name', $name);
			$propertiesB->addProperty('student_year', $class);	
			
			$agentTypeB =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentB =& $agentHandler->createAgent("jood8", $agentTypeB, $propertiesB);
			
			// Create new student 3
			//$this->write(2,"Magda");
			$propertiesTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$propertiesC =& new HarmoniProperties($propertiesTypeC);
			$name = "Magdalena Widjaja";
			$propertiesC->addProperty('student_name', $name);
			$propertiesC->addProperty('student_year', $class);	
			
			$agentTypeC =& new Type("CourseManagement", "edu.middlebury", "student");
			$agentC =& $agentHandler->createAgent("Mags", $agentTypeC, $propertiesC);
			
			$agentIdA =& $agentA->getId();
			$agentIdB =& $agentB->getId();
			$agentIdC =& $agentC->getId();
			
			$this->write(3,"add students to course");
			// Add students to course section
			$courseSectionA->addStudent($agentIdA, $enrollmentStatusTypeA);
			$courseSectionA->addStudent($agentIdB, $enrollmentStatusTypeB);
			$courseSectionA->addStudent($agentIdC, $enrollmentStatusTypeA);
			
			//$this->write(3, "getRoster");
			$roster = $courseSectionA->getRoster();
			//$this->printRoster($roster);
			
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"Mags"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"jood8"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"Gladius"));
			
			$this->write(5, "getRosterByType");
			// Should print Tim and Mag		
			//$this->write(3, "registerRoster");	
			$registerRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeA);		
			//$this->printRoster($roster);			
			$this->assertTrue($this->enrollmentIteratorHasStudent($registerRoster,"Mags"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($registerRoster,"jood8"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($registerRoster,"Gladius"));
			
			// Should print only John
			//$this->write(3, "auditRoster");
			$auditRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeB);
			//$this->printRoster($roster);
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($auditRoster,"Mags"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($auditRoster,"jood8"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($auditRoster,"Gladius"));
			
			$this->write(5, "Change student");
			$courseSectionA->changeStudent($agentIdA, $enrollmentStatusTypeB);
			
			// Should print only Mag
			//$this->write(3, "registerRoster");
			$registerRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeA);
			//$this->printRoster($roster);
			$this->assertTrue($this->enrollmentIteratorHasStudent($registerRoster,"Mags"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($registerRoster,"jood8"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($registerRoster,"Gladius"));
						
			// Should print Tim and John
			//$this->write(3, "auditRoster");
			$auditRoster = $courseSectionA->getRosterByType($enrollmentStatusTypeB);
			//$this->printRoster($roster);
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($auditRoster,"Mags"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($auditRoster,"jood8"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($auditRoster,"Gladius"));
			
			$this->write(5, "remove student");
			$courseSectionA->removeStudent($agentIdA);
			$roster =& $courseSectionA->getRoster();
			//$this->printRoster($roster);
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"Mags"));
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"jood8"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"Gladius"));
			
			$courseSectionA->removeStudent($agentIdB);
			$roster =& $courseSectionA->getRoster();
		
			$this->assertTrue($this->enrollmentIteratorHasStudent($roster,"Mags"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"jood8"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"Gladius"));
			
			$this->write(5, "remove one more student");
			$courseSectionA->removeStudent($agentIdC);
			$roster =& $courseSectionA->getRoster();
			//$this->printRoster($roster);
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"Mags"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"jood8"));
			$this->assertTrue(!$this->enrollmentIteratorHasStudent($roster,"Gladius"));
			
			$properties = $courseSectionA->getProperties();
			print "<p>";
			print_r($properties);
			
			$propertyTypes = $courseSectionA->getPropertyTypes();
			print "<p>";
			print_r($propertyTypes);
			
			$agentHandler->deleteAgent($agentIdA);
			$agentHandler->deleteAgent($agentIdB);
			$agentHandler->deleteAgent($agentIdC);
								
			$courseOffering->deleteCourseSection($courseSectionA->getId());
          	$courseOffering->deleteCourseSection($courseSectionB->getId());
          	$canonicalCourse->deleteCourseOffering($courseOffering->getId());
          	$cmm->deleteCanonicalCourse($canonicalCourse->getId());  
          	
          	
          	
          	
          	
          	*/
        	
        	
        
        }
        
        
        
        function enrollmentIteratorHasStudent($iter, $agent){
        	//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
			while($iter->hasNext()){
				$am =& Services::GetService("AgentManager");
				$er =& $iter->next();
				$currAgent =& $am->getAgent($er->getStudent());
				
				if($agent->getDisplayName() == $currAgent->getDisplayName()){
					return true;
				}
			}
			return false;
		}
		
		function printRoster($roster){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
			print "\n";
			print "<center><p>{";
			$am =& Services::getService("AgentManager");
			while ($roster->hasNext()) {

			  	$er =& $roster->next();
			  	$id =& $er->getStudent();
			  	$agent =& $am->getAgent($id);
			  	
				print_r($agent->getDisplayName());
				print " ";
		
			}
			print "}</p></center>";
		}
        
        
        
		
    }
?>