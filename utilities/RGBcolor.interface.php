<?php

/**
 * A class designed to manipulate colors using the RGB color scheme.
 *
 * @version $Id: RGBcolor.interface.php,v 1.1 2003/07/20 14:17:17 gabeschine Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class RGBColorInterface {

 	/**
	 * Get the red component of the color.
	 * @return integer The value of the red component of the color
	 * @access public
	 */	
	function getRed() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Get the green component of the color.
	 * @return integer The value of the green component of the color
	 * @access public
	 */	
	function getGreen() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Get the blue component of the color.
	 * @return integer The value of the blue component of the color
	 * @access public
	 */	
	function getBlue() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * get all three components of the color.
	 * @return array The components of the color (0=>red 1=>green 2=>blue)
	 * @access public
	 */	
	function getRGB() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * set the red component of the color.
	 * @param integer $value The value to set the red component to (0-255).
	 * @access public
	 */	
	function setRed($value) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * set the green component of the color.
	 * @param integer $value The value to set the green component to (0-255).
	 * @access public
	 */	
	function setGreen($value) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * set the blue component of the color.
	 * @param integer $value The value to set the blue component to (0-255).
	 * @access public
	 */	
	function setBlue($value) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * set all three components of the color.
	 * @param integer $red The value to set the red component to (0-255).
	 * @param integer $green The value to set the green component to (0-255).
	 * @param integer $blue The value to set the red component to (0-255).
	 * @access public
	 */	
	function setRGB($red,$green,$blue) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Darken the color by a certain amount (0-100)
	 * @param float $percent The amount to darken the color by (0 keeps the color unchanged, 
	 * 50 divides all color components by 2, 100 makes the color black.
	 * @access public
	 */	
	function darken($percent) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Lighten the color by a certain amount (0-100)
	 * @param float $percent The amount to lighten the color by (0 keeps the color unchanged, 
	 * 50 multiplies all color components by 2, 100 makes the color white.
	 * @access public
	 */	
	function lighten($percent) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Inverts the color.
	 * @access public
	 * @return void 
	 **/
	function invert() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
 	/**
	 * Shift the red component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftRed($amount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Shift the green component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the green component by. 
	 * @access public
	 */	
	function shiftGreen($amount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

 	/**
	 * Shift the red component by a certain amount.
	 * @param integer $amount The amount to shift (add to or substract from) the red component by. 
	 * @access public
	 */	
	function shiftBlue($amount) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}


?>
