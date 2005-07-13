<?php
/**
 * @package harmoni.osid_v2.authorization.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthorizationManagerTestCase.class.php,v 1.7 2005/07/13 17:41:13 adamfranco Exp $
 */
 
require_once(HARMONI.'oki/authorization/HarmoniAuthorizationManager.class.php');
require_once(HARMONI.'oki/authorization/DefaultFunctionType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.osid_v2.authorization.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthorizationManagerTestCase.class.php,v 1.7 2005/07/13 17:41:13 adamfranco Exp $
 */
 
class DoboTemp {

  var $yo;
  
}

class HarmoniAuthorizationManagerTestCase extends UnitTestCase {


	function HarmoniAuthorizationManagerTestCase() {
		$this->UnitTestCase();
	}

	/**
	 *	  Sets up unit test wide variables at the start
	 *	  of each test method.
	 *	  @access public
	 */
	function setUp() {
		// Set up the database connection
		$dbHandler=&Services::getService("DatabaseManager");
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


	function test_create_dated_authorization() {
		$agentId =& new HarmoniId("3827");
		$functionId =& new HarmoniId("501");
		$qualifierId =& new HarmoniId("6799");
		$date1 =& DateAndTime::withYearMonthDay(1987, 10, 24);
		$date2 =& DateAndTime::withYearMonthDay(2014, 6, 25);

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
		$azs =& $this->manager->_cache->getAZs("3826", "501", "6800", new DefaultFunctionType(), false, false);
		$this->assertIdentical(count($azs), 1);
		$az =& $azs[0];
		$this->assertIdentical($az->_id, "1");
		$this->assertIdentical($az->_agentId->getIdString(), "3826");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertTrue($az->isExplicit());

		$azs =& $this->manager->_cache->getAZs(null, null, "6800", null, false, true);
		$this->assertIdentical(count($azs), 7);
		$az =& $azs[0];
		$this->assertIdentical($az->_id, "1");
		$this->assertIdentical($az->_agentId->getIdString(), "3826");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertTrue($az->isExplicit());
		$az =& $azs[1];
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());
		$az =& $azs[2];
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertFalse($az->isExplicit());
		$az =& $azs[3];
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6796");
		$this->assertFalse($az->isExplicit());
		$az =& $azs[4];
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6797");
		$this->assertFalse($az->isExplicit());
		$az =& $azs[5];
		$this->assertIdentical($az->_id, "3");
		$this->assertIdentical($az->_agentId->getIdString(), "3826");
		$this->assertIdentical($az->_functionId->getIdString(), "502");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6796");
		$this->assertTrue($az->isExplicit());
		$az =& $azs[6];
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3826");
		$this->assertIdentical($az->_functionId->getIdString(), "502");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertFalse($az->isExplicit());
	}
	
	function test_get_all_AZs() {
		$azs =& $this->manager->getAllAZs(new HarmoniId("3825"), new HarmoniId("501"), 
										  new HarmoniId("6800"), true);

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertFalse($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6796");
		$this->assertFalse($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6797");
		$this->assertFalse($az->isExplicit());

		$this->assertFalse($azs->hasNext());
	}

	
	function test_get_all_AZs_by_func_type() {
		$azs =& $this->manager->getAllAZsByFuncType(new HarmoniId("3825"), new DefaultFunctionType(), 
											  new HarmoniId("6800"), true);

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertFalse($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6796");
		$this->assertFalse($az->isExplicit());

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, null);
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6797");
		$this->assertFalse($az->isExplicit());

		$this->assertFalse($azs->hasNext());
	}

	
	function test_get_explicit_AZs() {
		$azs =& $this->manager->getExplicitAZs(new HarmoniId("3825"), new HarmoniId("501"), 
											  new HarmoniId("6800"), true);

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());
		$this->assertFalse($azs->hasNext());

		$azs =& $this->manager->getExplicitAZs(new HarmoniId("3825"), new HarmoniId("501"), 
											  new HarmoniId("6795"), true);
		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());
		$this->assertFalse($azs->hasNext());
	}


	
	function test_get_explicit_AZs_by_func_type() {
		$azs =& $this->manager->getExplicitAZsByFuncType(new HarmoniId("3826"), new DefaultFunctionType(), 
											  new HarmoniId("6800"), true);

		$this->assertTrue($azs->hasNext());
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "1");
		$this->assertIdentical($az->_agentId->getIdString(), "3826");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6800");
		$this->assertTrue($az->isExplicit());

		$this->assertFalse($azs->hasNext());
	}
	
	
	function test_is_authorized() {
		$this->assertTrue($this->manager->isAuthorized(new HarmoniId("3825"), 
													   new HarmoniId("501"),
													   new HarmoniId("6800")));
		$this->assertTrue($this->manager->isAuthorized(new HarmoniId("3825"), 
													   new HarmoniId("501"),
													   new HarmoniId("6801")));
		$this->assertFalse($this->manager->isAuthorized(new HarmoniId("3825"), 
													   new HarmoniId("502"),
													   new HarmoniId("6799")));
	}
	
	
	function test_get_functions() {
		$functions =& $this->manager->getFunctions(new DefaultFunctionType());
		
		while ($functions->hasNext())
			$this->assertIsA($functions->next(), "FunctionInterface");
	}
	
	
	function test_get_qualifier_children() {
		$qualifiers =& $this->manager->getQualifierChildren(new HarmoniId("6800"));

		while ($qualifiers->hasNext())
			$this->assertIsA($qualifiers->next(), "Qualifier");
	}
	
	function test_get_qualifier_descendants() {
		$qualifiers =& $this->manager->getQualifierDescendants(new HarmoniId("6800"));

		while ($qualifiers->hasNext()) {
			$qualifier =& $qualifiers->next();
			$this->assertIsA($qualifier, "Qualifier");
		}
	}
	
	
	function test_get_who_can_do() {
		$agentIds =& $this->manager->getWhoCanDo(new HarmoniId("501"),
												 new HarmoniId("6800"),
												 true);

		while ($agentIds->hasNext()) {
			$agentId =& $agentIds->next();
			$this->assertIsA($agentId, "Id");
		}
	}

	
	function test_get_all_user_AZs() {
		$azs =& $this->manager->getAllUserAZs(new HarmoniId("501"), 
											  new HarmoniId("6800"), true);

	}
	
	
	function test_explicit_for_implicit() {
		$azs =& $this->manager->getAllAZs(new HarmoniId("3825"), new HarmoniId("501"), 
										  new HarmoniId("6800"), true);
										  
		$this->assertTrue($azs->hasNext());
		$azs->next();
		$az =& $azs->next();

		$azs =& $this->manager->getExplicitUserAZsForImplicitAZ($az);
		$az =& $azs->next();
		$this->assertIdentical($az->_id, "2");
		$this->assertIdentical($az->_agentId->getIdString(), "3825");
		$this->assertIdentical($az->_functionId->getIdString(), "501");
		$this->assertIdentical($az->_qualifierId->getIdString(), "6795");
		$this->assertTrue($az->isExplicit());
		$this->assertFalse($azs->hasNext());
	}
	
	
	function test_get_root_qualifiers() {
		$qualifiers =& $this->manager->getRootQualifiers(new HarmoniId("6794"));
		
		$qualifier =& $qualifiers->next();
		$this->assertIdentical($qualifier->getId(), new HarmoniId("6795"));
		$this->assertFalse($qualifiers->hasNext());
	}
	
	
	function test_get_qualifier_hierarchies() {
		$hierarchies =& $this->manager->getQualifierHierarchies();
		while ($hierarchies->hasNext()) {
			$hierarchy =& $hierarchies->next();
			$this->assertIsA($hierarchy, "Hierarchy");
		}
	}

	/**
	 *	  Clears the data set in the setUp() method call.
	 *	  @access public
	 */
	function tearDown() {
	}
	
}

?>