<?php

require_once(HARMONI."languageLocalizer/LanguageLocalizer.interface.php");

/**
 * The LanguageLocalizer is a class that handles the organization or strings
 * and other data for multiple languages.
 *
 * @package harmoni.languages
 * @version $Id: LanguageLocalizer.class.php,v 1.1 2003/07/22 22:05:47 gabeschine Exp $
 * @copyright 2003 
 **/
class LanguageLocalizerInterface {
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
			ereg("^([[:alnum:]_-]+):(.+)$",$line,$regs);
			$key = $regs[0];
			$data = $regs[1];
			$this->_strings[$key] = $data;
		}
	}
	
}

?>