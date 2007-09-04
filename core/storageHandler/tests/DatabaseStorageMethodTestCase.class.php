<?php

require_once(HARMONI.'storageHandler/StorageMethods/DatabaseStorageMethod.class.php');
require_once(HARMONI.'storageHandler/Storables/FileStorable.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.storage.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DatabaseStorageMethodTestCase.class.php,v 1.7 2007/09/04 20:25:53 adamfranco Exp $
 **/

    class DatabaseStorageMethodTestCase extends UnitTestCase {
	
		function DatabaseStorageMethodTestCase() {
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
		function test_exists_store() {
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

			$storageMethod = new DatabaseStorageMethod($dataContainer);
			$this->assertTrue($storageMethod->exists(1,3));
			$this->assertTrue($storageMethod->exists(1));	
			$this->assertFalse($storageMethod->exists(2));	
			
			$storable =&new FileStorable(HARMONI.'storageHandler/tests/','','seal01.gif');
			 
			$storageMethod->store($storable,'3','seal.gif');
			$this->assertTrue($storageMethod->exists('3','seal.gif'));	

			$newstorable = $storageMethod->retrieve('3','seal.gif');
			$data = $newstorable->getData();

			$newstorable = $storageMethod->retrieve('3','seal.gif');

			$this->assertTrue($newstorable->getSize()==14096);

		}

		function test_getSize() {
			$dbHandler = Services::getService("DatabaseManager");

			$dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test33", "test3", "test3");
			$databaseId = $dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");

			$dataContainer = new DatabaseStorableDataContainer();
			$dataContainer->set("dbIndex",1);
			$dataContainer->set("dbTable","decisions");
			$dataContainer->set("pathColumn","FK_teams");
			$dataContainer->set("nameColumn","data_id");
			$dataContainer->set("sizeColumn","lesize");
			$dataContainer->set("dataColumn","lenom");

			$storageMethod = new DatabaseStorageMethod($dataContainer);
			
			$this->assertEqual($storageMethod->getSizeOf(1,1),8);
			$this->assertEqual($storageMethod->getSizeOf(1),52);
		}

		function test_delete() {
			$dbHandler = Services::getService("DatabaseManager");

			$dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test33", "test3", "test3");
			$databaseId = $dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");

			$dataContainer = new DatabaseStorableDataContainer();
			$dataContainer->set("dbIndex",1);
			$dataContainer->set("dbTable","decisions");
			$dataContainer->set("pathColumn","FK_teams");
			$dataContainer->set("nameColumn","data_id");
			$dataContainer->set("sizeColumn","lesize");
			$dataContainer->set("dataColumn","lenom");

			$storageMethod = new DatabaseStorageMethod($dataContainer);
			
			$storageMethod->deleteRecursive(2);
			$this->assertFalse($storageMethod->exists(2));
		}

		function test_listInPath_getcont() {
			$dbHandler = Services::getService("DatabaseManager");

			$dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test33", "test3", "test3");
			$databaseId = $dbHandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");

			$dataContainer = new DatabaseStorableDataContainer();
			$dataContainer->set("dbIndex",1);
			$dataContainer->set("dbTable","decisions");
			$dataContainer->set("pathColumn","FK_teams");
			$dataContainer->set("nameColumn","data_id");
			$dataContainer->set("sizeColumn","lesize");
			$dataContainer->set("dataColumn","lenom");

			$storageMethod = new DatabaseStorageMethod($dataContainer);
			
			$storables = $storageMethod->listInPath(1);

			$this->assertTrue(is_array($storables));
			$this->assertEqual(count($storables),3);
			$this->assertEqual($storageMethod->getCount(1),3);
			$this->assertEqual($storageMethod->getCount(1,false),3);
		}
    }

?>