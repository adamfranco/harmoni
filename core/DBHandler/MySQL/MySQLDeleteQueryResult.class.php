<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDeleteQueryResult.class.php,v 1.5 2007/09/04 20:25:19 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/DeleteQueryResult.interface.php");

/**
 * The DeleteQueryResult interface provides the functionality common to all Delete query results.
 *
 * For example, you can get the primary key for the last Deleteion, get number of Deleteed rows, etc.
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDeleteQueryResult.class.php,v 1.5 2007/09/04 20:25:19 adamfranco Exp $
 */

class MySQLDeleteQueryResult extends DeleteQueryResultInterface {


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
	 * Creates a new MySQLDeleteQueryResult object.
	 * Creates a new MySQLDeleteQueryResult object.
	 * @access public
	 * @param integer $linkId The link identifier for the database connection.
	 * @return object MySQLDeleteQueryResult A new MySQLDeleteQueryResult object.
	 */
	function MySQLDeleteQueryResult($linkId) {
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
	 * this would be the total number of rows selected. For a UPDATE, INSERT, or
	 * Delete query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() {
		return $this->_numberOfRows;
	}

}

?>