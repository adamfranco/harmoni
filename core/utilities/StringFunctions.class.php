<?php

/**
 * String Functions for common manipulations
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StringFunctions.class.php,v 1.2 2005/01/19 21:10:15 adamfranco Exp $
 */
class StringFunctions {
		
	/**
	 * Get a string representation of a byte size
	 * 
	 * @param integer $bytes
	 * @return string
	 * @access public
	 * @date 10/13/04
	 */
	function getSizeString ($bytes) {
		if ($bytes < 1024)
			return $bytes." B";
		if ($bytes < 1048576)
			return round($bytes/1024, 1)." KB";
		if ($bytes < 1073741824)
			return round($bytes/1048576, 1)." MB";
		if ($bytes < 1099511627776)
			return round($bytes/1073741824, 1)." GB";
		else
			return round($bytes/1099511627776, 1)." TB";
	}
	
}

?>