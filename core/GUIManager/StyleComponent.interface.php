<?php

/**
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
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
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: StyleComponent.interface.php,v 1.3 2004/07/19 23:59:50 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StyleComponentInterface {

	/**
	 * Returns the display name of this SC.
	 * @access public
	 * @return string The display name of this SC.
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
	 * Get the value of this SC.
	 * @access public
	 * @return string The value of this SC.
	 **/
	function getValue() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the value of this SC and validates it using the attached <code>ValidatorRule</code>.
	 * @access public
	 * @param string value The new value.
	 **/
	function setValue($value) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Determines whether this SC has a list of options. If there is a list of 
	 * options, then the ValidatorRule of this SC would be a ChoiceValidatorRule. 
	 * If not, the ValidatorRule could be any ValidatorRule.
	 * @access public
	 * @return boolean True if the SC has a list of options. FALSE if 
	 * the SC can take any value.
	 **/
	function hasOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * This function will return <code>TRUE</code> if the value of this SC is
	 * restricted only to the list of options. It will return <code>FALSE</code>,
	 * if not.
	 * @access public
	 * @return boolean <code>TRUE</code> if the value of this SC is
	 * restricted only to the list of options. <code>FALSE</code>,
	 * if not.
	 **/
	function isLimitedToOptions() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Returns the list of options (list of allowed values) of this SC.
	 * @access public
	 * @return array An array containing the list of options 
	 * (list of allowed values) of this SC.
	 **/
	function getOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}	

}
?>