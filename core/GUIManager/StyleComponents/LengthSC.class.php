<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The LengthSC represents CSS relative and absolute length values. The allowed
 * formats are: 
 * <ul style="font-family: monospace;">
 * 		<li> Percentage      - "12%" </li>
 * 		<li> Ems             - "12em" </li>
 * 		<li> X-Height        - "25ex" </li>
 * 		<li> Pixels          - "120px" </li>
 * 		<li> Inches          - "2.3in" </li>
 * 		<li> Centimeters     - "23cm" </li>
 * 		<li> Millimeters     - "1232mm" </li>
 * 		<li> Points          - "22pt" </li>
 * 		<li> Picas           - "54pc" </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: LengthSC.class.php,v 1.4 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class LengthSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function LengthSC($value) {
		$errDescription = "Could not validate the length StyleComponent value \"$value\". ";
		$errDescription .= "Allowed untis are: %, in, cm, mm, em, ex, pt, pc, px.";
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "Length";
		$description = "Specifies the length (width, size, etc) in percentages (%),
		inches (in), centimeters (cm), millimeters (mm), ems (em), X-height (ex),
		points (pt), picas (pc), or	pixels (px).";
		
		$this->StyleComponent($value, $rule, null, null, $errDescription, $displayName, $description);
	}
}

class CSSLengthValidatorRule extends ValidatorRuleInterface {

	function check(& $val) {
		return ereg("^-?[0-9]+(\.[0-9]+)?(%|in|cm|mm|em|ex|pt|pc|px)$", $val);
	}
}
?>