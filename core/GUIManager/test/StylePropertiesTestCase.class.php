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
require_once(HARMONI."GUIManager/StyleProperties/DisplaySP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PositionSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextTransformSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/VisibilitySP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ZIndexSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MaxWidthSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MaxHeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/WordSpacingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/LetterSpacingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/WhiteSpaceSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ClearSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FloatSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/LeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/RightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/VerticalAlignSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/OverflowSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StylePropertiesTestCase.class.php,v 1.5 2004/07/22 17:10:40 tjigmes Exp $
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
		
		function test_display_sp() {
			$sp =& new DisplaySP("inline");
			$this->assertIdentical($sp->getCSS(), "display: inline;");
			
			$sp =& new DisplaySP("block");
			$this->assertIdentical($sp->getCSS(), "display: block;");
		}
				
		function test_position_sp() {
			$sp =& new PositionSP("absolute");
			$this->assertIdentical($sp->getCSS(), "position: absolute;");
		}
		
		function test_text_transform_sp() {
			$sp =& new TextTransformSP("capitalize");
			$this->assertIdentical($sp->getCSS(), "text-transform: capitalize;");
		}
		
		function test_visibility_sp() {
			$sp =& new VisibilitySP("hidden");
			$this->assertIdentical($sp->getCSS(), "visibility: hidden;");
		}
		
		function test_z_index_sp() {
			$sp =& new ZIndexSP("3");
			$this->assertIdentical($sp->getCSS(), "z-index: 3;");
		}
		
		function test_max_width_sp() {
			$sp =& new MaxWidthSP("none");
			$this->assertIdentical($sp->getCSS(), "max-width: none;");
		}

		function test_max_height_sp() {
			$sp =& new MaxHeightSP("12px");
			$this->assertIdentical($sp->getCSS(), "max-height: 12px;");
		}

		function test_word_spacing_sp() {
			$sp =& new WordSpacingSP("12px");
			$this->assertIdentical($sp->getCSS(), "word-spacing: 12px;");
		}
		
		function test_letter_spacing_sp() {
			$sp =& new LetterSpacingSP("normal");
			$this->assertIdentical($sp->getCSS(), "letter-spacing: normal;");
		}
		
		function test_white_space_sp() {
			$sp =& new WhiteSpaceSP("normal");
			$this->assertIdentical($sp->getCSS(), "white-space: normal;");
		}
		
		function test_clear_sp() {
			$sp =& new ClearSP("both");
			$this->assertIdentical($sp->getCSS(), "clear: both;");
		}
		
		function test_float_sp() {
			$sp =& new FloatSP("left");
			$this->assertIdentical($sp->getCSS(), "float: left;");
		}
		
		function test_top_sp() {
			$sp =& new TopSP("auto");
			$this->assertIdentical($sp->getCSS(), "top: auto;");
		}
		
		function test_left_sp() {
			$sp =& new LeftSP("2%");
			$this->assertIdentical($sp->getCSS(), "left: 2%;");
		}
		
		function test_right_sp() {
			$sp =& new RightSP("auto");
			$this->assertIdentical($sp->getCSS(), "right: auto;");
		}
		
		function test_bottom_sp() {
			$sp =& new BottomSP("13cm");
			$this->assertIdentical($sp->getCSS(), "bottom: 13cm;");
		}
		
		function test_vertical_align_sp() {
			$sp =& new VerticalAlignSP("middle");
			$this->assertIdentical($sp->getCSS(), "vertical-align: middle;");
		}
		
		function test_overflow_sp() {
			$sp =& new OverflowSP("scroll");
			$this->assertIdentical($sp->getCSS(), "overflow: scroll;");
		}
	}

?>