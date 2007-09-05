<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: InsertQuery.interface.php,v 1.5 2007/09/05 21:38:59 adamfranco Exp $
 */
require_once("Query.interface.php");

/**
 * An InsertQuery interface provides the tools to build an SQL INSERT query.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: InsertQuery.interface.php,v 1.5 2007/09/05 21:38:59 adamfranco Exp $
 */

interface InsertQueryInterface 
	extends Query 
{

	/**
	 * Sets the table to insert into.
	 * @param string $table The table to insert into.
	 * @access public
	 */
	function setTable($table) ;

	/**
	 * Sets the columns to insert into the table.
	 * @param array $table The columns to insert into the table.
	 * @access public
	 */
	function setColumns($columns) ;

	/**
	 * Adds one row of values to insert into the table.
	 * 
	 * By calling this method multiple times, you can insert many rows of
	 * information using just one query.
	 * @param array $values One row of values to insert into the table. Must
	 * match the order of columns specified with the setColumns() method.
	 * @access public
	 */
	function addRowOfValues($values) ;
	
	/**
	 * This is an alias for addRowOfValues for compatability with the UpdateQuery class.
	 * Adds one row of values to insert into the table. 
	 * By calling this method multiple times, you can insert many rows of
	 * information using just one query.
	 * @see InsertQueryInterface::addRowOfValues 
	 * @param array $values One row of values to insert into the table. Must
	 * match the order of columns specified with the setColumns() method.
	 * @access public
	 */
	function setValues($values) ;

	/**
	 * Sets the autoincrement column.
	 * Sets the autoincrement column. This could be useful with Oracle, for example.
	 * Do not include this column with the setColumns() method - it will be added
	 * automatically.
	 * @param string $column The autoincrement column.
	 * @param string $sequence The sequence to use for generating new ids.
	 * @access public
	 */ 
	function setAutoIncrementColumn($column, $sequence) ;

}
?>