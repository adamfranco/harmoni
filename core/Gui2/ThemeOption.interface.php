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
 * This interface defines a single theme option
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeOptionInterface {
		
	/**
	 * Answer the display name of this option
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDisplayName ();
	
	/**
	 * Answer a description of this option
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getDescription ();
	
	/**
	 * Get the allowed values for this option.
	 * 
	 * @return array of strings
	 * @access public
	 * @since 5/6/08
	 */
	public function getValues ();
	
	/**
	 * Get text labels for the values for this option.
	 * 
	 * @return array of strings
	 * @access public
	 * @since 5/6/08
	 */
	public function getLabels ();
	
	/**
	 * Set the value of this option
	 * 
	 * @param string $value
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setValue ();
	
	/**
	 * Set the value of this option to be the default.
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function useDefault ();
}

?>