<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontFamilySC represents CSS "font-family" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> serif </li>
 * 		<li> sans-serif </li>
 * 		<li> cursive </li>
 * 		<li> fantasy </li>
 * 		<li> monospace </li>
 * 		<li> [specific-font-family] - for example: Arial, "Courier New" (if there is white space
 *                                    in the name of the font, then it must be quoted)</li>
 * </ul>
 * <br /><br />
 * One or more values (comma separated) are allowed. Example: you can set the 
 * value to "Arial" or "Courier, 'Courier New', monospace".
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
 * @version $Id: FontFamilySC.class.php,v 1.4 2005/01/19 21:09:33 adamfranco Exp $
 */
class FontFamilySC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontFamilySC($value) {
		$options = array("serif","sans-serif","cursive","fantasy","monospace");

		$errDescription = "Could not validate the font-family StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific font-family name (names with white space must be quoted).
						   Also, you can specify one or many comma-separated values.";
		
		
		$rule =& new CSSFontFamilyValidatorRule();
		
		$displayName = "Font Family";
		$description = "Specifies the font to use. Allowed values are: ".implode(", ", $options)."
					    or a specific font-family name (names with white space must be quoted).
						Also, you can specify one or many comma-separated values.";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}

class CSSFontFamilyValidatorRule extends ValidatorRuleInterface {

	function check(& $val) {
		$regs = array();
		$fonts = explode(",", $val);
		
		foreach ($fonts as $font)
			// no quotes, no white space
			if (ereg("^ *([a-z|A-Z])+ *$", $font))
				continue;
			// single quotes with optional white space
			else if (ereg("^ *'([a-z|A-Z] *)+' *$", $font))
				continue;
			// double quotes with optional white space
			else if (ereg("^ *\"([a-z|A-Z] *)+\" *$", $font))
				continue;
			else
				return false;

		return true;
	}
}
?>