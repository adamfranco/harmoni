<?php

require_once(HARMONI.'/oki/shared/HarmoniAgent.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AgentTestCase.class.php,v 1.1 2004/04/01 22:44:14 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class AgentTestCase extends UnitTestCase {
	
		var $agent;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// Set up the database connection
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->agent);
        }

		//--------------the tests ----------------------

		function test_everything() {
			$id =& new HarmoniId(8);
			$type =& new HarmoniType("Look at me!", "I rock...", "I rule!", "And rise!");

			$this->agent =& new HarmoniAgent("dobomode", $id, $type);
			
			$this->assertIsA($this->agent, "HarmoniAgent");
			$this->assertIdentical($this->agent->getDisplayName(), "dobomode");
			$this->assertIdentical($this->agent->getId(), $id);
			$this->assertIdentical($this->agent->getType(), $type);
		}
		
		
	}