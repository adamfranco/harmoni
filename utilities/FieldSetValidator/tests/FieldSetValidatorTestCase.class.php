<?php

    require_once('inc.php');
    require_once('rules/inc.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: FieldSetValidatorTestCase.class.php,v 1.1 2003/06/23 19:14:26 gabeschine Exp $
 * @copyright 2003 
 **/

    class FieldSetValidatorTestCase extends UnitTestCase {
	
		var $testFieldSet;
		var $testRuleSet;
		var $testValidator;
	
		function FieldSetValidatorTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->testFieldSet =& new FieldSet();
			
			$this->testRuleSet =& new RuleSet();

			$this->testValidator = & new FieldSetValidator(& $this->testFieldSet, & $this->testRuleSet );
			
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			unset($this->testFieldSet,$this->testRuleSet, $this->testValidator);
		}
	
		/**
		 *    Tests getNumberOfUsers() function.
		 */ 
		function test_field_set_add() {
			$this->assertEqual($this->testFieldSet->count(),0);
			
			$this->testFieldSet->set("mystring","this is a string");
			
			$this->assertEqual($this->testFieldSet->get("mystring"),"this is a string");
			$this->assertEqual($this->testFieldSet->count(),1);
		}
		
		function test_field_set_add_multiple() {
			$this->assertEqual($this->testFieldSet->count(),0);
			
			$this->testFieldSet->set("mystring","this is a tree");
			$this->testFieldSet->set("mynumber",10);
			$this->testFieldSet->set("mystring","this is a string");
			
			$this->assertEqual($this->testFieldSet->get("mystring"),"this is a string");
			$this->assertEqual($this->testFieldSet->get("mynumber"),10);
			$this->assertEqual($this->testFieldSet->count(),2);
		}
		
		function test_field_set_unsetKey() {
			$this->assertEqual($this->testFieldSet->count(),0);
			
			$this->testFieldSet->set("mystring","this is a tree");
			$this->testFieldSet->set("mynumber",10);
			$this->testFieldSet->set("mystring","this is a string");
			
			$this->testFieldSet->unsetKey("mystring");
			$this->assertEqual($this->testFieldSet->count(),1);
			$this->assertFalse($this->testFieldSet->get("mystring"));
		}
		
		function test_field_set_getKeys() {
			$this->assertEqual($this->testFieldSet->count(),0);
			
			$this->testFieldSet->set("mystring","this is a tree");
			$this->testFieldSet->set("mynumber",10);
			$this->testFieldSet->set("mystring","this is a string");
			
			$keys=$this->testFieldSet->getKeys();
			$this->assertEqual($keys,array("mystring","mynumber"));
		}
		
		function test_field_set_clear() {
			$this->assertEqual($this->testFieldSet->count(),0);
			
			$this->testFieldSet->set("mystring","this is a tree");
			$this->testFieldSet->set("mynumber",10);
			$this->testFieldSet->set("mystring","this is a string");
			
			$this->testFieldSet->clear();
			$this->assertEqual($this->testFieldSet->count(),0);
		}
		
		function test_rule_set_add_multiple() {
			$this->assertEqual($this->testRuleSet->count(),0);
			$error = 1;
			$rq = & new FieldRequiredValidatorRule;
			$email = & new EmailValidatorRule;
			$number = & new NumericValidatorRule;
			$this->testRuleSet->addRule("mystring", $rq,$error);
			$this->testRuleSet->addRule("mystring",$email,$error);
			
			$this->testRuleSet->addRule("mynumber", $number, $error);
			$this->assertEqual($this->testRuleSet->count(),2);
			$this->assertReference($this->testRuleSet->_rules["mystring"][0][0], $rq);
			$this->assertReference($this->testRuleSet->_rules["mystring"][1][0], $email);
			$this->assertReference($this->testRuleSet->_rules["mynumber"][0][0], $number);
			$this->assertEqual($this->testRuleSet->getKeys(), array("mystring","mynumber"));
		}
		
		function test_validator_all() {
			$this->test_field_set_add_multiple();
			$this->test_rule_set_add_multiple();
			
			// now do some tests
			//$this->testValidator->validateAll();
			$this->assertTrue($this->testValidator->validate("mynumber"));
			$this->assertFalse($this->testValidator->validate("mystring"));
		}
    }

?>