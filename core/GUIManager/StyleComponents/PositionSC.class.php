<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The PositionSC represents CSS "position" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> static </li>	
 * 		<li> relative </li>	
 * 		<li> absolute </li>	
 * 		<li> fixed </li>	
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
 * @version $Id: PositionSC.class.php,v 1.1 2004/07/15 21:29:29 tjigmes Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class PositionSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function PositionSC($value) {
		$options = array("static","relative","absolute","fixed");

		$errDescription = "Could not validate the position StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
				
		$displayName = "Position";
		$description = "Specifies the display to use. Allowed values are: "
						.implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>