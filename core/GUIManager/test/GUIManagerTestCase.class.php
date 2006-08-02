<?php
/**
 * @package harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GUIManagerTestCase.class.php,v 1.11 2006/08/02 23:50:28 sporktim Exp $
 */
require_once(HARMONI."GUIManager/GUIManager.class.php");
require_once(HARMONI."GUIManager/Theme.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GUIManagerTestCase.class.php,v 1.11 2006/08/02 23:50:28 sporktim Exp $
 */

    class GUIManagerTestCase extends UnitTestCase {
		
		var $manager;

		function GUIManagerTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
			//$dbHandler=&Services::getService("DatabaseManager");
			//$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			//$dbHandler->connect($dbIndex);
			//unset($dbHandler); // done with that for now
			
			//$this->manager =& new GUIManager($dbIndex, "doboHarmoniTest");
			$this->manager =& Services::getService("GUI");
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		function test_constructor() {			
			$this->assertTrue(is_int($this->manager->_dbIndex));
			$this->assertTrue(is_string($this->manager->_dbName));
		}
	
		function test_db_methods() {
			$theme =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#FFFCF0");
			$id1 = $theme->registerSP($sp1);
			$sp2 =& new ColorSP("#2E2B33");
			$id2 = $theme->registerSP($sp2);
			$sp3 =& new FontSP("Verdana", "10pt");
			$id3 = $theme->registerSP($sp3);
			
			$this->manager->setTheme($theme);
			$this->manager->saveTheme();
			$id =& $theme->getId();
			$this->assertIsA($id, "HarmoniId");
			
			$theme1 =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#241");
			$id1 = $theme1->registerSP($sp1);
			$sp2 =& new ColorSP("#325");
			$id2 = $theme1->registerSP($sp2);
			$sp3 =& new FontSP("Arial", "9pt");
			$id3 = $theme1->registerSP($sp3);
			
			$this->manager->loadTheme($id);
			$themea =& $this->manager->getTheme();
			$this->assertIdentical($theme, $themea);
				
			/*** testing method replaceThemeState ***/
			$theme2 =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#241");
			$id1 = $theme2->registerSP($sp1);
			$sp2 =& new ColorSP("#325");
			$id2 = $theme2->registerSP($sp2);
			$sp3 =& new FontSP("Arial", "9pt");
			$id3 = $theme2->registerSP($sp3);
			
			$this->manager->saveTheme($id, $theme2);
			$this->manager->loadTheme($id, $theme1);

			$this->assertIdentical($theme2,$theme1);
			
			/*** testing method deleteThemeState ***/
			
			$dbHandler=&Services::getService("DatabaseManager");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->connect($dbIndex);
			
			
			$this->manager->deleteTheme($id);
			$idValue = $id->getIdString();
			$query =& new SelectQuery;
			$query->addColumn("gui_theme");
			$query->addColumn("gui_state");
			$query->addTable("gui");
			$query->addWhere("gui_id = ".$idValue);
			
			$queryResult =& $dbHandler->query($query, $dbIndex);
			
			$affectedRows = $queryResult->getNumberOfRows();
			$this->assertIdentical($affectedRows,0);
			
			$queryResult->free();
			
		}
		
		
    }

?>