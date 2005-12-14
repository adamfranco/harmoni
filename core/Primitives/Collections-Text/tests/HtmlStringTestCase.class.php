<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HtmlStringTestCase.class.php,v 1.2 2005/12/14 00:34:39 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

require_once(dirname(__FILE__)."/../HtmlString.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @since 5/3/05
 *
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HtmlStringTestCase.class.php,v 1.2 2005/12/14 00:34:39 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class HtmlStringTestCase extends UnitTestCase {
	
	/**
	*  Sets up unit test wide variables at the start
	*	 of each test method.
	*	 @access public
	*/
	function setUp() {
		
	}
	
	/**
	 *	  Clears the data set in the setUp() method call.
	 *	  @access public
	 */
	function tearDown() {
		// perhaps, unset $obj here
	}
	
	/**
	 * Test the creation methods.
	 */ 
	function test_trim_tag_handling() {
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(100);
		$this->assertEqual($htmlString->asString(), $string);
		
		// test single html tags <hr/>
		$string = 
"Hello world.<hr/>
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(100);
		$this->assertEqual($htmlString->asString(), $string);
		
		$string = 
"Hello world.<img src='' border='1' />
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(100);
		$this->assertEqual($htmlString->asString(), $string);
		
		// Test bad html tags.
		$string = 
"Hello world.<hr> <img src='' border='1'>
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.<hr/> <img src='' border='1'/>
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(100);
		$this->assertEqual($htmlString->asString(), $result);
		
		// test re-nesting
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong><em>fox</strong></em> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong><em>fox</em></strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString->trim(100);
		$this->assertEqual($htmlString->asString(), $string);
	}
	
	/**
	 * Test the creation methods.
	 */ 
	function test_trim_lengths() {
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello...";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(1);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world....";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(2);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello   \n \n\t \n\r  world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello   \n \n\t \n\r  world....";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(2);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(3);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(4);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(5);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong>...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(6);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(7);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(8);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(9);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy...</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(10);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(11);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(12);
		$this->assertEqual($htmlString->asString(), $result);
		
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(13);
		$this->assertEqual($htmlString->asString(), $result);
	}
	
	/**
	 * Test Elipses
	 */
	function test_elipses () {
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world....";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(2);
		$this->assertEqual($htmlString->asString(), $result);
		
		$string = 
"Hello world.
<p style='font-size: large;'>The quick brown <strong>fox</strong> 
jumped over the lazy <em>dog</em>.</p>";
		$result = 
"Hello world.";
		$htmlString =& HtmlString::withValue($string);
		$htmlString->trim(2, false);
		$this->assertEqual($htmlString->asString(), $result);
	}
}
?>