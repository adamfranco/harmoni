<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");

require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderLeftSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginLeftSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingLeftSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/LineHeightSP.class.php");

require_once(HARMONI."GUIManager/StyleProperties/CursorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/DirectionSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StylePropertiesTestCase.class.php,v 1.4 2004/07/19 23:59:51 dobomode Exp $
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
	
		function test_generic_sp() {
			$sp =& new StyleProperty("border", "border", "The border");
			$sp->addSC(new StyleComponent("solid", null));
			$sp->addSC(new StyleComponent("1px", null));
			$sp->addSC(new StyleComponent("#000", null));
			$this->assertIdentical($sp->getDisplayName(), "border");
			$this->assertIdentical($sp->getDescription(), "The border");
			$this->assertIdentical($sp->getCSS(), "border: solid 1px #000;");
		}
		
		function test_color_sps() {
			$sp =& new ColorSP("#23FF12");
			$this->assertIdentical($sp->getDisplayName(), "Color");
			$this->assertIdentical($sp->getDescription(), "This property specifies the foreground color.");
			$this->assertIdentical($sp->getCSS(), "color: #23FF12;");

			$sp =& new BackgroundColorSP("#23FF12");
			$this->assertIdentical($sp->getCSS(), "background-color: #23FF12;");
		}
		
		function test_border_sps() {
			$sp =& new BorderSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border: 23in ridge #23FF12;");

			$sp =& new BorderTopSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border-top: 23in ridge #23FF12;");
			$sp =& new BorderRightSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border-right: 23in ridge #23FF12;");
			$sp =& new BorderBottomSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border-bottom: 23in ridge #23FF12;");
			$sp =& new BorderLeftSP("23in", "ridge","#23FF12");
			$this->assertIdentical($sp->getCSS(), "border-left: 23in ridge #23FF12;");
		}
		
		function test_margin_sps() {
			$sp =& new MarginSP("23in");
			$this->assertIdentical($sp->getCSS(), "margin: 23in;");
			$sp =& new MarginTopSP("23in");
			$this->assertIdentical($sp->getCSS(), "margin-top: 23in;");
			$sp =& new MarginRightSP("23in");
			$this->assertIdentical($sp->getCSS(), "margin-right: 23in;");
			$sp =& new MarginBottomSP("23in");
			$this->assertIdentical($sp->getCSS(), "margin-bottom: 23in;");
			$sp =& new MarginLeftSP("23in");
			$this->assertIdentical($sp->getCSS(), "margin-left: 23in;");
		}		

		function test_padding_sps() {
			$sp =& new PaddingSP("23in");
			$this->assertIdentical($sp->getCSS(), "padding: 23in;");
			$sp =& new PaddingTopSP("23in");
			$this->assertIdentical($sp->getCSS(), "padding-top: 23in;");
			$sp =& new PaddingRightSP("23in");
			$this->assertIdentical($sp->getCSS(), "padding-right: 23in;");
			$sp =& new PaddingBottomSP("23in");
			$this->assertIdentical($sp->getCSS(), "padding-bottom: 23in;");
			$sp =& new PaddingLeftSP("23in");
			$this->assertIdentical($sp->getCSS(), "padding-left: 23in;");
		}
		
		function test_font_sp() {
			$sp =& new FontSP("'Verdana'", "x-large");
			$this->assertIdentical($sp->getCSS(), "font: x-large 'Verdana';");

			$sp =& new FontSP("'Verdana'", "x-large", "oblique");
			$this->assertIdentical($sp->getCSS(), "font: oblique x-large 'Verdana';");

			$sp =& new FontSP("'Verdana'", "x-large", null, 600, "small-caps");
			$this->assertIdentical($sp->getCSS(), "font: small-caps 600 x-large 'Verdana';");
		}
		
		function test_line_height_sp() {
			$sp =& new LineHeightSP("3.54");
			$this->assertIdentical($sp->getCSS(), "line-height: 3.54;");
		}
		
		function test_cursor_sp() {
			$sp =& new CursorSP("hand");
			$this->assertIdentical($sp->getCSS(), "cursor: hand;");
		}
		
		function test_direction_sp() {
			$sp =& new DirectionSP("ltr");
			$this->assertIdentical($sp->getCSS(), "direction: ltr;");
		}
		
		
		
    }

?>