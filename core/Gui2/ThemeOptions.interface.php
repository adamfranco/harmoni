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
 * This interface defines an object for working with theme options.
 * 
 * @since 5/6/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_ThemeOptionsInterface {
		
	/**
	 * Answer an array of ThemeOption objects
	 * 
	 * @return array of Harmoni_Gui2_ThemeOptionInterface
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptions ();
	
	/**
	 * Answer a string version of the current option-values that
	 * can be fed back into setOptions() to return to the current
	 * state.
	 * 
	 * @return string
	 * @access public
	 * @since 5/6/08
	 */
	public function getOptionsValue ();
	
	/**
	 * Given a string created by getOptionsValue(), set the current
	 * state of the options to match.
	 * 
	 * @param string $optionsValue
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function setOptionsValue ($optionsValue);
	
	/**
	 * Set all options to use their defaults
	 * 
	 * @return null
	 * @access public
	 * @since 5/6/08
	 */
	public function useDefaults ();
}

?>