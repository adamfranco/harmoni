<?php

require_once(HARMONI.'oki/authorization/HarmoniAuthorizationManager.class.php');
require_once(HARMONI.'oki/authorization/DefaultFunctionType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationManagerTestCase.class.php,v 1.2 2004/06/22 15:23:08 dobomode Exp $
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

		$hierarchyManager =& Services::requireService("Hierarchy");
		$hierarchy =& $hierarchyManager->getHierarchy(new HarmoniId("6794"));
		echo "<pre>\n";
		print_r(array_keys($hierarchy->_cache->_tree->_nodes));
		echo "</pre>\n";
		ob_flush();
		ob_start();
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
	
	
	function test_create_dated_authorization() {
		$agentId =& new HarmoniId("3827");
		$functionId =& new HarmoniId("501");
		$qualifierId =& new HarmoniId("6799");
		$date1 =& new DateTime(1987, 10, 24);
		$date2 =& new DateTime(2014, 6, 25);
		
		$authorization =& $this->manager->createDatedAuthorization($agentId, 
													$functionId, $qualifierId,
													$date1, $date2);

		$this->assertIsA($authorization, "HarmoniAuthorization");
		$this->assertReference($agentId, $authorization->getAgentId());
		$this->assertReference($functionId, $authorization->_functionId);
		$this->assertReference($qualifierId, $authorization->_qualifierId);
		$this->assertIdentical($authorization->getEffectiveDate(), $date1);
		$this->assertIdentical($authorization->getExpirationDate(), $date2);

		$this->manager->deleteAuthorization($authorization);
	}
	
	
	function test_create_authorization() {
		$agentId =& new HarmoniId("3827");
		$functionId =& new HarmoniId("501");
		$qualifierId =& new HarmoniId("6799");
		
		$authorization =& $this->manager->createAuthorization($agentId, 
													$functionId, $qualifierId);

		$this->assertIsA($authorization, "HarmoniAuthorization");
		$this->assertReference($agentId, $authorization->getAgentId());
		$this->assertReference($functionId, $authorization->_functionId);
		$this->assertReference($qualifierId, $authorization->_qualifierId);
		
		$this->manager->deleteAuthorization($authorization);
	}
	
	
	function test_create_qualifiers() {
		$qualifierId =& new HarmoniId("777");
		$displayName = "Drop-Dead-Gorgeous";
		$description = "The People\'s Republic of United Bohemian Superstar Bulgarians";
		$type =& new DefaultQualifierType();
		$qualifierHierarchyId =& new HarmoniId("6794");

		$qualifier =& $this->manager->createRootQualifier($qualifierId, $displayName, 
											$description, $type, $qualifierHierarchyId);
		$this->assertReference($qualifierId, $qualifier->getId());
		$this->assertReference($type, $qualifier->getQualifierType());
		$this->assertIdentical($displayName, $qualifier->getDisplayName());
		$this->assertIdentical($description, $qualifier->getDescription());
		
		$qualifier2Id =& new HarmoniId("778");
		$qualifier2 =& $this->manager->createQualifier($qualifier2Id, $displayName, 
											$description, $type, $qualifierId);
		
		$this->manager->deleteQualifier($qualifier2Id);
		$this->manager->deleteQualifier($qualifierId);
	}

	
	function test_create_function() {
		$functionId =& new HarmoniId("777");
		$displayName = "UEFA sucks!";
		$description = "Balgari Iunaci!!!";
		$type =& new DefaultFunctionType();
		$qualifierHierarchyId =& new HarmoniId("6794");

		$function =& $this->manager->createFunction($functionId, $displayName, 
											$description, $type, $qualifierHierarchyId);
											
		$this->assertReference($functionId, $function->getId());
		$this->assertReference($type, $function->getfunctionType());
		$this->assertIdentical($displayName, $function->getReferenceName());
		$this->assertIdentical($description, $function->getDescription());
		$this->assertReference($qualifierHierarchyId, $function->getQualifierHierarchyId());

		$this->manager->deleteFunction($functionId);
	}
	
	
	// test the getAZs() method in AuthorizationCache
	function test_cache_getAZs() {
		// first, create a bunch of authorizations	
//		$az1 =& $this->manager->createAuthorization($agentId, $functionId, $qualifierId);
//		$az2 =& $this->manager->createAuthorization($agentId, $functionId, $qualifierId);
//		$az3 =& $this->manager->createAuthorization($agentId, $functionId, $qualifierId);

		$this->manager->_cache->getAZs("koko", "stupify", "6799", null, true, false);
		
	}
	
}

?>