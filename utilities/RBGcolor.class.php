<?php

/**
 * A class designed to manipulate colors using the RGB color scheme.
 *
 * @version $Id: RBGcolor.class.php,v 1.1 2003/07/18 02:28:22 movsjani Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class RGBColor extends RGBColorInterface {

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
	 * Darken the color by a certain ammount (0-100)
	 * @param float $percent The ammount to darken the color by (0 keeps the color unchanged, 
	 * 50 divides all color components by 2, 100 makes the color black.
	 * @access public
	 */	
	function darken($percent) { 
		

	}

 	/**
	 * Lighten the color by a certain ammount (0-100)
	 * @param float $percent The ammount to lighten the color by (0 keeps the color unchanged, 
	 * 50 multiplies all color components by 2, 100 makes the color white.
	 * @access public
	 */	
	function lighten($percent) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Shift the red component by a certain ammount.
	 * @param integer $ammount The ammount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftRed($ammount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Shift the green component by a certain ammount.
	 * @param integer $ammount The ammount to shift (add to or substract from) the green component by. 
	 * @access public
	 */	
	function shiftGreen($ammount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Shift the red component by a certain ammount.
	 * @param integer $ammount The ammount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftBlue($ammount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}


?>
