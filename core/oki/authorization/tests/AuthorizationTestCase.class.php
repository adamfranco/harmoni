<?php

require_once(HARMONI.'oki/authorization/HarmoniAuthorization.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorizationManager.class.php');
require_once(HARMONI.'oki/authorization/DefaultFunctionType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationTestCase.class.php,v 1.3 2004/06/24 17:51:38 dobomode Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

class HarmoniAuthorizationTestCase extends UnitTestCase {


	function HarmoniAuthorizationTestCase() {
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
		$this->agentId =& new HarmoniId("3826");
		$this->functionId =& new HarmoniId("501");
		$this->qualifierId =& new HarmoniId("6796");
		$this->date1 =& new DateTime(1981, 10, 24);
		$this->date2 =& new DateTime(2004, 6, 25);
		
		$this->authorization =& $this->manager->createDatedAuthorization($this->agentId, 
													$this->functionId, $this->qualifierId,
													$this->date1, $this->date2);
    }

	function test_constructor() {
		$this->assertReference($this->agentId, $this->authorization->getAgentId());
		$this->assertReference($this->functionId, $this->authorization->_functionId);
		$this->assertReference($this->qualifierId, $this->authorization->_qualifierId);
		$this->assertIdentical($this->authorization->getEffectiveDate(), $this->date1);
		$this->assertIdentical($this->authorization->getExpirationDate(), $this->date2);
	}


	function test_is_active() {
		$this->assertTrue($this->authorization->isActiveNow());

		$this->authorization->_effectiveDate =& new DateTime(2014, 6, 12);
		$this->assertFalse($this->authorization->isActiveNow());

		$this->authorization->_expirationDate =& new DateTime(2004, 6, 1);
		$this->assertFalse($this->authorization->isActiveNow());

	}


	function test_is_explicit() {
		$this->assertTrue($this->authorization->isExplicit());
	}



	function test_updates() {
		$dateTime =& DateTime::now();

		$this->authorization->updateExpirationDate($dateTime);
		$this->assertReference($dateTime, $this->authorization->getExpirationDate());
		$this->assertFalse($this->authorization->isActiveNow());

		$dateTime =& DateTime::now();

		$this->authorization->updateEffectiveDate($dateTime);
		$this->authorization->updateExpirationDate(new DateTime(2030, 10, 10));
		$this->assertReference($dateTime, $this->authorization->getEffectiveDate());
		$this->assertTrue($this->authorization->isActiveNow());
	}


	function test_get_function() {
		$function =& $this->authorization->getFunction();
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

		$this->assertReference($function, $this->authorization->_cache->_functions['501']);	
	}


	function test_get_qualifier() {
		$qualifier =& $this->authorization->getQualifier();
		$this->assertIsA($qualifier, "Qualifier");
		$this->assertIdentical($qualifier->getDisplayName(), "sectionA");
		$this->assertIdentical($qualifier->getDescription(), "");
		$deftype =& new DefaultQualifierType();
		$type =& $qualifier->getQualifierType();
		$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
		$this->assertIdentical($type->getDomain(), $deftype->getDomain());
		$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
		$this->assertIdentical($type->getDescription(), $deftype->getDescription());

//		$this->assertReference($qualifier, $this->authorization->_cache->_qualifiers['6796']);

	}


	/**
     *    Clears the data set in the setUp() method call.
     *    @public
     */
    function tearDown() {
		$this->manager->deleteAuthorization($this->authorization);
    }


}

?>