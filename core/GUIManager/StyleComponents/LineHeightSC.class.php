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
 * <br><br>
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
 * @version $Id: LineHeightSC.class.php,v 1.1 2004/07/14 20:54:27 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

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