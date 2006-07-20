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
    
    class CourseOfferingTestCase extends OKIUnitTestCase {
      
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
        	
        	
        	$cm =& Services::getService("CourseManagement");
        	$sm =& Services::getService("Scheduling");
        	
        	$this->write(7, "Test Course Offering");

        	
        	$canType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType =& new Type("CourseManagement", "edu.middlebury", "Still offered", "Offerd sometimes");
          	
          	$offerType1 =& new Type("CourseManagement", "edu.middlebury", "default", "");
          	$offerType2 =& new Type("CourseManagement", "edu.middlebury", "undefault", "MYSTERIOUS!");
          	$offerStatType1 =& new Type("CourseManagement", "edu.middlebury", "Full", "You can't still register.");
          	$offerStatType2 =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$gradeType =& new Type("CourseManagement", "edu.middlebury", "AutoFail", "Sucks to be you");
          	$gradeType2 =& new Type("CourseManagement", "edu.middlebury", "EasyA", "AM LIT!");
          	$termType =& new Type("CourseManagement", "edu.middlebury", "Fall");
          	
          	
          	$cs1 =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);
          	$cs2 =& $cm->createCanonicalCourse("Computer Graphics", "CSCI367", "",$canType, $canStatType,1);
          	
          	       
          	$agents = array();
          	 	
			$scheduleItemA =& $sm->createScheduleItem("Fall 2006 range", "", $agents, 300, 600, null);
			$scheduleItemB =& $sm->createScheduleItem("Fall 2006 range", "", $agents, 1300, 1600, null);				
			$scheduleA = array($scheduleItemA);
			$scheduleB = array($scheduleItemA);
						
			$term1 =& $cm->createTerm($termType, $scheduleA);
			$term1->updateDisplayName("Fall 2005");
			$term2 =& $cm->createTerm($termType, $scheduleB);
			$term2->updateDisplayName("Fall 2006");
			
			
          	$cs1A =& $cs1->createCourseOffering(null,null,"DescribeIT!", $term1->getId(),$offerType1,$offerStatType1,$gradeType);
          	$cs1B =& $cs1->createCourseOffering(null,null,null, $term2->getId(),$offerType2,$offerStatType2,$gradeType);
          	$cs2A =& $cs2->createCourseOffering(null,"CSCI367",null, $term1->getId(),$offerType2,$offerStatType1,$gradeType);
          	$cs2B =& $cs2->createCourseOffering("Computer Graphics",null,null, $term2->getId(),$offerType1,$offerStatType1,$gradeType);
          	
          	
        	
        	
        	$this->write(4,"Test of basic get methods");   
          	
         $this->write(1,"Group A");
         
          	$this->assertEqual($cs1A->getTitle(), "Intro to CSCI");
          	$this->assertEqual($cs1A->getDescription(), "DescribeIT!");
          	$this->assertEqual($cs1A->getNumber(), "CSCI101");   	
          	$this->assertEqualTypes($cs1A->getOfferingType(),$offerType1);
          	$this->assertEqualTypes($cs1A->getStatus(),$offerStatType1);
          	$this->assertEqualTypes($cs1A->getCourseGradeType(),$gradeType); 	
          	$this->assertHasEqualIds($cs1A->getCanonicalCourse(),$cs1);
          	$this->assertHasEqualIds($cs1A->getTerm(),$term1);

     
          	
          	 $this->write(1,"Group B");
          	
          	
          	$this->assertEqual($cs1B->getTitle(), "Intro to CSCI");
          	$this->assertEqual($cs1B->getDescription(), "");
          	$this->assertEqual($cs1B->getNumber(), "CSCI101");   	
          	$this->assertEqualTypes($cs1B->getOfferingType(),$offerType2);
          	$this->assertEqualTypes($cs1B->getStatus(),$offerStatType2);
          	$this->assertEqualTypes($cs1B->getCourseGradeType(),$gradeType);
          	$this->assertHasEqualIds($cs1B->getCanonicalCourse(),$cs1);
          	$this->assertHasEqualIds($cs1B->getTerm(),$term2);
          	
          	   
          	    
          	    
          	$this->write(3,"Test of getCourseOffering()");
          	
          	$cs2Aa =& $cm->getCourseOffering($cs2A->getID());
          	
          	
          	$this->assertHasEqualIds($cs2Aa,$cs2A);
          	$this->assertEqual($cs2Aa->getTitle(), "Computer Graphics");
          	$this->assertEqual($cs2Aa->getDescription(), "");
          	$this->assertEqual($cs2Aa->getNumber(), "CSCI367");   	
          	$this->assertEqualTypes($cs2Aa->getOfferingType(),$offerType2);
          	$this->assertEqualTypes($cs2Aa->getStatus(),$offerStatType1);
          	$this->assertEqualTypes($cs2Aa->getCourseGradeType(),$gradeType);
          	$this->assertHasEqualIds($cs2Aa->getCanonicalCourse(),$cs2);
          	$this->assertHasEqualIds($cs2Aa->getTerm(),$term1);
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	$courseStatusType2 =& new Type("CourseManagement", "edu.middlebury", "No longer offered", "You're out of luck");
         	
          	$cs2B->updateDisplayName("Economic Statistics");          	
			$cs2B->updateTitle("Snore");					
			$cs2B->updateDescription("Boring stuff");
			$cs2B->updateNumber("EC123");			
			$cs2B->updateStatus($offerStatType2);
			$cs2B->updateCourseGradeType($gradeType2);
			
			
			$this->assertEqual($cs2B->getDisplayName(),"Economic Statistics");			
          	$this->assertEqual($cs2B->getTitle(), "Snore");
          	$this->assertEqual($cs2B->getDescription(), "Boring stuff");
          	$this->assertEqual($cs2B->getNumber(), "EC123");   	
          	$this->assertEqualTypes($cs2B->getStatus(),$offerStatType2);
        	$this->assertEqualTypes($cs2B->getCourseGradeType(),$gradeType2);
        	
        	$this->write(4,"Test of assets");
        	
        	$idManager =& Services::getService("Id");
        	
       		//rather than create actual assets, Ids, will work fine.
       		
       		$assetA =& $idManager->createId();
        	$assetB =& $idManager->createId();
        	$assetC =& $idManager->createId();
        	
        	
        	$this->write(1,"Group A");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	
        	$cs1A->addAsset($assetA);
        	
        	$this->write(1,"Group B");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs1A->addAsset($assetB);
        	
        	$this->write(1,"Group C");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	
        	$cs1A->addAsset($assetC);
        	
        	$this->write(1,"Group D");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue($this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs1A->removeAsset($assetA);
        	
        	$cs1B->addAsset($assetC);
        	
        	$this->write(1,"Group E");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	$iter =& $cs1B->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue($this->idIteratorHas($iter,$assetC));
        	
        	
        	$cs1A->removeAsset($assetC);
        	
        	$this->write(1,"Group F");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue($this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	$cs1A->removeAsset($assetB);
        	
        	
        	$this->write(1,"Group G");
        	$iter =& $cs1A->getAssets();
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetA));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetB));
        	$this->assertTrue(!$this->idIteratorHas($iter,$assetC));
        	
        	
        	$this->write(4,"Test of getting CourseOfferings");
        	
        	$this->write(1,"Group A");
        	$iter =& $cs1->getCourseOfferings();
        	$this->assertIteratorHasItemWithId($iter, $cs1A);
        	$this->assertIteratorHasItemWithId($iter, $cs1B);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A);
        	$this->assertIteratorLacksItemWithId($iter, $cs2B);

        	$this->write(1,"Group B");
        	$iter =& $cs2->getCourseOfferings();
        	$this->assertIteratorLacksItemWithId($iter, $cs1A);
        	$this->assertIteratorLacksItemWithId($iter, $cs1B);
        	$this->assertIteratorHasItemWithId($iter, $cs2A);
        	$this->assertIteratorHasItemWithId($iter, $cs2B);
        	
        	$this->write(1,"Group C");
        	$iter =& $cs1->getCourseOfferingsByType($offerType1);
        	$this->assertIteratorHasItemWithId($iter, $cs1A);
        	$this->assertIteratorLacksItemWithId($iter, $cs1B);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A);
        	$this->assertIteratorLacksItemWithId($iter, $cs2B);
        	
        	$this->write(1,"Group D");
        	$iter =& $cs1->getCourseOfferingsByType($offerType2);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A);
        	$this->assertIteratorHasItemWithId($iter, $cs1B);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A);
        	$this->assertIteratorLacksItemWithId($iter, $cs2B);
        	
        	$this->write(1,"Group E");
        	$iter =& $cs2->getCourseOfferingsByType($offerType1);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A);
        	$this->assertIteratorLacksItemWithId($iter, $cs1B);
        	$this->assertIteratorLacksItemWithId($iter, $cs2A);
        	$this->assertIteratorHasItemWithId($iter, $cs2B);
        	
        	$this->write(1,"Group F");
        	$iter =& $cs2->getCourseOfferingsByType($offerType2);
        	$this->assertIteratorLacksItemWithId($iter, $cs1A);
        	$this->assertIteratorLacksItemWithId($iter, $cs1B);
        	$this->assertIteratorHasItemWithId($iter, $cs2A);
        	$this->assertIteratorLacksItemWithId($iter, $cs2B);
        	
        	
        	
        	$this->write(4,"Test of getting Types");
			$this->write(1,"Group A");
			$iter1 =& $cm->getOfferingTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $offerType1));
			$this->assertTrue($this->typeIteratorHas($iter1, $offerType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			$this->write(1,"Group B");
			$iter1 =& $cm->getOfferingStatusTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $offerStatType1));
			$this->assertTrue($this->typeIteratorHas($iter1, $offerStatType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			$this->write(1,"Group C");
			$iter1 =& $cm->getCourseGradeTypes();
			$this->assertTrue($this->typeIteratorHas($iter1, $gradeType));
			$this->assertTrue($this->typeIteratorHas($iter1, $gradeType2));
			$this->assertTrue(!$this->typeIteratorHas($iter1,new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
        	  
        	
        	
        	$cs1->deleteCourseOffering($cs1A->getId());
        	$cs1->deleteCourseOffering($cs1B->getId());
        	$cs1->deleteCourseOffering($cs2A->getId());
        	$cs1->deleteCourseOffering($cs2B->getId());
        	
        	$cm->deleteCanonicalCourse($cs1->getId());
        	$cm->deleteCanonicalCourse($cs2->getId());
        	
        	
        
        	
        	
        	
        	
        	
        }
		
		
    }
?>