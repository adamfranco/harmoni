<?php

require_once(HARMONI.'authorizationHandler/HierarchicalAuthorizationContext.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchicalAuthorizationContextTestCase.class.php,v 1.1 2003/07/01 23:51:50 dobomode Exp $
 * @copyright 2003 
 */

    class AuthorizationContextTestCase extends UnitTestCase {
		
		var $context;
	
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->context =& new HierarchicalAuthorizationContext("segue", "siteunit", 2, array(3, 5, 6), 15);
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->context);
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_constructor() {
			$this->assertEqual($this->context->getSystem(), "segue");
			$this->assertEqual($this->context->getSubsystem(), "siteunit");
			$this->assertEqual($this->context->getHierarchyDepth(), 2);
			$this->assertEqual($this->context->getAncestorSystemIds(), array(3, 5, 6));
			$this->assertEqual($this->context->getSystemId(), 15);
		}
		
    }

?>