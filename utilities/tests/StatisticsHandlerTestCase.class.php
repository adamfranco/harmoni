<?php

    require_once(HARMONI.'utilities/StatisticsHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StatisticsHandlerTestCase.class.php,v 1.1 2003/07/10 23:05:26 movsjani Exp $
 * @copyright 2003 
 **/

    class StatisticsHandlerTestCase extends UnitTestCase {
	
		var $testList;
		var $testObject;
		var $testQueue,$testQueue2;
	
		function QueueTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$test = array(10,184,23,77,77,0);
			$this->testList = new StatisticsHandler($test);
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}

		function testMedian() {
			$this->assertEqual(77,$this->testList->getMedian());

		}

		function testMean() {
			$this->assertEqual($this->testList->getMean(),61.833);

		}

		function testStandardDeviation() {
			$this->assertEqual($this->testList->getStandardDeviation(),62.454);

		}

		function testModal() {
			$this->assertEqual($this->testList->getModal(),77);

		}

		function testDiscrimination() {

			$this->assertEqual($this->testList->getDiscrimination(),125.5);

		}

		function testSecondaryDiscrimination() {
			$test = array(1,0,1,0,1,1);
			$this->assertEqual($this->testList->getSecondaryDiscrimination($test),-0.5);

		}


	
	

    }

?>