<?php
/**
 * @package harmoni.osid_v2.agent.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentTestCase.class.php,v 1.8 2007/09/04 20:25:36 adamfranco Exp $
 */
 
require_once(HARMONI.'/oki2/agent/HarmoniAgent.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.osid_v2.agent.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AgentTestCase.class.php,v 1.8 2007/09/04 20:25:36 adamfranco Exp $
 */

	class AgentTestCase extends UnitTestCase {
	
		var $agent;

		/**
		 *	  Sets up unit test wide variables at the start
		 *	  of each test method.
		 *	  @access public
		 */
		function setUp() {
			// Set up the database connection
		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->agent);
		}

		//--------------the tests ----------------------

		function test_everything() {
			$id = new HarmoniId("8");
			$type = new HarmoniType("Look at me!", "I rock...", "I rule!", "And rise!");

			$this->agent = new HarmoniAgent("dobomode", $id, $type, 1, "blah");
			
			$this->assertIsA($this->agent, "HarmoniAgent");
			$this->assertIdentical($this->agent->getDisplayName(), "dobomode");
			$this->assertIdentical($this->agent->getId(), $id);
			$this->assertIdentical($this->agent->getType(), $type);
		}
		
		
	}