<?php

require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ComponentsTestCase.class.php,v 1.2 2004/07/22 16:31:55 dobomode Exp $
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
	
		function test_generic_component() {
			$bodyStyle =& new StyleCollection("body", "hey", "Body Style", "Global style settings.");
			$bodyStyle->addSP(new BackgroundColorSP("#FFFCF0"));
			$bodyStyle->addSP(new ColorSP("#2E2B33"));
			$bodyStyle->addSP(new FontSP("Verdana", "10pt"));
			
			$mainBoxStyle =& new StyleCollection("*.mainBoxStyle", "mainBoxStyle", "Main Box Style", "Style for the main box.");
			$mainBoxStyle->addSP(new BackgroundColorSP("#FFF3C2"));
			$mainBoxStyle->addSP(new BorderSP("1px", "solid", "#2E2B33"));
			$mainBoxStyle->addSP(new WidthSP("750px"));
			$mainBoxStyle->addSP(new MarginSP("5px"));
			$mainBoxStyle->addSP(new PaddingSP("5px"));
		
			$comp1 =& new Component(null, BLANK, 3);
			$comp1->addStyle($bodyStyle);
			$comp1->addStyle($mainBoxStyle);
			$this->assertReference($comp1->_styleCollections["body"], $bodyStyle);
			$this->assertReference($comp1->_styleCollections["*.mainBoxStyle"], $mainBoxStyle);
			$this->assertIdentical($comp1->getType(), BLANK);
			$this->assertReference($comp1->getStyle("body"), $bodyStyle);
			
			$comp2 =& new Component(null, BLANK, 3, $bodyStyle, $mainBoxStyle);
			$this->assertIdentical($comp2->_styleCollections["body"], $bodyStyle);
			$this->assertIdentical($comp2->_styleCollections["*.mainBoxStyle"], $mainBoxStyle);
			$this->assertIdentical($comp1->getType(), BLANK);
			$this->assertIdentical($comp2->getIndex(), 3);

			$this->assertIdentical($comp1, $comp2);
		}
	
		function test_generic_container() {
			$comp =& new Container(new FlowLayout(), MENU, 5);
			
			$c =& new Component("Hello!", FOOTER, 4);
			$c1 =& $comp->add($c, "12px", "2em", LEFT, BOTTOM);
			$this->assertReference($c1, $c);
			$this->assertReference($comp->getComponent(1), $c);
			$this->assertIdentical($comp->getComponentWidth(1), "12px");
			$this->assertIdentical($comp->getComponentHeight(1), "2em");
			$this->assertIdentical($comp->getComponentAlignmentX(1), LEFT);
			$this->assertIdentical($comp->getComponentAlignmentY(1), BOTTOM);

			$c =& new Component("Hello!", MENU_ITEM_SELECTED, 2);
			$c2 =& $comp->add($c, "16px", "6em", RIGHT, CENTER);
			$this->assertReference($c2, $c);
			$this->assertReference($comp->getComponent(2), $c);

			$c =& new Component("Hello!", MENU_ITEM_UNSELECTED, 5);
			$c3 =& $comp->add($c, "6px", "2em", CENTER, TOP);
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