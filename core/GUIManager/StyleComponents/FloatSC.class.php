<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FloatSC represents CSS float values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> left </li>
 * 		<li> right </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: FloatSC.class.php,v 1.3 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FloatSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FloatSC($value) {
		$options = array("none","left","right");
	
		$errDescription = "Could not validate the float StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Float";
		$description = "Specifies whether an element will float left, right, or not float at all. 
						Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>