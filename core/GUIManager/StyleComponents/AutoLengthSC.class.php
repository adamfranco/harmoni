<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The AutoLengthSC represents CSS "top", "left", "right", "bottom",
 * "width", and "height" values. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> auto </li>
 * 		<li> [specific length] - a length value (%, px, in, etc.) </li>
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
 * @version $Id: AutoLengthSC.class.php,v 1.3 2004/07/16 04:17:22 dobomode Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class AutoLengthSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function AutoLengthSC($value) {
		$options = array("auto");

		$errDescription = "Could not validate the AutoLength StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).", or a specific 
						   value (a length value, i.e. px, in, %, etc.).";
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "AutoLength";
		$description = "Specifies the values for CSS properties 'top', 'left', 'right',
						'bottom', 'width', and 'height'. Allowed values are: 
						".implode(", ", $options).", or a specific value 
						(a length value, i.e. px, in, %, etc.).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>