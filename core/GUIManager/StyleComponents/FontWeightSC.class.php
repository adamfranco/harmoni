<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontWeightSC represents CSS "font-weight" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> 100 </li>
 * 		<li> 200 </li>
 * 		<li> 300 </li>
 * 		<li> 400 </li>
 * 		<li> 500 </li>
 * 		<li> 600 </li>
 * 		<li> 700 </li>
 * 		<li> 800 </li>
 * 		<li> 900 </li>
 * 		<li> normal </li>
 * 		<li> bold </li>
 * 		<li> lighter </li>
 * 		<li> bolder </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: FontWeightSC.class.php,v 1.3 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FontWeightSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontWeightSC($value) {
		$options = array("100", "200", "300", "400", "500", 
		                 "600", "700", "800", "900", "normal", 
						 "bold", "lighter", "bolder");

		$errDescription = "Could not validate the font-weight StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Weight";
		$description = "Specifies the font weight (thickness). Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>