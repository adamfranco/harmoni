<?php

require_once(HARMONI."DBHandler/DeleteQueryResult.interface.php");

/**
 * The DeleteQueryResult interface provides the functionality common to all Delete query results.
 *
 * The DeleteQueryResult interface provides the functionality common to all Delete query results.
 * For example, you can get the primary key for the last Deleteion, get number of Deleteed rows, etc.
 * @version $Id: OracleDeleteQueryResult.class.php,v 1.4 2005/03/29 19:44:08 adamfranco Exp $
 * @package harmoni.dbc.oracle
 * @access public
 * @copyright 2003 
 */

class OracleDeleteQueryResult extends DeleteQueryResultInterface {

	/**
	 * The resource id for this query.
	 * @var integer __resourceId 
	 * @access private
	 */
	var $_resourceId;


	/**
	 * Stores the number of rows processed by the query.
	 * Stores the number of rows processed by the query.
	 * @var integer $_numberOfRows The number of rows processed by the query.
	 * @access private
	 */
	var $_numberOfRows;


	/**
	 * The constructor.
	 * @access public
	 * @param integer $resourceId The resource id for this query.
	 */
	function OracleDeleteQueryResult($resourceId) {
		// ** parameter validation
		$resourceRule =& ResourceValidatorRule::getRule();
		ArgumentValidator::validate($resourceId, $resourceRule, true);
		// ** end of parameter validation

		$this->_resourceId = $resourceId;
		
		$this->_numberOfRows = pg_affected_rows($this->_resourceId);
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