<?php

require_once(HARMONI."DBHandler/SQLGenerator.interface.php");

/**
 * A MySQLSelectQueryGenerator class provides the tools to build a MySQL SELECT query from a SelectQuery object.
 * A MySQLSelectQueryGenerator class provides the tools to build a MySQL SELECT query from a SelectQuery object.
 *
 * @version $Id: MySQL_SQLGenerator.class.php,v 1.3 2003/06/26 15:24:20 dobomode Exp $
 * @package harmoni.dbhandler
 * @copyright 2003 
 */

class MySQL_SQLGenerator extends SQLGeneratorInterface {

	/**
	 * Returns a string representing the SQL query corresonding to the specified Query object.
	 * @param object QueryInterface $query The object from which to generate the SQL string.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	function generateSQLQuery(& $query) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("QueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		// ** end of parameter validation

		switch($query->getType()) {
			case INSERT : 
				return MySQL_SQLGenerator::generateInsertSQLQuery($query);
				break;
			case UPDATE : 
				return MySQL_SQLGenerator::generateUpdateSQLQuery($query);
				break;
			case DELETE : 
				return MySQL_SQLGenerator::generateDeleteSQLQuery($query);
				break;
			case SELECT : 
				return MySQL_SQLGenerator::generateSelectSQLQuery($query);
				break;
			default:
				return "Exception";
		} // switch
	}


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @access public
	 * @static
	 */
	function generateInsertSQLQuery(& $query) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("InsertQueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		// ** end of parameter validation

		$sql = "";
	
		if (!$query->_table || count($query->_columns) == 0 || count($query->_values) == 0)
			return "Exception";
	
		$sql .= "INSERT INTO ";
		$sql .= $query->_table;
		$sql .= "\n\t(";
		$sql .= implode(", ", $query->_columns);
		$sql .= ")\n\tVALUES";

		// process all rows in the $query->_values array
		$allRows = array();
		foreach ($query->_values as $rowOfValues) {
			// make sure that the number of fields matches the number of columns
			if (count($rowOfValues) != count($query->_columns))
			    return "Exception";
			$allRows[] = implode(", ", $rowOfValues);
		}

		$sql .= "(";
		$sql .= implode("), (", $allRows);
		$sql .= ")\n";
			
		return $sql;
	}


	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	function generateUpdateSQLQuery(& $query) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("UpdateQueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		// ** end of parameter validation

		$sql = "";
	
		if (!$query->_table || count($query->_columns) == 0 || count($query->_values) == 0)
			return "Exception";
			
		$sql .= "UPDATE ";
		$sql .= $query->_table;
		$sql .= "\nSET\n\t";
		
		// make sure that the number of fields matches the number of columns
		if (count($query->_values) != count($query->_columns))
		    return "Exception";

		$updateExpressions = array(); // will store things like "id = 5" where
									  // "id" was in the _columns array
									  // and "5" was in the _values array
		
		// this loop sticks together _columns and _values
		foreach ($query->_columns as $key => $column)
			$updateExpressions[] = $column." = ".$query->_values[$key];
		
		$sql .= implode(",\n\t", $updateExpressions);
		
		// include WHERE condition, if necessary
		if ($query->_condition)
		    $sql .= "\nWHERE\n\t".$query->_condition;
		
		$sql .= "\n";
			
		return $sql;
	}


	/**
	 * Returns a string representing the DELETE SQL query corresonding to the Query object.
	 * @return string A string representing the DELETE SQL query corresonding to the Query object.
	 * @static
	 * @access public
	 */
	function generateDeleteSQLQuery(& $query) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("DeleteQueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		// ** end of parameter validation

		$sql = "";
	
		if (!$query->_table)
			return "Exception";
			
		$sql .= "DELETE\nFROM\n\t";
		$sql .= $query->_table;
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\nWHERE\n\t";
			$sql .= $query->_condition;
		}
		
		$sql .= "\n";

		return $sql;
	}



	/**
	 * Returns a string representing the SELECT SQL query corresonding to the Query object.
	 * @return string A string representing the SELECT SQL query corresonding to the Query object.
	 * @access public
	 */
	function generateSelectSQLQuery(& $query) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("SelectQueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		// ** end of parameter validation

		$sql = "";
		
		if (count($query->_columns) == 0)
			return "Exception";
			
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
						default:;
					} // switch
				}

				$sql .= "\n\t";
				
				// append table name
				$sql .= $table[0];
				
				// now append join condition
				if ($table[1] != NO_JOIN && $table[2]) {
					$sql .= "\n\t\tON ";
					$sql .= $table[2];
				}
			}
		}
		
		// include the WHERE clause, if necessary
		if ($query->_condition) {
			$sql .= "\nWHERE\n\t";
			$sql .= $query->_condition;
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
		
		// include the LIMIT clause, if necessary
		if ($query->_startFromRow || $query->_limitNumberOfRows) {
			$sql .= "\nLIMIT\n\t";

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