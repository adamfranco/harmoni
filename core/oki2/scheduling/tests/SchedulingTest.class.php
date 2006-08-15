<?php
   //this tests all of scheduling in one go.  Hooray!
   //@TODO I need to figure out how to test the getCreator() method.
    
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
    
    class SchedulingTestCase extends OKIUnitTestCase {
      
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
        
        function TestOfScheduling() {
        	
        	
        	
        	$this->write(7, "Scheduling Test");
        	
        	
        	
        	
          	
        	$cm =& Services::getService("CourseManagement");
        	$sm =& Services::getService("Scheduling");
        	$am =& Services::getService("Agent");
			
        	
        	$this->write(6, "Test of Timespan");
        	
        	
        	$ts1 =& new HarmoniTimespan(100,234);
        	$ts2 =& new HarmoniTimespan(400,800);
        	$ts3 =&new  HarmoniTimespan(700,900);
        	
        	$this->assertEqual($ts1->getStart(), 100);
          	$this->assertEqual($ts1->getEnd(), 234);  
          	$this->assertEqual($ts2->getStart(), 400);
          	$this->assertEqual($ts2->getEnd(), 800);  
          	$this->assertEqual($ts3->getStart(), 700);
          	$this->assertEqual($ts3->getEnd(), 900);  
        	
        	
        	
        
          	$itemStat1 =& new Type("ScheduleItemStatusType", "edu.middlebury", "Required");
          	$itemStat2 =& new Type("ScheduleItemStatusType", "edu.middlebury", "Optional");
          	$defStat =& new Type("ScheduleItemStatusType", $sm->_defaultAuthority, "default"); 
          	$defCommitStat =& new Type("AgentCommitmentStatusType", $sm->_defaultAuthority, "default");             	
          	$propertiesType =& new Type("PropertiesType", "edu.middlebury", "properties");              	
          	$agentType =& new Type("AgentType", "edu.middlebury", "student");              	
          	$commitType1 =& new Type("AgentCommitmentStatusType", "edu.middlebury", "accepted");              	
          	$commitType2 =& new Type("AgentCommitmentStatusType", "edu.middlebury", "rejected");             
          	
          	
          	
				
			$properties =& new HarmoniProperties($propertiesType);
			$agent1 =& $am->createAgent("Gladius", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);
			$agent2 =& $am->createAgent("MadgaTheAmazingFiancee", $agentType, $properties);
			$properties =& new HarmoniProperties($propertiesType);			
			$agent3 =& $am->createAgent("nood8?jood8", $agentType, $properties); 	
			
			$agents2[] =& $agent1->getId();
			$agents2[] =& $agent2->getId();
                      	
          	        	
			$scheduleItemA1 =& $sm->createScheduleItem("Fall 2006 range", "Fallin' leaves!", $itemStat2, 300, 900, null);
			$masterIdA = $scheduleItemA1->getMasterIdentifier();
			$scheduleItemA2 =& $sm->createScheduleItem("Thanksgiving", "", $itemStat1, 350, 400, $masterIdA);
			$scheduleItemA3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $itemStat2, 500, 600, $masterIdA);
			
			$scheduleItemB1 =& $sm->createScheduleItem("Fall 2006 range", "", $itemStat1, 1300, 1900, null);
			$masterIdB = $scheduleItemB1->getMasterIdentifier();
			$scheduleItemB2 =& $sm->createScheduleItem("Thanksgiving", "", $itemStat1, 1350, 1400, $masterIdB);
			$scheduleItemB3 =& $sm->createScheduleItem("Christmas", "ho ho ho", $itemStat2, 1500, 1600, $masterIdB);				
			
			$scheduleItemC1 =& $sm->createScheduleItem("Funky time", "", $itemStat1, 100, 500, null);
			$masterIdC = $scheduleItemC1->getMasterIdentifier();
			$scheduleItemC2 =& $sm->createScheduleItem("Dance party", "", $itemStat2, 700, 1400, $masterIdC);
        	
        	
			
	
			
			
			
			$this->write(6, "Test of ScheduleItem");
			
        	$this->write(4,"Test of basic get methods");   
          	
 	
        	$this->write(1,"Group A");   
          
        	$this->assertEqualIds($scheduleItemA1->getID(),$scheduleItemA1->getID());
          	$this->assertEqual($scheduleItemA1->getDisplayName(), "Fall 2006 range");
          	$this->assertEqual($scheduleItemA1->getDescription(), "Fallin' leaves!");
          	$this->assertEqual($scheduleItemA1->getStart(), 300);
          	$this->assertEqual($scheduleItemA1->getEnd(), 900);       	
          	$this->assertEqual($scheduleItemA1->getMasterIdentifier(), $masterIdA);
          	$this->assertEqualTypes($scheduleItemA1->getStatus(),$itemStat2);
          	
          	$this->write(1,"Group B");   
          	$this->assertEqualIds($scheduleItemB2->getID(),$scheduleItemB2->getID());
          	$this->assertEqual($scheduleItemB2->getDisplayName(), "Thanksgiving");
          	$this->assertEqual($scheduleItemB2->getDescription(), "");
          	$this->assertEqual($scheduleItemB2->getStart(), 1350);
          	$this->assertEqual($scheduleItemB2->getEnd(), 1400);       	
          	$this->assertEqual($scheduleItemB2->getMasterIdentifier(), $masterIdB);
          	$this->assertEqual($scheduleItemB2->getStatus(),$itemStat1);
          	
          	/*$this->write(4,"Test of getting passed in agents with default type");  
          	
          	$iter =& $scheduleItemA3->getAgentCommitments();
          	$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$defCommitStat));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$defCommitStat));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$defCommitStat));         	
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			$scheduleItemA3->removeAgentCommitment($agent1->getId());
			$scheduleItemA3->removeAgentCommitment($agent2->getId());*/
          	
          	$this->write(4,"Test of getScheduleItem()");
          	
          	$scheduleItemA1a =& $sm->getScheduleItem($scheduleItemA1->getID());
          	
          	
          	$this->assertEqualIds($scheduleItemA1a->getID(),$scheduleItemA1->getID());
          	
          	$this->assertEqual($scheduleItemA1a->getDisplayName(), "Fall 2006 range");
          	$this->assertEqual($scheduleItemA1a->getDescription(), "Fallin' leaves!");
          	$this->assertEqual($scheduleItemA1a->getStart(), 300);
          	$this->assertEqual($scheduleItemA1a->getEnd(), 900);       	
          	$this->assertEqual($scheduleItemA1a->getMasterIdentifier(), $masterIdA);
          	//implementation specific
          	$this->assertEqual($scheduleItemA1a->getStatus(),$itemStat2);
          	
          	
          	
          	$this->write(4,"Test of basic update methods");
          	
          	
          	
          	$courseStatusType2 =& new Type("CourseManagement", "edu.middlebury", "No longer offered", "You're out of luck");
         	
          	
          	
          	$scheduleItemA1->updateDisplayName("Revised Fall 2005");          	
			$scheduleItemA1a->updateDescription("ChikaChanged");	
			$scheduleItemA1->updateStatus($itemStat1);
			$scheduleItemA1a->updateStart(303);
			$scheduleItemA1->updateEnd(909);
			
			$this->assertEqual($scheduleItemA1->getDisplayName(), "Revised Fall 2005");
          	$this->assertEqual($scheduleItemA1->getDescription(),"ChikaChanged");
          	$this->assertEqual($scheduleItemA1->getStart(), 303);
          	$this->assertEqual($scheduleItemA1->getEnd(), 909);       	
          	$this->assertEqualTypes($scheduleItemA1->getStatus(),$itemStat1);
        	
        
          	
          	$this->write(4,"Test of masterId");
          	
          	
      //assertIteratorHasItemWithId
          	
          	$this->write(1,"Group A:");										                                
			$iter =& $sm->getScheduleItemsByMasterId($masterIdA);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group B:");										                                
			$iter =& $sm->getScheduleItemsByMasterId($masterIdB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");										                                
			$iter =& $sm->getScheduleItemsByMasterId($masterIdC);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group D:");										                                
			$iter =& $sm->getScheduleItemsByMasterId("bob2o34hj5kl234u5o2345lkj3h245");
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			
			$this->write(4,"Test of adding, changing and getting agents");
		
			$scheduleItemA1->addAgentCommitment($agent1->getId(),$commitType1);
			$scheduleItemA2->addAgentCommitment($agent2->getId(),$commitType2);
			
			$this->write(1,"Group A:");										                                
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			$scheduleItemA1->addAgentCommitment($agent3->getId(),$commitType2);
			$scheduleItemA2->addAgentCommitment($agent1->getId(),$commitType1);
			$scheduleItemA2->addAgentCommitment($agent3->getId(),$commitType2);
			
			$this->write(1,"Group B:");										                                
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			
			$this->write(4,"Test of removing agents");
			
			
			$this->write(1,"Group A:");										                                
			
			
			$scheduleItemA1->removeAgentCommitment($agent3->getId());
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			
			$scheduleItemA2->removeAgentCommitment($agent1->getId());
			
			
			$this->write(1,"Group B:");										                                
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			
			$this->write(4,"Test of changing agent commitments");
			
			$scheduleItemA1->changeAgentCommitment($agent1->getId(), $commitType2);
			
			
			$this->write(1,"Group A:");										                                
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
			$scheduleItemA2->changeAgentCommitment($agent2->getId(), $commitType1);
			$this->write(1,"Group B:");
			$scheduleItemA2->changeAgentCommitment($agent3->getId(), $commitType2);
			
													                                
			$iter =& $scheduleItemA1->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			$iter =& $scheduleItemA2->getAgentCommitments();
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType1));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent2,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent3,$commitType1));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent1,$commitType2));
			$this->assertTrue(!$this->iteratorHasAgentWithStatus($iter, $agent2,$commitType2));
			$this->assertTrue($this->iteratorHasAgentWithStatus($iter, $agent3,$commitType2));
			
          	$scheduleItemA1->removeAgentCommitment($agent1->getId());
			$scheduleItemA2->removeAgentCommitment($agent2->getId());
			$scheduleItemA2->removeAgentCommitment($agent3->getId());
			
			
		$this->write(7,"Test of getting ScheduleItems");
			
          	$scheduleItemA1->updateStatus($itemStat1);
          	$scheduleItemA2->updateStatus($itemStat2);
          	$scheduleItemA3->updateStatus($itemStat2);
			$scheduleItemB1->updateStatus($itemStat1);
          	$scheduleItemB2->updateStatus($itemStat2);
          	$scheduleItemB3->updateStatus($itemStat2);
          	$scheduleItemC1->updateStatus($itemStat1);
          	$scheduleItemC2->updateStatus($itemStat2);
			
          	$scheduleItemA1->addAgentCommitment($agent1->getId(), $commitType1);
          	$scheduleItemA2->addAgentCommitment($agent1->getId(), $commitType1);
          	$scheduleItemA3->addAgentCommitment($agent1->getId(), $commitType1);          	
          	$scheduleItemA1->addAgentCommitment($agent2->getId(), $commitType1);
          	$scheduleItemA2->addAgentCommitment($agent2->getId(), $commitType1);
          	$scheduleItemA3->addAgentCommitment($agent2->getId(), $commitType1);
          	
          	$scheduleItemB1->addAgentCommitment($agent3->getId(), $commitType1);
          	$scheduleItemB2->addAgentCommitment($agent3->getId(), $commitType1);
          	$scheduleItemB3->addAgentCommitment($agent3->getId(), $commitType1);         	
          	$scheduleItemB1->addAgentCommitment($agent1->getId(), $commitType1);
          	$scheduleItemB2->addAgentCommitment($agent1->getId(), $commitType1);
          	$scheduleItemB3->addAgentCommitment($agent1->getId(), $commitType1);         	

                  	         
          	$scheduleItemC1->addAgentCommitment($agent3->getId(), $commitType1);
          	$scheduleItemC2->addAgentCommitment($agent3->getId(), $commitType1);

          
          	$groupA[] =& $agent1->getId();
          	$groupA[] =& $agent2->getId();
          	$groupA[] =& $agent3->getId();
          	
          	$groupB[] =& $agent1->getId();
          	$groupB[] =& $agent2->getId();
          	
          	$groupC[] =& $agent3->getId();
          	
          	
          	
          	$null = null;
          
          	
          	$this->write(4,"Test of getting ScheduleItems 1");
          	$start = 0;
          	$end = 20000;
          			
          	$this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupA);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupA);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group E:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group F:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group G:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupC);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group H:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupC);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			
			
			
			
			$this->write(4,"Test of getting ScheduleItems 2");
          	$start = 400;
          	$end = 1300;
          			
          	$this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);			
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(4,"Test of getting ScheduleItems 3");
          	$start = 877;
          	$end = 1370;
          			
          	$this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			
			$this->write(4,"Test of getting ScheduleItems 4");
          	$start = 0;
          	//remember that fall 05 changed start time
          	$end = 303;
          			
        $this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(4,"Test of getting ScheduleItems 5");
          	$start = 1400;
          	$end = 2400;
          			
          	$this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			
			$this->write(4,"Test of getting ScheduleItems 6");
          	$start = 1401;
          	$end = 2400;
          			
          	$this->write(1,"Group A:");
      									                                
			$iter =& $sm->getScheduleItems($start, $end, $null);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			$this->write(1,"Group B:");
			$iter =& $sm->getScheduleItems($start,$end, $itemStat2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);
			
			$this->write(1,"Group C:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $null, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB1);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
			$this->write(1,"Group D:");
			$iter =& $sm->getScheduleItemsForAgents($start,$end, $itemStat2, $groupB);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA2);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemA3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemB2);
			$this->assertIteratorHasItemWithId($iter, $scheduleItemB3);
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC1);//
			$this->assertIteratorLacksItemWithId($iter, $scheduleItemC2);//
			
		
			
				
			$this->write(4,"Test of Properties 1");			
			$this->goTestPropertiesFunctions($scheduleItemA1);
			$this->write(4,"Test of Properties 2");
			$this->goTestPropertiesFunctions($scheduleItemB3);
			$this->write(4,"Test of Properties 3");
			$this->goTestPropertiesFunctions($scheduleItemC2);
			
			$sm->deleteScheduleItem($scheduleItemA1->getId());
			$sm->deleteScheduleItem($scheduleItemA2->getId());
			$sm->deleteScheduleItem($scheduleItemA3->getId());
			$sm->deleteScheduleItem($scheduleItemB1->getId());
			$sm->deleteScheduleItem($scheduleItemB2->getId());
			$sm->deleteScheduleItem($scheduleItemB3->getId());
			$sm->deleteScheduleItem($scheduleItemC1->getId());
			$sm->deleteScheduleItem($scheduleItemC2->getId());
			
			
			$this->write(5,"Test of available times");
			
			
			
			$agents = array();
			
			$si1 =& $sm->createScheduleItem("", "", $defStat, 100, 200, null);
			$si2 =& $sm->createScheduleItem("", "", $defStat, 150, 300, null);
			$si3 =& $sm->createScheduleItem("", "", $defStat, 250, 400, null);
			$si4 =& $sm->createScheduleItem("", "", $defStat, 300, 350, null);
			$si5 =& $sm->createScheduleItem("", "", $defStat, 351, 450, null);
			$si6 =& $sm->createScheduleItem("", "", $defStat, 500, 650, null);
			
			$si1->addAgentCommitment($agent3->getId(),$defCommitStat);
			$si2->addAgentCommitment($agent1->getId(),$defCommitStat);
			$si3->addAgentCommitment($agent3->getId(),$defCommitStat);
			$si4->addAgentCommitment($agent1->getId(),$defCommitStat);
			$si4->addAgentCommitment($agent2->getId(),$defCommitStat);
			$si5->addAgentCommitment($agent2->getId(),$defCommitStat);
			$si6->addAgentCommitment($agent1->getId(),$defCommitStat);
			$si6->addAgentCommitment($agent3->getId(),$defCommitStat);
			
			$this->write(1,"Group A:");
			$array =array();
			$array[] = $agent1->getId();
			$array[] = $agent2->getId();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,100);
			$this->assertNextTimespan($iter,450,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group B:");
			$array =array();
			$array[] = $agent1->getId();
			$array[] = $agent2->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,150);
			$this->assertNextTimespan($iter,350,351);
			$this->assertNextTimespan($iter,450,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group C:");
			$array =array();
			$array[] = $agent1->getId();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,100);
			$this->assertNextTimespan($iter,400,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group D:");
			$array =array();
			$array[] = $agent1->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,150);
			$this->assertNextTimespan($iter,350,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group E:");
			$array =array();
			$array[] = $agent2->getId();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,100);
			$this->assertNextTimespan($iter,200,250);
			$this->assertNextTimespan($iter,450,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group F:");
			$array =array();
			$array[] = $agent2->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,300);
			$this->assertNextTimespan($iter,350,351);
			$this->assertNextTimespan($iter,450,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group G:");
			$array =array();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,100);
			$this->assertNextTimespan($iter,200,250);
			$this->assertNextTimespan($iter,400,500);
			$this->assertNextTimespan($iter,650,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group H:");
			$array =array();
			$iter =& $sm->getAvailableTimes($array,0,700);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,0,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group I:");
			$array =array();
			$array[] = $agent2->getId();
			$iter =& $sm->getAvailableTimes($array,277,457);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,277,300);
			$this->assertNextTimespan($iter,350,351);
			$this->assertNextTimespan($iter,450,457);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			$this->write(1,"Group J:");
			$array =array();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array,233,478);	
			//$this->printTimespanIterator($iter);			
			$this->assertNextTimespan($iter,233,250);
			$this->assertNextTimespan($iter,400,478);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			/*
			
						$this->write(1,"Group A:");
			$array =array();
			$array[] = $agent1->getId();
			$array[] = $agent2->getId();
			$array[] = $agent3->getId();
			$iter =& $sm->getAvailableTimes($array);	
			$this->assertNextTimespan($iter,0,);
			$this->assertNextTimespan($iter,,);
			$this->assertNextTimespan($iter,,);
			$this->assertNextTimespan($iter,,);
			$this->assertNextTimespan($iter,,700);
			$this->assertTrue(!$iter->hasNextTimeSpan());
			
			*/
          	
          	
        	
        	
        	$this->write(4,"Test of getting Types");
			$this->write(1,"Group A");
			$iter =& $sm->getItemStatusTypes();
			$this->assertTrue($this->typeIteratorHas($iter, $itemStat1));
			$this->assertTrue($this->typeIteratorHas($iter, $itemStat2));
			$this->assertTrue($this->typeIteratorHas($iter, $defStat));
			$this->assertTrue(!$this->typeIteratorHas($iter, $commitType1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $commitType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
			$this->write(1,"Group B");
			$iter =& $sm->getItemCommitmentStatusTypes();
			$this->assertTrue($this->typeIteratorHas($iter, $commitType1));
			$this->assertTrue($this->typeIteratorHas($iter, $commitType2));
			$this->assertTrue(!$this->typeIteratorHas($iter, $itemStat1));
			$this->assertTrue(!$this->typeIteratorHas($iter, $itemStat2));
			$this->assertTrue(!$this->typeIteratorHas($iter, new Type("sadfsz234dfwerwer","sadfszd23fwerwer","asdfwer123")));
			
	
			
			
			$sm->deleteScheduleItem($si1->getId());
			$sm->deleteScheduleItem($si2->getId());
			$sm->deleteScheduleItem($si3->getId());
			$sm->deleteScheduleItem($si4->getId());
			$sm->deleteScheduleItem($si5->getId());
			$sm->deleteScheduleItem($si6->getId());


			
			
          
			$am->deleteAgent($agent1->getId());
			$am->deleteAgent($agent2->getId());
			$am->deleteAgent($agent3->getId());
			
        }
		
        
        
		
		//This function's name can't start with test or it is called without parameters
		function goTestPropertiesFunctions($itemToTest){
			$this->write(1,"Group A");
			$courseType =& $itemToTest->getStatus();
			$correctType =& new Type("PropertiesType", $courseType->getAuthority(), "properties");  
			$propertyType =& $itemToTest->getPropertyTypes();
			$this->assertTrue($propertyType->hasNextType());
			if($propertyType->hasNextType()){
				$type1 =&  $propertyType->nextType();		
				$this->assertEqualTypes($type1, $correctType);
				$this->assertFalse($propertyType->hasNextType());		
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
			
			$key = "start";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getStart());
			}
			
			$key = "end";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getEnd());
			}
			
			$key = "master_identifier";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqual($prop->getProperty($key),$itemToTest->getMasterIdentifier());
			}			
			
			$key = "status_type";			
			$this->assertTrue($this->primitiveIteratorHas($keys,$key));
			if($this->primitiveIteratorHas($keys,$key)){
				$this->assertEqualTypes($prop->getProperty($key),$itemToTest->getStatus());
			}
			
		}
		
		
		function iteratorHasAgentWithStatus($iter, $agent,$status){
			//this relies on usage of the HarmoniIterator
			$iter->_i=-1;
			$id =& $agent->getId();		
			while($iter->hasNextAgentCommitment()){
				$currAgentCommitment =& $iter->nextAgentCommitment();
				if($id->isEqual($currAgentCommitment->getAgentId())){
					if($status->isEqual($currAgentCommitment->getStatus())){
						return true;
					}
				}
			}
			return false;
		}
		
		function assertNextTimeSpan(&$iter, $start, $end){
			if(!$iter->hasNextTimespan()){
				$this->assertTrue(false);
				return;
			}
			$time =& $iter->nextTimespan();
			$this->assertTrue($time->getStart()==$start&&$time->getEnd()==$end);	
			
		}
		
		function printTimespanIterator(&$iter){
			$iter->_i =-1;
			print "<font color=darkgreen> <p> { ";
			while($iter->hasNextTimespan()){
				$curr =& $iter->nextTimespan();
				print "(".$curr->getStart().", ".$curr->getEnd()."); ";
			}	
			print " }</p></font>";
			$iter->_i =-1;
		}
		
		
    }
?>