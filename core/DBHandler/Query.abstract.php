<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.abstract.php,v 1.2 2005/04/07 16:33:23 adamfranco Exp $
 */
require_once(HARMONI."DBHandler/Query.interface.php");

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.abstract.php,v 1.2 2005/04/07 16:33:23 adamfranco Exp $
 */

class Query extends QueryInterface { 

	/**
	 * The type of the query.
	 * The type of the query. Allowed values: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * var integer $_type The type of the query.
	 */ 
	var $_type;

	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		$this->_type = UNKNOWN;
	}
	
	/**
	 * Returns the type of this query.
	 * Returns the type of this query: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * @access public
	 * @return integer The type of this query: SELECT, INSERT, DELETE, or UPDATE.
	 */
	function getType() {
		return $this->_type;	
	}
	
}

?>