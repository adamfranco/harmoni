<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The BorderStyleSC represents CSS border-style values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> none </li>
 * 		<li> dotted </li>
 * 		<li> dashed </li>
 * 		<li> solid </li>
 * 		<li> groove </li>
 * 		<li> ridge </li>
 * 		<li> inset </li>
 * 		<li> outset </li>
 * 		<li> double </li>
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
 * @version $Id: BorderStyleSC.class.php,v 1.4 2005/01/19 21:09:32 adamfranco Exp $
 */
class BorderStyleSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function BorderStyleSC($value) {
		$options = array("none", "dotted", "dashed", 
					     "solid", "groove", "ridge", 
						 "inset", "outset", "double");
	
		$errDescription = "Could not validate the border-style StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Border Style";
		$description = "Specifies the border style. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>