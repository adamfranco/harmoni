<?php

require_once(HARMONI."languageLocalizer/LanguageLocalizer.interface.php");

/**
 * The LanguageLocalizer is a class that handles the organization or strings
 * and other data for multiple languages.
 *
 * @package harmoni.languages
 * @version $Id: LanguageLocalizer.class.php,v 1.4 2004/05/11 15:03:30 adamfranco Exp $
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
	 * @access private
	 * @var string $_application The "app" we are bound to.
	 **/
	var $_application;

	/**
	 * The constructor.
	 * @param string $langDir The directory in which language files reside.
	 * @param string $application The name of the application to use (for *.mo files)
	 * @access public
	 * @return void
	 * @todo -cLanguageLocalizer Implement LanguageLocalizer.constructor - use gettext functionality.
	 **/
	function LanguageLocalizer($langDir,$application) {
		if (!file_exists($folder = $langDir)) {
			throwError(new Error("LanguageLocalizer - could not find language folder '$langDir!","LanguageLocalizer",true));
			return false;
		}
				
		$this->_langDir = $langDir;
		$this->_application = $application;
		bindtextdomain($application, $langDir);
		
		// Get the current Language settings from the session if they exist.
		if (isset($_SESSION['__CurrentLanguage'])) {
			$this->setLanguage( $_SESSION['__CurrentLanguage'] );
			debug::output( "Setting Lang to ".$_SESSION['__CurrentLanguage']);
		} else {
			$this->setLanguage( "en_US" );
			debug::output( "Setting Lang to ".$_SESSION['__CurrentLanguage']);
		}
		
		// Get the current Language encoding from the session if it exists.
		if (isset($_SESSION['__CurrentLanguageCodeset'])) {
			$this->_codeset = $_SESSION['__CurrentLanguageCodeset'];
		} else {
			// Use UTF-8 by default.
			$this->_codeset = "UTF-8";
		}
		
		bind_textdomain_codeset ($application, $this->_codeset);
	}
	
	/**
	 * Sets the language to use for getting data to $language.
	 * @param string $language The language code (eg, "en_US") to use.
	 * @access public
	 * @return void
	 * @todo -cLanguageLocalizer Implement LanguageLocalizer.setLanguage - use gettext functionality.
	 **/
	function setLanguage($language) {
		if (!ereg("^[a-z]{2}_[A-Z]{2}",$language)) {
			throwError(new Error("LanguageLocalizer::setLanguage($language) - language must start with 'xx_XX' (where x/X is any letter). Example: 'en_US'.","LanguageLocalizer",true));
			return false;
		}
		
		$file = $this->_langDir . DIRECTORY_SEPARATOR
				. $language . DIRECTORY_SEPARATOR
				. "LC_MESSAGES" . DIRECTORY_SEPARATOR
				. $this->_application . ".mo";
		
		if (! file_exists($file) ) {
			throwError(new Error("LanguageLocalizer::setLanguage($language) - could not set language. The translation file '$file' does not exist!","LanguageLocalizer", true));
			return false;
		}
		
		$this->_lang = $language;
		$_SESSION['__CurrentLanguage'] = $this->_lang;
		setlocale(LC_MESSAGES, $language);
	}
	
	/**
	 * Return the code of the current language.
	 * @return string
	 */
	function getLanguage() {
		return $this->_lang;
	}
	
	/**
	 * Sets the codeset to use for charactor encoding. UTF-8 is used by default.
	 * @param string $codeset The codeset to use (eg, "UTF-8", "ISO-8859-8",
	 *		"SHIFT_JIS", etc).
	 * @return void
	 */
	function setCodeset($codeset) {
		$this->_codeset = $codeset;
		$_SESSION['__CurrentLanguageCodeset'] = $this->_codeset;
		bind_textdomain_codeset ($application, $codeset);
	}
	
	/**
	 * Return an array of availible languages. The keys are the language codes
	 * and the values are a UTF-8 encoded string representation of the language
	 * name (eg. "en_US" => "English - US", "es_ES" => "Espa–ol - Espa–a",
	 * "es_MX" => "Espa–ol - MŽxico")
	 * @param boolean $includeCountries Include the countries of the language
	 *		codes. Default is TRUE.
	 * @return array
	 */
	function getLanguages($includeCountries = TRUE) {
		if (!$_SESSION['__AvailibleLanguages']) {
			$langfile = HARMONI.'languageLocalizer/iso639-utf8.txt';
			$countryfile = HARMONI.'languageLocalizer/countries.txt';
			
			// Compile an array of all languages
			$languages = array();
			$inputArray = file($langfile);
			foreach ($inputArray as $line) {
				$line = rtrim($line);
				$parts = explode(';',$line);
				if ($parts[2])
					$languages[$parts[2]] = $parts[3];
			}
			
			// Compile an array of all countries
			if ($includeCountries) {
				$countries = array();
				$inputArray = file($countryfile);
				foreach ($inputArray as $line) {
					$line = rtrim($line);
					$parts = explode(';',$line);
					$countries[$parts[1]] = $parts[0];
				}
			}
			
			$_SESSION['__AvailibleLanguages'] = array();
			$handle = opendir($this->_langDir);
			while (($file = readdir($handle)) !== FALSE) {
				if (ereg("([a-z]{2})_([A-Z]{2})", $file, $parts)) {
					if ($includeCountries)
						$_SESSION['__AvailibleLanguages'][$file] = $languages[$parts[1]].
															" - ".$countries[$parts[2]];
					else
						$_SESSION['__AvailibleLanguages'][$file] = $languages[$parts[1]];
				}
			}
		}
		
		return $_SESSION['__AvailibleLanguages'];
	}
	
	/**
	 * Returns a string in the language set with setLanguage() of "id" $stringName.
	 * @param string $stringName The corresponding string name in the language strings file.
	 * @access public
	 * @deprecated 8/8/2003 - localization functionality now handled by gettext()
	 * @return string The string corresponding to $stringName in the specified language.
	 **/
	function getString($stringName) {
		throwError(new Error("LanguageLocalizer::getString($stringName) has been deprecated. Use the gettext function '_()' instead.","LanguageLocalizer",false));
	}
	
	/**
	 * Reads all the strings from the strings file into memory.
	 * @access private
	 * @deprecated 8/8/2003 - localization functionality now handled by gettext()
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