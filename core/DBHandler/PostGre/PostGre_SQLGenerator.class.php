<?php
/**
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGre_SQLGenerator.class.php,v 1.10 2007/09/05 21:39:01 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/SQLGenerator.interface.php");

/**
 * A PostGreQueryGenerator class provides the tools to build a PostGre query from a Query object.
 *
 *
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGre_SQLGenerator.class.php,v 1.10 2007/09/05 21:39:01 adamfranco Exp $
 */

class PostGre_SQLGenerator extends SQLGeneratorInterface {

	/**
	 * Returns a string representing the SQL query corresonding to the specified Query object.
	 * @param object QueryInterface $query The object from which to generate the SQL string.
	 * @return mixed Either a string (this would be the case, normally) or an array of strings. 
	 * Each string is corresponding to an SQL query.
	 * @static
	 * @access public
	 */
	function generateSQLQuery(Query $query) {
		switch($query->getType()) {
			case INSERT : 
				return PostGre_SQLGenerator::generateInsertSQLQuery($query);
				break;
			case UPDATE : 
				return PostGre_SQLGenerator::generateUpdateSQLQuery($query);
				break;
			case DELETE : 
				return PostGre_SQLGenerator::generateDeleteSQLQuery($query);
				break;
			case SELECT : 
				return PostGre_SQLGenerator::generateSelectSQLQuery($query);
				break;
			case GENERIC : 
				return MySQL_SQLGenerator::generateGenericSQLQuery($query);
				break;
			default:
				throw new DatabaseException("Unsupported query type.");
		} // switch
	}

	


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @access public
	 * @static
	 */
	function generateGenericSQLQuery(GenericSQLQueryInterface $query) {

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
	function generateInsertSQLQuery(InsertQueryInterface $query) {
		if (!$query->_table || count($query->_values) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
		
		$count = count($query->_values);
		$queries = array();
		
		for ($row = 0; $row < $count; $row++) {
			$sql = "";
			$sql .= "INSERT INTO ";
			$sql .= $query->_table;
			if ($query->_columns || $query->_autoIncrementColumn) {
				$sql .= "\n\t(";
				
				$columns = $query->_columns;
				
				// include autoincrement column if necessary
				if ($query->_autoIncrementColumn)
					$columns[] = $query->_autoIncrementColumn;
					
			    $sql .= implode(", ", $columns);

				$sql .= ")";
			}
			
			$sql .= "\n\tVALUES";
			$rowOfValues = $query->_values[$row];
			
			// make sure that the number of fields matches the number of columns
			if (count($rowOfValues) != count($query->_columns)) {
				$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
				throw new DatabaseException($description);
				return null;
			}
			
			// include autoincrement column if necessary
			if ($query->_autoIncrementColumn)
				$rowOfValues[] = "NEXTVAL('".$query->_sequence."')";
				
			$values = implode(", ", $rowOfValues);
	
			$sql .= "(";
			$sql .= $values;
			$sql .= ")\n";
			
			$queries[] = $sql;
		}
		
		if (count($queries) == 1)
		    return $queries[0];
		else 
			return $queries;
	}


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	function generateUpdateSQLQuery(UpdateQueryInterface $query) {
		$sql = "";
	
		if (!$query->_table || count($query->_columns) == 0 || count($query->_values) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "UPDATE ";
		$sql .= $query->_table;
		$sql .= "\nSET\n\t";
		
		// make sure that the number of fields matches the number of columns
		if (count($query->_values) != count($query->_columns)) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}

		$updateExpressions = array(); // will store things like "id = 5" where
									  // "id" was in the _columns array
									  // and "5" was in the _values array
		
		// this loop sticks together _columns and _values
		foreach ($query->_columns as $key => $column)
			$updateExpressions[] = $column." = ".$query->_values[$key];
		
		$sql .= implode(",\n\t", $updateExpressions);
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\nWHERE";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n\t\tAND";
							break;
						case _OR :
							$sql .= "\n\t\tOR";
							break;
						default:
							throw(new Error("Unsupported logical operator!", "DBHandler", true));				;
					} // switch
				}
				
				$sql .= "\n\t";
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
	function generateDeleteSQLQuery(DeleteQueryInterface $query) {

		$sql = "";
	
		if (!$query->_table) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup.";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "DELETE\nFROM\n\t";
		$sql .= $query->_table;
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\nWHERE";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n\t\tAND";
							break;
						case _OR :
							$sql .= "\n\t\tOR";
							break;
						default:
							throw(new Error("Unsupported logical operator!", "DBHandler", true));				;
					} // switch
				}
				
