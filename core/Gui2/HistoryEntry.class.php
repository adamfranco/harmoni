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

require_once(dirname(__FILE__).'/HistoryEntry.interface.php');

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
class Harmoni_Gui2_HistoryEntry
	implements Harmoni_Gui2_HistoryEntryInterface
{
	
	/**
	 * @var DateAndTime $date;  
	 * @access private
	 * @since 5/8/08
	 */
	private $date;
	
	/**
	 * @var string $comment;  
	 * @access private
	 * @since 5/8/08
	 */
	private $comment;
	
	/**
	 * @var string $name;  
	 * @access private
	 * @since 5/8/08
	 */
	private $name;
	
	/**
	 * @var string $email;  
	 * @access private
	 * @since 5/8/08
	 */
	private $email;
	
	/**
	 * Constructor
	 * 
	 * @param object DateAndTime $date
	 * @param string $comment
	 * @param string $name
	 * @param string $email
	 * @return null
	 * @access public
	 * @since 5/8/08
	 */
	public function __construct (DateAndTime $date, $comment, $name, $email) {
		$this->date = $date;
		$this->comment = $comment;
		$this->name = $name;
		$this->email = $email;
	}
	
	/**
	 * Answer the comment for this entry
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getComment () {
		return $this->comment;
	}
	
	/**
	 * Answer the date of this entry.
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/8/08
	 */
	public function getDateAndTime () {
		return $this->date;
	}
	
	/**
	 * Answer the name of the person associated with this entry.
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getName () {
		return $this->name;
	}
	
	/**
	 * Answer the email of the person associated with this entry.
	 * 
	 * @return string
	 * @access public
	 * @since 5/8/08
	 */
	public function getEmail () {
		return $this->email;
	}
	
}

?>