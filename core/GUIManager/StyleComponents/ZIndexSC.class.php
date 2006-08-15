<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/IntegerValidatorRule.class.php");

/**
 * The ZIndexSC represents CSS z-index values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> auto </li>
 * 		<li> [specific z-index value] - an integer value</li>
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
 * @version $Id: ZIndexSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class ZIndexSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function ZIndexSC($value) {
		$options = array("auto");
	
		$errDescription = "Could not validate the z-index StyleComponent value \"%s\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options)." or a 
							specific integer value.";
		
		$rule=& RegexValidatorRule::getRule("^(auto|-?[0-9]+)$");
		
		$displayName = "Z-Index";
		$description = "Specifies the z-index. Allowed values are: ".implode(", ", $options).".
						or a specific integer value.";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
		
}


?>