<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The LineHeightSC represents CSS "line-height" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>
 * 		<li> [multiplier] -  a non-negative number</li>
 * 		<li> [specific line height] - a length value (%, px, in, etc.) </li>
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
 * @version $Id: LineHeightSC.class.php,v 1.4 2005/01/19 21:09:33 adamfranco Exp $
 */
class LineHeightSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function LineHeightSC($value) {
		$options = array("normal");

		$errDescription = "Could not validate the line-height StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).", a non-negative
						   multiplier, or a specific line-height value 
						   (a length value, i.e. px, in, %, etc.).";
		
		$rule =& new OrValidatorRule(new CSSLengthValidatorRule(), new NumericValidatorRule());
		
		$displayName = "Line Height";
		$description = "Specifies the line height. This property allows one to modify
						the distance between text lines. For example, you can use it to achieve the effect
						of a double-spaced text. Allowed values are: ".implode(", ", $options).", a non-negative
						multiplier (use 2 for double-spaced text), or a specific line-height value 
						(a length value, i.e. px, in, %, etc.).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>