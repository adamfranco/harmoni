<?php

require_once(HARMONI."DBHandler/classes/SelectQuery.abstract.php");

/**
 * A MySQLSelectQuery class provides the tools to build a MySQL SELECT query.
 *
 * @version $Id: MySQLSelectQuery.class.php,v 1.1 2003/06/24 20:56:25 gabeschine Exp $
 * @package harmoni.dbhandler
 * @copyright 2003 
 */

class MySQLSelectQuery extends SelectQuery {
	
	/**
	 * The constructor initializes the query object.
	 * 
	 * The constructor initializes the query object.
	 * @access public
	 */
	function MySQLSelectQuery() {
		$this->reset();
	}

	/**
	 * Returns a string representing the SQL query corresonding to this Query object.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @access public
	 */
	function generateSQLQuery() {
		$sql = "";
		
		if (count($this->_columns) == 0)
			return "Exception";
			
		$sql .= "SELECT";
		
		// include the DISTINCT keyword, if necessary
		if ($this->_distinct) {
		    $sql .= " DISTINCT";
		}
		
		$sql .= "\n\t";
		
		// include columns to select
		$sql .= implode(",\n\t", $this->_columns);
		
		// include FROM clause if necessary
		if ($this->_tables) {
			$sql .= "\nFROM";

			// include join
			foreach($this->_tables as $key => $table) {
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
		if ($this->_condition) {
			$sql .= "\nWHERE\n\t";
			$sql .= $this->_condition;
		}
		
		// include the GROUP BY and HAVING clauses, if necessary
		if ($this->_groupBy) {
			$sql .= "\nGROUP BY\n\t";
			$sql .= implode(",\n\t", $this->_groupBy);
			if ($this->_having) {
				$sql .= "\nHAVING\n\t";
				$sql .= $this->_having;
			}
		}

		// include the ORDER BY clause, if necessary
		if ($this->_orderBy) {
			$sql .= "\nORDER BY\n\t";
			$sql .= implode(",\n\t", $this->_orderBy);
			if ($this->_orderByDirection) {
				$sql .= "\n\t";
				$sql .= ($this->_orderByDirection == ASCENDING) ? "ASC" : "DESC";
			}
		}
		
		// include the LIMIT clause, if necessary
		if ($this->_startFromRow || $this->_limitNumberOfRows) {
			$sql .= "\nLIMIT\n\t";

			if ($this->_startFromRow) {
				$sql .= $this->_startFromRow - 1;
				$sql .= ", ";
			}

			if ($this->_numberOfRows)
				$sql .= $this->_numberOfRows;
			else
				$sql .= "-1";
		}
		
		$sql .= "\n";
		
		return $sql;
	}

}
?>