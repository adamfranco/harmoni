<?php

require_once(HARMONI."GUIManager/Theme.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ThemesTestCase.class.php,v 1.2 2004/07/26 23:23:31 dobomode Exp $
 * @copyright 2003 
 */

    class ThemesTestCase extends UnitTestCase {
		
		function ThemesTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
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
	
		
    }

?>