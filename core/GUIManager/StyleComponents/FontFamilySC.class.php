<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontFamilySC represents CSS "font-family" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> serif </li>
 * 		<li> sans-serif </li>
 * 		<li> cursive </li>
 * 		<li> fantasy </li>
 * 		<li> monospace </li>
 * 		<li> [specific-font-family] - for example: Arial, "Courier New" (if there is white space
 *                                    in the name of the font, then it must be quoted)</li>
 * </ul>
 * <br /><br />
 * One or more values (comma separated) are allowed. Example: you can set the 
 * value to "Arial" or "Courier, 'Courier New', monospace".
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
 * @version $Id: FontFamilySC.class.php,v 1.13 2007/10/22 18:05:27 adamfranco Exp $
 */
class FontFamilySC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontFamilySC($value=null) {
		$options = array("serif","sans-serif","cursive","fantasy","monospace");

		$errDescription = "Could not validate the font-family StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific font-family name (names with white space must be quoted).
						   Also, you can specify one or many comma-separated values.";
		
		
		$rule = CSSFontFamilyValidatorRule::getRule();
		
		$displayName = "Font Family";
		$description = "Specifies the font to use. Allowed values are: ".implode(", ", $options)."
					    or a specific font-family name (names with white space must be quoted).
						Also, you can specify one or many comma-separated values.";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}



class CSSFontFamilyValidatorRule extends RegexValidatorRule {
	//@todo not tested
	
	
	function CSSFontFamilyValidatorRule(){
		
		$singleQuote = "'[- A-Za-z0-9]+'";
		$doubleQuote = "\"[- A-Za-z0-9]+\"";
		$noQuote = "[-A-Za-z0-9]+";
		
		$fontName = "(".$singleQuote."|".$doubleQuote."|".$noQuote.")";
		
		
		$re = "^(serif|sans-serif|cursive|fantasy|monospace|".$fontName."(, *".$fontName.")?)$";
		
		$this->_regex=$re;
	}
	
	
	
	/*
	function check($val) {
		$regs = array();
		$fonts = explode(",", $val);
		
		foreach ($fonts as $font)
			// no quotes, no white space
			if (ereg("^ *([a-z|A-Z])+ *$", $font))
				continue;
			// single quotes with optional white space
			else if (ereg("^ *'([a-z|A-Z] *)+' *$", $font))
				continue;
			// double quotes with optional white space
			else if (ereg("^ *\"([a-z|A-Z] *)+\" *$", $font))
				continue;
			else
				return false;

		return true;
	}
	*/
	
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
	static function getRule ($regex) {
		if ($regex)
			throw new HarmoniException("Passing of a custom string to this rule is not allowed.");
		
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] = new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

	
	

?>