<?php

require_once(HARMONI."GUIManager/StyleComponent.interface.php");
require_once(HARMONI."oki/shared/HarmoniIterator.class.php");

/**
 * This <code>StyleComponent</code> generic class is the base for all the other
 * <code>StyleComponents</code>. It is up to the user to provide all the
 * necessary data (display name, description, the ValidatorRule, the value of the SC, etc.)
 * 
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
 * @version $Id: StyleComponent.class.php,v 1.1 2004/07/14 20:50:27 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class StyleComponent extends StyleComponentInterface {

	/**
	 * The display name of this SC.
	 * @attribute private string _displayName
	 */
	var $_displayName;
	
	/**
	 * The description of this SC.
	 * @attribute private string _description
	 */
	var $_description;
	
	/**
	 * This is the ValidatorRule of this SC.
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
	 * If TRUE, then the value of this SC will be restricted to the list of options.
	 * @attribute private boolean _limitedToOptions
	 */
	var $_limitedToOptions;
	
	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @param ref object rule The ValidatorRule that will be used to validate the 
	 * values of this SC. If <code>NULL</code>, no validator rule will be used.
	 * @param array options An array of strings that represents the allowed values 
	 * (i.e. the list of options) of this SC. If this argument is not null, hasOptions()
	 * will return <code>true</code> and getOptions() will return an iterator of
	 * the options. In addition, if <code>limitedToOptions</code> is set to <code>TRUE</code>,
	 * then a new ChoiceValidatorRule will be created with the given options. 
	 * If this argument is <code>null</code>, then hasOptions() will
	 * return <code>false</code>.
	 * @param mixed limitedToOptions This is either a boolean or null. If TRUE, 
	 * a new ChoiceValidatorRule will be created for the given list of options. 
	 * If <code>limitedToOptions</code> is not set, then the value of the argument is irrelevant.
	 * FALSE and <code>null</code> will result the same behavior but it is recommended
	 * that <code>FALSE</code> is used whenever <code>options</code> is set, and <code>null</code>
	 * if not.
	 * @param ref mixed This is one of the following two: 1) The ValidatorRule
	 * that will be used to validate the values of this SC, or 2) An array of strings
	 * that represents the allowed values (i.e. the list of options) of this SC. Pass the
	 * array whenever you want hasOptions() and getOptions to function accordingly.
	 * @param ref object error This is the Error to throw when validation fails.
	 * @param string displayName The display name of the SC.
	 * @param string description The description of the SC.
	 * @access public
	 **/
	function StyleComponent($value, $rule, $options, $limitedToOptions, $errorDescription, $displayName, $description) {
		if (isset($rule))
			$this->_rule = $rule;
		else
			$this->_rule =& new AlwaysTrueValidatorRule();

		$this->_displayName = $displayName;
		$this->_description = $description;
		$this->_errorDescription = $errorDescription;
		$this->_limitedToOptions = false;
		$this->_options = array();
		
		if (isset($options) && is_array($options)) {
			// the SC will have a list of options
			$this->_options = $options;
			if ($limitedToOptions) {
				// create the appropriate ChoiceValidatorRule with the given options
				$this->_limitedToOptions = true;
				$choiceRule =& new ChoiceValidatorRule($options);
				$this->_rule =& new AndValidatorRule($this->_rule, $choiceRule);
			}
			else
				$this->_rule =& new OrValidatorRule($this->_rule, new ChoiceValidatorRule($options));
		}

		// validate the value
		if (!$this->_rule->check($value))
			throwError(new Error($this->_errorDescription, "GUIManager", false));
			
		$this->_value = $value;
	}
		

	/**
	 * Returns the display name of this SC.
	 * @access public
	 * @return string The display name of this SC.
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
	 * Get the value of this SC.
	 * @access public
	 * @return string The value of this SC.
	 **/
	function getValue() {
		return $this->_value;
	}
	
	/**
	 * Sets the value of this SC and validates it using the attached <code>ValidatorRule</code>.
	 * @access public
	 * @param string value The new value.
	 **/
	function setValue($value) {
		// validate the value
		if (!$this->_rule->check($value))
			throwError(new Error($this->_errorDescription, "GUIManager", false));
			
		$this->_value = $value;
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
		return count($this->_options) > 0;
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
		return $this->_limitedToOptions;
	}
	
	
	/**
	 * Returns the list of options (list of allowed values) of this SC.
	 * @access public
	 * @return ref object An iterator containing the list of options 
	 * (list of allowed values) of this SC.
	 **/
	function & getOptions() {
		return new HarmoniIterator($this->_options);
	}	
	
}
?>