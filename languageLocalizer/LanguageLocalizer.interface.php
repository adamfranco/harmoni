<?php

/**
 * The LanguageLocalizer interface defines what methods are required of any
 * language localizer class.
 * 
 * The LanguageLocalizer is a class that handles the organization or strings
 * and other data for multiple languages.
 *
 * @package harmoni.interfaces.languages
 * @version $Id: LanguageLocalizer.interface.php,v 1.4 2003/08/11 03:12:46 gabeschine Exp $
 * @copyright 2003 
 **/
class LanguageLocalizerInterface extends ServiceInterface {
	/**
	 * Sets the language to use for getting data to $language.
	 * @param string $language The language code (eg, "en") to use.
	 * @access public
	 * @return void
	 **/
	function setLanguage($language) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a string in the language set with setLanguage() of "id" $stringName.
	 * @param string $stringName The corresponding string name in the language strings file.
	 * @access public
	 * @deprecated 8/8/2003 - localization functionality now handled by gettext()
	 * @return string The string corresponding to $stringName in the specified language.
	 **/
	function getString($stringName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>