<?php

require_once(HARMONI.'/oki/shared/HarmoniDatabaseId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseIdTestCase.class.php,v 1.1 2003/10/17 15:52:56 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class DatabaseIdTestCase extends UnitTestCase {

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
//        	print "<pre>";
        	$this->dbc =& Services::requireService("DBHandler","DBHandler");
 			$this->dbindex = $this->dbc->createDatabase(MYSQL,"devo.middlebury.edu", "harmoniTest", "test", "test");
 			$this->dbc->connect($this->dbindex);
 			
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			$this->dbc->disconnect($this->dbindex);
			
//			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$newId =& new HarmoniDatabaseId($this->dbindex);
			$this->assertTrue(is_object($newId));
			$this->assertTrue($newId->getIdString());
		}

	}