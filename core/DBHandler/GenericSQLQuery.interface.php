<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GenericSQLQuery.interface.php,v 1.4 2005/04/07 16:33:23 adamfranco Exp $
 */
require_once("Query.abstract.php");


/**
 * A GenericSQLQuery provides a way to specify the SQL string manually. Use this
 * query type to execute queries not available through the other Query
 * objects (for example, data-definition queries).
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GenericSQLQuery.interface.php,v 1.4 2005/04/07 16:33:23 adamfranco Exp $
 */

class GenericSQLQueryInterface extends Query {


	/**
	 * Adds one SQL string to this query.
	 * @access public
	 * @param string sql One SQL string,
	 * @return void 
	 */
	function addSQLQuery($sql) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	
}
?>