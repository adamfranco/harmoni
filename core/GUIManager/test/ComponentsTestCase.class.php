<?php

require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ComponentsTestCase.class.php,v 1.1 2004/07/19 23:59:51 dobomode Exp $
 * @copyright 2003 
 */

    class ComponentsTestCase extends UnitTestCase {
		
		function ComponentsTestCase() {
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
	
		function test_generic_container() {
			$comp =& new Container(new FlowLayout());
			
			$c =& new Component("Hello!");
			$c1 =& $comp->add($c, "12px", "2em", ALIGNMENT_LEFT, ALIGNMENT_BOTTOM);
			$this->assertReference($c1, $c);
			$this->assertReference($comp->getComponent(1), $c);
			$this->assertIdentical($comp->getComponentWidth(1), "12px");
			$this->assertIdentical($comp->getComponentHeight(1), "2em");
			$this->assertIdentical($comp->getComponentAlignmentX(1), ALIGNMENT_LEFT);
			$this->assertIdentical($comp->getComponentAlignmentY(1), ALIGNMENT_BOTTOM);

			$c =& new Component("Hello!");
			$c2 =& $comp->add($c, "16px", "6em", ALIGNMENT_RIGHT, ALIGNMENT_CENTER);
			$this->assertReference($c2, $c);
			$this->assertReference($comp->getComponent(2), $c);

			$c =& new Component("Hello!");
			$c3 =& $comp->add($c, "6px", "2em", ALIGNMENT_CENTER, ALIGNMENT_TOP);
			$this->assertReference($c3, $c);
			$this->assertReference($comp->getComponent(3), $c);
			
			$c =& $comp->remove(2);
			$this->assertReference($c, $c2);
			$this->assertNull($comp->getComponent(2));
			
			$comp->removeAll();
			$this->assertIdentical($comp->_components, array());
		}
		
    }

?>