<?php

/**
 * The <code>StylePropertyComponent</code> (SPC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * The other two CSS styles building pieces are <code>StyleProperties</code> and
 * <code>StyleCollections</code>. To clarify the relationship between these three
 * building pieces, consider the following example:
 * <pre>
 * div {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>margin</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StylePropertyComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StylePropertyComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StylePropertyComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: StylePropertyComponent.interface.php,v 1.1 2004/07/09 06:06:37 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StylePropertyComponentInterface {

	/**
	 * Returns the display name of this SPC.
	 * @access public
	 * @return string The display name of this SPC.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the description of this StlyeProperty.
	 * @access public
	 * @return string The description of this StlyeProperty.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Get the value of this SPC.
	 * @access public
	 * @return string The value of this SPC.
	 **/
	function getValue() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the value of this SPC and validates it using the attached <code>ValidatorRule</code>.
	 * @access public
	 * @param string value The new value.
	 **/
	function setValue($value) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Determines whether this SPC has a list of options. If there is a list of 
	 * options, then the ValidatorRule of this SPC would be a ChoiceValidatorRule. 
	 * If not, the ValidatorRule could be any ValidatorRule.
	 * @access public
	 * @return boolean True if the SPC has a list of options. FALSE if 
	 * the SPC can take any value.
	 **/
	function hasOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the list of options (list of allowed values) of this SPC.
	 * @access public
	 * @return ref object An iterator containing the list of options 
	 * (list of allowed values) of this SPC.
	 **/
	function & getOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}	

}
?>