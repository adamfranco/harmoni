<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The FontSizeSC represents CSS "font-size" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> xx-small </li>
 * 		<li> x-small </li>
 * 		<li> small </li>
 * 		<li> medium </li>
 * 		<li> large </li>
 * 		<li> x-large </li>
 * 		<li> xx-large </li>
 * 		<li> smaller </li>
 * 		<li> larger </li>
 * 		<li> [specific font size value] - a length value (i.e. units are %, px, in, etc.) </li>
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
 * @version $Id: FontSizeSC.class.php,v 1.10 2007/09/04 20:25:22 adamfranco Exp $
 */
class FontSizeSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value=null) {
		$options = array("xx-small","x-small","small","medium",
					     "large","x-large","xx-large","smaller","larger");

		$errDescription = "Could not validate the font-size StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific font-size value (in length units, i.e. px,
						   in, %, etc).";
		
		
		$rule = CSSLengthValidatorRuleWithOptions::getRule($options);
		
		$displayName = "Font Size";
		$description = "Specifies the font size to use. Allowed values are: ".implode(", ", $options)."
  					    or a specific font-size value (in length units, i.e. px,
						in, %, etc).";
		
		parent::__construct($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>