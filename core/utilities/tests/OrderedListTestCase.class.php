<?php
/**
 * @package harmoni.utilities.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OrderedListTestCase.class.php,v 1.5 2005/04/07 16:33:31 adamfranco Exp $
 */

    require_once(HARMONI.'utilities/OrderedList.class.php');
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
 * @version $Id: OrderedListTestCase.class.php,v 1.5 2005/04/07 16:33:31 adamfranco Exp $
 **/

    class QueueTestCase extends UnitTestCase {
	
		var $testList;
		var $testObject;
		var $testQueue,$testQueue2;
	
		function QueueTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
			$this->testList = new OrderedList();
			$this->testQueue = new Queue();
			$this->testQueue2 = new Queue();

			$this->testList->add(&$this->testQueue,"pervyj");
			$this->testList->add(&$this->testQueue2,"vtoroj");
			
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
		function testAddCount() {
			$this->assertEqual($this->testList->getSize(),2);
		}

		function testReference() {
			$this->assertReference($this->testList->_list["pervyj"],$this->testQueue);

			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("vtoroj");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($this->testQueue2,$tretij);
		}

		function testDelete() {
			$this->testList->delete("pervyj");

			$this->assertTrue(isset($this->testQueue));
			$this->assertFalse(isset($this->testList->_list["pervyj"]));
			$this->assertFalse($this->testList->exists("pervyj"));
			$this->assertTrue($this->testList->exists("vtoroj"));
		}

		function testCopy() {
			$cpervyj = $this->testList->copy("pervyj");
			$this->assertReference($cpervyj,$this->testQueue,"This test is supposed to fail, because we are hoping for copies of objects.");
		}

		function testMovement() {
			$testQueue3 =& new Queue();

			$this->testList->add($testQueue3,"tretij");

			$this->assertEqual($this->testList->getSize(),3);
			
			$this->testList->swap("tretij","pervyj");
			

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}

			$this->testList->moveUp("vtoroj");

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}

			$this->assertFalse($this->testList->moveUp("vtoroj"));

			$this->assertTrue($this->testList->moveDown("vtoroj"));

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}
			$this->assertTrue($this->testList->moveDown("vtoroj"));

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}
			
			$this->testList->putBefore("tretij","list_end");

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}

			$this->testList->putBefore("vtoroj","pervyj");

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}

			$this->testList->putBefore("tretij","vtoroj");

 			$pervyj =& $this->testList->retrieve("pervyj");
			$vtoroj =& $this->testList->retrieve("vtoroj");
			$tretij =& $this->testList->retrieve("tretij");

 			$this->assertReference($this->testQueue,$pervyj);
			$this->assertReference($this->testQueue2,$vtoroj);
			$this->assertReference($testQueue3,$tretij);

			foreach ($this->testList->_list as $key=>$value){
				echo "<br /> $key <br />";
			}
		}

		function testNext() {
			$testQueue3 =& new Queue();

			$this->testList->add($testQueue3,"tretij");

			$this->assertEqual($this->testList->getSize(),3);
			
			$this->testList->swap("tretij","pervyj");

			$i=0;
			while($this->testList->hasNext()){
				$i++;
				$current =& $this->testList->next();
				switch($i){
				case 1: $this->assertReference($current,$testQueue3); echo "adyn"; break;
				case 2: $this->assertReference($current,$this->testQueue2); break;
				case 3: $this->assertReference($current,$this->testQueue); echo "tri"; break;
				default: echo "ebat`, kolotit`";
				}

				
			}

		}

		

    }

?>