<?php


require_once(HARMONI.'errorHandler/ErrorHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ErrorHandlerTestCase.class.php,v 1.6 2003/06/25 15:11:29 movsjani Exp $
 * @package harmoni.errorhandler.tests
 * @copyright 2003 
 **/

    class ErrorHandlerTestCase extends UnitTestCase {
	
	var $_testHandler;

	function ErrorTestCase() {
	    $this->UnitTestCase();
	}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
	function setUp() {
		// perhaps, initialize $obj here
	}	
		
	/**
	 *    Clears the data set in the setUp() method call.
	 *    @public
	 */
	function tearDown() {
	    unset($this->_testHandler);
		// perhaps, unset $obj here
	}

	function testTwoParameters(){
	    $this->_testHandler = new ErrorHandler();
		$this->_testHandler->addNewError("first Error","user");
		$this->_testHandler->addNewError("second Error","prof");
		$testError = new Error("third error","system",true);
		$this->_testHandler->addError(& $testError);
		$this->assertEqual(3,$this->_testHandler->getNumberOfErrors());
		$this->assertReference($testError,$this->_testHandler->_errorQueue->_queue[2]);
	}


    }

?>