<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The CursorSC represents CSS "cursor" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> default </li>
 * 		<li> auto </li>
 * 		<li> n-resize </li>
 * 		<li> ne-resize </li>
 * 		<li> e-resize </li>
 *		<li> se-resize </li> 
 * 		<li> s-resize </li>
 * 		<li> sw-resize </li>
 * 		<li> w-resize </li>
 * 		<li> nw-resize </li>
 * 		<li> crosshair </li>
 * 		<li> pointer </li>
 * 		<li> move </li>
 * 		<li> text </li>
 * 		<li> wait </li>
 * 		<li> help </li>
 * 		<li> hand </li>
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
 * @version $Id: CursorSC.class.php,v 1.7 2006/08/15 20:44:58 sporktim Exp $
 */
class CursorSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function __construct($value) {
		$options = array("auto","n-resize","ne-resize","e-resize","se-resize",
		                 "s-resize","sw-resize","w-resize","nw-resize","crosshair",
					     "pointer","move","text","wait","help","hand");

		$errDescription = "Could not validate the cursor StyleComponent value \"%s\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Cursor";
		$description = "Specifies the cursor type to use when the pointing device is over
					    the element . Allowed values are: ".implode(", ", $options).".";
  					
		$rule = RegexValidatorRule::getRuleByArray($options);    		
		parent::__construct($value, $rule, $options, true, $errDescription, $displayName, $description);
	}
}
?>