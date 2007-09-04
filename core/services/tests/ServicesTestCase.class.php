<?php

    require_once(HARMONI.'services/Services.class.php');
	

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 *
 * @package harmoni.services.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ServicesTestCase.class.php,v 1.4 2007/09/04 20:25:49 adamfranco Exp $
 */

    class ServicesTestCase extends UnitTestCase {
	
		var $_servicesObject = "__services__";
	
		function ServicesTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
			// The following will kill the running of other tests.
//			$GLOBALS['__services__'] =  new Services;
//		   	Services::registerService("ErrorHandler","ErrorHandler");
//			Services::startService("ErrorHandler");
		}

		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
//			global $__services__;
//			$__services__ = NULL;
		}
	
		/**
		 *    Tests getNumberOfUsers() function.
		 */ 
		function test_services_object() {
			global $__services__;
			$this->assertReference(Services::getServices(),$__services__);
		}
		
		function test_a_register_service() {
			// The following will kill the running of other tests.
//			$this->assertTrue(Services::registerService("DBHandler","DBHandler"));
//			$this->assertFalse(Services::serviceRunning("DBHandler"));
			$this->assertTrue(Services::serviceAvailable("DBHandler"));
			$this->assertTrue(Services::startService("DBHandler"));
			$this->assertIsA(Services::getService("DBHandler"), "dbhandler");
		   
		}
		
		function test_start_stop_restart() {
			
			$this->test_register_service();
			//$this->assertFalse(Services::serviceRunning("DBHandler"));
			
			// start it!
			$this->assertTrue(Services::startService("DBHandler"));
			$this->assertTrue(Services::serviceRunning("DBHandler"));
			$this->assertTrue(Services::serviceAvailable("DBHandler"));
			
			// stop it!
			$this->assertTrue(Services::stopService("DBHandler"));
			$this->assertFalse(Services::serviceRunning("DBHandler"));
			$this->assertTrue(Services::serviceAvailable("DBHandler"));
			
			// restart it! (or, first start it, *then* restart it!)
			$this->assertTrue(Services::startService("DBHandler"));
			$this->assertTrue(Services::serviceRunning("DBHandler"));
			$this->assertTrue(Services::serviceAvailable("DBHandler"));
			$this->assertTrue(Services::restartService("DBHandler"));
			$this->assertTrue(Services::serviceRunning("DBHandler"));
			$this->assertTrue(Services::serviceAvailable("DBHandler"));
		}
		
		function test_class_methods_register() {
			$services = new Services;
			$this->assertEqual(count($services->_registeredServices), 0);
			$this->assertTrue($services->register("DBHandler","DBHandler",HARMONI."/DBHandler/classes/DBHandler.class.php"));
			$this->assertEqual(count($services->_registeredServices), 1);
		}

		function test_class_methods_get() {
			$services = new Services;
			$services->register("DBHandler","DBHandler");
			//print_r($services->_registeredServices);
			$this->assertTrue($services->start("DBHandler"));
			$this->assertTrue($services->running("DBHandler"));
			$this->assertTrue(is_object($services->get("DBHandler")));
			$this->assertEqual(get_class($services->get("DBHandler")),"dbhandler");
			$this->assertReference($services->get("DBHandler"),$services->_services['DBHandler']);
		}
			
    }

?>