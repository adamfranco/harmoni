<?php

require_once(HARMONI.'/oki/hierarchy2/HarmoniNode.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: NodeTestCase.class.php,v 1.2 2004/05/12 22:31:48 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class NodeTestCase extends UnitTestCase {
	
		var $nodeA;
		
        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// Set up the database connection
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$type =& new HarmoniType("whatever", "type", "blah", "zoro");
			$cache =& new HierarchyCache($dbIndex, "doboHarmoniTest");
			$this->nodeA =& new HarmoniNode(new HarmoniId('1'), $type, "A", "nothing", $cache);
			$this->nodeF =& new HarmoniNode(new HarmoniId('6'), $type, "F", "nothing", $cache);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
        }

		//--------------the tests ----------------------

		function test_get_children() {
			$children =& $this->nodeA->getChildren();
		
		}
		
		
		function test_updates() {
			$val = md5(uniqid(rand(), true));
			$this->nodeA->updateDescription($val);
			$this->assertIdentical($this->nodeA->getDescription(), $val);
			$val = md5(uniqid(rand(), true));
			$this->nodeA->updateDisplayName($val);
			$this->assertIdentical($this->nodeA->getDisplayName(), $val);
		}
	}