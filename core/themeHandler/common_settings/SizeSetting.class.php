<?php

require_once(HARMONI."/themeHandler/ThemeSetting.abstract.php");

/**
 * A simple size setting that takes a positive integer size.
 *
 * @package harmoni.themes.included_settings
 * @version $Id: SizeSetting.class.php,v 1.2 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SizeSetting
	extends ThemeSetting {
	

/******************************************************************************
 * Methods
 ******************************************************************************/

	/**
	 * Constructor.
	 */
 	function SizeSetting () { 		

		// Set the Display Name:
		$this->_displayName = "Size";
		
		// Set the Descripiton:
		$this->_description = "Size in either pixels or percent";

		// Set the Default Value:
		$this->_defaultValue = "100%";
		$this->_value = "100%";

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
		
		if(!(ereg("^[0-9]+px$", $value) || ereg("^[0-9]+%$", $value)))
			throwError(new Error("Invalid size value, '".$value."'.","SizeSetting", FALSE));
		
		$this->_value = $value;
	}
	
	/**
	 * Sets the DefaultValue of this ThemeSetting.
	 * @access public
	 * @param string $defaultValue The DefaultValue of this ThemeSetting.
	 * @return void
	 **/
	function & setDefaultValue ($defaultValue) {
		ArgumentValidator::validate($defaultValue, new StringValidatorRule);
		
		if(!(ereg("^[0-9]+px$", $defaultValue) || ereg("^[0-9]+%$", $defaultValue)))
			throwError(new Error("Invalid size value, '".$defaultValue."'.","SizeSetting", FALSE));
		
		$this->_defaultValue = $defaultValue;
	}
}

?>