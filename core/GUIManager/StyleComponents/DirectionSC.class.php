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
 *
 * @package  harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DirectionSC.class.php,v 1.7 2005/02/07 21:38:15 adamfranco Exp $
 */
class DirectionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function DirectionSC($value) {
		$options = array("ltr","rtl");
	
		$errDescription = "Could not validate the direction StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Direction";
		$description = "Specifies the text direction (left-to-right or right-to-left).
						Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>