<?php

require_once(HARMONI."GUIManager/GenericSP.class.php");

/**
 * The ColorSP represents the 'color' StyleProperty.
 * 
 * A StyleProperty stores information about a single CSS style property. For example,
 * the object could represent a <code>background-color</code> property and its
 * value (an HTML color in this case).
 * @version $Id: ColorSP.class.php,v 1.1 2004/07/09 06:06:38 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class ColorSP extends GenericSP {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function ColorSP($value) {
		$this->GenericSP("color", "Color", "This property specifies the foreground color.");
		$this->addSPC(new ColorSPC($value));
	}

}

?>