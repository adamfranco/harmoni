<?php

require_once(HARMONI.'layoutHandler/components/Content.class.php');
require_once(HARMONI.'layoutHandler/components/HeaderMenuItem.class.php');
require_once(HARMONI.'layoutHandler/components/LinkMenuItem.class.php');
require_once(HARMONI.'layoutHandler/components/Menu.class.php');
require_once(HARMONI.'layoutHandler/components/layouts/SingleContentLayout.class.php');
//require_once(HARMONI.'layoutHandler/components/layouts/LeftMenuLayout.class.php');
//require_once(HARMONI.'layoutHandler/components/layouts/TopMenuLayout.class.php');
require_once(HARMONI."utilities/Template.class.php");
require_once(HARMONI."themeHandler/TestTheme.class.php");


/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: LayoutTestCase.class.php,v 1.2 2005/01/19 16:32:57 adamfranco Exp $
 * @copyright 2003 
 **/

    class LayoutTestCase extends UnitTestCase {
	
		function LayoutTestCase() {
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

		}
	
		/**
		 *    Tests getNumberOfUsers() function.
		 */ 
		function test_content_component() {
			$c =& new Content;
			$c->setContent("this is some content!");
			$this->assertEqual($c->getContent(),"this is some content!");
		}
		
		function test_headermenuitem() {
			$h =& new HeaderMenuItem("header");
			$this->assertEqual($h->getType(),HEADING);
			$this->assertEqual($h->getLabel(),"header");
			
			$h->setLabel("header2");
			$this->assertEqual($h->getLabel(),"header2");
		}
		
		function test_linkmenuitem() {
			$l =& new LinkMenuItem("link","www.middlebury.edu");
			$this->assertEqual($l->getLabel(),"link");
			$this->assertEqual($l->getURL(),"www.middlebury.edu");
			
			$this->assertFalse($l->isSelected());
			
			$l->setSelected(true);
			$this->assertTrue($l->isSelected());
			
			$this->assertEqual(null,$l->getTarget());
			
			$l->setTarget("target");
			$this->assertEqual("target",$l->getTarget());
			
			$l->addExtraAttributes("name='value'","name2='value2'");
			$this->assertEqual(" name='value' name2='value2'",$l->getExtraAttributes());
		}
		
		function test_singlecontentlayout() {
			$l =& new SingleContentLayout();
			$c =& new Content;
			$c->setContent("this is some content and <b>bold</b>!");
			$l->setComponent(0,&$c);
			
			// uncomment this and it throws a fatal error:
			//$l->setComponent(0,new Menu);
			$this->assertTrue($l->verifyComponents());
			//$l->output(null);
		}
		
		function test_menu() {
			$m =& new Menu;
			$this->assertEqual(0,$m->getCount());
			$this->assertEqual(0,$m->addItem(new HeaderMenuItem("What??")));
			$this->assertEqual(1,$m->getCount());
			$this->assertEqual(1,$m->addItem(new HeaderMenuItem("You heard me.")));
			$this->assertEqual(2,$m->getCount());
			
			$m->addItem(new LinkMenuItem("Link1","http://www.middlebury.edu"));
			$m->addItem(new LinkMenuItem("New window","http://google.com",false,"_blank"));
			$m->addItem(new LinkMenuItem("JavaScript Alert","#",false,null,"onClick='alert(\"testing\")'","style='text-decoration:none' "));
			//$m->output(null,3,HORIZONTAL);
			
			//$m->output(null,0,VERTICAL);
		}
		
		function test_template() {
			$tpl =& new Template("TestTheme.tpl",HARMONI."themeHandler");
			$this->assertTrue(is_object($tpl));
			$this->assertEqual($tpl->_fullPath,HARMONI."themeHandler/TestTheme.tpl");
			$f =& new FieldSet;
			$f->set("content","bla bla");
			$tpl->output($f);
		}
		
		function test_theme() {
			$t =& new TestTheme;
			$this->assertTrue(is_object($t));
			$this->assertEqual($t->getName(),"Test Theme");
			
            $layout =& new SingleContentLayout;
            $layout->setComponent(0,new Content("this is some content!"));
			$t->outputPageWithLayout($layout);
		}
    }

?>