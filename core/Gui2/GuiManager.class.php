<?php
/**
 * @since 5/5/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

require_once(dirname(__FILE__).'/DirectoryThemeSource.class.php');

/**
 * A new GUIManager for defining CSS/Template-based themes
 * 
 * @since 5/5/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Gui2_GuiManager 
	extends OutputHandler
{
		
	/**
	 * Constructor
	 * 
	 * @return null
	 * @access public
	 * @since 5/5/08
	 */
	public function __construct () {
		
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *		theme_directories	array 	of paths to directores that contain themes
	 *		default_theme		string 	the id of the default theme.
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
	public function assignConfiguration ( Properties $configuration ) {
		$this->_configuration = $configuration;
		
		$sources = $this->_configuration->getProperty('sources');
		if (!is_array($sources))
			throw new ConfigurationErrorException("'sources' must be an array");
		if (!count($sources))
			throw new ConfigurationErrorException("At least one source in 'sources' must be defined.");
		
		$this->themeSources = array();
		foreach ($sources as $sourceConfig) {
			// Already created Theme Source objects.
			if (is_object($sourceConfig) 
				&& $sourceConfig instanceof Harmoni_Gui2_ThemeSourceInterface) 
			{
				$this->themeSources[] = $sourceConfig;
			}
			// Config arrays
			else {
				switch ($sourceConfig['type']) {
					case 'directory':
						$this->themeSources[] = new Harmoni_Gui2_DirectoryThemeSource($sourceConfig);
						break;
					default:
						throw new ConfigurationErrorException("Unknown theme source type, '".$sourceConfig['type']."'.");
				}
			}
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
		ArgumentValidator::validate($context->getContext('harmoni'),
		ExtendsValidatorRule::getRule('Harmoni'));

		$this->_osidContext = $context;

		$this->attachToHarmoni();
	}
	
/*********************************************************
 * Methods defined in OutputHandler
 *********************************************************/
	/**
	 * Output the content that was returned from an action. This content should
	 * have been created such that it is a type that this OutputHandler can deal
	 * with.
	 * 
	 * @param mixed $returnedContent Content returned by the action
	 * @param string $printedContent Additional content printed, but not returned.
	 * @return void
	 * @access public
	 * @since 4/4/05
	 */
	function output ( $returnedContent, $printedContent ) {
		ArgumentValidator::validate($returnedContent,  ExtendsValidatorRule::getRule("ComponentInterface"));
		
		$osidContext =$this->getOsidContext();
		$harmoni =$osidContext->getContext('harmoni');
		
		$doctypeDef = $this->_configuration->getProperty('document_type_definition');
		$doctype =  $this->_configuration->getProperty('document_type');
		$characterSet = $this->_configuration->getProperty('character_set');
		try {
			$xmlns = " xmlns=\"".$this->_configuration->getProperty('xmlns')."\"";
		} catch (Exception $e) {
			$xmlns = "";
		}
		$head = $this->getHead();
		
		$css = str_replace("\n", "\n\t\t\t", $this->getCurrentTheme()->getCss());
		
		if (!headers_sent())
			header("Content-type: $doctype; charset=$characterSet");
		
		print<<<END
$doctypeDef
<html{$xmlns}>
	<head>
		<meta http-equiv="Content-Type" content="$doctype; charset=$characterSet" />
		
		$head
		
		<style type="text/css">
$css
		</style>
	</head>
	<body>
		$printedContent
		
END;

		$this->getCurrentTheme()->printPage($returnedContent);
			
		print<<<END
	</body>
</html>
END;
	}
	
	/*********************************************************
	 * Other general methods
	 *********************************************************/
	/**
	 * @var object ThemeInterface $_theme;  
	 * @access private
	 * @since 5/5/08
	 */
	private $_theme;
	
	/**
	 * Answer the current Theme
	 * 
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/5/08
	 */
	public function getCurrentTheme () {
		if (!isset($this->_theme))
			$this->useDefaultTheme();
		
		return $this->_theme;
	}
	
	/**
	 * Answer the default theme
	 * 
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/8/08
	 */
	public function getDefaultTheme () {
			$default = $this->_configuration->getProperty('default_theme');
		if (!$default)
			throw new ConfigurationErrorException("'default_theme' not specified.");

		return $this->getTheme($default);
	}
	
	/**
	 * Set the current theme
	 * 
	 * @param object Harmoni_Gui2_ThemeInterface $theme
	 * @return null
	 * @access public
	 * @since 5/5/08
	 */
	public function setCurrentTheme (Harmoni_Gui2_ThemeInterface $theme) {
		$this->_theme = $theme;
	}
	
	/**
	 * Set the default theme as the current theme
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function useDefaultTheme () {
		$this->setCurrentTheme($this->getDefaultTheme());
	}
	
	/**
	 * Answer an array of all themes
	 * 
	 * @return array
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemes () {
		$themes = array();
		foreach ($this->getThemeSources() as $source)
			$themes = array_merge($themes, $source->getThemes());
		
		return $themes;
	}
	
	/**
	 * Answer a theme by Id
	 * 
	 * @param string $idString
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getTheme ($idString) {
		foreach ($this->themeSources as $source) {
			try {
				return $source->getTheme($idString);
			} catch (UnknownIdException $e) {
			}
		}
		throw new UnknownIdException("Could not find a theme with Id, '$idString'.");
	}
	
	/**
	 * @var array $themeSources;  
	 * @access private
	 * @since 5/6/08
	 */
	private $themeSources;
	
	/**
	 * Answer an array of all theme sources
	 * 
	 * @return array of Harmoni_Gui2_ThemeSourceInterface objects
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemeSources () {
		return $this->themeSources;
	}
}

?>