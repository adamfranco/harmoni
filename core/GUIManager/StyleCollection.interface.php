<?php

/**
 * A StyleCollection is one of the tree building pieces of CSS styles. As the  name
 * suggests it handles a collection of StyleProperties.
 * 
 * The other two CSS styles building pieces are <code>StylePropertiy</code> and
 * <code>StyleComponent</code>. To clarify the relationship between these three
 * building pieces, consider the following example:
 * <pre>
 * div {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>margin</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: StyleCollection.interface.php,v 1.2 2004/07/16 04:17:14 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StyleCollectionInterface {

	/**
	 * Returns the CSS code for this StyleCollection.
	 * @access public
	 * @param integer indent An optional integer specifying how many tabs to indent
	 * the result string.
	 * @return string The CSS code for this StyleCollection.
	 **/
	function getCSS($indent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the name of this StyleCollection.
	 * @access public
	 * @return string The name of this StyleCollection.
	 **/
	function getName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the display name of this StyleCollection.
	 * @access public
	 * @return string The display name of this StyleCollection.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the description of this StyleCollection.
	 * @access public
	 * @return string The description of this StlyeProperty.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Adds one StyleProperty to this StyleCollection.
	 * @access public
	 * @param ref object A StyleComponent object.
	 **/
	function addSP(& $sc) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the StyleProperties of this StyleCollection in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return array An array of the StyleComponents of this StyleCollection.
	 **/
	function getSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}

?>