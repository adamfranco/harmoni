<?php

require_once(HARMONI.'oki/authorization/HarmoniAuthorizationManager.class.php');
require_once(HARMONI.'oki/authorization/DefaultFunctionType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationManagerTestCase.class.php,v 1.1 2004/06/14 03:38:19 dobomode Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

class HarmoniAuthorizationManagerTestCase extends UnitTestCase {


	function HarmoniAuthorizationManagerTestCase() {
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
		
		$this->manager =& new HarmoniAuthorizationManager($dbIndex, "doboHarmoniTest");
    }

	function test_get_function() {
		$function =& $this->manager->getFunction(new HarmoniId("501"));
		$this->assertIsA($function, "FunctionInterface");
		$this->assertIdentical($function->getReferenceName(), "Edit");
		$this->assertIdentical($function->getDescription(), "Permission to edit qualifiers.");
		$this->assertIdentical($function->getQualifierHierarchyId(), new HarmoniId("6794"));
		$deftype =& new DefaultFunctionType();
		$type =& $function->getFunctionType();
		$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
		$this->assertIdentical($type->getDomain(), $deftype->getDomain());
		$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
		$this->assertIdentical($type->getDescription(), $deftype->getDescription());
		
		$this->assertReference($function, $this->manager->_cache->_functions['501']);
		
		// second time should come from cache
		$function =& $this->manager->getFunction(new HarmoniId("501"));
		$this->assertIsA($function, "FunctionInterface");
		
	}

	function test_get_qualifier() {
		$qualifier =& $this->manager->getQualifier(new HarmoniId("6796"));
		$this->assertIsA($qualifier, "Qualifier");
		$this->assertIdentical($qualifier->getDisplayName(), "sectionA");
		$this->assertIdentical($qualifier->getDescription(), "");
		$deftype =& new DefaultQualifierType();
		$type =& $qualifier->getQualifierType();
		$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
		$this->assertIdentical($type->getDomain(), $deftype->getDomain());
		$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
		$this->assertIdentical($type->getDescription(), $deftype->getDescription());
		
		$this->assertReference($qualifier, $this->manager->_cache->_qualifiers['6796']);
		
		// second time should come from cache
		$qualifier =& $this->manager->getQualifier(new HarmoniId("6796"));
		$this->assertIsA($qualifier, "Qualifier");
	}
}

?>