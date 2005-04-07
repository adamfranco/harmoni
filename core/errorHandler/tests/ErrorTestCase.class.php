<?php
/**
 * @package harmoni.errorhandler.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorTestCase.class.php,v 1.4 2005/04/07 16:33:28 adamfranco Exp $
 */
 
require_once(HARMONI.'errorHandler/Error.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.errorhandler.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorTestCase.class.php,v 1.4 2005/04/07 16:33:28 adamfranco Exp $
 */

class ErrorTestCase extends UnitTestCase {
	
	var $_testError;

	function ErrorTestCase() {
	    $this->UnitTestCase();
	}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
	function setUp() {
			// perhaps, initialize $obj here
	}
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
	function tearDown() {
	    unset($this->_testError);
		// perhaps, unset $obj here
	}

	function testTwoParameters(){
	    $this->_testError = new Error("Error1","user");
		
		print "<pre>";
		//		print_r ($this->_testError->getDebugBacktrace());
		print "</pre>";


	    $this->assertEqual("Error1",$this->_testError->getDescription());
	    $this->assertEqual("user",$this->_testError->getType());
	    $this->assertFalse($this->_testError->isFatal());
	}


	function testThreeParameters(){
		$this->_testError = new Error("Error1","user",true);
	    $this->assertEqual("Error1",$this->_testError->getDescription());
	    $this->assertEqual("user",$this->_testError->getType());
	    $this->assertTrue($this->_testError->isFatal());
	}
}
?>