<?php

require_once(HARMONI.'oki/authorization/HarmoniQualifier.class.php');
require_once(HARMONI.'oki/authorization/DefaultQualifierType.class.php');

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
 * @version $Id: QualifierTestCase.class.php,v 1.7 2007/09/04 20:25:39 adamfranco Exp $
 */
class HarmoniQualifierTestCase extends UnitTestCase {


	function HarmoniQualifierTestCase() {
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
		
		$this->cache = new HierarchyCache("6794", true, $dbIndex, "doboHarmoniTest");
		$this->node =$this->cache->getNode("6800");
		$this->qualifier = new HarmoniQualifier($this->node, new AuthorizationCache($dbIndex, "doboHarmoniTest"));
	}

	function test_constructor() {
		$this->assertReference($this->node, $this->qualifier->_node);
	}
	
	function test_various_get_functions() {
		// getId()
		$id =$this->qualifier->getId();
		$this->assertReference($id, $this->node->getId());
		$this->assertIdentical($id, new HarmoniId("6800"));
		
		// getQualifierType()
		$type =$this->qualifier->getQualifierType();
		$this->assertReference($type, $this->node->getType());
		$deftype = new DefaultQualifierType();
		$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
		$this->assertIdentical($type->getDomain(), $deftype->getDomain());
		$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
		$this->assertIdentical($type->getDescription(), $deftype->getDescription());
		
		// getDisplayName()
		$displayName =$this->qualifier->getDisplayName();
		$this->assertIdentical($displayName, $this->node->getDisplayName());
		$this->assertIdentical($displayName, "pageC");
		
		// getDescription()
		$description =$this->qualifier->getDescription();
		$this->assertIdentical($description, $this->node->getDescription());
		$this->assertIdentical($description, "");
	}
	

	function test_updates() {
		$val = md5(uniqid(rand(), true));
		$this->qualifier->updateDescription($val);
		$this->assertIdentical($this->qualifier->getDescription(), $val);
		$val = md5(uniqid(rand(), true));
		$this->qualifier->updateDisplayName($val);
		$this->assertIdentical($this->qualifier->getDisplayName(), $val);

		$this->qualifier->updateDescription("");
		$this->qualifier->updateDisplayName("pageC");
	}
	
	
	function test_add_remove_change_parent() {
		$this->assertFalse($this->qualifier->isChildOf(new HarmoniId("6795")));
		$this->qualifier->addParent(new HarmoniId("6795"));
		$this->assertTrue($this->qualifier->isChildOf(new HarmoniId("6795")));

		$this->assertFalse($this->qualifier->isChildOf(new HarmoniId("6798")));
		$this->qualifier->changeParent(new HarmoniId("6795"), new HarmoniId("6798"));
		$this->assertTrue($this->qualifier->isChildOf(new HarmoniId("6798")));
		$this->assertFalse($this->qualifier->isChildOf(new HarmoniId("6795")));
		
		$this->qualifier->removeParent(new HarmoniId("6798"));
		$this->assertFalse($this->qualifier->isChildOf(new HarmoniId("6798")));
	}
	
	
	function test_get_parents_and_children() {
		$parents =$this->qualifier->getParents();
		$this->assertIdentical(count($parents->_qualifiers), 2);
		while ($parents->hasNext())
			$this->assertIsA($parents->next(), "Qualifier");

		$children =$this->qualifier->getChildren();
		$this->assertIdentical(count($children->_qualifiers), 2);
		while ($children->hasNext())
			$this->assertIsA($children->next(), "Qualifier");
	}

	
	function test_is_parent() {
		$this->assertTrue($this->qualifier->isParent());
		
		// go one level down
		$children =$this->qualifier->getChildren();
		$qualifier =$children->next();

		$this->assertFalse($qualifier->isParent());
	}
	
	
	function test_is_descendant() {
		$this->assertTrue($this->qualifier->isDescendantOf(new HarmoniId("6795")));
		$this->assertTrue($this->qualifier->isDescendantOf(new HarmoniId("6797")));
		$this->assertTrue($this->qualifier->isDescendantOf(new HarmoniId("6796")));
		$this->assertFalse($this->qualifier->isDescendantOf(new HarmoniId("6799")));
		$this->assertFalse($this->qualifier->isDescendantOf(new HarmoniId("6798")));
		$this->assertFalse($this->qualifier->isDescendantOf(new HarmoniId("6801")));
	}

	/**
	 *	  Clears the data set in the setUp() method call.
	 *	  @access public
	 */
	function tearDown() {
		// perhaps, unset $obj here
	}


}

?>