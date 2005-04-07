<?php
/**
 * @package harmoni.errorhandler.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorHandlerTestCase.class.php,v 1.4 2005/04/07 16:33:28 adamfranco Exp $
 */

require_once(HARMONI.'errorHandler/ErrorHandler.class.php');
require_once(HARMONI.'errorHandler/ErrorPrinterBasic.class.php');

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
 * @version $Id: ErrorHandlerTestCase.class.php,v 1.4 2005/04/07 16:33:28 adamfranco Exp $
 */

    class ErrorHandlerTestCase extends UnitTestCase {
	
	var $_testHandler;

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
	    unset($this->_testHandler);
		// perhaps, unset $obj here
	}

	function testTwoParameters(){
	    $this->_testHandler =& new ErrorHandler();
		$printer =& new ErrorPrinterBasic();
		$this->_testHandler->addErrorPrinter(& $printer);
		$this->_testHandler->addNewError("first Error","user");
		$this->_testHandler->addNewError("second Error","prof");
		$testError =& new Error("third error","system",true);
		$this->_testHandler->addError(& $testError);
		$this->assertEqual(3,$this->_testHandler->getNumberOfErrors());
		$this->assertReference($testError,$this->_testHandler->_errorQueue->_queue[2]);
	}


    }

?>