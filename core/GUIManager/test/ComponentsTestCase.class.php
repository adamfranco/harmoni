<?php
/**
 * @package  harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ComponentsTestCase.class.php,v 1.9 2006/08/02 23:50:28 sporktim Exp $
 */
require_once(HARMONI."GUIManager/Component.class.php");
require_once(HARMONI."GUIManager/Container.class.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");
require_once(HARMONI."GUIManager/Layouts/XLayout.class.php");

require_once(HARMONI."GUIManager/Components/Blank.class.php");
require_once(HARMONI."GUIManager/Components/Block.class.php");
require_once(HARMONI."GUIManager/Components/Heading.class.php");
require_once(HARMONI."GUIManager/Components/Footer.class.php");
require_once(HARMONI."GUIManager/Components/MenuItemLink.class.php");
require_once(HARMONI."GUIManager/Components/MenuItemHeading.class.php");
require_once(HARMONI."GUIManager/Components/Menu.class.php");


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
 * @version $Id: ComponentsTestCase.class.php,v 1.9 2006/08/02 23:50:28 sporktim Exp $
 */

    class ComponentsTestCase extends UnitTestCase {
		
		function ComponentsTestCase() {
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
			$style =& $comp1->addStyle($bodyStyle);
			$this->assertReference($style, $bodyStyle);
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

			$style =& $comp1->removeStyle("body");
			$this->assertReference($style, $bodyStyle);
			$this->assertTrue(!isset($comp1->_styleCollections["body"]));
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
			$this->assertIdentical($comp->getComponentsCount(), 1);

			$c =& new Component("Hello!", MENU_ITEM_LINK_SELECTED, 2);
			$c2 =& $comp->add($c, "16px", "6em", RIGHT, CENTER);
			$this->assertReference($c2, $c);
			$this->assertReference($comp->getComponent(2), $c);
			$this->assertIdentical($comp->getComponentsCount(), 2);

			$c =& new Component("Hello!", MENU_ITEM_LINK_UNSELECTED, 5);
			$c3 =& $comp->add($c, "6px", "2em", CENTER, TOP);
			$this->assertReference($c3, $c);
			$this->assertReference($comp->getComponent(3), $c);
			$this->assertIdentical($comp->getComponentsCount(), 3);
			
			$c =& $comp->remove(2);
			$this->assertReference($c, $c2);
			$this->assertNull($comp->getComponent(2));
			$this->assertIdentical($comp->getComponentsCount(), 2);
			
			$comp->removeAll();
			$this->assertIdentical($comp->_components, array());
			$this->assertIdentical($comp->getComponentsCount(), 0);
		}
		
		function test_simple_components() {
			$comp =& new Blank(3);
			$this->assertIdentical($comp->getType(), BLANK);
		
			$comp =& new Block("hoho", 3);
			$this->assertIdentical($comp->getType(), BLOCK);
		
			$comp =& new Heading("hoho", 3);
			$this->assertIdentical($comp->getType(), HEADING);
		
			$comp =& new Footer("hoho", 3);
			$this->assertIdentical($comp->getType(), FOOTER);
			
		}
		
		function test_menu_components() {
			$theme =& new Theme("","");

			$heading =& new MenuItemHeading("hoho", 3);
			$this->assertIdentical($heading->getType(), MENU_ITEM_HEADING);
			$this->assertIdentical($heading->getDisplayName(), "hoho");
//			$comp->render($theme);
		
			$comp =& new MenuItemLink("Google", "http://www.google.com", true, 1,
								  "_BLANK", "g", "Go to the Google search page");
			$this->assertIdentical($comp->getDisplayName(), "Google");
			$this->assertIdentical($comp->getURL(), "http://www.google.com");
			$this->assertTrue($comp->isSelected());
			$this->assertIdentical($comp->getTarget(), "_BLANK");
			$this->assertIdentical($comp->getAccessKey(), "g");
			$this->assertIdentical($comp->getToolTip(), "Go to the Google search page");
			$this->assertIdentical($comp->getType(), MENU_ITEM_LINK_SELECTED);
			
			$comp->setDisplayName("1");
			$comp->setURL("2");
			$comp->setSelected(false);
			$comp->setTarget("4");
			$comp->setAccessKey("5");
			$comp->setToolTip("6");
			$this->assertIdentical($comp->getDisplayName(), "1");
			$this->assertIdentical($comp->getURL(), "2");
			$this->assertFalse($comp->isSelected());
			$this->assertIdentical($comp->getTarget(), "4");
			$this->assertIdentical($comp->getAccessKey(), "5");
			$this->assertIdentical($comp->getToolTip(), "6");
			$this->assertIdentical($comp->getType(), MENU_ITEM_LINK_UNSELECTED);
			
			$comp =& new MenuItemLink("Google", "http://www.google.com", true, 1,
								  "_BLANK", "g", "Go to the Google search page");
								  
			$comp->addAttribute("name", "haha");
								  
//			$comp->render($theme);

			$menuStyle =& new StyleCollection("*.menu", "menu", "Menu Style", "Style for the menu.");
			$menuStyle->addSP(new BackgroundColorSP("#997755"));
			$menuStyle->addSP(new BorderSP("1px", "solid", "#FFFFFF"));
			
			$menu =& new Menu(new XLayout(), 4, $menuStyle);
			$this->assertTrue(!isset($comp->_selectedId));
			$menu->add($comp, "100px", null, CENTER);
			$this->assertIdentical($menu->_selectedId, 1);
			$this->assertIdentical($comp->isSelected(), true);
			$this->assertReference($menu->getSelected(), $comp);
			
			$comp1 = $comp;
			$menu->add($comp1, "100px", null, CENTER);
			$this->assertIdentical($menu->_selectedId, 2);
			$this->assertIdentical($comp1->isSelected(), true);
			$this->assertIdentical($comp->isSelected(), false);
			$this->assertReference($menu->getSelected(), $comp1);
			
			$comp2 = $comp;
			$comp2->setSelected(false);
			$menu->add($comp2, "100px", null, CENTER);
			$this->assertIdentical($menu->_selectedId, 2);
			$this->assertIdentical($comp->isSelected(), false);
			$this->assertIdentical($comp1->isSelected(), true);
			$this->assertIdentical($comp2->isSelected(), false);
			$this->assertReference($menu->getSelected(), $comp1);
			
			$menu->select(3);
			$this->assertIdentical($comp->isSelected(), false);
			$this->assertIdentical($comp1->isSelected(), false);
			$this->assertIdentical($comp2->isSelected(), true);
			$this->assertReference($menu->getSelected(), $comp2);
			
			$menu->add($heading, "100px", null, CENTER);
			
			echo "<style>";
			echo $menuStyle->getCSS();
			echo "</style>";
			$menu->render($theme);
		}
		
    }

?>