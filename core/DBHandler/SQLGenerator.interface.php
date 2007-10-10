<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLGenerator.interface.php,v 1.4 2007/10/10 22:58:31 adamfranco Exp $
 */

/**
 * A SQLGeneratorInterface interface is the parent of all SQLGenerator objects.
 * A SQLGeneratorInterface interface declares only one method, namely
 * generateSQLQuery(), which takes a query object as a parameter. The method
 * returns the SQL string representation of that query object - thus, a SQLGenerator.
 * @version $Id: SQLGenerator.interface.php,v 1.4 2007/10/10 22:58:31 adamfranco Exp $
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SQLGenerator.interface.php,v 1.4 2007/10/10 22:58:31 adamfranco Exp $
 */

class SQLGeneratorInterface { 

	/**
	 * Returns a string representing the SQL query corresonding to the specified Query object.
	 * @param object QueryInterface $query The object from which to generate the SQL string.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	static function generateSQLQuery($query) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	
}

?>