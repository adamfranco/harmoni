<?php

require_once(HARMONI."GUIManager/GenericSP.class.php");

/**
 * The BorderSP represents the 'border' StyleProperty.
 * 
 * A StyleProperty stores information about a single CSS style property. For example,
 * the object could represent a <code>background-color</code> property and its
 * value (an HTML color in this case).
 * @version $Id: BorderSP.class.php,v 1.1 2004/07/09 06:06:38 dobomode Exp $
 * @package harmoni.gui
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BorderSP extends GenericSP {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BorderSP($width, $style, $color) {
		$this->GenericSP("border", "Border", "This property specifies all four borders at once.");
		$this->addSPC(new LengthSPC($width));
		$this->addSPC(new BorderStyleSPC($style));
		$this->addSPC(new ColorSPC($color));
	}

}

?>