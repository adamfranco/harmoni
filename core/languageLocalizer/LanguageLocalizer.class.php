<?php

/**
 * The LanguageLocalizer is a class that handles the organization or strings
 * and other data for multiple languages.
 *
 * @package harmoni.languages
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LanguageLocalizer.class.php,v 1.26 2008/04/03 03:12:00 adamfranco Exp $
 */
class LanguageLocalizer {
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
	 * @param optional string $langDir The directory in which language files reside.
	 * @param optional string $application The name of the application to use (for *.mo files)
	 * @param optional string $defaultLanguage The default language to use.
	 * @access public
	 * @return void
	 * @todo -cLanguageLocalizer Implement LanguageLocalizer.constructor - use gettext functionality.
	 **/
	function __construct() {
	
		// Get the current Language encoding from the session if it exists.
		if (isset($_SESSION['__CurrentLanguageCodeset'])) {
			$this->_codeset = $_SESSION['__CurrentLanguageCodeset'];
		} else {
			// Use UTF-8 by default.
			$this->_codeset = "UTF-8";
		}
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *		default_language	string	(ex: 'en_US')
	 *		applications		array of strings (
	 *								application_name => language_file_directory,
	 *	 							...,
	 * 								...,
	 *							)
	 *		
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( Properties $configuration ) { 
		$this->_configuration =$configuration;
		
		ArgumentValidator::validate($configuration->getProperty('default_language'),
			StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($configuration->getProperty('applications'),
			ArrayValidatorRule::getRule(), true);
		
		// Get the current Language settings from the session if they exist.
		if (isset($_SESSION['__CurrentLanguage'])) {
			$this->setLanguage( $_SESSION['__CurrentLanguage'] );
		} else {
			$this->setLanguage( $configuration->getProperty('default_language') );
		}
		
		foreach ($configuration->getProperty('applications') 
			as $application => $languageDir)
		{
			ArgumentValidator::validate($application, StringValidatorRule::getRule(), true);
			ArgumentValidator::validate($languageDir, StringValidatorRule::getRule(), true);
			
			$this->addApplication($application, $languageDir);
		}
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext =$context;
	}
	
	/**
	 * Add a new application to the LanguageLocalizer.
	 * The first application added will be the default textdomain.
	 * To use language files in other textdomains use the PHP textdomain()
	 * function as follows:
	 * 
	 * < ?
	 * $defaultTextDomain = textdomain();
	 * textdomain("myAppName");
	 * 
	 * ...
	 * print _("My nice string");
	 * print _("Some other stuff.");
	 * ...
	 *
	 * textdomain($defaultTextDomain);
	 * ? >
	 *
	 * To create the localized binary hashes, the following steps need to be
	 * followed:
	 *
	 * 1. use xgettext to create the .po translation files:
	 * 		find /www/afranco/polyphony/ -iname "*.php" -exec xgettext -C -j -o /www/afranco/polyphony/main/languages/en_US/LC_MESSAGES/polyphony.po --keyword=_ {} \;
	 *
	 * 2. translate the .po files
	 * 3. use msgfmt to create the binary hashes
	 *		msgfmt -vf /www/afranco/polyphony/main/languages/es_ES/LC_MESSAGES/polyphony.po -o /www/afranco/polyphony/main/languages/es_ES/LC_MESSAGES/polyphony.mo
	 *
	 * @param string $application The application name to add.
	 * @param string $langDir The directory where language files for the 
	 *		application are stored.
	 * @return void
	 */
	function addApplication ($application, $langDir) {
		if (!file_exists($langDir)) {
			throwError(new HarmoniError("LanguageLocalizer - could not find language folder '$langDir'.","LanguageLocalizer",true));
			return false;
		}
		
		$this->_applications[$application] = $langDir;
		
		// If gettext support is availible, use it.
		if (hasGettext()) {
			bindtextdomain($application, $langDir);
			bind_textdomain_codeset ($application, $this->_codeset);
		
			// The first application added will be the default textdomain.		
			if (count($this->_applications) == 1)
				textdomain($application);
		}
	}
	
	/**
	 * Sets the language to use for getting data to $language.
	 * @param string $language The language code (eg, "en_US") to use.
	 * @access public
	 * @return void
	 * @todo -cLanguageLocalizer Implement LanguageLocalizer.setLanguage - use gettext functionality.
	 **/
	function setLanguage($language) {
		if (!preg_match("/^[a-z]{2,3}_[A-Z]{2}$/",$language)) {
			throwError(new HarmoniError("LanguageLocalizer::setLanguage($language) - language must start with 'xx_XX' or 'xxx_XX' (where x/X is any letter). Example: 'en_US'.","LanguageLocalizer",true));
			return false;
		}
		
// 		foreach ($this->_applications as $application => $langDir) {
// 			$file = $langDir . DIRECTORY_SEPARATOR
// 					. $language . DIRECTORY_SEPARATOR
// 					. "LC_MESSAGES" . DIRECTORY_SEPARATOR
// 					. $application . ".mo";
// 			
// 			if (! file_exists($file) ) {
// 				throwError(new HarmoniError("LanguageLocalizer::setLanguage($language) - could not set language. The translation file '$file' does not exist!","LanguageLocalizer", true));
// 				return false;
// 			}
// 		}
		
		
		$this->_lang = $language;
		$_SESSION['__CurrentLanguage'] = $this->_lang;
		
		// If gettext support is availible, use it.
		if (hasGettext()) {
			// Safe-Mode will restrict usage of putenv, so suppress errros for those
			// environments 
			if (!ini_get('safe_mode') || (ini_get('safe_mode') && preg_match('/LANG/', ini_get('safe_mode_allowed_env_vars')))) 
				putenv("LANG=".$this->_lang);
			else
				@ putenv("LANG=".$this->_lang);
			$result = setlocale(LC_ALL, $this->_lang);
			
			debug::output( "Setting Lang to ".$this->_lang." => '$result'.",DEBUG_SYS5,"LanguageLocalizer");
		}
	}
	
	/**
	 * Return the code of the current language.
	 * @return string
	 */
	function getLanguage() {
		return $this->_lang;
	}
	
	/**
	 * Answer the language code without the country
	 * 
	 * @return string
	 * @access public
	 * @since 4/2/08
	 */
	public function getCurrentLanguageCode () {
		if (!preg_match("/^([a-z]{2,3})_([A-Z]{2})$/", $this->_lang, $parts))
			throw new OperationFailedException("Invalid current language, '".$this->_lang."'.");
		
		return $parts[1];
	}
	
	/**
	 * Answer the country code without the language
	 * 
	 * @return string
	 * @access public
	 * @since 4/2/08
	 */
	public function getCurrentCountryCode () {
		if (!preg_match("/^([a-z]{2,3})_([A-Z]{2})$/", $this->_lang, $parts))
			throw new OperationFailedException("Invalid current language, '".$this->_lang."'.");
		
		return $parts[2];
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
		// If gettext support is availible, use it.
		if (hasGettext()) {
			foreach ($this->_applications as $application => $langDir) {
				bind_textdomain_codeset ($application, $codeset);
			}
		}
	}
	
	/**
	 * Return an array of availible languages. The keys are the language codes
	 * and the values are a UTF-8 encoded string representation of the language
	 * name (eg. "en_US" => "English - US", "es_ES" => "Español - España",
	 * "es_MX" => "Español - México")
	 * @param boolean $includeCountries Include the countries of the language
	 *		codes. Default is TRUE.
	 * @param optional array $nameTranslationOrder The order in which to return translated name strings.
	 * 		Default is array('native', 'eng', 'fra', 'spa', 'zho', 'rus', 'deu')
	 * @return array
	 */
	function getLanguages($includeCountries = TRUE, $nameTranslationOrder = array('native', 'eng', 'fra', 'spa', 'zho', 'rus', 'deu')) {
		if (!isset($_SESSION['__AvailibleLanguages'])) {
			$validNameTranslations = array('native', 'eng', 'fra', 'spa', 'zho', 'rus', 'deu');
			foreach ($nameTranslationOrder as $trans)
				if (!in_array($trans, $validNameTranslations))
					throw new InvalidArgumentException("Invalid name translation, $trans.");
			
			$langfile = HARMONI.'languageLocalizer/iso-639-3.tab';
			$translationsFile = HARMONI.'languageLocalizer/iso-639-3_translated.tab';
			$countryfile = HARMONI.'languageLocalizer/countries.txt';
			
			// Compile an array of translated names.
			$translations = array();
			$inputArray = file($translationsFile);
			$defs = explode("\t", array_shift($inputArray));
			foreach ($inputArray as $line) {
				$parts = explode("\t",$line);
				$code = $parts[0];
				$translations[$code] = array();
				for ($i = 5; $i <= 11; $i++) {
					if (isset($parts[$i]))
						$translations[$code][$defs[$i]] = $parts[$i];
				}

			}
// 			header("Content-type: text/plain; charset=utf-8");
// 			printpre($translations);
// 			exit;
			
			// Compile an array of all languages
			$languages = array();
			$inputArray = file($langfile);
			array_shift($inputArray);

			foreach ($inputArray as $line) {
// 				$line = rtrim($line);
				$parts = explode("\t",$line);
				$code = $parts[0];
				
				// Determine the name of the language
				$name = null;
				if (isset($translations[$code])) {
					foreach ($nameTranslationOrder as $trans) {
						if (isset($translations[$code][$trans]) && $translations[$code][$trans]) {
							$name = $translations[$code][$trans];
							break;
						}
					}
				}
				// Use the ISO english name if none is found or the english version is to be used.
				if (!$name || $trans == 'eng')
					$name = $parts[6];
					
				$languages[$parts[0]] = $name;
				if ($parts[1])
					$languages[$parts[1]] = $name;
				if ($parts[2])
					$languages[$parts[2]] = $name;
				if ($parts[3])
					$languages[$parts[3]] = $name;
				
			}
			
// 			header("Content-type: text/plain; charset=utf-8");
// 			printpre($languages); exit;
						
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
			
			// If gettext is availible, return all of the languages availble
			if (hasGettext()) {
				foreach ($this->_applications as $application => $langDir) {
					$handle = opendir($langDir);
					while (($file = readdir($handle)) !== FALSE) {
						if (preg_match("/^([a-z]{2,3})_([A-Z]{2})$/", $file, $parts)) {
							if ($includeCountries)
								$_SESSION['__AvailibleLanguages'][$file] = 
										$languages[$parts[1]].
									" - ".$countries[$parts[2]];
// 									" - ".$this->ucfirst_strtolower_utf8($countries[$parts[2]]);
							else
								$_SESSION['__AvailibleLanguages'][$file] = $languages[$parts[1]];
						}
					}
				}
			} 
			// if we don't have gettext support, just show the default language
			else {
				preg_match("/^([a-z]{2,3})_([A-Z]{2})$/", $this->_lang, $parts);
				$_SESSION['__AvailibleLanguages'][$this->_lang] = $languages[$parts[1]].
															" - ".$countries[$parts[2]];
			}
		}
		
		return $_SESSION['__AvailibleLanguages'];
	}
	
	/**
	 * Do a ucfirst(strtolower()) on a utf8 string
	 * 
	 * @param string $inputString
	 * @return string
	 * @access private
	 * @since 4/2/08
	 */
	private function ucfirst_strtolower_utf8 ($inputString) {
		$outputString    = utf8_decode($inputString);
		$outputString    = strtolower($outputString);
		$outputString    = ucfirst($outputString);
		$outputString    = utf8_encode($outputString);
		return $outputString;
	}
}

/**
 * For systems that don't have gettext installed, we want to define a "_" function
 * so that harmoni will still operate, if only in English
 */
if (!function_exists("gettext")) {
	
	/**
	 * Return The status of REAL gettext support
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/17/04
	 *
	 */
	function hasGettext () {
		return FALSE;
	}
	
	/**
	 * Returns the passed string to emulate untranslated language support for
	 * systems on which gettext isn't availible
	 * 
	 * @param string $string
	 * @return string
	 * @access public
	 * @since 11/16/04
	 *
	 */
	function _ ( $string ) {
		return $string;
	}

	/**
	 * Returns the passed string to emulate untranslated language support for
	 * systems on which gettext isn't availible
	 * 
	 * @param string $string
	 * @return string
	 * @access public
	 * @since 11/16/04
	 *
	 */
	function gettext ( $string ) {
		return $string;
	}
	
	/**
	 * Returns the passed string unchanged.
	 * @param string $domain
	 * @param string $string
	 * @access public
	 * @return string
	 */
	function dgettext ($domain, $string) {
		return $string;
	}
	
	/**
	 * Does nothing. Here to emulate untranslated language support for
	 * systems on which gettext isn't availible
	 * 
	 * @param string $string
	 * @return string
	 * @access public
	 * @since 11/16/04
	 *
	 */
	function textdomain ( $string ) {
		if ($string) {
			$_SESSION['__fake_text_domain'] = $string;
		}
		
		if (isset($_SESSION['__fake_text_domain']))
			return $_SESSION['__fake_text_domain'];
		else
			return "en_US";
	}
	
} else {

	/**
	 * Return The status of REAL gettext support
	 * 
	 * @return boolean
	 * @access public
	 * @since 11/17/04
	 *
	 */
	function hasGettext () {
		return TRUE;
	}
}