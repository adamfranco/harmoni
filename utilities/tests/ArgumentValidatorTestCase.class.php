<?php

require_once(HARMONI."utilities/ArgumentValidator.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");


/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ArgumentValidatorTestCase.class.php,v 1.1 2003/06/26 02:03:27 dobomode Exp $
 * @copyright 2003 
 **/

    class ArgumentValidatorTestCase extends UnitTestCase {
	
		function ServicesTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
		}

		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
		}
	
		/**
		 *    Tests different types of validations.
		 */ 
		function test_All_Sorts_Of_Values() {
			// test a plain string
			$this->assertTrue(ArgumentValidator::validate("Hello!", new StringValidatorRule(), true));

			// test numeric values
			$this->assertTrue(ArgumentValidator::validate("23.21E10", new NumericValidatorRule(), true));
			$this->assertTrue(ArgumentValidator::validate(23, new NumericValidatorRule(), true));
			$this->assertTrue(ArgumentValidator::validate(23.21, new NumericValidatorRule(), true));

			// test integer values
			$this->assertTrue(ArgumentValidator::validate(23, new IntegerValidatorRule(), true));

			// test string values
			$this->assertTrue(ArgumentValidator::validate("23", new StringValidatorRule(), true));

			// test email values
			$this->assertTrue(ArgumentValidator::validate("dradichk@middlebury.edu", new EmailValidatorRule(), true));
			$this->assertFalse(ArgumentValidator::validate("dradichk@middlebury", new EmailValidatorRule(), true), "Gabe, fix this! Your EmailValidatorRule is faulty!");

			// test boolean values
			$this->assertTrue(ArgumentValidator::validate(true, new BooleanValidatorRule(), true));
			$this->assertFalse(ArgumentValidator::validate("HOHO", new BooleanValidatorRule(), false), "Gabe, fix this! Your BooleanValidatorRule is faulty!\nIn fact, I think you should just use is_bool() in your check() function.");
		}
			
    }

?>