<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLUtils.static.php,v 1.10 2007/09/11 18:50:28 adamfranco Exp $
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
 * @version $Id: SQLUtils.static.php,v 1.10 2007/09/11 18:50:28 adamfranco Exp $
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
	public static function parseSQLFile ( $file ) {
		$queryString = file_get_contents($file);
		if ($queryString)
			return self::parseSQLString($queryString);
		else
			throw new DatabaseException("The file, '".$file."' was empty or doesn't exist.");
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
	public static function parseSQLString ( $queryString ) {
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
	public static function multiQuery ( $queryString, $dbIndex ) {
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
	public static function runSQLfile ($file, $dbIndex) {
		$string = self::parseSQLFile($file);
		self::multiQuery($string, $dbIndex);
	}
	
	/**
	 * Run all of the files with a given extention in a directory as SQL files.
	 * 
	 * @param string $dir
	 * @param integer $dbIndex The index of the database to run the queries on.
	 * @param optional string $extn The file extention to execute, default: 'sql'.
	 * @return void
	 * @access public
	 * @since 9/11/07
	 */
	public static function runSQLdir ($dir, $dbIndex, $extn = 'sql') {
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$path = $dir."/".$file;
					// Recurse into sub directories
					if (is_dir($path))
						self::runSQLdir($path, $dbIndex, $extn);
					// Run any SQL files
					else if (preg_match('/.+\.'.$extn.'$/i', $file))
						self::runSQLfile($path, $dbIndex);
					// Ignore any other files.
				}
			}
			closedir($handle);
		} else {
			throw new Exception ("Could not open SQL directory, '$dir', for reading.");
		}
	}
}
?>