<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
//require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The DisplaySC represents CSS "display" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> inline </li>
 * 		<li> block </li>	
 * 		<li> list-item </li>	
 * <br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: DisplaySC.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DisplaySC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function DisplaySC($value) {
		$options = array("none","inline","block","list-item");

		$errDescription = "Could not validate the display StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Display";
		$description = "Specifies the display value to use. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>