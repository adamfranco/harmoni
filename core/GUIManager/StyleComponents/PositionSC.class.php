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
 *
 * @package  harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PositionSC.class.php,v 1.7 2005/02/07 21:38:15 adamfranco Exp $
 */
class PositionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function PositionSC($value) {
		$options = array("static","relative","absolute","fixed");

		$errDescription = "Could not validate the position StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
				
		$displayName = "Position";
		$description = "Specifies the position property value. Allowed values are: "
						.implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>