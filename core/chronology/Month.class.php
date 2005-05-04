<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Month.class.php,v 1.1 2005/05/04 20:18:31 adamfranco Exp $
 */ 

/**
 * I represent a month.
 * 
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Month.class.php,v 1.1 2005/05/04 20:18:31 adamfranco Exp $
 */
class Month {
		
	/**
	 * Return the index of a string Month.
	 * 
	 * @param string $aNameString
	 * @return integer
	 * @access public
	 * @since 5/4/05
	 */
	function indexOfMonth ( $aNameString ) {
		foreach (ChronologyConstants::MonthNames() as $i => $name) {
			if (preg_match("/$aNameString.*/i", $name))
				return $i;
		}
		
		throwError(new Error( $aNameString ." is not a recognized month name."));
	}
	
	
	
}

?>