<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The BackgroundRepeatSC represents CSS background-repeat values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> repeat </li>
 * 		<li> repeat-x </li>
 * 		<li> repeat-y </li>
 * 		<li> no-repeat </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: BackgroundRepeatSC.class.php,v 1.1 2004/08/09 02:58:36 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BackgroundRepeatSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function BackgroundRepeatSC($value) {
		$options = array("repeat", "repeat-x", "repeat-y", "no-repeat");
	
		$errDescription = "Could not validate the background-repeat StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Background Repeat";
		$description = "Specifies the background-repeat value. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>