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
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * The other two CSS styles building pieces are <code>StyleProperties</code> and
 * <code>StyleCollections</code>. To clarify the relationship between these three
 * building pieces, consider the following example:
 * <pre>
 * div {
 *     margin: 20px;
 *     border: 1px solid #000;
 * }
 * </pre>
 * <code>div</code> is a <code>StyleCollection</code> consisting of 2 
 * <code>StyleProperties</code>: <code>margin</code> and <code>border</code>. Each
 * of the latter consists of one or more <code>StyleComponents</code>. In
 * specific, <code>margin</code> consists of one <code>StyleComponent</code>
 * with the value <code>20px</code>, and <code>border</code> has three 
 * <code>StyleComponents</code> with values <code>1px</code>, <code>solid</code>,
 * and <code>#000</code> correspondingly.
 * 
 * @version $Id: CursorSC.class.php,v 1.1 2004/07/15 21:29:29 tjigmes Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class CursorSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function CursorSC($value) {
		$options = array("auto","n-resize","ne-resize","e-resize","se-resize",
		                 "s-resize","sw-resize","w-resize","nw-resize","crosshair",
					     "pointer","move","text","wait","help","hand");

		$errDescription = "Could not validate the cursor StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Cursor";
		$description = "Specifies the cursor type to use when the pointing device is over
					    the element . Allowed values are: ".implode(", ", $options).".";
  					    		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>