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

/**
 * Theme sources provide access to themes in a standardized way.
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeSourceInterface {
		
	/**
	 * Answer an array of all of the themes known to this source
	 * 
	 * @return array of Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemes ();
	
	/**
	 * Answer a theme by Id
	 * 
	 * @param string $idString
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getTheme ($idString);
	
	/**
	 * Answer true if this source supports theme administration.
	 * If this method returns true, getThemeAdminSession must
	 * not throw an UnimplementedException
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/6/08
	 */
	public function supportsThemeAdmin ();
	
	/**
	 * Answer an object that implements the ThemeAdminSessionInterface
	 * for this theme source. This could be the same or a different object.
	 * 
	 * @return object Harmoni_Gui2_ThemeAdminSessionInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getThemeAdminSession ();
}

?>