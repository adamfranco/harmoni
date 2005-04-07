<?php
/**
 * @package harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleComponentsTestCase.class.php,v 1.8 2005/04/07 16:33:27 adamfranco Exp $
 */
 
require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BorderStyleSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontFamilySC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontSizeSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontStyleSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontWeightSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontVariantSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LineHeightSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextDecorationSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/CursorSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/DirectionSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/DisplaySC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/PositionSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextAlignSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextTransformSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/VisibilitySC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ZIndexSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/WhiteSpaceSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ClearSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FloatSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AutoLengthSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/VerticalAlignSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/OverflowSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/MaxDimensionSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextSpacingSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/UrlSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BackgroundRepeatSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BackgroundAttachmentSC.class.php");

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
 * @version $Id: StyleComponentsTestCase.class.php,v 1.8 2005/04/07 16:33:27 adamfranco Exp $
 */

    class StyleComponentsTestCase extends UnitTestCase {
		
		function StyleComponentsTestCase() {
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
	
		function test_generic_sc() {
			$error = "This Error should be here!";
			$rule =& StringValidatorRule::getRule();
			$sc =& new StyleComponent("catch me", $rule, null, null, $error, "Generic", "For Testing Purposes");
			
			$this->assertIdentical("catch me", $sc->getValue());
			$this->assertIdentical("Generic", $sc->getDisplayName());
			$this->assertIdentical("For Testing Purposes", $sc->getDescription());
			$this->assertIdentical($rule, $sc->_rule);
			$this->assertIdentical($error, $sc->_errorDescription);
			$this->assertFalse($sc->hasOptions());

			$sc =& new StyleComponent(5, $rule, null, null, $error, "Generic", "For Testing Purposes");

			$error = "This one as well!";
			$options = array("red", "blue", "green");
			$sc =& new StyleComponent("catch me", null, $options, true, $error, "Generic", "For Testing Purposes");

			$sc =& new StyleComponent("blue", null, $options, true, $error, "Generic", "For Testing Purposes");

			$this->assertIdentical("blue", $sc->getValue());
			$this->assertIdentical("Generic", $sc->getDisplayName());
			$this->assertIdentical("For Testing Purposes", $sc->getDescription());
			$this->assertIdentical($options, $sc->_options);
			$this->assertIdentical($error, $sc->_errorDescription);
			$this->assertTrue($sc->hasOptions());
			$options1 = $sc->getOptions();
			$this->assertIdentical($options, $options1);
		}
		
		function test_scs() {
			$sc =& new LengthSC("123.2px");
			$sc =& new LengthSC("-13.2in");
			$sc =& new LengthSC("12em");
			$sc =& new LengthSC("12cm");

			// ---------------------------------------------------
			
			$sc =& new ColorSC("#ABC");
			$sc =& new ColorSC("#03A");

			$sc =& new ColorSC("#ABDFAC");
			$sc =& new ColorSC("#003344");

			$sc =& new ColorSC("rgb(39,49,39)");
			$sc =& new ColorSC("rgb(39, 149, 239)");
			$sc =& new ColorSC("rgb(111,0, 255)");

			$sc =& new ColorSC("rgb(39%,49%,39%)");
			$sc =& new ColorSC("rgb(0.3124%,49.412%,39.123%)");
			$sc =& new ColorSC("rgb(0.0%,   100%, 3.324%)");

			// ---------------------------------------------------

			$sc =& new BorderStyleSC("none");
			$sc =& new BorderStyleSC("dotted");
			$sc =& new BorderStyleSC("solid");
			$sc =& new BorderStyleSC("dashed");
			$sc =& new BorderStyleSC("ridge");

			// ---------------------------------------------------

			$sc =& new FontFamilySC("cursive");
			$sc =& new FontFamilySC("monospace");
			$sc =& new FontFamilySC("   monospace , cuRsive,   fantasY   ");
			$sc =& new FontFamilySC("'Lucida Console'");
			$sc =& new FontFamilySC("'Arial', 'MS Sans Serif', serif  , 'blahblah'");

			// ---------------------------------------------------

			$sc =& new FontSizeSC("12px");
			$sc =& new FontSizeSC("43.2%");
			$sc =& new FontSizeSC("xx-small");

			// ---------------------------------------------------

			$sc =& new FontStyleSC("normal");
			$sc =& new FontStyleSC("italic");
			$sc =& new FontStyleSC("oblique");

			// ---------------------------------------------------

			$sc =& new FontWeightSC("300");
			$sc =& new FontWeightSC("bold");
			$sc =& new FontWeightSC("lighter");

			// ---------------------------------------------------

			$sc =& new LineHeightSC("3.5");
			$sc =& new LineHeightSC("3px");
			$sc =& new LineHeightSC("normal");

			// ---------------------------------------------------

			$sc =& new FontVariantSC("normal");
			$sc =& new FontVariantSC("small-caps");

			// ---------------------------------------------------

			$sc =& new TextDecorationSC("blink");
			$sc =& new TextDecorationSC("underline");

			// ---------------------------------------------------

			$sc =& new CursorSC("auto");
			$sc =& new CursorSC("sw-resize");
			$sc =& new CursorSC("text");

			// ---------------------------------------------------

			$sc =& new DirectionSC("ltr");
			$sc =& new DirectionSC("rtl");
			
			// ---------------------------------------------------

			$sc =& new DisplaySC("none");
			$sc =& new DisplaySC("block");
			$sc =& new DisplaySC("inline");
			
			// ---------------------------------------------------

			$sc =& new PositionSC("static");
			$sc =& new PositionSC("absolute");
			
			// ---------------------------------------------------

			$sc =& new TextAlignSC("right");
			$sc =& new TextAlignSC("justify");
			
			// ---------------------------------------------------

			$sc =& new TextTransformSC("none");
			$sc =& new TextTransformSC("uppercase");
			$sc =& new TextTransformSC("capitalize");
									
			// ---------------------------------------------------

			$sc =& new VisibilitySC("hidden");
			$sc =& new VisibilitySC("collapse");
			
									
			// ---------------------------------------------------

			$sc =& new ZIndexSC("auto");
			$sc =& new ZIndexSC("11");
			
			
			// ---------------------------------------------------

			$sc =& new WhiteSpaceSC("normal");
			$sc =& new WhiteSpaceSC("pre");
			
						
			// ---------------------------------------------------

			$sc =& new ClearSC("none");
			$sc =& new ClearSC("right");
			$sc =& new ClearSC("both");
									
			// ---------------------------------------------------

			$sc =& new FloatSC("none");
			$sc =& new FloatSC("right");
			
			// ---------------------------------------------------

			$sc =& new AutoLengthSC("auto");
			$sc =& new AutoLengthSC("10in");			
			
						
			// ---------------------------------------------------

			$sc =& new VerticalAlignSC("middle");
			$sc =& new VerticalAlignSC("text-top");
			$sc =& new VerticalAlignSC("10in");			
			
						
			// ---------------------------------------------------

			$sc =& new OverflowSC("visible");
			$sc =& new OverflowSC("hidden");
			$sc =& new OverflowSC("auto");			
			
						
			// ---------------------------------------------------

			$sc =& new MaxDimensionSC("none");
			$sc =& new MaxDimensionSC("12in");
									
			// ---------------------------------------------------

			$sc =& new TextSpacingSC("12in");
			$sc =& new TextSpacingSC("normal");

			// ---------------------------------------------------

			$sc =& new UrlSC("url(\"dads\"   )");

			// ---------------------------------------------------

			$sc =& new BackgroundRepeatSC("repeat");
			$sc =& new BackgroundRepeatSC("repeat-x");
			$sc =& new BackgroundRepeatSC("repeat-y");

			// ---------------------------------------------------

			$sc =& new BackgroundAttachmentSC("scroll");
			$sc =& new BackgroundAttachmentSC("fixed");
		}
		
		
    }

?>