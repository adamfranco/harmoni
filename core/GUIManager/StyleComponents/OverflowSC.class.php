<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The OverflowSC represents CSS overflow values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> visible </li>
 * 		<li> hidden </li>
 * 		<li> scroll </li>
 * 		<li> auto </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: OverflowSC.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class OverflowSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function OverflowSC($value) {
		$options = array("visible", "hidden", "scroll", "auto");
	
		$errDescription = "Could not validate the overflow StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Overflow";
		$description = "Specifies the overflow property value. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>