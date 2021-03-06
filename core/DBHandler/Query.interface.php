<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.interface.php,v 1.8 2007/09/05 21:38:59 adamfranco Exp $
 */
 
	/**
	 * A constant for an UNKNOWN query type.
 	 * @const UNKNOWN A constant for an UNKNOWN query type.
	 * @access public
	 */
	define("UNKNOWN", 1);

	/**
	 * A constant for a SELECT query type.
 	 * @const SELECT A constant for a SELECT query type.
	 * @access public
	 */
	define("SELECT", 1);

	/**
	 * A constant for an UPDATE query type.
 	 * @const UPDATE A constant for an UPDATE query type.
	 * @access public
	 */
	define("UPDATE", 2);

	/**
	 * A constant for an INSERT query type.
 	 * @const INSERT A constant for an INSERT query type.
	 * @access public
	 */
	define("INSERT", 3);

	/**
	 * A constant for a DELETE query type.
 	 * @const DELETE A constant for a DELETE query type.
	 * @access public
	 */
	define("DELETE", 4);

	/**
	 * A constant for a GENERIC query type.
 	 * @const GENERIC A constant for a GENERIC query type.
	 * @access public
	 */
	define("GENERIC", 5);
	
	/**
	 * Defines a constant for 'AND' operations (used in WHERE and JOIN clauses)
	 * @const integer _AND
	 */
	define("_AND", 7);
	
	
	/**
	 * Defines a constant for 'OR' operations (used in WHERE and JOIN clauses)
	 * @const integer _OR
	 */
	define("_OR", 8);
	
	

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.interface.php,v 1.8 2007/09/05 21:38:59 adamfranco Exp $
 */

interface Query { 

	/**
	 * Resets the query.
	 * @access public
	 */
	public function reset() ;
	
	/**
	 * Returns the type of this query.
	 * Returns the type of this query: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * @access public
	 * @return integer The type of this query: SELECT, INSERT, DELETE, or UPDATE.
	 */
	public function getType() ;
	
}

?>