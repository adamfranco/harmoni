<?php

require_once(HARMONI.'oki/authorization/HarmoniFunction.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HarmoniFunctionTestCase.class.php,v 1.1 2004/03/11 22:43:28 dobomode Exp $
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
     * Tests the getType function.
	 **/
	function test_getSomething() {

	}


}

?>