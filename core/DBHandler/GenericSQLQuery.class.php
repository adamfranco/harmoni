<?php

require_once("GenericSQLQuery.interface.php");


/**
 * A GenericSQLQuery provides a way to specify the SQL string manually. Use this
 * query type to execute queries not available through the other Query
 * objects (for example, data-definition queries).
 *
 * @version $Id: GenericSQLQuery.class.php,v 1.4 2005/01/19 23:21:34 adamfranco Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class GenericSQLQuery extends GenericSQLQueryInterface {


	/**
	 * Stores all the SQL queries.
	 * @var array _sql 
	 * @access private
	 */
	var $_sql;
	
	
	/**
	 * This is the constructor for a GenericSQLQuery object.
	 * @access public
	 */
	function GenericSQLQuery($sql=null) {
		if ($sql) $this->addSQLQuery($sql);
		$this->reset();
	}

	
	/**
	 * Adds one SQL string to this query.
	 * @access public
	 * @param string sql One SQL string,
	 * @return void 
	 */
	function addSQLQuery($sql) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($sql, $stringRule, true);
		// ** end of parameter validation

		$this->_sql[] = $sql;
	}

	
	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// an UPDATE query
		$this->_type = GENERIC;

		// default query configuration:
		
		// no table to insert into
		$this->_sql = array();
	}


}
?>