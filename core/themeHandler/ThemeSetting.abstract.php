<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/ThemeSetting.interface.php");

/**
 * The abstract ThemeSetting class provides some fleshed out methods for easier
 * implimentation of ThemeSettings.
 * The constructor will need to be implimented for any classes that extend this 
 * abstract class. As well, the setValue() method should check for valid inputs.
 *
 * @package harmoni.themes
 * @version $Id: ThemeSetting.abstract.php,v 1.2 2004/03/05 21:40:05 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeSetting
	extends ThemeSettingInterface {
	
	/**
	 * @access private
	 * @var object $_id The Id of this this ThemeSetting.
	 **/
	var $_id;
	
	/**
	 * @access private
	 * @var string $_displayName The Display Name of this this ThemeSetting.
	 **/
	var $_displayName;
	
	/**
	 * @access private
	 * @var string $_description The description of this this ThemeSetting.
	 **/
	var $_description;
	
	/**
	 * @access private
	 * @var string $_defaultValue The default value of this this ThemeSetting.
	 **/
	var $_defaultValue;
	
	/**
	 * @access private
	 * @var string $_value The current value of this this ThemeSetting.
	 **/
	var $_value;
	
	/**
	 * @access private
	 * @var array $_options An array of the options for this ThemeSetting.
	 **/
	var $_options;
	


/******************************************************************************
 * Methods
 ******************************************************************************/

	/**
	 * Constructor, throws an error since this is an abstract class.
	 * The constructor will need to be implimented for any classes that extend this 
 	 * abstract class. As well, the setValue() method should check for valid inputs.
	 */
 	function ThemeSetting () {
 		die ("Can not instantiate abstract class <b> ".__CLASS__."</b>. Extend with a non-abstract child class and instantiate that instead."); 
 		
// 		// Sample Constructor (for a "Color" ThemeSetting)
// 
// 		// Set the Display Name:
// 		$this->_displayName = "Color";
// 		
// 		// Set the Descripiton:
// 		$this->_description = "An RGB-hexadecimal color code. 
// 		Each digit in the color code can range from 0-F with two digits for Red, Green, and Blue respectively.
// 		Examples: Black=000000; White=FFFFFF; Pure-Red=FF0000; Pure-Green=00FF00; Pure-Blue=0000FF; Yellow=FFFF00; Rusty-Orange=FE5D00.";
// 
// 		// Set the Default Value:
// 		$this->_defaultValue = "000000";
// 		$this->_value = "000000";
// 
// 		// Set the options: Since this takes open values, no options are specified.
// 		$this->_options = array();
	}

	/**
	 * Returns the ID of this ThemeSetting.
	 * @access public
	 * @return object Id The ID of this ThemeSetting.
	 **/
	function & getId () {
		if (!$this->_id)
			throwError(new Error("This setting has not been given an Id yet.","ThemeSetting", TRUE));
		
		return $this->_id;
	}
	
	/**
	 * Sets the ID of this ThemeSetting.
	 * @access public
	 * @param object Id $id The ID of this ThemeSetting.
	 * @return void
	 **/
	function & setId (& $id) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		$this->_id =& $id;
	}

	/**
	 * Returns the DisplayName of this ThemeSetting.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Sets the DisplayName of this ThemeSetting.
	 * @access public
	 * @param string $displayName The DisplayName of this ThemeSetting.
	 * @return void
	 **/
	function & setDisplayName ( $displayName ) {
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		
		$this->_displayName = $displayName;
	}
	
	/**
	 * Returns the Description of this ThemeSetting.
	 * @access public
	 * @return string The Description of the ThemeSetting.
	 **/
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Sets the Description of this ThemeSetting.
	 * @access public
	 * @param string $description The Description of this ThemeSetting.
	 * @return void
	 **/
	function & setDescription ( $description ) {
		ArgumentValidator::validate($description, new StringValidatorRule);
		
		$this->_description = $description;
	}

	/**
	 * Returns the Value of this ThemeSetting.
	 * @access public
	 * @return string The Value of the ThemeSetting.
	 **/
	function getValue() {
		return $this->_value;
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
		
		// This method is an outline only, please overload it to do proper checking
		// of inputs to the setting.
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
		
		$this->_value = $value;
	}
	
	/**
	 * Returns the DefaultValue of this ThemeSetting.
	 * @access public
	 * @return string The DefaultValue of the ThemeSetting.
	 **/
	function getDefaultValue() {
		return $this->_defaultValue;
	}
	
	/**
	 * Sets the DefaultValue of this ThemeSetting.
	 * @access public
	 * @param string $defaultValue The DefaultValue of this ThemeSetting.
	 * @return void
	 **/
	function & setDefaultValue (& $defaultValue) {
		ArgumentValidator::validate($defaultValue, new StringValidatorRule);
		
		// This method is an outline only, please overload it to do proper checking
		// of inputs to the setting.
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
		
		$this->_defaultValue = $defaultValue;
	}
	
	/**
	 * Returns the FormType of this ThemeSetting.
	 * @access public
	 * @return boolean True if the ThemeSetting has a list of options. FALSE if 
	 *		the setting can take any value.
	 **/
	function hasOptions() {
		if (!is_array($this->_options) || !count($this->_options))
			return FALSE;
		else
			return TRUE;
	}
	
	/**
	 * Returns the Options of this ThemeSetting.
	 * @access public
	 * @return object HarmoniIterator An iterator of the Option strings for the ThemeSetting.
	 **/
	function & getOptions() {
		if (!is_array($this->_options))
			$this->_options = array();
		
		return new HarmoniIterator($this->_options);
	}
}

?>