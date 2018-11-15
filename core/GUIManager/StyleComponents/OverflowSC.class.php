<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The OverflowSC represents CSS overflow values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> visible </li>
 * 		<li> hidden </li>
 * 		<li> scroll </li>
 * 		<li> auto </li>
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
 * @version $Id: OverflowSC.class.php,v 1.7 2006/08/15 20:44:58 sporktim Exp $
 */
class OverflowSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value) {
		$options = array("visible", "hidden", "scroll", "auto");
	
		$errDescription = "Could not validate the overflow StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Overflow";
		$description = "Specifies the overflow property value. Allowed values are: ".implode(", ", $options).".";
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>