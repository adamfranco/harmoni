<?php

require_once(HARMONI."DBHandler/UpdateQueryResult.interface.php");

/**
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 *
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 * For example, you can get the primary key for the last UPDATEion, get number of UPDATEed rows, etc.
 * @version $Id: OracleUpdateQueryResult.class.php,v 1.4 2005/03/29 19:44:08 adamfranco Exp $
 * @package harmoni.dbc.oracle
 * @access public
 * @copyright 2003 
 */

class OracleUpdateQueryResult extends UpdateQueryResultInterface {



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
	function OracleUpdateQueryResult($resourceId) {
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