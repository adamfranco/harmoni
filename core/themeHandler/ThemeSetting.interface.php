<?php

/**
 * ThemeSetting interface defines what methods are required of any theme widget.
 * 
 * A ThemeSetting is a manager and container for a display option for a theme or
 * theme widget. The ThemeSetting class is used to get and set the values for each
 * setting.
 *
 * @package harmoni.themes
 * @version $Id: ThemeSetting.interface.php,v 1.4 2004/03/05 21:40:06 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeSettingInterface {

	/**
	 * Returns the ID of this ThemeSetting.
	 * @access public
	 * @return object Id The ID of this ThemeSetting.
	 **/
	function & getId () {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the ID of this ThemeSetting.
	 * @access public
	 * @param object Id $id The ID of this ThemeSetting.
	 * @return void
	 **/
	function & setId (& $id) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}

	/**
	 * Returns the DisplayName of this ThemeSetting.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the DisplayName of this ThemeSetting.
	 * @access public
	 * @param string $displayName The DisplayName of this ThemeSetting.
	 * @return void
	 **/
	function & setDisplayName ( $displayName ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the Description of this ThemeSetting.
	 * @access public
	 * @return string The Description of the ThemeSetting.
	 **/
	function getDescription() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the Description of this ThemeSetting.
	 * @access public
	 * @param string $description The Description of this ThemeSetting.
	 * @return void
	 **/
	function & setDescription ( $description ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}

	/**
	 * Returns the Value of this ThemeSetting.
	 * @access public
	 * @return string The Value of the ThemeSetting.
	 **/
	function getValue() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the Value of this ThemeSetting.
	 * @access public
	 * @param string $value The new Value of the ThemeSetting. Throws an error if
	 *		an invalid $value is passed.
	 * @return void
	 **/
	function setValue($value) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the DefaultValue of this ThemeSetting.
	 * @access public
	 * @return string The DefaultValue of the ThemeSetting.
	 **/
	function getDefaultValue() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the DefaultValue of this ThemeSetting.
	 * @access public
	 * @param string $defaultValue The DefaultValue of this ThemeSetting.
	 * @return void
	 **/
	function & setDefaultValue ( $defaultValue ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the FormType of this ThemeSetting.
	 * @access public
	 * @return boolean True if the ThemeSetting has a list of options. FALSE if 
	 *		the setting can take any value.
	 **/
	function hasOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the Options of this ThemeSetting.
	 * @access public
	 * @return object HarmoniIterator An iterator of the Option strings for the ThemeSetting.
	 **/
	function & getOptions() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
}

?>