<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The AlignmentPosition represents CSS relative and absolute position values, as well as certain alignments. The allowed
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
 * 		<li> or either: top/center/bottom </li>
 * 		<li> or either: left/center/right </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: AlignmentPositionSC.class.php,v 1.1 2004/08/17 02:22:34 gabeschine Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class AlignmentPositionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function AlignmentPositionSC($value, $options) {
		$errDescription = "Could not validate the length StyleComponent value \"$value\". ";
		$errDescription .= "Allowed units are: %, in, cm, mm, em, ex, pt, pc, px, or any of:";
		$errDescription .= " ".implode(", ", $options).".";
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "AlignmentPosition";
		$description = "Specifies the length (width, size, etc) in percentages (%),
		inches (in), centimeters (cm), millimeters (mm), ems (em), X-height (ex),
		points (pt), picas (pc), or	pixels (px) or an alignment: ".implode(", ",$options).".";
		
		$this->StyleComponent($value, $rule, $options, null, $errDescription, $displayName, $description);
	}
}

?>