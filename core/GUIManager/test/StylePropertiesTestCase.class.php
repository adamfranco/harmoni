<?php

require_once(HARMONI."GUIManager/GenericSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StylePropertiesTestCase.class.php,v 1.1 2004/07/09 06:06:39 dobomode Exp $
 * @copyright 2003 
 */

    class StylePropertiesTestCase extends UnitTestCase {
		
		function StylePropertiesTestCase() {
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
	
		function test_generic_style_property() {
			$sp =& new GenericSP("border", "border", "The border");
			$sp->addSPC(new GenericSPC("solid", null));
			$sp->addSPC(new GenericSPC("1px", null));
			$sp->addSPC(new GenericSPC("#000", null));
			$this->assertIdentical($sp->getDisplayName(), "border");
			$this->assertIdentical($sp->getDescription(), "The border");
			$this->assertIdentical($sp->getCSS(), "border: solid 1px #000;");
		}
		
		function test_color_style_property() {
			$sp =& new ColorSP("#23FF12");
			$this->assertIdentical($sp->getDisplayName(), "Color");
			$this->assertIdentical($sp->getDescription(), "This property specifies the foreground color.");
			$this->assertIdentical($sp->getCSS(), "color: #23FF12;");
		}
		
		function test_border_style_property() {
			$sp =& new BorderSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border: 23in ridge #23FF12;");
		}
		
		
    }

?>