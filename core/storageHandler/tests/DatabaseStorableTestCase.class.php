<?php


require_once(HARMONI.'storageHandler/Storables/DatabaseStorable.class.php');
require_once(HARMONI.'services/Services.class.php');


/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 *
 * @package harmoni.storage.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DatabaseStorableTestCase.class.php,v 1.7 2007/09/04 20:25:53 adamfranco Exp $
 */

    class DatabaseStorableTestCase extends UnitTestCase {
	
		function FileStorableTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		/**
		 *    First test Description.
		 */ 
		function test_get_data() {
			$dbHandler = Services::getService("DatabaseManager");

			$dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");
			$databaseId = $dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");

			$dataContainer = new DatabaseStorableDataContainer();
			$dataContainer->set("dbIndex",1);
			$dataContainer->set("dbTable","decisions");
			$dataContainer->set("pathColumn","FK_teams");
			$dataContainer->set("nameColumn","data_id");
			$dataContainer->set("sizeColumn","");
			$dataContainer->set("dataColumn","lenom");
  			$storable = new DatabaseStorable($dataContainer,1,1);

			$this->assertEqual(get_class($dbHandler),"dbhandler");
		    $this->assertEqual($storable->getData(),"lettonie");
		}

		function test_get_size() {
			$dbHandler = Services::getService("DatabaseManager");

			$dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");
			$databaseId = $dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");

			$dataContainer = new DatabaseStorableDataContainer();
			$dataContainer->set("dbIndex",1);
			$dataContainer->set("dbTable","decisions");
			$dataContainer->set("pathColumn","FK_teams");
			$dataContainer->set("nameColumn","data_id");
			$dataContainer->set("sizeColumn","lesize");
			$dataContainer->set("dataColumn","lenom");
  			$storable = new DatabaseStorable($dataContainer,1,3);

		    $this->assertEqual($storable->getSize(),3);

		}
		
    }

?>