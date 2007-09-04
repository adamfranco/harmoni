<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLUtils.static.php,v 1.7 2007/09/04 20:25:18 adamfranco Exp $
 */

/**
 * This is a static class that provides functions for the running of arbitrary
 * SQL strings and files.
 * 
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLUtils.static.php,v 1.7 2007/09/04 20:25:18 adamfranco Exp $
 * @static
 */

class SQLUtils {

	/**
	 * Parse SQL textfile to remove comments and line returns.
	 * 
	 * @param string $file The file to be parsed
	 * @return string The parsed SQL string.
	 * @access public
	 * @since 7/2/04
	 * @static
	 */
	function parseSQLFile ( $file ) {
		$queryString = file_get_contents($file);
		if ($queryString)
			return SQLUtils::parseSQLString($queryString);
		else
			throwError(new Error("The file, '".$file."' was empty or doesn't exist.","DBHandler::SQLUtils",true));
	}
	
	/**
	 * Parse SQL string to remove comments and line returns.
	 * 
	 * @param string $queryString The string to be parsed
	 * @return string The parsed SQL string.
	 * @access public
	 * @since 7/2/04
	 * @static
	 */
	function parseSQLString ( $queryString ) {
		// Remove the comments
		$queryString = ereg_replace("(#|--)[^\n\r]*(\n|\r|\n\r)", "", $queryString);
		
		// Remove the line returns
		$queryString = ereg_replace("\n|\r", " ", $queryString);
		
		// Remove multiple spaces
		$queryString = ereg_replace("\ +", " ", $queryString);
		
		// Remove backticks included by MySQL since they aren't needed anyway.
		$queryString = ereg_replace("`", "", $queryString);
		return $queryString;
	}
	
	/**
	 * Break up a SQL string with multiple queries (separated by ';') and run each
	 * query
	 * 
	 * @param string $queryString The string of queries.
	 * @param integer $dbIndex The database index to run the queries on.
	 * @return void
	 * @access public
	 * @since 7/2/04
	 * @static
	 */
	function multiQuery ( $queryString, $dbIndex ) {
		// break up the query string.
		$queryStrings = explode(";", $queryString);
	
		$dbHandler = Services::getService("DatabaseManager");
		
		// Run each query
		foreach ($queryStrings as $string) {
			$string = trim($string);
			if ($string) {
				$query = new GenericSQLQuery();
				$query->addSQLQuery($string);
				$genericResult =$dbHandler->query($query, $dbIndex);
			}
		}
	}
	
	/**
	 * Run all of the queries in a text file. Comments must start with '#' and
	 * queries must be separated by ';'.
	 * 
	 * @param string $file The input file containing the queries.
	 * @param integer $dbIndex The index of the database to run the queries on.
	 * @return void
	 * @access public
	 * @since 7/2/04
	 * @static
	 */
	function runSQLfile ($file, $dbIndex) {
		$string = SQLUtils::parseSQLFile($file);
		SQLUtils::multiQuery($string, $dbIndex);
	}
}
?>