<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The TextTransformSC represents CSS text-transform values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> capitalize </li>
 * 		<li> uppercase </li>
 * 		<li> lowercase </li>
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
 * @version $Id: TextTransformSC.class.php,v 1.6 2005/02/07 21:38:15 adamfranco Exp $
 */
class TextTransformSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextTransformSC($value) {
		$options = array("none", "capitalize", "uppercase", "lowercase");
	
		$errDescription = "Could not validate the text-transform StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Text Transform";
		$description = "Specifies the text transformation. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>