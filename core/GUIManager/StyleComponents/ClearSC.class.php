<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The ClearSC represents CSS clear values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> left </li>
 * 		<li> right </li>
 * 		<li> both </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: ClearSC.class.php,v 1.4 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class ClearSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function ClearSC($value) {
		$options = array("none", "left", "right", "both");
	
		$errDescription = "Could not validate the clear StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Clear";
		$description = "Specifies the clear value. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>