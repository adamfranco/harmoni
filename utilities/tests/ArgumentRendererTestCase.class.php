<?php

require_once(HARMONI."utilities/ArgumentRenderer.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ArgumentRendererTestCase.class.php,v 1.1 2003/06/26 02:03:27 dobomode Exp $
 * @copyright 2003 
 **/

    class ArgumentRendererTestCase extends UnitTestCase {
	
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
		 *    Renders all types of arguments, not in detailed mode.
		 */ 
		function test_All_Types_Of_Arguments_Not_In_Detailed_Mode() {
			// test a boolean
			$arg = true;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Boolean: true";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test an integer
			$arg = 15;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Integer: 15";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test a floating point number
			$arg = 15.25;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Float: 15.25";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test a string
			$arg = "Muhaha";
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "String: \"Muhaha\"";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test an array
			$arg = array("one", "two");
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Array: 2 elements";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test an object
			$arg =& new ArgumentRenderer();
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Object: argumentrenderer";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test a resource
			$arg = mysql_connect("devo.middlebury.edu","test" ,"test");
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "Resource: mysql link";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test NULL
			$arg = NULL;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, false, true);
			$resultAssumed = "NULL";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
		}
			

	
		/**
		 *    Renders all types of arguments, in detailed mode.
		 */ 
		function test_All_Types_Of_Arguments_In_Detailed_Mode() {
			// test a boolean
			$arg = true;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "Boolean: true";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test an integer
			$arg = 15;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "Integer: 15";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test a floating point number
			$arg = 15.25;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "Float: 15.25";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test a string
			$arg = "Muhaha";
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "String: \"Muhaha\" (length = 6)";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test an array
			$arg = array("one", "two");
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$this->assertTrue($resultFromRenderer);
			
			// test an object
			$arg =& new ArgumentRenderer();
			$arg->temp = 1;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$this->assertTrue($resultFromRenderer);
			
			// test a resource
			$arg = mysql_connect("devo.middlebury.edu","test" ,"test");
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "Resource: mysql link";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
			// test NULL
			$arg = NULL;
			$resultFromRenderer = ArgumentRenderer::renderOneArgument($arg, true, true);
			$resultAssumed = "NULL";
			$this->assertEqual($resultFromRenderer, $resultAssumed);
			
		}

		/**
		 *    Renders multiple arguments, in detailed mode.
		 */ 
		function test_Multiple_Arguments() {
			$arguments = array();
			$arguments[] = true;
			$arguments[] = 15;
			$arguments[] = 15.25;
			$arguments[] = "Muhaha";
			$arguments[] = array("one", "two");
			$arguments[] =& new ArgumentRenderer();
			$arguments[] = mysql_connect("devo.middlebury.edu","test" ,"test");

			// detailed mode
			$result = ArgumentRenderer::renderManyArguments($arguments, true, true);
			// simple mode
			$result = ArgumentRenderer::renderManyArguments($arguments, false, true);
			$this->assertTrue($result);
		}

    }

?>