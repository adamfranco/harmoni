<?php

require_once(HARMONI."GUIManager/StyleSelector.interface.php");

/**
 * This is a generic <code>StyleSelector</code> implementation allowing one to
 * create an arbitrary selector. The syntax is not validated and thus 
 * <code>canBeApplied()</code> returns <code>false</code>.
 * <br><br>
 * A <code>StyleSelector</code> is an object that enables the user to create and 
 * possibly parse CSS selectors.
 *  
 * For more information on CSS selectors, visit the following webpages:<br>
 * <a href = "http://www.blooberry.com/indexdot/css/index10.htm">Index DOT Css</a><br>
 * <a href = "http://www.w3.org/TR/CSS21/selector.html">CSS 2.1 Specification, Chapter 5: Selectors</a><br>
 * <br><br> A <code>StyleSelector</code> is a mandatory component of <code>StyleCollections</code>. 
 * For (an extreme) example, consider the style collection represented by the CSS code:
 * <pre>
 * div.col1 > *#temp + td.hi#bye {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * The string '<code>div.col1 > *#temp + td.hi#bye</code>' is the CSS selector.
 *
 * @package harmoni.gui.extensions
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleSelector.class.php,v 1.2 2005/01/19 21:09:37 adamfranco Exp $
 */
class StyleSelector extends StyleSelectorInterface {

	/**
	 * This is the value of this <code>StyleSelector</code>.
	 * @attribute private string _value
	 */
	var $_value;
	
	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the selector.
	 **/
	function StyleSelector($value) {
		$this->_value = $value;
	}
	
	/**
	 * Returns the CSS code corresponding to this <code>StyleSelector</code>.
	 * @access public
	 * @return string The CSS code corresponding to this <code>StyleSelector</code>.
	 **/
	function getCSS() {
		return $this->_value;
	}
	
	/**
	 * Determines whether the implementation of this <code>StyleSelector</code>
	 * allows <code>StyleCollections</code> to be applied to <code>Components</code>.
	 * @access public
	 * @param 
	 * @return 
	 **/
	function canBeApplied() {
		return false;
	}

}

?>