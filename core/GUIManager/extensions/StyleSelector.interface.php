<?php

/**
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
 * @version $Id: StyleSelector.interface.php,v 1.1 2005/01/10 06:17:01 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StyleSelectorInterface {

	/**
	 * Returns the CSS code corresponding to this <code>StyleSelector</code>.
	 * @access public
	 * @return string The CSS code corresponding to this <code>StyleSelector</code>.
	 **/
	function getCSS() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Determines whether the implementation of this <code>StyleSelector</code>
	 * allows <code>StyleCollections</code> to be applied to <code>Components</code>.
	 * @access public
	 * @param 
	 * @return 
	 **/
	function canBeApplied() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>