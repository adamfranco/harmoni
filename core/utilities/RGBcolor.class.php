<?php

//require_once(HARMONI."utilities/RGBcolor.interface.php");

/**
 * A class designed to manipulate colors using the RGB color scheme.
 *
 * @version $Id: RGBcolor.class.php,v 1.3 2004/08/10 16:29:27 gabeschine Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class RGBColor {
	var $_red,$_green,$_blue;

 	/**
	 * Constructor. Create a new color.
	 * @param integer $red The value of the red component of the color.
	 * @param integer $green The value of the green component of the color.
	 * @param integer $blue The value of the blue component of the color.
	 * @access public
	 */	
	function RGBColor($red,$green,$blue) { 
		$this->_red = $red;
		$this->_green = $green;
		$this->_blue = $blue;
		$this->_checkColors();
	}

	/**
	 * Makes sure all the colors are within the range 0 - 255
	 * @access public
	 * @return void 
	 **/
	function _checkColors() {
		$this->_red = $this->_withinRange($this->_red);
		$this->_green = $this->_withinRange($this->_green);
		$this->_blue = $this->_withinRange($this->_blue);
	}
	
	/**
	 * Makes sure $val is within the range $min -> $max
	 * @param integer $val
	 * @param integer $min
	 * @param integer $max
	 * @access private
	 * @return void 
	 **/
	function _withinRange($val, $min=0, $max=255) {
		if ($val < $min) return $min;
		if ($val > $max) return $max;
		return $val;
	}	
	
 	/**
	 * Get the red component of the color.
	 * @return integer The value of the red component of the color
	 * @access public
	 */	
	function getRed() { 
		return $this->_red;
	}

 	/**
	 * Get the green component of the color.
	 * @return integer The value of the green component of the color
	 * @access public
	 */	
	function getGreen() { 
		return $this->_green;
	}


 	/**
	 * Get the blue component of the color.
	 * @return integer The value of the blue component of the color
	 * @access public
	 */	
	function getBlue() { 
		return $this->_blue;
	}

 	/**
	 * get all three components of the color.
	 * @return array The components of the color (0=>red 1=>green 2=>blue)
	 * @access public
	 */	
	function getRGB() { 
		return array($this->_red,$this->_green,$this->_blue);
	}

 	/**
	 * set the red component of the color.
	 * @param integer $value The value to set the red component to (0-255).
	 * @access public
	 */	
	function setRed($value) { 
		$this->_red = $value;
		$this->_checkColors();
	}

 	/**
	 * set the green component of the color.
	 * @param integer $value The value to set the green component to (0-255).
	 * @access public
	 */	
	function setGreen($value) { 
		$this->_green = $value;
		$this->_checkColors();
	}

 	/**
	 * set the blue component of the color.
	 * @param integer $value The value to set the blue component to (0-255).
	 * @access public
	 */	
	function setBlue($value) { 
		$this->_blue = $value;
		$this->_checkColors();
	}

 	/**
	 * set all three components of the color.
	 * @param integer $red The value to set the red component to (0-255).
	 * @param integer $green The value to set the green component to (0-255).
	 * @param integer $blue The value to set the red component to (0-255).
	 * @access public
	 */	
	function setRGB($red,$green,$blue) {
		$this->RGBColor($red,$green,$blue);
	}

 	/**
	 * Darken the color by a certain amount (0-100)
	 * @param float $percent The amount to darken the color by (0 keeps the color unchanged, 
	 * 50 divides all color components by 2, 100 makes the color black.
	 * @access public
	 */	
	function darken($percent) { 
		$percent = $this->_withinRange($percent, 0, 100);
		$factor = $percent / 100.0 + 1.0;
		$this->_green = 256 - (256 - $this->_green)*$factor;
		$this->_blue = 256 - (256 - $this->_blue)*$factor;
		$this->_red = 256 - (256 - $this->_red)*$factor;
		$this->_checkColors();
	}

 	/**
	 * Lighten the color by a certain amount (0-100)
	 * @param float $percent The amount to lighten the color by (0 keeps the color unchanged, 
	 * 50 multiplies all color components by 2, 100 makes the color white.
	 * @access public
	 */	
	function lighten($percent) {
		$percent = $this->_withinRange($percent, 0, 100);
		$factor = (100 - $percent) / 100.0;
		$this->_green = 255 - (255 - $this->_green)*$factor;
		$this->_blue = 255 - (255 - $this->_blue)*$factor;
		$this->_red = 255 - (255 - $this->_red)*$factor;
		$this->_checkColors();
	}

	/**
	 * Invert the color.
	 * @access public
	 * @return void 
	 **/
	function invert() {
		$this->_green = (255 - $this->_green);
		$this->_blue = (255 - $this->_blue);
		$this->_red = (255 - $this->_red);
	}
	
 	/**
	 * Shift the red component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftRed($amount) {
		$this->_red += $amount;
		$this->_checkColors();
	}

 	/**
	 * Shift the green component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the green component by. 
	 * @access public
	 */	
	function shiftGreen($amount) {
		$this->_green += $amount;
		$this->_checkColors();		
	}

 	/**
	 * Shift the red component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftBlue($amount) {
		$this->_blue += $amount;
		$this->_checkColors();
	}
	
	function &clone() {
		return new RGBColor($this->getRed(), $this->getGreen(), $this->getBlue());
	}
}


?>
