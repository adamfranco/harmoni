<?php

require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: StyleCollectionsTestCase.class.php,v 1.4 2004/08/09 03:54:35 dobomode Exp $
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
			$collection =& new StyleCollection("div", null, "The Block", "Some Blocky Block");
			$collection->addSP(new ColorSP("#FFBBAA"));
			
			$css1 =& $collection->getCSS();
			$css2 = "div {\n\tcolor: #FFBBAA;\n}\n";
			$this->assertIdentical($css1, $css2);
			$this->assertFalse($collection->canBeApplied());

			// another one
			$collection =& new StyleCollection("p.col3", "col3", "The Block", "Some Blocky Block");
			$sp =& $collection->addSP(new ColorSP("#FFBBAA"));
			$collection->addSP(new BorderSP("3em", "solid", "#421"));
			
			$css1 =& $collection->getCSS("\t\t");
			$css2 = "\t\tp.col3 {\n\t\t\tcolor: #FFBBAA;\n\t\t\tborder: 3em solid #421;\n\t\t}\n";
			$this->assertIdentical($css1, $css2);
			$this->assertTrue($collection->canBeApplied());
			$this->assertIdentical($collection->getClassSelector(), "col3");
			
			$this->assertNotNull($collection->_SPs['color']);
			$sp1 =& $collection->removeSP($sp);			
			$this->assertReference($sp1, $sp);
			$this->assertNull($collection->_SPs['color']);
			$sps =& $collection->getSPs();
			$this->assertNull($sps['color']);
		}
		
		
    }

?>