<?php

/**
 * ThemeSetting interface defines what methods are required of any theme widget.
 * 
 * A ThemeSetting is a manager and container for a display option for a theme or
 * theme widget. The ThemeSetting class is used to get and set the values for each
 * setting.
 *
 * @package harmoni.themes
 * @version $Id: ThemeSetting.interface.php,v 1.2 2004/03/04 00:01:10 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeSettingInterface {

	/**
	 * Returns the ID of this ThemeSetting.
	 * @access public
	 * @return object Id The ID of this ThemeSetting.
	 **/
	function & getId () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Returns the DisplayName of this ThemeSetting.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the Description of this ThemeSetting.
	 * @access public
	 * @return string The Description of the ThemeSetting.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Returns the Value of this ThemeSetting.
	 * @access public
	 * @return string The Value of the ThemeSetting.
	 **/
	function getValue() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets the Value of this ThemeSetting.
	 * @access public
	 * @param string $value The new Value of the ThemeSetting. Throws an error if
	 *		an invalid $value is passed.
	 * @return void
	 **/
	function setValue($value) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the DefaultValue of this ThemeSetting.
	 * @access public
	 * @return string The DefaultValue of the ThemeSetting.
	 **/
	function getDefaultValue() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the FormType of this ThemeSetting.
	 * @access public
	 * @return boolean True if the ThemeSetting has a list of options. FALSE if 
	 *		the setting can take any value.
	 **/
	function hasOptions() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the Options of this ThemeSetting.
	 * @access public
	 * @return array The Options for the ThemeSetting.
	 **/
	function getOptions() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>