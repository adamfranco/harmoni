<?php

require_once(HARMONI.'oki/authorization/HarmoniFunction.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: FunctionTestCase.class.php,v 1.2 2004/06/22 15:23:08 dobomode Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

class HarmoniFunctionTestCase extends UnitTestCase {


	function HarmoniFunctionTestCase() {
		$this->UnitTestCase();
	}

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
		
		$this->type =& new HarmoniType("authorization", "blah", "generic");
		$this->id1 =& new HarmoniId("1");
		$this->id4 =& new HarmoniId("4");
		$this->function =& new HarmoniFunction($this->id1, "It doesn't matter",
				"It doesn't matter too", $this->type, $this->id4, $dbIndex, "doboHarmoniTest");

		$hierarchyManager =& Services::requireService("Hierarchy");
		$hierarchy =& $hierarchyManager->getHierarchy(new HarmoniId("6794"));
		echo "<pre>\n";
		print_r(array_keys($hierarchy->_cache->_tree->_nodes));
		echo "</pre>\n";
		ob_flush();
		ob_start();
    }

	function test_constructor() {
		$this->assertReference($this->id1, $this->function->getId());
		$this->assertReference($this->type, $this->function->getFunctionType());
		$this->assertReference($this->id4, $this->function->getQualifierHierarchyId());
		$this->assertIdentical($this->function->getReferenceName(), "It doesn't matter");
		$this->assertIdentical($this->function->getDescription(), "It doesn't matter too");
	}
	
	function test_updates() {
		$val = md5(uniqid(rand(), true));
		$this->function->updateDescription($val);
		$this->assertIdentical($this->function->getDescription(), $val);
		$val = md5(uniqid(rand(), true));
		$this->function->updateReferenceName($val);
		$this->assertIdentical($this->function->getReferenceName(), $val);
	}
	

    /**
     *    Clears the data set in the setUp() method call.
     *    @public
     */
    function tearDown() {
		// perhaps, unset $obj here
    }

}

?>