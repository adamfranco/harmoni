<?php
/**
 * @package harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleCollectionsTestCase.class.php,v 1.9 2007/09/04 20:25:24 adamfranco Exp $
 */
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

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
 * @version $Id: StyleCollectionsTestCase.class.php,v 1.9 2007/09/04 20:25:24 adamfranco Exp $
 */

    class StyleCollectionsTestCase extends UnitTestCase {
		
		function __construct() {
			parent::__construct();
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
	
		function test_collections() {
			$collection = new StyleCollection("div", null, "The Block", "Some Blocky Block");
			$collection->addSP(new ColorSP("#FFBBAA"));
			
			$css1 = $collection->getCSS();
			$css2 = "div {\n\tcolor: #FFBBAA;\n}\n";
			$this->assertIdentical($css1, $css2);
			$this->assertFalse($collection->canBeApplied());

			// another one
			$collection = new StyleCollection("p.col3", "col3", "The Block", "Some Blocky Block");
			$sp =$collection->addSP(new ColorSP("#FFBBAA"));
			$collection->addSP(new BorderSP("3em", "solid", "#421"));
			
			$css1 = $collection->getCSS("\t\t");
			$css2 = "\t\tp.col3 {\n\t\t\tcolor: #FFBBAA;\n\t\t\tborder: 3em solid #421;\n\t\t}\n";
			$this->assertIdentical($css1, $css2);
			$this->assertTrue($collection->canBeApplied());
			$this->assertIdentical($collection->getClassSelector(), "col3");
			
			$this->assertNotNull($collection->_SPs['color']);
			$sp1 =$collection->removeSP($sp);			
			$this->assertReference($sp1, $sp);
			$this->assertTrue(!isset($collection->_SPs['color']));
			$sps =$collection->getSPs();
			$this->assertTrue(!isset($sps['color']));
		}
		
		
    }

?>