<?php

require_once(HARMONI."GUIManager/GenericSPC.class.php");
require_once(HARMONI."GUIManager/StylePropertyComponents/LengthSPC.class.php");
require_once(HARMONI."GUIManager/StylePropertyComponents/ColorSPC.class.php");
require_once(HARMONI."GUIManager/StylePropertyComponents/BorderStyleSPC.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StylePropertyComponentsTestCase.class.php,v 1.1 2004/07/09 06:06:39 dobomode Exp $
 * @copyright 2003 
 */

    class StylePropertyComponentsTestCase extends UnitTestCase {
		
		function StylePropertyComponentsTestCase() {
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
	
		function test_generic_spc() {
			$error = "This Error should be here!";
			$rule =& new StringValidatorRule();
			$spc =& new GenericSPC("catch me", $rule, $error, "Generic", "For Testing Purposes");
			
			$this->assertIdentical("catch me", $spc->getValue());
			$this->assertIdentical("Generic", $spc->getDisplayName());
			$this->assertIdentical("For Testing Purposes", $spc->getDescription());
			$this->assertIdentical($rule, $spc->_rule);
			$this->assertIdentical($error, $spc->_errorDescription);
			$this->assertFalse($spc->hasOptions());

			$spc =& new GenericSPC(5, $rule, $error, "Generic", "For Testing Purposes");

			$error = "This one as well!";
			$options = array("red", "blue", "green");
			$spc =& new GenericSPC("catch me", $options, $error, "Generic", "For Testing Purposes");

			$spc =& new GenericSPC("blue", $options, $error, "Generic", "For Testing Purposes");

			$this->assertIdentical("blue", $spc->getValue());
			$this->assertIdentical("Generic", $spc->getDisplayName());
			$this->assertIdentical("For Testing Purposes", $spc->getDescription());
			$this->assertIdentical($options, $spc->_options);
			$this->assertIdentical($error, $spc->_errorDescription);
			$this->assertTrue($spc->hasOptions());
			$options =& $spc->getOptions();
			$this->assertIdentical("red", $options->next());
			$this->assertIdentical("blue", $options->next());
			$this->assertIdentical("green", $options->next());
			$this->assertFalse($options->hasNext());
		}
		
		function test_spcs() {
			$spc =& new LengthSPC("123.2px");
			$spc =& new LengthSPC("-13.2in");
			$spc =& new LengthSPC("12em");
			$spc =& new LengthSPC("12cm");

			// ---------------------------------------------------
			
			$spc =& new ColorSPC("#ABC");
			$spc =& new ColorSPC("#03A");

			$spc =& new ColorSPC("#ABDFAC");
			$spc =& new ColorSPC("#003344");

			$spc =& new ColorSPC("rgb(39,49,39)");
			$spc =& new ColorSPC("rgb(39, 149, 239)");
			$spc =& new ColorSPC("rgb(111,0, 255)");

			$spc =& new ColorSPC("rgb(39%,49%,39%)");
			$spc =& new ColorSPC("rgb(0.3124%,49.412%,39.123%)");
			$spc =& new ColorSPC("rgb(0.0%,   100%, 3.324%)");

			// ---------------------------------------------------

			$spc =& new BorderStyleSPC("none");
			$spc =& new BorderStyleSPC("dotted");
			$spc =& new BorderStyleSPC("solid");
			$spc =& new BorderStyleSPC("dashed");
			$spc =& new BorderStyleSPC("ridge");
		}
		
    }

?>