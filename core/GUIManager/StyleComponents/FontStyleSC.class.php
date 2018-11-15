<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontStyleSC represents CSS "font-style" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>
 * 		<li> italic </li>
 * 		<li> oblique </li>
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
 * @version $Id: FontStyleSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class FontStyleSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value=null) {
		$options = array("normal","italic","oblique");

		$errDescription = "Could not validate the font-style StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Style";
		$description = "Specifies the font style. Allowed values are: ".implode(", ", $options).".";
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>