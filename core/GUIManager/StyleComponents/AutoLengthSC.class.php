<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The AutoLengthSC represents CSS "top", "left", "right", "bottom",
 * "width", and "height" values. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> auto </li>
 * 		<li> [specific length] - a length value (%, px, in, etc.) </li>
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
 * @version $Id: AutoLengthSC.class.php,v 1.7 2005/01/20 17:47:31 nstamato Exp $
 */
class AutoLengthSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function AutoLengthSC($value) {
		$options = array("auto");

		$errDescription = "Could not validate the AutoLength StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).", or a specific 
						   value (a length value, i.e. px, in, %, etc.).";
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "AutoLength";
		$description = "Specifies the values for CSS properties 'top', 'left', 'right',
						'bottom', 'width', and 'height'. Allowed values are: 
						".implode(", ", $options).", or a specific value 
						(a length value, i.e. px, in, %, etc.).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>