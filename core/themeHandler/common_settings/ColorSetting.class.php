<?php

require_once(HARMONI."/themeHandler/ThemeSetting.abstract.php");

/**
 * A simple color setting that takes RGB Hexadecimal colors.
 *
 * @package harmoni.themes.included_settings
 * @version $Id: ColorSetting.class.php,v 1.3 2004/08/26 15:10:36 adamfranco Exp $
 * @copyright 2004 
 **/

class ColorSetting
	extends ThemeSetting {
	

/******************************************************************************
 * Methods
 ******************************************************************************/

	/**
	 * Constructor.
	 */
 	function ColorSetting () { 		

		// Set the Display Name:
		$this->_displayName = "Color";
		
		// Set the Descripiton:
		$this->_description = "An RGB-hexadecimal color code. 
		Each digit in the color code can range from 0-F with two digits for Red, Green, and Blue respectively.
		Examples: Black=000000; White=FFFFFF; Pure-Red=FF0000; Pure-Green=00FF00; Pure-Blue=0000FF; Yellow=FFFF00; Rusty-Orange=FE5D00.";

		// Set the Default Value:
		$this->_defaultValue = "000000";
		$this->_value = "000000";

		// Set the options: Since this takes open values, no options are specified.
		$this->_options = array();
	}
	
	/**
	 * Sets the Value of this ThemeSetting.
	 * @access public
	 * @param string $value The new Value of the ThemeSetting. Throws an error if
	 *		an invalid $value is passed.
	 * @return void
	 **/
	function setValue($value) {
		ArgumentValidator::validate($value, new StringValidatorRule);
		
		if(!(ereg("^[0-9a-fA-F]{3}$", $value) || ereg("^[0-9a-fA-F]{6}$", $value)))
			throwError(new Error("Invalid RGB-Hexadecimal color value, '".$value."'.","ColorSetting", FALSE));
		
		$this->_value = $value;
	}
	
	/**
	 * Sets the DefaultValue of this ThemeSetting.
	 * @access public
	 * @param string $defaultValue The DefaultValue of this ThemeSetting.
	 * @return void
	 **/
	function &setDefaultValue ($defaultValue) {
		ArgumentValidator::validate($defaultValue, new StringValidatorRule);
		
		if(!(ereg("^[0-9a-fA-F]{3}$", $defaultValue) || ereg("^[0-9a-fA-F]{6}$", $defaultValue)))
			throwError(new Error("Invalid RGB-Hexadecimal color value, '".$defaultValue."'.","ColorSetting", FALSE));
		
		$this->_defaultValue = $defaultValue;
	}
}

?>