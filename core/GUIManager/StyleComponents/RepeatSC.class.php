<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The RepeatSC represents CSS "repeat" value. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> repeat </li>
 * 		<li> repeat-x </li>
 * 		<li> repeat-y </li>
 * 		<li> no-repeat </li>
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
 * @version $Id: RepeatSC.class.php,v 1.3 2005/01/19 21:09:33 adamfranco Exp $
 */
class RepeatSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function RepeatSC($value) {
		$options = array("repeat","repeat-x","repeat-y","no-repeat");

		$errDescription = "Could not validate the Repeat StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Repeat";
		$description = "Specifies the values for CSS property 'repeat'. Allowed values are: 
						".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>