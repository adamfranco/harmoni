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
	 * The link identifier for the database connection.
	 * The link identifier for the database connection.
	 * @param integer $_linkId The link identifier for the database connection.
	 * @access private
	 */
	var $_linkId;


	/**
	 * Stores the number of rows processed by the query.
	 * Stores the number of rows processed by the query.
	 * @var integer $_numberOfRows The number of rows processed by the query.
	 * @access private
	 */
	var $_numberOfRows;



	/**
	 * Creates a new MySQLINSERTQueryResult object.
	 * Creates a new MySQLINSERTQueryResult object.
	 * @access public
	 * @param integer $linkId The link identifier for the database connection.
	 * @return object MySQLINSERTQueryResult A new MySQLINSERTQueryResult object.
	 */
	function MySQLUpdateQueryResult($linkId) {
		// ** parameter validation
		$resourceRule = ResourceValidatorRule::getRule();
		ArgumentValidator::validate($linkId, $resourceRule, true);
		// ** end of parameter validation

		$this->_linkId = $linkId;

		$this->_numberOfRows = mysql_affected_rows($this->_linkId);
	}
		


	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, INSERT, or
	 * UPDATE query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() {
		return $this->_numberOfRows;
	}

}

?>