<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontVariantSC represents CSS "font-variant" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>
 * 		<li> small-caps </li>
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
 * @version $Id: FontVariantSC.class.php,v 1.4 2005/01/19 21:09:33 adamfranco Exp $
 */
class FontVariantSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontVariantSC($value) {
		$options = array("normal","small-caps");

		$errDescription = "Could not validate the font-variant StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Variant";
		$description = "Specifies the font variant. This property allows one to
						create text composed of capital letters. Allowed values 
						are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>