<?php

require_once(HARMONI."GUIManager/GUIManager.class.php");
require_once(HARMONI."GUIManager/Theme.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: GUIManagerTestCase.class.php,v 1.2 2005/01/19 16:32:55 adamfranco Exp $
 * @copyright 2003 
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
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->connect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$this->manager =& new GUIManager($dbIndex, "doboHarmoniTest");
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
			$this->assertIdentical($this->manager->_guiDB, "doboHarmoniTest");
		}
	
		function test_db_methods() {
			$theme =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#FFFCF0");
			$id1 = $theme->registerSP($sp1);
			$sp2 =& new ColorSP("#2E2B33");
			$id2 = $theme->registerSP($sp2);
			$sp3 =& new FontSP("Verdana", "10pt");
			$id3 = $theme->registerSP($sp3);
			
			$id =& $this->manager->saveThemeState($theme);
			$this->assertIsA($id, "HarmoniId");
			
			$theme1 =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#241");
			$id1 = $theme1->registerSP($sp1);
			$sp2 =& new ColorSP("#325");
			$id2 = $theme1->registerSP($sp2);
			$sp3 =& new FontSP("Arial", "9pt");
			$id3 = $theme1->registerSP($sp3);
			
			$this->manager->loadThemeState($id, $theme1);
			
			$this->assertIdentical($theme, $theme1);
			
		}
		
		
    }

?>