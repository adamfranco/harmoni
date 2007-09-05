<?php
/**
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGreUpdateQueryResult.class.php,v 1.7 2007/09/05 21:39:01 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/UpdateQueryResult.interface.php");

/**
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 * For example, you can get the primary key for the last UPDATEion, get number of UPDATEed rows, etc.
 *
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGreUpdateQueryResult.class.php,v 1.7 2007/09/05 21:39:01 adamfranco Exp $
 */
class PostGreUpdateQueryResult 
	implements UpdateQueryResultInterface 
{



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
	function PostGreUpdateQueryResult($resourceId) {
		// ** parameter validation
		$resourceRule = ResourceValidatorRule::getRule();
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