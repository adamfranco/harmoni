<?php

require_once(HARMONI."DBHandler/GenericQueryResult.interface.php");


/**
 * The GenericQueryResult interface provides methods for accessing the results of
 * a generic query. These results can be returned as if they were one of the other
 * query types, or the resource links can be returned and accessed directly.
 *
 * 
 * @version $Id: MySQLGenericQueryResult.class.php,v 1.2 2004/07/02 21:35:53 adamfranco Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class MySQLGenericQueryResult extends GenericQueryResultInterface {
	
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
	 * @date 7/2/04
	 */
	function MySQLGenericQueryResult ($resourceId, $linkId) {
		// ** parameter validation
		$resourceRule =& new ResourceValidatorRule();
		if (!is_bool($resourceId)) {
			ArgumentValidator::validate($resourceId, $resourceRule, true);
		}
		ArgumentValidator::validate($linkId, $resourceRule, true);
		// ** end of parameter validation

		$this->_resourceId = $resourceId;
		$this->_linkId = $linkId;
	}
	
	

	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the mysql_query() function.
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
	 * @date 7/1/04
	 */
	function & returnAsSelectQueryResult () {
		return new MySQLSelectQueryResult($this->_resourceId, $this->_linkId);
	}
	
	/**
	 * Returns the result of the query as an InsertQueryResult.
	 * 
	 * @return object InsertQueryResult
	 * @access public
	 * @date 7/1/04
	 */
	function & returnAsInsertQueryResult () {
		return new MySQLInsertQueryResult($this->_linkId);
	}
	
	/**
	 * Returns the result of the query as a UpdateQueryResult.
	 * 
	 * @return object UpdateQueryResult
	 * @access public
	 * @date 7/1/04
	 */
	function & returnAsUpdateQueryResult () {
		return new MySQLUpdateQueryResult($this->_linkId);
	}
	
	/**
	 * Returns the result of the query as a DeleteQueryResult.
	 * 
	 * @return object DeleteQueryResult
	 * @access public
	 * @date 7/1/04
	 */
	function & returnAsDeleteQueryResult () {
		return new MySQLDeleteQueryResult($this->_linkId);
	}
}

?>