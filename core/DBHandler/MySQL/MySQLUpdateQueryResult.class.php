<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLUpdateQueryResult.class.php,v 1.6 2007/09/05 21:39:00 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/UpdateQueryResult.interface.php");

/**
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 *
 * For example, you can get the primary key for the last UPDATEion, get number of UPDATEed rows, etc.
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLUpdateQueryResult.class.php,v 1.6 2007/09/05 21:39:00 adamfranco Exp $
 */

class MySQLUpdateQueryResult 
	implements UpdateQueryResultInterface 
{
	/**
	 * @var mysqli $_link The datbase connection.
	 */
	var $_link;


	/**
	 * Constructor
	 * 
	 * @param mysqli $link The database connection
	 * @access public
	 * @since 7/2/04
	 */
	function __construct (mysqli $link) {
		$this->_link = $link;
	}
	

	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() {
		return $this->_link->affected_rows;
	}

}

?>