<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The DirectionSC represents CSS direction values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> ltr </li>
 * 		<li> rtl </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: DirectionSC.class.php,v 1.4 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DirectionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function DirectionSC($value) {
		$options = array("ltr","rtl");
	
		$errDescription = "Could not validate the direction StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Direction";
		$description = "Specifies the text direction (left-to-right or right-to-left).
						Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>