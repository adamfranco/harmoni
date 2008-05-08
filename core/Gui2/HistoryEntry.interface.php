<?php
/**
 * @since 5/8/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */ 

/**
 * HistoryEntries are data containers for history information about themes.
 * 
 * @since 5/8/08
 * @package harmoni.gui2
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id$
 */
interface Harmoni_Gui2_HistoryEntryInterface {
	
	/**
	 * Answer the comment for this entry
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getComment ();
	
	/**
	 * Answer the date of this entry.
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/8/08
	 */
	public function getDateAndTime ();
	
	/**
	 * Answer the name of the person associated with this entry.
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getName ();
	
	/**
	 * Answer the email of the person associated with this entry.
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getEmail ();
	
}

?>