<?php

require_once(HARMONI."utilities/ArgumentValidator.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");


/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ArgumentValidatorTestCase.class.php,v 1.3 2005/03/29 19:44:48 adamfranco Exp $
 * @copyright 2003 
 **/

    class ArgumentValidatorTestCase extends UnitTestCase {
	
		function ServicesTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
		}

		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
		}
	
		/**
		 *    Tests different types of validations.
		 */ 
		function test_All_Sorts_Of_Values() {
			// test a plain string
			$this->assertTrue(ArgumentValidator::validate("Hello!", StringValidatorRule::getRule(), true));

			// test numeric values
			$this->assertTrue(ArgumentValidator::validate("23.21E10", NumericValidatorRule::getRule(), true));
			$this->assertTrue(ArgumentValidator::validate(23, NumericValidatorRule::getRule(), true));
			$this->assertTrue(ArgumentValidator::validate(23.21, NumericValidatorRule::getRule(), true));

			// test integer values
			$this->assertTrue(ArgumentValidator::validate(23, IntegerValidatorRule::getRule(), true));

			// test string values
			$this->assertTrue(ArgumentValidator::validate("23", StringValidatorRule::getRule(), true));

			// test email values
			$this->assertTrue(ArgumentValidator::validate("dradichk@middlebury.edu", EmailValidatorRule::getRule(), true));
			$this->assertFalse(ArgumentValidator::validate("dradichk@middlebury", EmailValidatorRule::getRule(), false), "Gabe, fix this! Your EmailValidatorRule is faulty!");

			// test boolean values
			$this->assertTrue(ArgumentValidator::validate(true, BooleanValidatorRule::getRule(), true));
			$this->assertFalse(ArgumentValidator::validate("HOHO", BooleanValidatorRule::getRule(), false), "Gabe, fix this! Your BooleanValidatorRule is faulty!\nIn fact, I think you should just use is_bool() in your check() function.");
		}
			
    }

?>