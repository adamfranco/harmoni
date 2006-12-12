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

        	
        	$canType =& new Type("CanonicalCourseType", "edu.middlebury", "DED", "Deductive Reasoning");
          	$canStatType =& new Type("CanonicalCourseStatusType", "edu.middlebury", "Still offered", "Offerd sometimes");
          	
          	$offerType1 =& new Type("CourseOfferingType", "edu.middlebury", "default", "");
          	$offerType2 =& new Type("CourseOfferingType", "edu.middlebury", "undefault", "MYSTERIOUS!");
          	$offerStatType1 =& new Type("CourseOfferingStatusType", "edu.middlebury", "Full", "You can't still register.");
          	$offerStatType2 =& new Type("CourseOfferingStatusType", "edu.middlebury", "Available", "You can still register.");
          	$gradeType =& new Type("GradeType", "edu.middlebury", "AutoFail", "Sucks to be you");
          	$gradeType2 =& new Type("GradeType", "edu.middlebury", "EasyA", "AM LIT!");
          	$termType =& new Type("TermType", "edu.middlebury", "Fall");
          	$scheduleItemType =& new Type("ScheduleItemStatusType", "edu.middlebury", "default");
          	
          	
          	$cs1 =& $cm->createCanonicalCourse("Intro to CSCI", "CSCI101", "",$canType, $canStatType,1);
          	$cs2 =& $cm->createCanonicalCourse("Computer Graphics", "CSCI367", "",$canType, $canStatType,1);
          	
          	       
          	$agents = array();
          	 	
			$scheduleItemA =& $sm->createScheduleItem("Fall 2006 range", "", $scheduleItemType, 300, 600, null);
			$scheduleItemB =& $sm->createScheduleItem("Fall 2006 range", "", $scheduleItemType, 1300, 1600, null);				
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
          	$this->assertHaveEqualIds($cs1A->getCanonicalCourse(),$cs1);
          	$this->assertHaveEqualIds($cs1A->getTerm(),$term1);

     
          	
          	 $this->write(1,"Group B");
          	
          	
          	$this->assertEqual($cs1B->getTitle(), "Intro to CSCI");
          	$this->assertEqual($cs1B->getDescription(), "");
          	$this->assertEqual($cs1B->getNumber(), "CSCI101");   	
          	$this->assertEqualTypes($cs1B->getOfferingType(),$offerType2);
          	$this->assertEqualTypes($cs1B->getStatus(),$offerStatType2);
          	$this->assertEqualTypes($cs1B->getCourseGradeType(),$gradeType);
          	$this->assertHaveEqualIds($cs1B->getCanonicalCourse(),$cs1);
          	$this->assertHaveEqualIds($cs1B->getTerm(),$term2);
          	
          	   
          	    
          	    
          	$this->write(3,"Test of getCourseOffering()");
          	
          	$cs2Aa =& $cm->getCourseOffering($cs2A->getID());
          	
          	
          	$this->assertHaveEqualIds($cs2Aa,$cs2A);
          	$this->assertEqual($cs2Aa->getTitle(), "Computer Graphics");
          	$this->assertEqual($cs2Aa->getDescription(), "");
          	$this->assertEqual($cs2Aa->getNumber(), "CSCI367");   	
          	$this->assertEqualTypes($cs2Aa->getOfferingType(),$offerType2);
          	$this->assertEqualTypes($cs2Aa->getStatus(),$offerStatType1);
          	$this->assertEqualTypes($cs2Aa->getCourseGradeType(),$gradeType);
          	$this->assertHaveEqualIds($cs2Aa->getCanonicalCourse(),$cs2);
          	$this->assertHaveEqualIds($cs2Aa->getTerm(),$term1);
          	
          	
          	
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
        	  
        	
			
			$this->write(4,"Test of Properties 1");
			$this->goTestPropertiesFunctions($cs1A);
			$this->write(4,"Test of Properties 2");
			$this->goTestPropertiesFunctions($cs1B);
			$this->write(4,"Test of Properties 3");
			$this->goTestPropertiesFunctions($cs2B);
			
        	
			$sm->deleteScheduleItem($scheduleItemA->getId());
			$sm->deleteScheduleItem($scheduleItemB->getId());
			
        	$cs1->deleteCourseOffering($cs1A->getId());
        	$cs1->deleteCourseOffering($cs1B->getId());
        	$cs1->deleteCourseOffering($cs2A->getId());
        	$cs1->deleteCourseOffering($cs2B->getId());
        	
        	$cm->deleteCanonicalCourse($cs1->getId());
        	$cm->deleteCanonicalCourse($cs2->getId());
        	
        	
        
        	$cm->deleteTerm($term1->getId());
			$cm->deleteTerm($term2->getId());
	
        	
        	
        	
        	
        }
        
        
		//This function's name can't start with test or it is called without parameters
		function goTestPropertiesFunctions($itemToTest){
			$this->write(1,"Group A");
			$courseType =& $itemToTest->getOfferingType();
			$correctType =& new Type("PropertiesType", $courseType->getAuthority(), "properties");  
			$propertyType =& $itemToTest->getPropertyTypes();
			$this->assertTrue($propertyType->hasNext());
			if($propertyType->hasNext()){
				$type1 =&  $propertyType->next();		
				$this->assertEqualTypes($type1, $correctType);
				$this->assertFalse($propertyType->hasNext());		
			}
			$this->write(1,"Group B");
			//multiple objects of type properties?  Propertiesies!
			$propertiesies =& $itemToTest->getProperties();
			$this->assertTrue($propertiesies->hasNextProperties());
			if($propertiesies->hasNextProperties()){
				$properties =&  $propertiesies->nextProperties();
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties($properties,$itemToTest);
				$this->assertFalse($propertiesies->hasNextProperties());		
			}
			$this->write(1,"Group C");
			$properties =& $itemToTest->getPropertiesByType($correctType);
			$this->assertNotEqual($properties,null);
			if(!is_null($properties)){
				$type1 =&  $properties->getType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->goTestProperties($properties,$itemToTest);
			}	
			
		}
		
		

		//This function's name can't start with test or it is called without parameters
		function goTestProperties($prop, $itemToTest){
			
			
			
			
			$idManager =& Services::getService("Id");
			
			
			$keys =& $prop->getKeys();
			
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
			
			$key = "grade_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getCourseGradeType());
			}
			
			$key = "term";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){					
				$this->assertHaveEqualIds($prop->getProperty($key),$itemToTest->getTerm());
			}
			
			$key = "type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getOfferingType());
			}
			
			$key = "status_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getStatus());
			}
			
		}
		
		
		
    }
?>