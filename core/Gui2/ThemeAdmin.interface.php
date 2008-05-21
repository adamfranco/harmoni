<?php
/**
 * @since 5/16/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * This interface defines the methods that a theme admin session must implement.
 * 
 * @since 5/16/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeAdminInterface {
		
	/**
	 * Create a new empty theme.
	 * 
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/16/08
	 */
	public function createTheme ();
	
	/**
	 * Create a copy of a theme and return the new copy.
	 * 
	 * @param object Harmoni_Gui2_ThemeInterface $theme
	 * @return object Harmoni_Gui2_ThemeInterface
	 * @access public
	 * @since 5/16/08
	 */
	public function createCopy (Harmoni_Gui2_ThemeInterface $theme);
	
}

?>