<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The TextTransformSC represents CSS text-transform values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> capitalize </li>
 * 		<li> uppercase </li>
 * 		<li> lowercase </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: TextTransformSC.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class TextTransformSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextTransformSC($value) {
		$options = array("none", "capitalize", "uppercase", "lowercase");
	
		$errDescription = "Could not validate the text-transform StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Text Transform";
		$description = "Specifies the text transformation. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>