				$sql .= "\n\t";
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
	 */
	function generateSelectSQLQuery(SelectQueryInterface $query) {

		$sql = "";
		
		if (count($query->_columns) == 0) {
			$description = "Cannot generate SQL string for this Query object due to invalid query setup; No columns added";
			throw new DatabaseException($description);
			return null;
		}
			
		$sql .= "SELECT";
		
		// include the DISTINCT keyword, if necessary
		if ($query->_distinct) {
		    $sql .= " DISTINCT";
		}
		
		$sql .= "\n\t";
		
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
		$sql .= implode(",\n\t", $columns);
		
		// include FROM clause if necessary
		if ($query->_tables) {
			$sql .= "\nFROM";

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
							$sql .= ",";
							break;
						case LEFT_JOIN :
							$sql .= "\n\t\tLEFT JOIN";
							break;
						case INNER_JOIN :
							$sql .= "\n\t\tINNER JOIN";
							break;
						case RIGHT_JOIN :
							$sql .= "\n\t\tRIGHT JOIN";
							break;
						default:
							throw new DatabaseException("Unsupported JOIN type!");				;
					} // switch
				}

				$sql .= "\n\t";
				
				// append table name
				$sql .= $table[0];
				
				// insert the alias if present
				if ($table[3])
				    $sql .= " AS ".$table[3];
				
				// now append join condition
				if ($key != 0 && $table[1] != NO_JOIN && $table[2]) {
					$sql .= "\n\t\tON ";
					$sql .= $table[2];
				}
			}
		}
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\nWHERE";

			// include join
			foreach($query->_condition as $key => $condition) {
				// we don't append anything for the first element
				if ($key != 0) {
					switch ($condition[1]) {
						case _AND :
							$sql .= "\n\t\tAND";
							break;
						case _OR :
							$sql .= "\n\t\tOR";
							break;
						default:
							throw new DatabaseException("Unsupported logical operator!");				;
					} // switch
				}
				
				$sql .= "\n\t";
				$sql .= $condition[0];
			}
		}
		
		// include the GROUP BY and HAVING clauses, if necessary
		if ($query->_groupBy) {
			$sql .= "\nGROUP BY\n\t";
			$sql .= implode(",\n\t", $query->_groupBy);
			if ($query->_having) {
				$sql .= "\nHAVING\n\t";
				$sql .= $query->_having;
			}
		}

		// include the ORDER BY clause, if necessary
		if ($query->_orderBy) {
			$sql .= "\nORDER BY\n\t";
			
			// generate an array for all the columns
			$columns = array();
			foreach($query->_orderBy as $orderBy) {
				$column = $orderBy[0];
				$column .= " ";
				$column .= ($orderBy[1] === ASCENDING) ? "ASC" : "DESC";
				$columns[] = $column;
			}
			$sql .= implode(",\n\t", $columns);
		}
		
		if ($query->_numberOfRows) {
			$sql .= "\nLIMIT ";
			$sql .= $query->_numberOfRows;
		}

		if ($query->_startFromRow) {
			$sql .= "\nOFFSET ";
			$sql .= $query->_startFromRow - 1;
		}
		
		$sql .= "\n";
		
		return $sql;
	}

}
?>