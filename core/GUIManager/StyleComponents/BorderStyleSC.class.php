<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The BorderStyleSC represents CSS border-style values. The allowed values are:
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
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: BorderStyleSC.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BorderStyleSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function BorderStyleSC($value) {
		$options = array("none", "dotted", "dashed", 
					     "solid", "groove", "ridge", 
						 "inset", "outset", "double");
	
		$errDescription = "Could not validate the border-style StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Border Style";
		$description = "Specifies the border style. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>