<?php

/**
 * A SQLGeneratorInterface interface is the parent of all SQLGenerator objects.
 * A SQLGeneratorInterface interface declares only one method, namely
 * generateSQLQuery(), which takes a query object as a parameter. The method
 * returns the SQL string representation of that query object - thus, a SQLGenerator.
 * @version $Id: SQLGenerator.interface.php,v 1.1 2003/06/24 20:56:26 gabeschine Exp $
 * @package harmoni.dbhandler
 * @access public
 * @copyright 2003 
 */

class SQLGeneratorInterface { 

	/**
	 * Returns a string representing the SQL query corresonding to the specified Query object.
	 * @param object QueryInterface $query The object from which to generate the SQL string.
	 * @return string A string representing the SQL query corresonding to this Query object.
	 * @static
	 * @access public
	 */
	function generateSQLQuery($query) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	
}

?>