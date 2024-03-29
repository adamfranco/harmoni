<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
//require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The DisplaySC represents CSS "display" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> inline </li>
 * 		<li> block </li>	
 * 		<li> list-item </li>	
 * <br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 *
 * @package  harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DisplaySC.class.php,v 1.7 2006/08/15 20:44:58 sporktim Exp $
 */
class DisplaySC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value) {
		$options = array("none","inline","block","list-item");

		$errDescription = "Could not validate the display StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Display";
		$description = "Specifies the display value to use. Allowed values are: ".implode(", ", $options).".";
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>