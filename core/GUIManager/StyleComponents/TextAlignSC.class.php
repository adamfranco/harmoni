<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The TextAlignSC represents CSS text-align values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> left </li>
 * 		<li> right </li>
 * 		<li> center </li>
 * 		<li> justify </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: TextAlignSC.class.php,v 1.4 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class TextAlignSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextAlignSC($value) {
		$options = array("left", "right", "center", "justify");
	
		$errDescription = "Could not validate the text-align StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Text Alignment";
		$description = "Specifies the text alignment. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>