<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The TextSpacingSC represents CSS "word-spacing" and "letter-spacing" values. 
 * The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>	
 * 		<li> [specific length value] - a length value (i.e. units are %, px, in, etc.
 * 			 but % CANNOT be used for this type!) </li>
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
 * @version $Id: TextSpacingSC.class.php,v 1.5 2005/01/19 21:09:33 adamfranco Exp $
 */
class TextSpacingSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextSpacingSC($value) {
		$options = array("normal");

		$errDescription = "Could not validate the text-spacing StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific distance value (in length units, i.e. px,
						   in, etc. but NOT %).";
		
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "Text Spacing";
		$description = "Affects the text spacing between words. Allowed values are: ".implode(", ", $options)."
  					    or a specific distance value (in length units, i.e. px,
						in, etc. but NOT %).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>