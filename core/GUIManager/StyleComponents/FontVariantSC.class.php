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
 * @version $Id: FontVariantSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class FontVariantSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontVariantSC($value=null) {
		$options = array("normal","small-caps");

		$errDescription = "Could not validate the font-variant StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Variant";
		$description = "Specifies the font variant. This property allows one to
						create text composed of capital letters. Allowed values 
						are: ".implode(", ", $options).".";
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		$this->StyleComponent($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>