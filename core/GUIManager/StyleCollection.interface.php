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
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StyleCollection.interface.php,v 1.7 2005/02/07 21:38:13 adamfranco Exp $
 **/

class StyleCollectionInterface {

	/**
	 * Returns the CSS code for this StyleCollection.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The CSS code for this StyleCollection.
	 **/
	function getCSS($tabs = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the class selector of this style collection. A class selector is the string
	 * that would be included in the 'class' attribute of HTML tags. One can use
	 * this method in order to apply the style collection to an arbitrary component.
	 * @access public
	 * @return string The class name of this style collection.
	 **/
	function getClassSelector() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Determines whether this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 * @access public
	 * @return boolean <code>TRUE</code> if this <code>StyleCollection</code> can be applied to <code>Components</code>.
	 **/
	function canBeApplied() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the selector of this StyleCollection.
	 * @access public
	 * @return string The selector of this StyleCollection.
	 **/
	function getSelector() {
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
	 * @param ref object sc A StyleProperty object.
	 * @return ref object The style property that was just added.
	 **/
	function &addSP(& $sp) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the StyleProperties of this StyleCollection in a suitable
	 * for CSS generation order.
	 * @access public
	 * @return array An array of the StyleProperties of this StyleCollection.
	 **/
	function getSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Remove the given StyleProperty from this Style Collection.
	 * @access public
	 * @param ref object The style property to remove.
	 * @return ref object The style property that was removed. <code>NULL</code>
	 * if it could not be found.
	 **/
	function &removeSP(& $sp) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}

?>