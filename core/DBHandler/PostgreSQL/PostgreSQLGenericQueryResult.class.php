<?php
/**
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostgreSQLGenericQueryResult.class.php,v 1.1 2007/09/14 13:57:08 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/GenericQueryResult.interface.php");

/**
 * The GenericQueryResult interface provides methods for accessing the results of
 * a generic query. These results can be returned as if they were one of the other
 * query types, or the resource links can be returned and accessed directly.
 *
 *
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostgreSQLGenericQueryResult.class.php,v 1.1 2007/09/14 13:57:08 adamfranco Exp $
 */
class PostgreSQLGenericQueryResult 
	implements GenericQueryResultInterface 
{
	
	/**
	 * The resource id for this SELECT query.
	 * The resource id for this SELECT query.
	 * @var integer $_resourceId The resource id for this SELECT query.
	 * @access private
	 */
	var $_resourceId;


	/**
	 * The link identifier for the database connection.
	 * The link identifier for the database connection.
	 * @param integer $_linkId The link identifier for the database connection.
	 * @access private
	 */
	var $_linkId;
	
	/**
	 * Constructor
	 * 
	 * @param integer $resourceId The resource id for this SELECT query.
	 * @param integer $linkId The link identifier for the database connection.
	 * @access public
	 * @since 7/2/04
	 */
	function __construct ($resourceId, $linkId) {
		// ** parameter validation
		$resourceRule = ResourceValidatorRule::getRule();
		if (!is_bool($resourceId)) {
			ArgumentValidator::validate($resourceId, $resourceRule, true);
		}
		ArgumentValidator::validate($linkId, $resourceRule, true);
		// ** end of parameter validation

		$this->_resourceId = $resourceId;
		$this->_linkId = $linkId;
	}
	
	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 */ 
	function getNumberOfRows() {
		return pg_num_rows($this->_resourceId);
	}

	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the PostgreSQL_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() { 
		return $this->_resourceId;
	}
	
	/**
	 * Returns the result of the query as a SelectQueryResult.
	 * 
	 * @return object SelectQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsSelectQueryResult () {
		$obj = new PostgreSQLSelectQueryResult($this->_resourceId, $this->_linkId);
		return $obj;
	}
	
	/**
	 * Returns the result of the query as an InsertQueryResult.
	 * 
	 * @return object InsertQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsInsertQueryResult () {
		$obj = new PostgreSQLInsertQueryResult($this->_linkId);
		return $obj;
	}
	
	/**
	 * Returns the result of the query as a UpdateQueryResult.
	 * 
	 * @return object UpdateQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsUpdateQueryResult () {
		$obj = new PostgreSQLUpdateQueryResult($this->_linkId);
		return $obj;
	}
	
	/**
	 * Returns the result of the query as a DeleteQueryResult.
	 * 
	 * @return object DeleteQueryResult
	 * @access public
	 * @since 7/1/04
	 */
	function returnAsDeleteQueryResult () {
		$obj = new PostgreSQLDeleteQueryResult($this->_linkId);
		return $obj;
	}
}

?>