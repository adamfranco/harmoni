<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The FontVariantSC represents CSS "font-variant" values. The allowed
 * values are: 
 * <ul style="font-family: monospace;">
 * 		<li> normal </li>
 * 		<li> small-caps </li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 * @version $Id: FontVariantSC.class.php,v 1.3 2005/01/03 20:50:31 adamfranco Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FontVariantSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function FontVariantSC($value) {
		$options = array("normal","small-caps");

		$errDescription = "Could not validate the font-variant StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		
		$displayName = "Font Variant";
		$description = "Specifies the font variant. This property allows one to
						create text composed of capital letters. Allowed values 
						are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>