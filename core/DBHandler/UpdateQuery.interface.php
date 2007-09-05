<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQuery.interface.php,v 1.7 2007/09/05 21:38:59 adamfranco Exp $
 */
 
require_once("Query.interface.php");	


/**
 * An UpdateQuery interface provides the tools to build an SQL UPDATE query.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQuery.interface.php,v 1.7 2007/09/05 21:38:59 adamfranco Exp $
 */

interface UpdateQueryInterface 
	extends Query 
{

	/**
	 * Sets the table to update.
	 * @param string $table The table to update.
	 * @access public
	 */
	function setTable($table);

	/**
	 * Sets the columns to update in the table.
	 * @param array $table The columns to update in the table.
	 * @access public
	 */
	function setColumns($columns) ;

	/**
	 * Specifies the values that the will be assigned to the columns specified with setColumns().
	 *
	 * @param array The values that the will be assigned to the columns specified with setColumns().
	 * @access public
	 */
	function setValues($values) ;

	/**
	 * *Deprecated* Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string The WHERE clause condition.
	 * @access public
	 * @deprecated July 09, 2003 - Use addWhere() instead.
	 */
	function setWhere($condition) ;

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
	function addWhere($condition, $logicalOperation = _AND) ;

}
?>