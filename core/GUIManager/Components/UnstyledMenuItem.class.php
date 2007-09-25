<?php
/**
 * @since 9/25/07
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UnstyledMenuItem.class.php,v 1.1 2007/09/25 14:32:41 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/MenuItem.class.php");

/**
 * The UnstyledMenuItem can be put in a menu, but is not styled as distinct from 
 * the menu background itself
 * 
 * @since 9/25/07
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UnstyledMenuItem.class.php,v 1.1 2007/09/25 14:32:41 adamfranco Exp $
 */
class UnstyledMenuItem
	extends MenuItem
{
		
	/**
	 * Constructor
	 * 
	 * @param string $text
	 * @param optional $index
	 * @return void
	 * @access public
	 * @since 9/25/07
	 */
	public function __construct ($text, $index = 1) {
		parent::__construct($text, $index);
		
		$this->_type = BLANK;
	}
	
}

?>