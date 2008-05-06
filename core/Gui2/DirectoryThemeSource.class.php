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

require_once(dirname(__FILE__).'/ThemeSource.interface.php');
require_once(dirname(__FILE__).'/DirectoryTheme.class.php');

/**
 * This class provides access to themes that exist as subdirecties 
 * in a directory.
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
class Harmoni_Gui2_DirectoryThemeSource
	implements Harmoni_Gui2_ThemeSourceInterface
{
	/**
	 * Constructor
	 * 
	 * @param array $configuration
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function __construct (array $configuration) {
		if (!isset($configuration['path']) || !strlen($configuration['path']))
			throw new ConfigurationErrorException("No 'path' specified.'");
			
		$path = $configuration['path'];
		if (!is_dir($path))
			throw new ConfigurationErrorException("Theme dir '$path' is not a directory.");
		if (!is_readable($path)) 
			throw new ConfigurationErrorException("Theme dir '$path' is not readable.");
			
		$this->path = $path;
	}
	
	/**
	 * Answer an array of all of the themes known to this source
	 * 
	 * @return array of Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemes () {
		$themes = array();
		$subDirs = scandir($this->path);
		if (!$subDirs)
			throw new OperationFailedException("Could not get themes.");
		foreach ($subDirs as $name) {
			$fullPath = $this->path."/".$name;
			if ($name != '.' && $name != '..' && is_dir($fullPath))
				$themes[] = new Harmoni_Gui2_DirectoryTheme($fullPath);
		}
		
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
		// check for any except the allow charachers.
		if (preg_match('/[^a-z0-9_\.-]/i', $idString))
			throw new UnknownIdException("No theme exists with id, '$idString'.");
		
		return new Harmoni_Gui2_DirectoryTheme($this->path.'/'.$idString);
	}
	
	/**
	 * Answer true if this source supports theme administration.
	 * If this method returns true, getThemeAdminSession must
	 * not throw an UnimplementedException
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/6/08
	 */
	public function supportsThemeAdmin () {
		return false;
	}
	
	/**
	 * Answer an object that implements the ThemeAdminSessionInterface
	 * for this theme source. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeAdminSessionInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemeAdminSession () {
		throw new UnimplementedException();
	}
	
}

?>