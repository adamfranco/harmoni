<?php

require_once(HARMONI."GUIManager/GenericSPC.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * The ColorSPC represents CSS border-style values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> dotted </li>
 * 		<li> dashed </li>
 * 		<li> solid </li>
 * 		<li> groove </li>
 * 		<li> ridge </li>
 * 		<li> inset </li>
 * 		<li> outset </li>
 * 		<li> double </li>
 * </u>
 * <br><br>
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
 * @version $Id: BorderStyleSPC.class.php,v 1.1 2004/07/09 06:06:38 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BorderStyleSPC extends GenericSPC {

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
	function BorderStyleSPC($value) {
		$options = array("none", "dotted", "dashed", 
					     "solid", "groove", "ridge", 
						 "inset", "outset", "double");
	
		$errDescription = "Could not validate the StylePropertyComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Color";
		$description = "Specifies the border style. Allowed values are: ".implode(", ", $options).".";
		
		$this->GenericSPC($value, $options, $errDescription, $displayName, $description);
	}
}
?>