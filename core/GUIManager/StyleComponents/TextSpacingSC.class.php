<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The TextSpacingSC represents CSS "word-spacing" and "letter-spacing" values. 
 * The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>	
 * 		<li> [specific length value] - a length value (i.e. units are %, px, in, etc.
 * 			 but % CANNOT be used for this type!) </li>
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
 * @version $Id: TextSpacingSC.class.php,v 1.1 2004/07/15 21:29:29 tjigmes Exp $
 * @package 
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class TextSpacingSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function TextSpacingSC($value) {
		$options = array("normal");

		$errDescription = "Could not validate the TextSpacing StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options)."
  					       or a specific distance value (in length units, i.e. px,
						   in, etc. but NOT %).";
		
		
		$rule =& new CSSLengthValidatorRule();
		
		$displayName = "TextSpacingSC";
		$description = "Specifies the length to use. Allowed values are: ".implode(", ", $options)."
  					    or a specific distance value (in length units, i.e. px,
						in, etc. but NOT %).";
		
		$this->StyleComponent($value, $rule, $options, false, $errDescription, $displayName, $description);
	}
}
?>