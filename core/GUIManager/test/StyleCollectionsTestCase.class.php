<?php

require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StyleCollectionsTestCase.class.php,v 1.1 2004/07/14 20:50:38 dobomode Exp $
 * @copyright 2003 
 */

    class StyleCollectionsTestCase extends UnitTestCase {
		
		function StyleCollectionsTestCase() {
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
	
		function test_collections() {
			$collection =& new StyleCollection("div", "The Block", "Some Blocky Block");
			$collection->addSP(new ColorSP("#FFBBAA"));
			
			$css1 =& $collection->getCSS();
			$css2 = "div {\n\tcolor: #FFBBAA;\n}";
			$this->assertIdentical($css1, $css2);

			// another one
			$collection =& new StyleCollection("p.col3", "The Block", "Some Blocky Block");
			$collection->addSP(new ColorSP("#FFBBAA"));
			$collection->addSP(new BorderSP("3em", "solid", "#421"));
			
			$css1 =& $collection->getCSS();
			$css2 = "p.col3 {\n\tcolor: #FFBBAA;\n\tborder: 3em solid #421;\n}";
			$this->assertIdentical($css1, $css2);
		}
		
		
    }

?>