<?php
/**
 * @package harmoni.utilities.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: QueueTestCase.class.php,v 1.4 2005/04/07 16:33:31 adamfranco Exp $
 */

    require_once(HARMONI.'utilities/Queue.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.utilities.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: QueueTestCase.class.php,v 1.4 2005/04/07 16:33:31 adamfranco Exp $
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
		*    @access public
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
		 *    @access public
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
			$this->assertEqual($this->testQueue->_nextPosition,0);
		
			$object =& $this->testQueue->next();

			$this->assertEqual($this->testQueue->_nextPosition,1);

			
			$this->assertReference($this->testObject,$object);
			
			$this->assertTrue($this->testQueue->hasNext());
			
			$object =& $this->testQueue->next();
			
			$this->assertEqual($this->testQueue->_nextPosition,2);

			
			$this->assertFalse($this->testQueue->hasNext());
		}
		
		function testReverse(){
			$testReversedQueue =& new Queue(true);
			$test1 = & new Queue();
			$test2 = & new Queue();
			$test3 = & new Queue();
			$test4 = & new Queue();
			$test5 = & new Queue();
			
			$testReversedQueue->add(& $test1);
			$testReversedQueue->add(& $test2);
			$testReversedQueue->add(& $test3);
			
			$this->assertReference($test3,$testReversedQueue->next());			

			$testReversedQueue->add(& $test4);
			
			$this->assertReference($test4,$testReversedQueue->next());			

			$testReversedQueue->add(& $test5);

			$this->assertReference($test5,$testReversedQueue->next());			

			$this->assertReference($test1,$testReversedQueue->_queue[0]);			

			$this->assertReference($test2,$testReversedQueue->_queue[1]);			
			
			// Max: Once, we start iterating (once we call next()), the
			// position should be preserved, so that the next call of
			// next() will return the same element regardless of whether
			// we have called add() or not. Please, fix this.
		} 

		function testRewind(){

			$testReversedQueue =& new Queue();
			$test1 = & new Queue();
			$test2 = & new Queue();
			$test3 = & new Queue();
			$test4 = & new Queue();
			$test5 = & new Queue();
			
			$testReversedQueue->add(& $test1);
			$testReversedQueue->add(& $test2);
			$testReversedQueue->add(& $test3);

			$this->assertReference($test1,$testReversedQueue->next());
			$this->assertReference($test2,$testReversedQueue->next());
			$testReversedQueue->rewind();
			$this->assertReference($test1,$testReversedQueue->next());

			
			
		}
		
    }

?>