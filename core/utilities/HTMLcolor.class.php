<?php

require_once(HARMONI."utilities/RGBcolor.class.php");

/**
 * The HTMLcolor class is used to manipulate 6 or 3-digix hexadecimal HTML colors.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HTMLcolor.class.php,v 1.4 2005/04/12 18:48:10 adamfranco Exp $
 */
class HTMLcolor extends RGBcolor {
	/**
	 * The constructor.
	 * @param string $color The HTML color.
	 * @access public
	 * @return void 
	 **/
	function HTMLcolor($color) {
		$color = ereg_replace("^\#","",$color);
		if (strlen($color) == 3)
			$color = $color[0].$color[0].
					 $color[1].$color[1].
					 $color[2].$color[2];
		
		if (strlen($color) != 6) throwError(new Error("HTMLcolor - can not create class for color '$color': it is not a valid HTML color.","HTMLcolor",false));
		// convert each part into its decimal equivaleng.
		$rgb = explode(" ",chunk_split($color,2," "));
		
		$this->_red = (integer)hexdec($rgb[0]);
		$this->_green = (integer)hexdec($rgb[1]);
		$this->_blue = (integer)hexdec($rgb[2]);
	}
	
	/**
	 * Returns a six-digit HTML color.
	 * @access public
	 * @return string The color in hex.
	 **/
	function getHTMLcolor() {
		$color = sprintf("#%02X%02X%02X",$this->_red, $this->_green, $this->_blue);
		return $color;
	}
	
	function &replicate() {
		return new HTMLColor($this->getHTMLColor());
	}
}

?>