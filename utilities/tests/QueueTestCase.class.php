<?php

    require_once('Queue.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: QueueTestCase.class.php,v 1.6 2003/06/19 18:28:07 adamfranco Exp $
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
		
		function testReverse(){
			$testReversedQueue =& new Queue(true);
			$test1 = & new Queue();
			$test2 = & new Queue();
			
			$testReversedQueue->add(& $test1);
			$testReversedQueue->add(& $test2);
			
			$this->assertReference($test2,$testReversedQueue->next());			
		} 
		
    }

?>