<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The TextAlignSC represents CSS text-align values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> left </li>
 * 		<li> right </li>
 * 		<li> center </li>
 * 		<li> justify </li>
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
 * @version $Id: TextAlignSC.class.php,v 1.6 2005/01/20 17:47:32 nstamato Exp $
 */
class TextAlignSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextAlignSC($value) {
		$options = array("left", "right", "center", "justify");
	
		$errDescription = "Could not validate the text-align StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Text Alignment";
		$description = "Specifies the text alignment. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>