<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The VerticalAlignSC represents CSS vertical-align values. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> baseline </li>
 * 		<li> middle </li>
 *		<li> top </li>
 * 		<li> bottom </li>
 * 		<li> text-top </li>
 * 		<li> text-bottom </li>
 * 		<li> super </li>
 * 		<li> sub </li>
 * 		<li> [specific value] - a length value (%, px, in, etc.) </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: VerticalAlignSC.class.php,v 1.3 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class VerticalAlignSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function VerticalAlignSC($value) {
		$options = array("baseline","middle","top","bottom","text-top","text-bottom",
					"super","sub");

		$errDescription = "Could not validate the vertical-align StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).", or a specific 
						   value (a length value, i.e. px, in, %, etc.).";
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "Vertical Alignment";
		$description = "Specifies the vertical-align value. Allowed values are: 
						".implode(", ", $options).", or a distance value 
						(a length value, i.e. px, in, %, etc.).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>