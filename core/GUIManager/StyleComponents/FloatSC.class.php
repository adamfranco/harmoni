<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FloatSC represents CSS float values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> left </li>
 * 		<li> right </li>
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
 * @version $Id: FloatSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class FloatSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value) {
		$options = array("none","left","right");
	
		$errDescription = "Could not validate the float StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Float";
		$description = "Specifies whether an element will float left, right, or not float at all. 
						Allowed values are: ".implode(", ", $options).".";
		
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>