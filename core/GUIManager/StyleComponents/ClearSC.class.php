<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The ClearSC represents CSS clear values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> left </li>
 * 		<li> right </li>
 * 		<li> both </li>
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
 * @version $Id: ClearSC.class.php,v 1.6 2005/01/20 17:47:31 nstamato Exp $
 */
class ClearSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function ClearSC($value) {
		$options = array("none", "left", "right", "both");
	
		$errDescription = "Could not validate the clear StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Clear";
		$description = "Specifies the clear value. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>