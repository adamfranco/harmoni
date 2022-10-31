<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The RepeatSC represents CSS "repeat" value. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> repeat </li>
 * 		<li> repeat-x </li>
 * 		<li> repeat-y </li>
 * 		<li> no-repeat </li>
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
 * @version $Id: RepeatSC.class.php,v 1.5 2006/08/15 20:44:58 sporktim Exp $
 */
class RepeatSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value) {
		$options = array("repeat","repeat-x","repeat-y","no-repeat");

		$errDescription = "Could not validate the Repeat StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Repeat";
		$description = "Specifies the values for CSS property 'repeat'. Allowed values are: 
						".implode(", ", $options).".";
		$rule = RegexValidatorRule::getRuleByArray($options);
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>