<?php

    require_once(HARMONI.'debugHandler/DebugHandler.class.php');
	require_once(HARMONI.'debugHandler/PlainTextDebugHandlerPrinter.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DebugHandlerTestCase.class.php,v 1.1 2003/06/24 20:22:40 gabeschine Exp $
 * @copyright 2003 
 **/

    class DebugHandlerTestCase extends UnitTestCase {
	
		var $testDebug;
	
		function FieldSetValidatorTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->testDebug = & new DebugHandler();
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			unset($this->testDebug);
		}
	
		/**
		 *    Tests getNumberOfUsers() function.
		 */ 
		function test_add_text() {
			$this->assertEqual($this->testDebug->getDebugItemCount(),0);
			$this->testDebug->add("Some debug text!");
			$this->assertEqual($this->testDebug->getDebugItemCount(),1);
			$this->assertEqual($this->testDebug->_queue[0]->getText(),"Some debug text!");
			$this->assertTrue(is_object($this->testDebug->_queue[0]));
		}
		
		function test_add_object() {
			$d = & new DebugItem("text--more! debug 2", 9, "user");
			$this->assertEqual($this->testDebug->getDebugItemCount(),0);
			$this->testDebug->add(&$d);
			$this->assertEqual($this->testDebug->getDebugItemCount(),1);
			$this->assertEqual($this->testDebug->_queue[0]->getText(),"text--more! debug 2");
			$this->assertEqual($this->testDebug->_queue[0]->getCategory(),"user");
			$this->assertEqual($this->testDebug->_queue[0]->getLevel(),9);
			$this->assertTrue(is_object($this->testDebug->_queue[0]));
		}
		
		function test_printer(){
			$this->addABunch();
			$p = & new PlainTextDebugHandlerPrinter();
			print "<pre>\nOnly 'general' <= 5\n";
			$p->printDebugHandler($this->testDebug,5,"general");
			print "\n</pre>";
			
			print "<pre>\nOnly 'user' <= 10\n";
			$p->printDebugHandler($this->testDebug,10,"user");
			print "\n</pre>";
			
			print "<pre>\nAll <= 20\n";
			$p->printDebugHandler($this->testDebug,20);
			print "\n</pre>";
		}
		
		function addABunch() {
			$this->testDebug->add("debug text1 -- some crippidy crap",1);
			$this->testDebug->add("debug text2 -- some crippidy crap",2);
			$this->testDebug->add("debug text3 -- some crippidy crap",3,"system");
			$this->testDebug->add("debug text4 -- some crippidy crap",4,"user");
			$this->testDebug->add("debug text5 -- some crippidy crap",5,"category5");
			$this->testDebug->add("debug text6 -- some crippidy crap",6);
			$this->testDebug->add("debug text7 -- some crippidy crap",7);
			$this->testDebug->add("debug text8 -- some crippidy crap",8);
			$this->testDebug->add("debug text9 -- some crippidy crap",9,"blabla9");
			$this->testDebug->add("debug text10 -- some crippidy crap",15);
		}
    }

?>