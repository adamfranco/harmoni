<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The TextSpacingSC represents CSS "word-spacing" and "letter-spacing" values. 
 * The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>	
 * 		<li> [specific length value] - a length value (i.e. units are %, px, in, etc.
 * 			 but % CANNOT be used for this type!) </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 *
 * @package  harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TextSpacingSC.class.php,v 1.9 2006/08/15 20:44:58 sporktim Exp $
 */
class TextSpacingSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextSpacingSC($value) {
		$options = array("normal");

		$errDescription = "Could not validate the text-spacing StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific distance value (in length units, i.e. px,
						   in, etc. but NOT %).";
		
		
		$rule =& CSSLengthValidatorRule::getRule();
		
		$displayName = "Text Spacing";
		$description = "Affects the text spacing between words. Allowed values are: ".implode(", ", $options)."
  					    or a specific distance value (in length units, i.e. px,
						in, etc. but NOT %).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}



class CSSTextSpacingValidatorRule extends ValidatorRuleInterface {

	
	var $_regex;
	
	function CSSColorValidatorRule(){

		$this->_regex="^(normal|-?[0-9]+(\.[0-9]+)?(in|cm|mm|em|ex|pt|pc|px))$";
	}
	
	//@todo not tested
	
	
	/**
	 * Returns a block of javascript code defining a function like so:
	 * 
	 * function(element) {
	 * 		return el.value.match(/\w+/);
	 * }
	 * @access public
	 * @return string
	 */
	function generateJavaScript () {
		$re = addslashes($this->_regex);
		return "function(el) {\n" .
				"var re = new RegExp(\"$re\");\n" .
				"return el.value.match(re);\n" .
				"}";
	}
		
	/**
	 * Returns true if the passed value validates against this rule.
	 * @param string $val
	 * @access public
	 * @return boolean
	 */
	function check($val) {
		if (preg_match("/".$this->_regex."/", $val)) return true;
		return false;
	}
	
	

	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern
	 * 
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule () {
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] =& new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}

?>