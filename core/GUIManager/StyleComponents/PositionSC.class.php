<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The PositionSC represents CSS "position" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> static </li>	
 * 		<li> relative </li>	
 * 		<li> absolute </li>	
 * 		<li> fixed </li>	
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: PositionSC.class.php,v 1.4 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class PositionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function PositionSC($value) {
		$options = array("static","relative","absolute","fixed");

		$errDescription = "Could not validate the position StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
				
		$displayName = "Position";
		$description = "Specifies the position property value. Allowed values are: "
						.implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>