<?php

require_once(HARMONI."DBHandler/Query.interface.php");

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 * @version $Id: Query.abstract.php,v 1.1 2003/08/14 19:26:28 gabeschine Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class Query extends QueryInterface { 

	/**
	 * The type of the query.
	 * The type of the query. Allowed values: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * var integer $_type The type of the query.
	 */ 
	var $_type;

	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		$this->_type = UNKNOWN;
	}
	
	/**
	 * Returns the type of this query.
	 * Returns the type of this query: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * @access public
	 * @return integer The type of this query: SELECT, INSERT, DELETE, or UPDATE.
	 */
	function getType() {
		return $this->_type;	
	}
	
}

?>