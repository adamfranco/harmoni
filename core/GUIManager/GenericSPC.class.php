<?php

require_once(HARMONI."GUIManager/StylePropertyComponent.interface.php");
require_once(HARMONI."oki/shared/HarmoniIterator.class.php");

/**
 * The <code>GenericSPC</code> is the base for all the other
 * <code>StylePropertyComponents</code>. It is up to the user to provide all the
 * necessary data (display name, description, the ValidatorRule, the value of the SPC, etc.)
 * 
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
 * @version $Id: GenericSPC.class.php,v 1.1 2004/07/09 06:06:37 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class GenericSPC extends StylePropertyComponentInterface {

	/**
	 * The display name of this SPC.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	/**
	 * The description of this SPC.
	 * @attribute private string _description
	 */
	var $_description;
	
	/**
	 * This is the ValidatorRule of this SPC.
	 * @attribute private object _rule
	 */
	var $_rule;
	
	/**
	 * The description of the Error that will be thrown whenever validation fails.
	 * @attribute private object _error
	 */
	var $_errorDescription;
	
	/**
	 * An array of strings that will store the list of options (may or may not be
	 * set in the constructor)
	 * @attribute private array _options
	 */
	var $_options;
	
	/**
	 * The constructor.
	 * @param string value The value to assign to this SPC.
	 * @@param ref mixed This is one of the following two: 1) The ValidatorRule
	 * that will be used to validate the values of this SPC, or 2) An array of strings
	 * that represents the allowed values (i.e. the list of options) of this SPC. Pass the
	 * array whenever you want hasOptions() and getOptions to function accordingly.
	 * @param ref object error This is the Error to throw when validation fails.
	 * @param string displayName The display name of the SPC.
	 * @param string description The description of the SPC.
	 * @access public
	 **/
	function GenericSPC($value, $ruleOrOptions, $errorDescription, $displayName, $description) {
		// figure out whether $ruleOrOptions is an array or a ValidatorRule object
		if (is_array($ruleOrOptions)) {
			// if array, create the appropriate ChoiceValidatorRule with the given options
			// the SPC will have a list of options
			$this->_options = $ruleOrOptions;
			$this->_rule =& new ChoiceValidatorRule($this->_options);
		}
		else
			// if not, then just set the rule
			// note that in this case this SPC has no list of options
			$this->_rule = $ruleOrOptions;
			
		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_errorDescription = $errorDescription;
		
		// validate the value
		if (isset($this->_rule) && !$this->_rule->check($value))
			throwError(new Error($this->_errorDescription, "GUIManager", false));
			
		$this->_value = $value;
	}
		

	/**
	 * Returns the display name of this SPC.
	 * @access public
	 * @return string The display name of this SPC.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the description of this StlyeProperty.
	 * @access public
	 * @return string The description of this StlyeProperty.
	 **/
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Get the value of this SPC.
	 * @access public
	 * @return string The value of this SPC.
	 **/
	function getValue() {
		return $this->_value;
	}
	
	/**
	 * Sets the value of this SPC and validates it using the attached <code>ValidatorRule</code>.
	 * @access public
	 * @param string value The new value.
	 **/
	function setValue($value) {
		// validate the value
		if (isset($this->_rule) && !$this->_rule->check($value))
			throwError(new Error($this->_errorDescription, "GUIManager", false));
			
		$this->_value = $value;
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
		return is_array($this->_options);
	}
	
	/**
	 * Returns the list of options (list of allowed values) of this SPC.
	 * @access public
	 * @return ref object An iterator containing the list of options 
	 * (list of allowed values) of this SPC.
	 **/
	function & getOptions() {
		return new HarmoniIterator($this->_options);
	}	
	
}
?>