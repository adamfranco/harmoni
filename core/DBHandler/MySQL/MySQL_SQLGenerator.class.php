<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQL_SQLGenerator.class.php,v 1.17 2008/04/25 13:12:09 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/SQLGenerator.interface.php");

/**
 * A MySQLSelectQueryGenerator class provides the tools to build a MySQL query from a Query object.
 *
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQL_SQLGenerator.class.php,v 1.17 2008/04/25 13:12:09 adamfranco Exp $
 */

class MySQL_SQLGenerator extends SQLGeneratorInterface {

	/**
	 * Returns a string representing the SQL query corresonding to the specified Query object.
	 * @param object QueryInterface $query The object from which to generate the SQL string.
	 * @return mixed Either a string (this would be the case, normally) or an array of strings. 
	 * Each string is corresponding to an SQL query.
	 * @static
	 * @access public
	 */
	static function generateSQLQuery(Query $query) {
	
		switch($query->getType()) {
			case INSERT : 
				$result = MySQL_SQLGenerator::generateInsertSQLQuery($query);
				break;
			case UPDATE : 
				$result = MySQL_SQLGenerator::generateUpdateSQLQuery($query);
				break;
			case DELETE : 
				$result = MySQL_SQLGenerator::generateDeleteSQLQuery($query);
				break;
			case SELECT : 
				$result = MySQL_SQLGenerator::generateSelectSQLQuery($query);
				break;
			case GENERIC : 
				$result = MySQL_SQLGenerator::generateGenericSQLQuery($query);
				break;
			default:
				throw new DatabaseException("Unsupported query type.");
		} // switch
		
//		echo "<pre>\n";
//		echo $result;
//		echo "</pre>\n";
		
		return $result;
		
	}


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @access public
	 * @static
	 */
	static function generateGenericSQLQuery(GenericSQLQueryInterface $query) {

		$queries = $query->_sql;

		if (!is_array($queries) || count($queries) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
		else if (count($queries) == 1)
		    return $queries[0];
		else 
			return $queries;
	}



	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @access public
	 * @static
	 */
	static function generateInsertSQLQuery(InsertQueryInterface $query) {

		$sql = "";
	
		if (!$query->_table || count($query->_values) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
	
		$sql .= "INSERT\n  INTO ";
		$sql .= $query->_table;
		if ($query->_columns || $query->_autoIncrementColumn) {
			$sql .= " (";
			
			$columns = $query->_columns;
			
			// include autoincrement column if necessary
			if ($query->_autoIncrementColumn)
				$columns[] = $query->_autoIncrementColumn;
				
		    $sql .= implode(", ", $columns);

			$sql .= ")";
		}
		
		$sql .= "\nVALUES ";

		// process all rows in the $query->_values array
		$allRows = array();
		foreach ($query->_values as $rowOfValues) {
			// make sure that the number of fields matches the number of columns
			if (count($rowOfValues) != count($query->_columns)) {
				$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
				throw new DatabaseException($description);
				return null;
			}
			
			// include autoincrement column if necessary
			if ($query->_autoIncrementColumn)
				$rowOfValues[] = "NULL";
			
			$allRows[] = implode(", ", $rowOfValues);
		}

		$sql .= "(";
		$sql .= implode("),\n       (", $allRows);
		$sql .= ")\n";
			
		return $sql;
	}


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	static function generateUpdateSQLQuery(UpdateQueryInterface $query) {

		$sql = "";
	
		if (!$query->_table || count($query->_columns) == 0 || count($query->_values) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "UPDATE ";
		$sql .= $query->_table;
		$sql .= "\n   SET ";
		
		// make sure that the number of fields matches the number of columns
		if (count($query->_values) != count($query->_columns)) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup: Num values is not equal to Num columns: ".print_r($query->_values, TRUE)." ".print_r($query->_columns, TRUE);
			throw new DatabaseException($description);
			return null;
		}

		$updateExpressions = array(); // will store things like "id = 5" where
									  // "id" was in the _columns array
									  // and "5" was in the _values array
		
		// this loop sticks together _columns and _values
		foreach ($query->_columns as $key => $column)
			$updateExpressions[] = $column." = ".$query->_values[$key];
		
		$sql .= implode(",\n       ", $updateExpressions);
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\n WHERE ";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n   AND ";
							break;
						case _OR :
							$sql .= "\n    OR ";
							break;
						default:
							throw(new Error("Unsupported logical operator!", "DBHandler", true));
					} // switch
				}
				
				$sql .= $condition[0];
			}
		}
		
		$sql .= "\n";
			
		return $sql;
	}


	/**
	 * Returns a string representing the DELETE SQL query corresonding to the Query object.
	 * @return string A string representing the DELETE SQL query corresonding to the Query object.
	 * @static
	 * @access public
	 */
	static function generateDeleteSQLQuery(DeleteQueryInterface $query) {

		$sql = "";
	
		if (!$query->_table) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "DELETE\n  FROM ";
		$sql .= $query->_table;
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\n WHERE ";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n   AND ";
							break;
						case _OR :
							$sql .= "\n    OR ";
							break;
						default:
							throw(new Error("Unsupported logical operator!", "DBHandler", true));
					} // switch
				}
				
				$sql .= $condition[0];
			}
		}

		$sql .= "\n";

		return $sql;
	}



	/**
	 * Returns a string representing the SELECT SQL query corresonding to the Query object.
	 * @return string A string representing the SELECT SQL query corresonding to the Query object.
	 * @access public
	 * @static
	 */
	static function generateSelectSQLQuery(SelectQueryInterface $query) {

		$sql = "";
		
		if (count($query->_columns) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "SELECT ";
		
		// include the DISTINCT keyword, if necessary
		if ($query->_distinct) {
		    $sql .= "DISTINCT\n       ";
		}
		
		// process any aliases
		$columns = array();
		foreach ($query->_columns AS $column) {
			$str = "";
			if ($column[2])
			    $str .= $column[2].".";
			$str .= $column[0];
			if ($column[1]) {
				$str .= " AS ";
			    $str .= $column[1];
			}		
			$columns[] = $str;
		}
		
		// include columns to select
		$sql .= implode(",\n       ", $columns);
		
		// include FROM clause if necessary
		if ($query->_tables) {
			$sql .= "\n  FROM ";

			// include join
			foreach($query->_tables as $key => $table) {
				// depending on join type we are appending:
				// NO_JOIN: ","
				// LEFT_JOIN: "LEFT JOIN"
				// INNER_JOIN: "INNER JOIN"
				// RIGHT_JOIN: "RIGHT JOIN"
				// however, we don't append anything for the first element
				if ($key != 0) {
					switch ($table[1]) {
						case NO_JOIN : 
							$sql .= ",\n       ";
							break;
						case LEFT_JOIN :
							$sql .= "\n  LEFT JOIN ";
							break;
						case INNER_JOIN :
							$sql .= "\n INNER JOIN ";
							break;
						case RIGHT_JOIN :
							$sql .= "\n RIGHT JOIN ";
							break;
						default:
							throw new DatabaseException("Unsupported JOIN type!");				;
					} // switch
				}

				// append table name
				if ($table[0] instanceof SelectQueryInterface)
					$sql .= "\n(\n".self::generateSelectSQLQuery($table[0])."\n)";
				else
					$sql .= $table[0];
				
				// insert the alias if present
				if ($table[3])
				    $sql .= " AS ".$table[3];
				
				// now append join condition
				if ($key != 0 && $table[1] != NO_JOIN && $table[2]) {
					$sql .= " ON ";
					$sql .= $table[2];
				}
			}
		}
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\n WHERE ";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n   AND ";
							break;
						case _OR :
							$sql .= "\n    OR ";
							break;
						default:
							throw new DatabaseException("Unsupported logical operator!");
					} // switch
				}
				
				$sql .= $condition[0];
			}
		}

		
		// include the GROUP BY and HAVING clauses, if necessary
		if ($query->_groupBy) {
			$sql .= "\n GROUP BY\n       ";
			$sql .= implode(",\n       ", $query->_groupBy);
			if ($query->_having) {
				$sql .= "\nHAVING ";
				$sql .= $query->_having;
			}
		}

		// include the ORDER BY clause, if necessary
		if ($query->_orderBy) {
			$sql .= "\n ORDER BY\n       ";
			
			// generate an array for all the columns
			$columns = array();
			foreach($query->_orderBy as $orderBy) {
				$column = $orderBy[0];
				$column .= " ";
				$column .= ($orderBy[1] === ASCENDING) ? "ASC" : "DESC";
				$columns[] = $column;
			}
			$sql .= implode(",\n       ", $columns);
		}
		
		// include the LIMIT clause, if necessary
		if ($query->_startFromRow || $query->_numberOfRows) {
			$sql .= "\n LIMIT ";

			if ($query->_startFromRow) {
				$sql .= $query->_startFromRow - 1;
				$sql .= ", ";
			}

			if ($query->_numberOfRows)
				$sql .= $query->_numberOfRows;
			else
				$sql .= "-1";
		}
		
		$sql .= "\n";
		
		return $sql;
	}
	

}
?>