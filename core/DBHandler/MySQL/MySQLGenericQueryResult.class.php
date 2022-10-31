<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLGenericQueryResult.class.php,v 1.10 2007/09/05 21:39:00 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/GenericQueryResult.interface.php");

/**
 * The GenericQueryResult interface provides methods for accessing the results of
 * a generic query. These results can be returned as if they were one of the other
 * query types, or the resource links can be returned and accessed directly.
 *
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLGenericQueryResult.class.php,v 1.10 2007/09/05 21:39:00 adamfranco Exp $
 */
class MySQLGenericQueryResult 
	implements GenericQueryResultInterface 
{
	
	/**
	 * @var mysqli $_link The datbase connection.
	 */
	var $_link;
	
	/**
	 * The resource id for this SELECT query.
	 * The resource id for this SELECT query.
	 * @var mysqli_result $_result The query result for this query.
	 * @access private
	 */
	var $_result;
	
	/**
	 * Constructor
	 * 
	 * @param mysqli $link The database connection
	 * @param mysqli_result $result The query result for this query.
	 * @access public
	 * @since 7/2/04
	 */
	function __construct (mysqli $link, mysqli_result $result) {
		$this->_link = $link;
		$this->_result = $result;
	}
	
	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 */ 
	function getNumberOfRows() {
		return $this->_result->num_rows;
	}
	
	/**
	 * Returns the result of the query as a SelectQueryResult.
	 * 
	 * @return object SelectQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsSelectQueryResult () {
		return new MySQLSelectQueryResult($this->_link, $this->_result);
	}
	
	/**
	 * Returns the result of the query as an InsertQueryResult.
	 * 
	 * @return object InsertQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsInsertQueryResult () {
		return new MySQLInsertQueryResult($this->_link);
	}
	
	/**
	 * Returns the result of the query as a UpdateQueryResult.
	 * 
	 * @return object UpdateQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsUpdateQueryResult () {
		return new MySQLUpdateQueryResult($this->_link);
	}
	
	/**
	 * Returns the result of the query as a DeleteQueryResult.
	 * 
	 * @return object DeleteQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsDeleteQueryResult () {
		return new MySQLDeleteQueryResult($this->_link);
	}
	
	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the mysql_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() { 
		return $this->_result;
	}

}

?>