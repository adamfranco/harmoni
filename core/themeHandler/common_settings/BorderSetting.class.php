<?php

require_once(HARMONI."/themeHandler/ThemeSetting.abstract.php");

/**
 * A simple border setting that takes a positive integer border.
 *
 * @package harmoni.themes
 * @version $Id: BorderSetting.class.php,v 1.3 2004/03/11 16:57:33 adamfranco Exp $
 * @copyright 2004 
 **/

class BorderSetting
	extends ThemeSetting {
	

/******************************************************************************
 * Methods
 ******************************************************************************/

	/**
	 * Constructor.
	 */
 	function BorderSetting () { 		

		// Set the Display Name:
		$this->_displayName = "Border";
		
		// Set the Descripiton:
		$this->_description = "Border can be solid, dotted, or dashed.";

		// Set the Default Value:
		$this->_defaultValue = "solid";
		$this->_value = "solid";

		// Set the options: Since this takes open values, no options are specified.
		$this->_options = array("solid", "dotted", "dashed");
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
		
		if(!in_array($value, $this->_options))
			throwError(new Error("Invalid border value, '".$value."'.","BorderSetting", FALSE));
		
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
		
		if($defaultValue != "solid" && $defaultValue != "dotted" && $defaultValue != "dashed")
			throwError(new Error("Invalid border value, '".$defaultValue."'.","BorderSetting", FALSE));
		
		$this->_defaultValue = $defaultValue;
	}
}

?>