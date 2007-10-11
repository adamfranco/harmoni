<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.abstract.php,v 1.7 2007/10/11 13:45:17 adamfranco Exp $
 */
require_once(HARMONI."DBHandler/Query.interface.php");

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Query.abstract.php,v 1.7 2007/10/11 13:45:17 adamfranco Exp $
 */

abstract class QueryAbstract 
	extends SObject
	implements Query
{ 

	/**
	 * The type of the query.
	 * The type of the query. Allowed values: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * var integer $_type The type of the query.
	 */ 
	var $_type;

	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		$this->_type = UNKNOWN;
	}
	
	/**
	 * Returns the type of this query.
	 * Returns the type of this query: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * @access public
	 * @return integer The type of this query: SELECT, INSERT, DELETE, or UPDATE.
	 */
	function getType() {
		return $this->_type;	
	}
	
	/**
	 * Answer a safe SQL column string
	 * 
	 * @param string $column
	 * @return string
	 * @access public
	 * @since 3/9/07
	 */
	function cleanColumn ( $column ) {
		if (!preg_match('/^[a-z0-9_\.]+$/i', $column))
			throw new DatabaseException("Invalid SQL column, '".$column."'");
		return $column;
	}
	
	/**
	 * Add a comparison where the value is NOT quoted or escaped
	 * 
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		if (!preg_match('/[!=><]{1,3}/', $comparison))
			throw new DatabaseException("Invalid SQL comparison, '".$comparison."'");
		
		$this->addWhere(
			$this->cleanColumn($column)
				.$comparison
				.$value, 
			$logicalOperation);
	}
	
	/**
	 * Add a comparison where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		$this->addWhereRawComparison(
			$column, 
			"'".addslashes($value)."'",
			$comparison, 
			$logicalOperation);
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLike ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhere(
			$this->cleanColumn($column).' LIKE '.$value, 
			$logicalOperation);
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLike ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawLike(
			$column, 
			"'".addslashes($value)."'",
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '!=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThan ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '<', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '>', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '<=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereComparison($column, $value, '>=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '!=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThan ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '<', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '>', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '<=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		$this->addWhereRawComparison($column, $value, '>=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IS NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNull ( $column, $logicalOperation = _AND ) {
		$this->addWhere(
			$this->cleanColumn($column)." IS NULL",
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IS NOT NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotNull ( $column, $logicalOperation = _AND ) {
		$this->addWhere(
			$this->cleanColumn($column)." IS NOT NULL", 
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereIn ( $column, array $values, $logicalOperation = _AND ) {
		$tmp = array();
		foreach ($values as $value) {
			$tmp[] = "'".addslashes($value)."'";
		}
		$string = $this->cleanColumn($column)." IN (";
		$string .= implode(", ", $tmp);
		$string .= ")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotIn ( $column, array $values, $logicalOperation = _AND ) {
		$tmp = array();
		foreach ($values as $value) {
			$tmp[] = "'".addslashes($value)."'";
		}
		$string = $this->cleanColumn($column)." NOT IN (";
		$string .= implode(", ", $tmp);
		$string .= ")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawIn ( $column, array $values, $logicalOperation = _AND ) {
		$string = $this->cleanColumn($column)." IN (";
		$string .= implode(", ", $values);
		$string .= ")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotIn ( $column, array $values, $logicalOperation = _AND ) {
		$string = $this->cleanColumn($column)." NOT IN (";
		$string .= implode(", ", $values);
		$string .= ")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Answer a string representation of the query.
	 * 
	 * @param int $dbIndex
	 * @return string
	 * @access public
	 * @since 7/10/07
	 */
	function asString ($dbIndex = 0) {
		$dbc = Services::getService('DBHandler');
		return $dbc->generateSQL($this, $dbIndex);
	}
}

?>