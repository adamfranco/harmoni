<?php

//    require_once(HARMONI.'authenticationHandler/AgentInformationHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AgentInformationHandlerTestCase.class.php,v 1.2 2003/06/26 20:47:26 adamfranco Exp $
 * @copyright 2003 
 **/

    class AgentInformationHandlerTestCase extends UnitTestCase {
	
		function AgentInformationHandlerTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
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
			// perhaps, unset $obj here
		}
	
		/**
		 *    Tests getting information for an agent.
		 */ 
		function test_get_information() {
			$this->assertEqual(false,"We need to delete this and write some real tests.");	

//			$AIhandler =& Services::getService('AIHandler');
			
		}
		
    }

?>