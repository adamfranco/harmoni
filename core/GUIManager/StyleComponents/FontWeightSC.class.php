<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontWeightSC represents CSS "font-weight" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> 100 </li>
 * 		<li> 200 </li>
 * 		<li> 300 </li>
 * 		<li> 400 </li>
 * 		<li> 500 </li>
 * 		<li> 600 </li>
 * 		<li> 700 </li>
 * 		<li> 800 </li>
 * 		<li> 900 </li>
 * 		<li> normal </li>
 * 		<li> bold </li>
 * 		<li> lighter </li>
 * 		<li> bolder </li>
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
 * @version $Id: FontWeightSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class FontWeightSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontWeightSC($value=null) {
		$options = array("100", "200", "300", "400", "500", 
		                 "600", "700", "800", "900", "normal", 
						 "bold", "lighter", "bolder");

		$errDescription = "Could not validate the font-weight StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Weight";
		$description = "Specifies the font weight (thickness). Allowed values are: ".implode(", ", $options).".";
		
		$rule = RegexValidatorRule::getRuleByArray($options);
		$this->StyleComponent($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>