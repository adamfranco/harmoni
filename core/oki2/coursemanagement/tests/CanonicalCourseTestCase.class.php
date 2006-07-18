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
    
    class CanonicalCourseTestCase extends UnitTestCase {
      
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
          	
          	$this->assertEqual($cs101->getID(),$cs101->getID());
          	$this->assertEqual($cs101->getTitle(), "Intro to Computer Science");
          	$this->assertEqual($cs101->getCredits(), "3.14159");
          	$this->assertEqual($cs101->getDescription(), "Yeah!  Buggles!");
          	$this->assertEqual($cs101->getNumber(), "CS101");   	
          	$this->assertEqualTypes($cs101->getCourseType(),$courseType);
          	$this->assertEqualTypes($cs101->getStatus(),$courseStatusType);
          	
          	
          	
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
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "1";
          	
       
          	$cs102 =& $cm->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);
												                                
			$title = "Not a course";
          	$number = "CS103";
          	$description = "No really";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "0";
          	
       
          	$cs103 =& $cm->createCanonicalCourse($title, $number, $description, 
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
			
			
			//$cs102->removeEquivalentCourse($cs101->getId());	
			
			
			
			
												                                
			$title = "Also Not a course";
          	$number = "CS104";
          	$description = "No really really";
          	$courseType =& new Type("CourseManagement", "edu.middlebury", "DED", "Deductive Reasoning");
          	$courseStatusType =& new Type("CourseManagement", "edu.middlebury", "Available", "You can still register.");
          	$credits = "0";
          	
       
          	$cs104 =& $cm->createCanonicalCourse($title, $number, $description, 
			  																	$courseType, $courseStatusType,
												                                $credits);												                                
			  
			
			$cm->deleteCanonicalCourse($cs101->getId());
			
		}
		
		
		function assertEqualTypes(&$typeA,&$typeB){
			
			//$this->assertEqual($typeA->getDomain(),$typeB->getDomain());
			//$this->assertEqual($typeA->getAuthority(),$typeB->getAuthority());
			//$this->assertEqual($typeA->getKeyword(),$typeB->getKeyword());
			//$this->assertEqual($typeA->getDescription(),$typeB->getDescription());
			$this->assertTrue($typeA->isEqual($typeB));
			if($typeA->getDomain()!=$typeB->getDomain()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getDomain().
				"' and '".$typeB->getDomain()."' should be equal </font></p>\n";
			}
			if($typeA->getAuthority()!=$typeB->getAuthority()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getAuthority().
				"' and '".$typeB->getAuthority()."' should be equal </font></p>\n";
			}
			if($typeA->getKeyword()!=$typeB->getKeyword()){
				print "<p align=center><font size=4 color=#FF2200>The domains '".$typeA->getKeyword().
				"' and '".$typeB->getKeyword()."' should be equal </font></p>\n";
			}
			
		}
		
		
		function write($size, $text){
			
			print "<p align=center><font size=".$size." color=#8888FF>".$text."</font></p>\n";
			
			
		} 
		
		
		//This method only works if the items have a getDisplayName() method.
		//Relies extensively on weak typing
		
		
		function iteratorHas($iter, $name){
			/*$bool=false;
			print "(";
			while($iter->hasNext()){
				
					$item =& $iter->next();
				print $item->getDisplayName().",";
					if($name == $item->getDisplayName()){
						$bool=true;;
					}
					
				}
			print ")";
			print "has ".$name."? --> ".$bool;
				return $bool;*/
			
				while($iter->hasNext()){
					//$am =& Services::GetService("AgentManager");
					$item =& $iter->next();
					if($name == $item->getDisplayName()){
						return true;
					}
				}
				return false;
		}
		
		
		function stringIteratorHas($iter, $string){
				
				while($iter->hasNext()){
					$item =& $iter->next();
					if($item==$string){						
						return true;
					}
				}
				return false;
		}
		
		function assertIteratorLacksItemWithId($iter, $theItem){
				$id =& $theItem->getId();
				while($iter->hasNext()){
					$item =& $iter->next();
					if($id->isEqual($item->getId())){						
						$this->assertFalse(true);
						print "<p align=center><font size=4 color=#FF0044> Iterator should not have '".$theItem->getDisplayName()."' but...</font></p>";
						$this->printIterator($iter);
						return;
					}
				}
				$this->assertFalse(false);		
		}
		
		function assertIteratorHasItemWithId($iter, $theItem){
				$id =& $theItem->getId();
				while($iter->hasNext()){
					$item =& $iter->next();
					if($id->isEqual($item->getId())){						
						$this->assertTrue(true);
						return;
					}
				}
				$this->assertTrue(false);	
				print "<p align=center><font size=4 color=#FF0044> Iterator should have '".$theItem->getDisplayName()."' but...</font></p>";
				$this->printIterator($iter);
					
		}
		
		function printIterator($iter){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
				print "<p align=center><font size=4 color=#88FF66> Iterator contains: {";
				$first = true;
				while($iter->hasNext()){					
					$item =& $iter->next();
					if(!$first){
						print ", ";
					}
					print "'".$item->getDisplayName()."'";
					$first=false;
				}
				print "}</font></p>\n";		
		}
		
		
		
		
    }
?>