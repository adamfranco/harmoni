<?php

require_once(HARMONI."languageLocalizer/LanguageLocalizer.interface.php");

/**
 * The LanguageLocalizer is a class that handles the organization or strings
 * and other data for multiple languages.
 *
 * @package harmoni.languages
 * @version $Id: LanguageLocalizer.class.php,v 1.4 2003/08/07 22:09:04 gabeschine Exp $
 * @copyright 2003 
 **/
class LanguageLocalizer extends LanguageLocalizerInterface {
	/**
	 * @access private
	 * @var string $_lang The current language.
	 **/
	var $_lang;
	
	/**
	 * @access private
	 * @var string $_langDir The directory in which all the languages reside.
	 **/
	var $_langDir;
	
	/**
	 * @access private
	 * @var array $_strings A hash table of strings for this language.
	 **/
	var $_strings;
	
	/**
	 * The constructor.
	 * @param string $langDir The directory in which language files reside.
	 * @access public
	 * @return void
	 **/
	function LanguageLocalizer($langDir) {
		$this->_langDir = $langDir;
	}
	
	/**
	 * Sets the language to use for getting data to $language.
	 * @param string $language The language code (eg, "en") to use.
	 * @access public
	 * @return void
	 **/
	function setLanguage($language) {
		$folder = $this->_langDir . DIRECTORY_SEPARATOR . $language;
		
		if (!file_exists($folder)) {
			throwError(new Error("LanguageLocalizer::setLanguage($language) - could not find language files in '$folder'!","LanguageLocalizer",true));
			return false;
		}
		
		$this->_lang = $language;
	}
	
	/**
	 * Returns a string in the language set with setLanguage() of "id" $stringName.
	 * @param string $stringName The corresponding string name in the language strings file.
	 * @access public
	 * @return string The string corresponding to $stringName in the specified language.
	 **/
	function getString($stringName) {
		$this->_readStrings();
		if (!defined($this->_strings[$stringName]))
			throwError(new Error("The string key '$stringName' is being used but has not yet been defined!","LanguageLocalizer",true));
		return $this->_strings[$stringName];
	}
	
	/**
	 * Reads all the strings from the strings file into memory.
	 * @access private
	 * @return void
	 **/
	function _readStrings() {
		if (is_array($this->_strings)) return;
		
		$this->_strings = array();
		
		$file = $this->_langDir . DIRECTORY_SEPARATOR . $this->_lang . DIRECTORY_SEPARATOR . "strings.$this->_lang.txt";
		if (!file_exists($file)) {
			throwError(new Error("LanguageLocalizer::getString() - could not find strings file '$file'!","LanguageLocalizer",true));
			return false;
		}
		
		$contents = file($file);
		foreach ($contents as $line) {
			// ignore comments
			if (ereg("^[:blank:]*#.*$",$line)) continue;
			
			// ignore blank lines
			if (ereg("^[:blank:]*$",$line)) continue;
			
			ereg("([^:]+):(.*)",$line,$regs);
			$key = trim($regs[1]);
			$data = trim($regs[2]);
			$this->_strings[$key] = $data;
		}
	}
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
		// do nothing
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
		// do nothing
	}
}

?>