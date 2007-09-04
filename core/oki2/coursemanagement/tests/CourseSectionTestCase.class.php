<?php
    // John Lee
    
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
    
    class CourseSectionTestCase extends OKIUnitTestCase {
      
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
        

        function TestOfCourseSection() {
        	
        	$cm = Services::getService("CourseManagement");
        	$sm = Services::getService("Scheduling");
        	
        	$this->write(7, "Test Course Section");

        	
        	$canType = new Type("CanonicalCourseType", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType = new Type("CanonicalCourseStatusType", "edu.middlebury", "Still offered", "Offerd sometimes");          	
          	$offerType = new Type("CourseOfferingType", "edu.middlebury", "default", "");         	
          	$offerStatType = new Type("CourseOfferingStatusType", "edu.middlebury", "Full", "You can't still register.");
          	$gradeType = new Type("GradeType", "edu.middlebury", "AutoFail", "Sucks to be you");
          	$termType = new Type("TermType", "edu.middlebury", "Fall");
          	$scheduleItemType = new Type("ScheduleItemStatusType", "edu.middlebury", "default");
          	
          	$sectionType1 = new Type("CourseSectionType", "edu.middlebury", "lecture", "");
          	$sectionType2 = new Type("CourseSectionType", "edu.middlebury", "lab", "");         	          	         	
          	$sectionStatType1 = new Type("CourseSectionStatusType", "edu.middlebury", "Slots open", "register, baby!");
          	$sectionStatType2 = new Type("CourseSectionStatusType", "edu.middlebury", "Full", "You can't still register.");
          	
          	
          	
          	$cs1 =$cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);
          	$cs2 =$cm->createCanonicalCourse("Computer Graphics", "CSCI367", "descrip",$canType, $canStatType,1);
          	
          	       
          	
          	 	
			$scheduleItemA1 =$sm->createScheduleItem("Fall 2006 range", "", $scheduleItemType, 300, 900, null);
			$scheduleItemA2 =$sm->createScheduleItem("Thanksgiving", "", $scheduleItemType, 350, 400, null);
			$scheduleItemA3 =$sm->createScheduleItem("Christmas", "ho ho ho", $scheduleItemType, 500, 600, null);
			
			$scheduleItemB1 =$sm->createScheduleItem("Fall 2006 range", "", $scheduleItemType, 1300, 1900, null);
			$scheduleItemB2 =$sm->createScheduleItem("Thanksgiving", "", $scheduleItemType, 1350, 1400, null);
			$scheduleItemB3 =$sm->createScheduleItem("Christmas", "ho ho ho", $scheduleItemType, 1500, 1600, null);				
			
			$scheduleItemC1 =$sm->createScheduleItem("Funky time", "", $scheduleItemType, 100, 500, null);
			$scheduleItemC2 =$sm->createScheduleItem("Dance party", "", $scheduleItemType, 700, 1400, null);
	
			
			$scheduleA = array($scheduleItemA1,$scheduleItemA2,$scheduleItemA3);
			$scheduleB = array($scheduleItemB1,$scheduleItemB2,$scheduleItemB3);
			$scheduleC = array($scheduleItemC1,$scheduleItemC2);
			
			
			
						
			$term1 =$cm->createTerm($termType, $scheduleA);
			$term1->updateDisplayName("Fall 2005");
			$term2 =$cm->createTerm($termType, $scheduleB);
			$term2->updateDisplayName("Fall 2006");
			
			
          	$cs1_05 =$cs1->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType);
          	$cs1_06 =$cs1->createCourseOffering(null,null,null, $term2->getId(),$offerType,$offerStatType,$gradeType);
          	$cs2_06 =$cs2->createCourseOffering(null,null,null, $term2->getId(),$offerType,$offerStatType,$gradeType);

          	$loc1 = "Bihall 514";
          	$loc2 = "Bihall 505";
          	$loc3 = "Bihall 632";
          	
          	$cs1A_05 =$cs1_05->createCourseSection("Program 2005 lecture","cx121","fun!", $sectionType1, $sectionStatType1,$loc1);
          	$cs1Z_05 =$cs1_05->createCourseSection("Program 2005 lab","cx121",null, $sectionType2, $sectionStatType2,$loc3);
          	$cs1A_06 =$cs1_06->createCourseSection("Program 2006 lecture",null,null, $sectionType1, $sectionStatType1,$loc3);
          	$cs2A_06 =$cs2_06->createCourseSection("Learn to program 2006 lecture",null,null, $sectionType1, $sectionStatType2,$loc2);
          	$cs2Z_06 =$cs2_06->createCourseSection("Graphics 2006 lab",null,null, $sectionType2, $sectionStatType1,$loc2);
          	
          	
          	
        	  	$this->write(4,"Test of basic get methods");   
          	
         $this->write(1,"Group A");
         
          	$this->assertEqual($cs1A_05->getTitle(), "Program 2005 lecture");
          	$this->assertEqual($cs1A_05->getDescription(), "fun!");
          	$this->assertEqual($cs1A_05->getNumber(), "cx121");   	
          	$this->assertEqualTypes($cs1A_05->getSectionType(),$sectionType1);
          	$this->assertEqualTypes($cs1A_05->getStatus(),$sectionStatType1);         	
          	$this->assertEqual($cs1A_05->getLocation(),$loc1); 	
          	$this->assertHaveEqualIds($cs1A_05->getCourseOffering(),$cs1_05);

     
          	
          	 $this->write(1,"Group B");
          	
          	
          	$this->assertEqual($cs2Z_06->getTitle(),"Graphics 2006 lab");
          	$this->assertEqual($cs2Z_06->getDescription(), "descrip");
          	$this->assertEqual($cs2Z_06->getNumber(), "CSCI367");   	
          	$this->assertEqualTypes($cs2Z_06->getSectionType(),$sectionType2);
          	$this->assertEqualTypes($cs2Z_06->getStatus(),$sectionStatType1);         	
          	$this->assertEqual($cs2Z_06->getLocation(),$loc2); 	
          	$this->assertHaveEqualIds($cs2Z_06->getCourseOffering(),$cs2_06);
          	
          	   
          	    
          	    
          	$this->write(3,"Test of getCourseSection()");
          	
          	$cs2Z_06a =$cm->getCourseSection($cs2Z_06->getID());
          	
          	
          	
          	$this->assertHaveEqualIds($cs2Z_06a,$cs2Z_06);
			$this->assertEqual($cs2Z_06a->getTitle(),"Graphics 2006 lab");
          	$this->assertEqual($cs2Z_06a->getDescription(), "descrip");
          	$this->assertEqual($cs2Z_06a->getNumber(), "CSCI367");   	
          	$this->assertEqualTypes($cs2Z_06a->getSectionType(),$sectionType2);
          	$this->assertEqualTypes($cs2Z_06a->getStatus(),$sectionStatType1);         	
          	$this->assertEqual($cs2Z_06a->getLocation(),$loc2); 	
          	$this->assertHaveEqualIds($cs2Z_06a->getCourseOffering(),$cs2_06);
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	$courseStatusType2 = new Type("CourseManagement", "edu.middlebury", "No longer offered", "You're out of luck");
         	
          	$cs1Z_05->updateDisplayName("Economic Statistics (Graphics 2006 lab)");          	
			$cs1Z_05->updateTitle("Snore");					
			$cs1Z_05->updateDescription("Boring stuff");
			$cs1Z_05->updateNumber("EC123");			
			$cs1Z_05->updateStatus($sectionStatType1);
			$cs1Z_05->updateLocation($loc2);
			
			$this->assertEqual($cs1Z_05->getDisplayName(),"Economic Statistics (Graphics 2006 lab)");
			$this->assertEqual($cs1Z_05->getTitle(),"Snore");
          	$this->assertEqual($cs1Z_05->getDescription(), "Boring stuff");
          	$this->assertEqual($cs1Z_05->getNumber(), "EC123");  
          	$this->assertEqualTypes($cs1Z_05->getStatus(),$sectionStatType1);         	
          	$this->assertEqual($cs1Z_05->getLocation(),$loc2); 	

        	$this->write(4,"Test of assets");
        	
        	$idManager = Services::getService("Id");
        	
       		//rather than create actual assets, Ids, will work fine.
       		
       		$assetA =$idManager->createId();
        	$assetB =$idManager->createId();
        	$assetC =$idManager->createId();
        	
        	
        	$this->write(1,"Group A");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	
        	$cs2Z_06->addAsset($assetA);
        	
        	$this->write(1,"Group B");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs2Z_06->addAsset($assetB);
        	
        	$this->write(1,"Group C");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	
        	$cs2Z_06->addAsset($assetC);
        	
        	$this->write(1,"Group D");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs2Z_06->removeAsset($assetA);
        	
        	$cs2A_06->addAsset($assetC);
        	
        	$this->write(1,"Group E");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	$iter =$cs2A_06->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs2Z_06->removeAsset($assetC);
        	
        	$this->write(1,"Group F");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	$cs2Z_06->removeAsset($assetB);
        	
        	
        	$this->write(1,"Group G");
        	$iter =$cs2Z_06->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
  
        	
        	/*
        	
        	$cs1_05 =$cs1->createCourseOffering(null,null,null, $term1->getId(),$offerType,$offerStatType,$gradeType);
          	$cs1_06 =$cs1->createCourseOffering(null,null,null, $term2->getId(),$offerType,$offerStatType,$gradeType);
          	$cs2_06 =$cs2->createCourseOffering(null,null,null, $term2->getId(),$offerType,$offerStatType,$gradeType);

       
          	
          	$cs1A_05 =$cs1_05->createCourseSection("Learn to program","cx121","fun!", $sectionType1, $sectionStatType1,$loc1);
          	$cs1Z_05 =$cs1_05->createCourseSection(null,"cx121",null, $sectionType2, $sectionStatType2,$loc3);
          	$cs1A_06 =$cs1_06->createCourseSection(null,null,null, $sectionType1, $sectionStatType1,$loc3);
          	$cs2A_06 =$cs2_06->createCourseSection(null,null,null, $sectionType1, $sectionStatType2,$loc2);
          	$cs2Z_06 =$cs2_06->createCourseSection(null,null,null, $sectionType2, $sectionStatType1,$loc2);
          	
          	*/
        	
        	$this->write(4,"Test of getting CourseSections");
        	
        	$this->write(1,"Group A");
        	$iter =$cs1_05->getCourseSections();
        	$this->assertIteratorHasItemWithId($iter, $cs1A_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group B");
        	$iter =$cs1_06->getCourseSections();
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group C");
        	$iter =$cs2_06->getCourseSections();
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorHasItemWithId($iter, $cs2A_06);
        	$this->assertIteratorHasItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group D");
        	$iter =$cs1_05->getCourseSectionsByType($sectionType1);
        	$this->assertIteratorHasItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group E");
        	$iter =$cs1_06->getCourseSectionsByType($sectionType1);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group F");
        	$iter =$cs2_06->getCourseSectionsByType($sectionType1);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorHasItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	
        	$this->write(1,"Group G");
        	$iter =$cs1_05->getCourseSectionsByType($sectionType2);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorHasItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group H");
        	$iter =$cs1_06->getCourseSectionsByType($sectionType2);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2Z_06);
        	
        	$this->write(1,"Group I");
        	$iter =$cs2_06->getCourseSectionsByType($sectionType2);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1Z_05);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A_06);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A_06);
        	$this->assertIteratorHasItemWithId($iter, $cs2Z_06);

        	
        	
        	
        	
        	
        		
        	$this->write(4,"Test of getting Types");
			$this->write(1,"Group A");
			$iter1 =$cm->getSectionTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionType1));
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			$this->write(1,"Group B");
			$iter1 =$cm->getSectionStatusTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionStatType1));
			$this->assertTrue($this->typeIteratorHas($iter1, $sectionStatType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
	
        	
        	
        	
        	$this->write(4,"Test of update Schedule() and getSchedule()");  
        	 
        	$cs1A_05->updateSchedule($scheduleA);
        	$this->write(1,"Group A");
        	$iter =$cs1A_05->getSchedule();
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);			
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			
			$cs1A_06->updateSchedule($scheduleB);
			$this->write(1,"Group B");
			$iter =$cs1A_06->getSchedule();
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);			
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$cs1A_05->updateSchedule($scheduleB);
			$this->write(1,"Group C");
			$iter =$cs1A_05->getSchedule();
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);			
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group D");
			$iter =$cs1A_06->getSchedule();
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);			
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$cs1A_06->updateSchedule($scheduleC);
			$this->write(1,"Group E");
			$iter =$cs1A_06->getSchedule();
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);			
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
				
			$this->write(4,"Test of Properties 1");
			$this->goTestPropertiesFunctions($cs1A_05);
			$this->write(4,"Test of Properties 2");
			$this->goTestPropertiesFunctions($cs1A_06);
			$this->write(4,"Test of Properties 3");
			$this->goTestPropertiesFunctions($cs2Z_06);
			
          	
          	$cs1_05->deleteCourseSection($cs1A_05->getId());
        	$cs1_05->deleteCourseSection($cs1Z_05->getId());
        	$cs1_05->deleteCourseSection($cs1A_06->getId());
        	$cs1_05->deleteCourseSection($cs2A_06->getId());
        	$cs1_05->deleteCourseSection($cs2Z_06->getId());
          	
        	$cs1->deleteCourseOffering($cs1_05->getId());
        	$cs1->deleteCourseOffering($cs1_06->getId());
        	$cs1->deleteCourseOffering($cs2_06->getId());
       
        	
        	$cm->deleteCanonicalCourse($cs1->getId());
        	$cm->deleteCanonicalCourse($cs2->getId());
        	
        	
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
		
        	
		}
		
		
		
		
		        
		//This function's name can't start with test or it is called without parameters
		function goTestPropertiesFunctions($itemToTest){
			$this->write(1,"Group A");
			$courseType =$itemToTest->getSectionType();
			$correctType = new Type("PropertiesType", $courseType->getAuthority(), "properties");  
			$propertyType =$itemToTest->getPropertyTypes();
			$this->assertTrue($propertyType->hasNext());
			if($propertyType->hasNext()){
				$type1 =  $propertyType->next();		
				$this->assertEqualTypes($type1, $correctType);
				$this->assertFalse($propertyType->hasNext());		
			}
			$this->write(1,"Group B");
			//multiple objects of type properties?  Propertiesies!
			$propertiesies =$itemToTest->getProperties();
			$this->assertTrue($propertiesies->hasNextProperties());
			if($propertiesies->hasNextProperties()){
				$properties =  $propertiesies->nextProperties();
				$type1 =  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties($properties,$itemToTest);
				$this->assertFalse($propertiesies->hasNextProperties());		
			}
			$this->write(1,"Group C");
			$properties =$itemToTest->getPropertiesByType($correctType);
			$this->assertNotEqual($properties,null);
			if(!is_null($properties)){
				$type1 =  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties($properties,$itemToTest);
			}	
			
		}
		
		
		/*
		
		$property->addProperty('type', $courseType);		
		$statusType =$this->getStatus();
		$property->addProperty('status_type', $statusType);
		$property->addProperty('location', $row['location']);
		*/

		//This function's name can't start with test or it is called without parameters
		function goTestProperties($prop, $itemToTest){
			
			
			
			
			$idManager = Services::getService("Id");
			
			
			$keys =$prop->getKeys();
			
			$key = "display_name";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getDisplayName());
			}
			
			$key = "title";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getTitle());
			}
			
			$key = "description";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getDescription());
			}
			
			$key = "id";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getId());
			}
			
			$key = "number";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getNumber());
			}
			
	
			$key = "type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getSectionType());
			}
			
			$key = "status_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getStatus());
			}
			
			$key = "location";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getLocation());
			}
			
		}
		
		
		
    }
?>