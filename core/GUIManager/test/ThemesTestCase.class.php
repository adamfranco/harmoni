<?php

require_once(HARMONI."GUIManager/Theme.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ThemesTestCase.class.php,v 1.7 2005/01/27 15:45:38 adamfranco Exp $
 * @copyright 2003 
 */

    class ThemesTestCase extends UnitTestCase {
		
		function ThemesTestCase() {
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
	
		function test_generic_theme() {
			$theme =& new Theme("Master", "And Servant");
			$this->assertIdentical($theme->getDisplayName(), "Master");
			$this->assertIdentical($theme->getDescription(), "And Servant");
			$theme->setDisplayName("Enjoy");
			$theme->setDescription("The Silence");
			$this->assertIdentical($theme->getDisplayName(), "Enjoy");
			$this->assertIdentical($theme->getDescription(), "The Silence");
			
			$bodyStyle =& new StyleCollection("body", "hey", "Body Style", "Global style settings.");
			$bodyStyle->addSP(new BackgroundColorSP("#FFFCF0"));
			$bodyStyle->addSP(new ColorSP("#2E2B33"));
			$bodyStyle->addSP(new FontSP("Verdana", "10pt"));
			
			$theme->addStyleForComponentType($bodyStyle, MENU, 2);

			$arr =& $theme->getStylesForComponentType(MENU, 2);
			$this->assertReference($bodyStyle, $arr["body"]);
			$this->assertReference($bodyStyle, $theme->_styles["body"]);

			$arr =& $theme->getStylesForComponentType(MENU, 3);
			$this->assertReference($bodyStyle, $arr["body"]);

			$arr =& $theme->getStylesForComponentType(MENU, 1);
			$this->assertIdentical(array(), $arr);

			$arr =& $theme->getStylesForComponentType(BLANK, 1);
			$this->assertIdentical(array(), $arr);
			
			$theme->setPreHTMLForComponentType("blah1", BLOCK, 3);
			$theme->setPreHTMLForComponentType("blah2", BLOCK, 1);
			$theme->setPostHTMLForComponentType("blah3", BLOCK, 4);
			$theme->setPostHTMLForComponentType("blah4", BLOCK, 2);
			
			$this->assertIdentical($theme->getPreHTMLForComponentType(BLOCK, 3), "blah1");
			$this->assertIdentical($theme->getPreHTMLForComponentType(BLOCK, 1), "blah2");
			$this->assertIdentical($theme->getPostHTMLForComponentType(BLOCK, 4), "blah3");
			$this->assertIdentical($theme->getPostHTMLForComponentType(BLOCK, 2), "blah4");

			$this->assertIdentical($theme->getPreHTMLForComponentType(BLOCK, 4), "blah1");
			$this->assertIdentical($theme->getPreHTMLForComponentType(BLOCK, 2), "blah2");
			$this->assertIdentical($theme->getPostHTMLForComponentType(BLOCK, 5), "blah3");
			$this->assertIdentical($theme->getPostHTMLForComponentType(BLOCK, 1), "");

//			$theme->printPage();
		}
		
		// test registering and exporting sps
		function test_register_sps() {
			$theme =& new Theme("Master", "And Servant");

			$sp1 =& new BackgroundColorSP("#FFFCF0");
			$id1 = $theme->registerSP($sp1);
			$sp2 =& new ColorSP("#2E2B33");
			$id2 = $theme->registerSP($sp2);
			$sp3 =& new FontSP("Verdana", "10pt");
			$id3 = $theme->registerSP($sp3, "getAllRegisteredSPs");
			
			$this->assertReference($sp1, $theme->getRegisteredSP($id1));
			$this->assertReference($sp2, $theme->getRegisteredSP($id2));
			$this->assertReference($sp3, $theme->getRegisteredSP($id3));
			
			$exportData1 = $theme->exportRegisteredSP($id1);
			$this->assertIdentical($exportData1, array("#FFFCF0"));
			$exportData2 = $theme->exportRegisteredSP($id2);
			$this->assertIdentical($exportData2, array("#2E2B33"));
			$exportData3 = $theme->exportRegisteredSP($id3);
			$this->assertIdentical($exportData3, array("10pt", "Verdana"));
		
			$exportData4 = $theme->exportAllRegisteredSPs();
			$this->assertIdentical($exportData4, array($id1 => $exportData1, 
													   $id2 => $exportData2, 
													   $id3 => $exportData3));
													   
			$sp3_copy = $sp3;
			$theme->importRegisteredSP($id3, $exportData3);
			$this->assertIdentical($sp3, $sp3_copy);

			// ***
			
			$bodyStyle =& new StyleCollection("body", "hey", "Body Style", "Global style settings.");
			$bodyStyle->addSP($sp2);

			$theme->addGlobalStyle($bodyStyle);
			$theme->importRegisteredSP($id2, array("#AAA"));
			$sp2a =& $bodyStyle->_SPs["color"];
			$this->assertIdentical($sp2a->_SCs[0]->getValue(), "#AAA");

		}
	
		
    }

?>