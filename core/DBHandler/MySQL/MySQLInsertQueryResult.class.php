<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLInsertQueryResult.class.php,v 1.6 2007/09/05 21:39:00 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/InsertQueryResult.interface.php");

/**
 * The InsertQueryResult interface provides the functionality common to all INSERT query results.
 *
 * For example, you can get the primary key for the last insertion, get number of inserted rows, etc.
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLInsertQueryResult.class.php,v 1.6 2007/09/05 21:39:00 adamfranco Exp $
 */

class MySQLInsertQueryResult 
	implements InsertQueryResultInterface  
{

	/**
	 * @var mysqli $_link The datbase connection.
	 */
	var $_link;
	
	/**
	 * Constructor
	 * 
	 * @param mysqli $link The database connection
	 * @param mysqli_result $result The query result for this query.
	 * @access public
	 * @since 7/2/04
	 */
	function __construct (mysqli $link) {
		$this->_link = $link;
	}
		

	/**
	 * Gets the last auto increment value that was generated by the INSERT query.
	 * Gets the last auto increment value that was generated by the INSERT query.
	 * @access public
	 * @return integer The last auto increment value that was generated by the INSERT query.
	 */ 
	function getLastAutoIncrementValue() {
		return $this->_link->insert_id;
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