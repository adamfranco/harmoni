<?php
/**
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

require_once(dirname(__FILE__).'/Theme.interface.php');
require_once(dirname(__FILE__).'/Theme.abstract.php');
require_once(HARMONI.'/utilities/Filing/FileSystemFile.class.php');
require_once(dirname(__FILE__).'/HistoryEntry.class.php');
require_once(dirname(__FILE__).'/ThemeOption.class.php');
require_once(HARMONI.'/Gui2/ThemeOptions.interface.php');

/**
 * All GUI 2 themes must implement this interface
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Gui2_DirectoryTheme
	extends Harmoni_Gui2_ThemeAbstract
	implements Harmoni_Gui2_ThemeInterface, Harmoni_Gui2_ThemeOptionsInterface
{
	/**
	 * Constructor
	 * 
	 * @param string $path
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function __construct ($path) {
		if (!file_exists($path))
			throw new UnknownIdException("No theme found with Id, '".basename($path)."'.");
		if (!is_dir($path) || !is_readable($path))
			throw new ConfigurationErrorException("'$path' is not a readable theme directory.");
		
		$this->path = $path;
		$this->optionsPath = $this->path.'/options.xml';
		
		$this->preHtml = array();
		$this->postHtml = array();
	}
	
	/*********************************************************
	 * Output
	 *********************************************************/
	
	/**
	 * Answer a block of CSS for the theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getCss () {
		$allCss = '';
		foreach ($this->getCssFiles() as $cssFile) {
			if (!file_exists($this->path.'/'.$cssFile)) 
				throw new OperationFailedException("Required CSS file  '$cssFile' was not found in the '".$this->getIdString()."' theme.");
			$css = trim (file_get_contents($this->path.'/'.$cssFile));

			// Replace any option-markers
			foreach($this->getOptions() as $option) {
				$choice = $option->getCurrentChoice();
				foreach($choice->getSettings() as $marker => $replacement) {
					$css = str_replace($marker, $replacement, $css);
				}
			}
			
			// Replace image urls
			$css = $this->replaceRelativeUrls($css);
			
			$allCss .= $css;
		}
		return $allCss;
	}
	
	/**
	 * Print out the component tree
	 * 
	 * @param object ComponentInterface $rootComponent
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function printPage (ComponentInterface $rootComponent) {
		$rootComponent->render($this, "\t\t");
	}
	
	/**
	 * Returns the HTML string that needs to be printed before successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 * @access public
	 * @since 5/6/08
	 */
	public function getPreHTMLForComponentType ($type, $index) {
		$type = $this->resolveType($type, $index);
		return $this->getPreHtml($type);
	}
	
	/**
	 * Returns the HTML string that needs to be printed after successful rendering
	 * of components of the given type and index. Note: use of the PreHTML
	 * and PostHTML get/set methods is discouraged - use styles instead: see 
	 * <code>addStyleForComponentType()</code> and <code>getStylesForComponentType()</code>.
	 * @access public
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * If the given index is greater than the maximal registered index
	 * for the given component type, then the highest index availible will be used.
	 * @return string The HTML string.
	 * @access public
	 * @since 5/6/08
	 */
	public function getPostHTMLForComponentType ($type, $index) {
		$type = $this->resolveType($type, $index);
		return $this->getPostHtml($type);
	}
	
	/**
	 * This method is just here for compatability with the original
	 * GUIManager Components, should just return an empty array
	 * 
	 * @param integer type The type of the component. One of BLANK, HEADING, HEADER, FOOTER,
	 * BLOCK, MENU, MENU_ITEM_LINK_UNSELECTED, MENU_ITEM_LINK_SELECTED, MENU_ITEM_HEADING, OTHER.
	 * @param integer index The index that will determine which HTML string to return
	 * @return array
	 * @access public
	 * @since 5/6/08
	 */
	public function getStylesForComponentType ($type, $index) {
		return array();
	}
	
	/**
	 * Answer an image file for the image with the file-name specified
	 * 
	 * @param string $filename
	 * @return Harmoni_FileInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getImage ($filename) {
		// Ensure that no directory traversal requested
		$relPathParts = explode('/', $filename);
		foreach ($relPathParts as $part) {
			if ($part == '..')
				throw new InvalidArgumentException("Directory traversal is not allowed.");
		}
		
		$path = $this->path.'/images/'.$filename;
		if (!file_exists($path))
			throw new UnknownIdException("No image found with name '$filename' in theme '".$this->getIdString()."'");
		
		return new Harmoni_Filing_FileSystemFile($path);
	}
	
	/*********************************************************
	 * Information
	 *********************************************************/
	
	/**
	 * Answer the Id of this theme.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getIdString () {
		return basename($this->path);
	}
	
	/**
	 * Answer the display name of this theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDisplayName () {
		if (!isset($this->info))
			$this->loadInfo();
		if (is_null($this->info))
			return _("Untitled");
		
		$xpath = new DOMXPath($this->info);
		return trim($this->getPathLangVersion($xpath, '/ThemeInfo/DisplayName', $this->info->documentElement));
	}
	
	/**
	 * Answer a description of this theme
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDescription () {
		if (!isset($this->info))
			$this->loadInfo();
		if (is_null($this->info))
			return '';
		
		$xpath = new DOMXPath($this->info);
		return trim($this->getPathLangVersion($xpath, '/ThemeInfo/Description', $this->info->documentElement));
	}
	
	/**
	 * Answer a thumbnail file.
	 * 
	 * @return object Harmoni_Filing_FileInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThumbnail () {
		$file = $this->path.'/thumbnail.png';
		if (!file_exists($file))
			throw new OperationFailedException("Required thumbnail file, 'thumbnail.png' is missing from theme '".$this->getIdString()."'.");
		if (!is_readable($file))
			throw new OperationFailedException("Required thumbnail file, 'thumbnail.png' is not readable in theme '".$this->getIdString()."'.");
		
		return new Harmoni_Filing_FileSystemFile($file);
	}
	
	/**
	 * Answer the date when this theme was last modified.
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/13/08
	 */
	public function getModificationDate () {
		return TimeStamp::fromUnixTimeStamp($this->getRecentModTime($this->path));
	}
	
	/**
	 * Answer an array of ThemeHistory items, in reverse chronological order.
	 * 
	 * @return array
	 * @access public
	 * @since 5/8/08
	 */
	public function getHistory () {
		if (!isset($this->info))
			$this->loadInfo();
		if (is_null($this->info))
			return array();
		
		
		$xpath = new DOMXPath($this->info);
		$entryElements = $xpath->query('/ThemeInfo/History/Entry');
		$history = array();
		$dates = array();
		foreach ($entryElements as $entryElement) {
			$comment = $xpath->query('Comment', $entryElement)->item(0)->nodeValue;
			$name = $xpath->query('Name', $entryElement)->item(0)->nodeValue;
			$email = $xpath->query('EMail', $entryElement)->item(0)->nodeValue;
			$date = DateAndTime::fromString($entryElement->getAttribute('date'));
			
			$history[] = new Harmoni_Gui2_HistoryEntry($date, $comment, $name, $email);
			$dates[] = $date->asString();
		}
		$unique = array_keys($history);
		array_multisort($dates, SORT_DESC, $unique, $history);
		
		return $history;
	}
	
	/*********************************************************
	 * Options
	 *********************************************************/
	/**
	 * Answer an XML document for the options for this theme
	 * 
	 * @return object Harmoni_DOMDocument
	 * @access public
	 * @since 5/15/08
	 */
	public function getOptionsDocument () {
		$options = new Harmoni_DOMDocument;
		
		if (file_exists($this->optionsPath)) {
			$options->preserveWhiteSpace = false;
			$options->load($this->optionsPath);
			$options->schemaValidateWithException(dirname(__FILE__).'/theme_options.xsd');
		}
		
		return $options;
	}
	
	/*********************************************************
	 * Accessing Theme Data
	 *********************************************************/
	/**
	 * Answer the global CSS string.
	 * 
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getGlobalCss () {
		$path = $this->path.'/Global.css';
		if (file_exists($path))
			return file_get_contents($path);
		else
			return '';
	}
	
	/**
	 * Get the CSS for a component Type.
	 * 
	 * @param string $componentType
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getCssForType ($componentType) {
		$path = $this->path.'/'.$componentType.'.css';
		if (file_exists($path))
			return file_get_contents($path);
		else
			return '';
	}
	
	/**
	 * Get the HTML template for a component Type.
	 * 
	 * @param string $componentType
	 * @return string
	 * @access public
	 * @since 5/15/08
	 */
	public function getTemplateForType ($componentType) {
		$path = $this->path.'/'.$componentType.'.html';
		if (file_exists($path))
			return file_get_contents($path);
		else
			return '';
	}
	
	/**
	 * Answer the images for this theme
	 * 
	 * @return array of Harmoni_Filing_FileInterface objects
	 * @access public
	 * @since 5/15/08
	 */
	public function getImages () {
		return $this->getImagesIn($this->path.'/images');
	}
	
	/**
	 * Answer the images in the path specified.
	 * 
	 * @param string $path
	 * @return array of Harmoni_Filing_FileInterface objects
	 * @access private
	 * @since 5/16/08
	 */
	private function getImagesIn ($path) {
		$images = array();
		if (file_exists($path) && is_dir($path)) {
			foreach (scandir($path) as $filename) {
				if (is_dir($path.'/'.$filename)) {
					if ($filename != '.' && $filename != '..')
						$images = array_merge($images, $this->getImagesIn($path.'/'.$filename));
				} else
					$images[] = new Harmoni_Filing_FileSystemFile($path.'/'.$filename);
			}
		}
		return $images;
	}
	
	/*********************************************************
	 * Theme Modification
	 *********************************************************/
	
	/**
	 * Answer true if this theme supports modification.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/15/08
	 */
	public function supportsModification () {
		return false;
	}
	
	/**
	 * Answer an object that implements the ThemeModificationInterface
	 * for this theme. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeModificationInterface
	 * @access public
	 * @since 5/15/08
	 */
	public function getModificationSession () {
		throw new UnimplementedException();
	}
	
	/*********************************************************
	 * internal
	 *********************************************************/
	
	/**
	 * Load the information XML file
	 * 
	 * @return null
	 * @access protected
	 * @since 5/7/08
	 */
	protected function loadInfo () {
		$path = $this->path.'/info.xml';
		if (!file_exists($path))
			throw new OperationFailedException("Theme '".$this->getIdString()."' is missing its info.xml file.");
		
		$this->info = new Harmoni_DOMDocument;
		$this->info->load($path);
		$this->info->schemaValidateWithException(dirname(__FILE__).'/theme_info.xsd');
	}
	
	/**
	 * Answer a list of required CSS files
	 * 
	 * @return array
	 * @access protected
	 * @since 5/6/08
	 */
	protected function getCssFiles () {
		$types = array_merge(array('Global'), $this->getComponentTypes());
		foreach ($types as $key => $type)
			$types[$key] = $type.'.css';
		
		return $types;
	}
	
	/**
	 * Answer a list of required template files
	 * 
	 * @return array
	 * @access protected
	 * @since 5/6/08
	 */
	protected function getTemplateFiles () {
		$types = $this->getComponentTypes();
		foreach ($types as $key => $type)
			$types[$key] = $type.'.html';
		
		return $types;
	}
	
	/**
	 * Answer Pre-HTML for the type specified.
	 * 
	 * @param string $type
	 * @return string
	 * @access protected
	 * @since 5/6/08
	 */
	protected function getPreHtml ($type) {
		if ($type == 'Blank')
			return '';
		
		if (!isset($this->preHtml[$type]))
			$this->loadType($type);
			
		return $this->preHtml[$type];
	}
	
	/**
	 * Answer Post-HTML for the type specified.
	 * 
	 * @param string $type
	 * @return string
	 * @access protected
	 * @since 5/6/08
	 */
	protected function getPostHtml ($type) {
		if ($type == 'Blank')
			return '';
		
		if (!isset($this->postHtml[$type]))
			$this->loadType($type);
			
		return $this->postHtml[$type];
	}
	
	/**
	 * @var array $preHtml;  
	 * @access private
	 * @since 5/6/08
	 */
	private $preHtml;
	
	/**
	 * @var array $postHtml;  
	 * @access private
	 * @since 5/6/08
	 */
	private $postHtml;
	
	/**
	 * Parse a type file and load its contents into our arrays
	 * 
	 * @param string $type
	 * @return null
	 * @access protected
	 * @since 5/6/08
	 */
	protected function loadType ($type) {
		if (!in_array($type, $this->getComponentTypes()))
			throw new InvalidArgumentException("Invalid type, '$type'.");
		
		$file = $this->path.'/'.$type.'.html';
		if (!file_exists($file))
			throw new OperationFailedException("Required template file, '{$type}.html' is missing from theme '".$this->getIdString()."'.");
		if (!is_readable($file))
			throw new OperationFailedException("Required template file, '{$type}.html' is not readable in theme '".$this->getIdString()."'.");
			
		$contents = trim(file_get_contents($file));
		
		// Set to empty for empty files.
		if (!strlen($contents)) {
			$this->preHtml[$type] = '';
			$this->postHtml[$type] = '';
			return;
		}
		
		// Verify that a placeholder exists
		if (strpos($contents, '[[CONTENT]]') === false)
			throw new OperationFailedException("Required template file, '{$type}.html' is missing a '[[CONTENT]]' placeholder in theme '".$this->getIdString()."'.");
		
		// Replace any option-markers
		foreach($this->getOptions() as $option) {
			$choice = $option->getCurrentChoice();
			foreach($choice->getSettings() as $marker => $replacement) {
				$contents = str_replace($marker, $replacement, $contents);
			}
		}
		
		// Replace image urls
		$contents = $this->replaceRelativeUrls($contents);
		
		// Save our pieces
		$this->preHtml[$type] = substr($contents, 0, strpos($contents, '[[CONTENT]]'));
		$this->postHtml[$type] = substr($contents, strpos($contents, '[[CONTENT]]') + 11);
	}
	
	/**
	 * Answer the most recent modification time in the directory passed
	 * 
	 * @param string $dirPath
	 * @return int
	 * @access private
	 * @since 5/13/08
	 */
	private function getRecentModTime ($dirPath) {
		$latest = 0;
		foreach (scandir($dirPath) as $fname) {
			if (is_dir($fname)) {
				if ($fname != '.' && $fname != '..')
					$latest = max($latest, $this->getRecentModTime($dirPath.'/'.$fname));
			} else {
				$latest = max($latest, filemtime($dirPath.'/'.$fname));
			}	
		}
		return $latest;
	}
}

?>