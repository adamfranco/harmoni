<?php

    require_once('Queue.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: QueueTestCase.class.php,v 1.3 2003/06/16 22:24:33 dobomode Exp $
 * @copyright 2003 
 **/

    class QueueTestCase extends UnitTestCase {
	
		var $testQueue;
		var $testObject;
	
		function QueueTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->testQueue =& new Queue();
			
			$this->testObject =& new Queue();

			$this->testQueue->add($this->testObject);
			$this->testQueue->add(new Queue());
			
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		/**
		 *    Tests getNumberOfUsers() function.
		 */ 
		function testQueueAdd() {
			
			
			$this->assertEqual($this->testQueue->getSize(), 2);
			$this->assertReference($this->testObject,$this->testQueue->_queue[0]);
		}
		
		function testQueueClear(){
			$this->assertEqual($this->testQueue->getSize(), 2);
			
			$this->testQueue->clear();
			
			$this->assertEqual($this->testQueue->getSize(), 0);
			
			$this->assertFalse($this->testQueue->hasNext());
		}
		
		function testNext(){
			$this->assertEqual($this->testQueue->_position,0);
		
			$object =& $this->testQueue->next();

			$this->assertEqual($this->testQueue->_position,1);

			
			$this->assertReference($this->testObject,$object);
			
			$this->assertTrue($this->testQueue->hasNext());
			
			$object =& $this->testQueue->next();
			
			$this->assertEqual($this->testQueue->_position,2);

			
			$this->assertFalse($this->testQueue->hasNext());
		}
		
    }

?>