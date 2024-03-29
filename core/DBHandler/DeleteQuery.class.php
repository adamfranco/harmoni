<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DeleteQuery.class.php,v 1.8 2007/09/05 21:38:59 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/DeleteQuery.interface.php");
require_once("Query.abstract.php");	

/**
 * A DeleteQuery class provides the tools to build a DELETE query.
 * 
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DeleteQuery.class.php,v 1.8 2007/09/05 21:38:59 adamfranco Exp $
 */

class DeleteQuery 
	extends QueryAbstract
	implements DeleteQueryInterface 
{


	/**
	 * @var string $_table The name of the table to update.
	 * @access private
	 */
	var $_table;

	
	/**
	 * This will store the condition in the WHERE clause. Each element of this
	 * array stores 2 things: the condition itself, and the logical operator
	 * to use to join with the previous condition.
	 * @var array $_condition The condition in the WHERE clause.
	 * @access private
	 */
	var $_condition;

	
	/**
	 * This is the constructor for a DELETE query.
	 * This is the constructor for a DELETE query.
	 * @access public
	 */
	function __construct() {
		$this->reset();
	}


	/**
	 * Sets the table to delete from.
	 * @param string $table The table to delete from.
	 * @access public
	 */
	function setTable($table) {
		// ** parameter validation
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($table, $stringRule, true);
		// ** end of parameter validation

		$this->_table = $table;
	}


	/**
	 * *Deprecated* Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string The WHERE clause condition.
	 * @access public
	 * @deprecated July 09, 2003 - Use addWhere() instead.
	 */
	function setWhere($condition) {
		// ** parameter validation
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation

		$arr = array();
		$arr[] = $condition;
		$arr[] = null;
		
		$this->_condition[] = $arr;
	}


	/**
	 * Adds a new condition in the WHERE clause.
	 * 
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition to add.
	 * @param integer logicalOperation The logical operation to use to connect
	 * this WHERE condition with the previous WHERE conditions. Allowed values:
	 * <code>_AND</code> and <code>_OR</code>. 
	 * @access public
	 * @return void 
	 */
	function addWhere($condition, $logicalOperation = _AND) {
		// ** parameter validation
		$stringRule = StringValidatorRule::getRule();
		$integerRule = IntegerValidatorRule::getRule();
		$optionalRule = OptionalRule::getRule($integerRule);
		ArgumentValidator::validate($condition, $stringRule, true);
		ArgumentValidator::validate($logicalOperation, $optionalRule, true);
		// ** end of parameter validation

		$arr = array();
		$arr[] = $condition;
		$arr[] = $logicalOperation;
		
		$this->_condition[] = $arr;
	}


	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// a DELETE query
		$this->_type = DELETE;
		
		// default query configuration:
		
		// no table to delete from
		$this->_table = "";

		// no WHERE condition, by default
		$this->_condition = array();
	}

}
?>