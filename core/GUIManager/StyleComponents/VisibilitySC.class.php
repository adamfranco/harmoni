<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The VisibilitySC represents CSS visibility values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> visible </li>
 * 		<li> hidden </li>
 * 		<li> collapse </li>
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
 * @version $Id: VisibilitySC.class.php,v 1.6 2005/02/07 21:38:15 adamfranco Exp $
 */
class VisibilitySC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function VisibilitySC($value) {
		$options = array("visible", "hidden", "collapse");
	
		$errDescription = "Could not validate the visiblity StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Visibility";
		$description = "Specifies the visibility. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>