<?php

require_once(HARMONI."/utilities/DBE.interface.php");

/**
 * HarmoniFunctionDBE allows for updating Function fields in a database.
 * @version $Id: HarmoniFunctionDBE.class.php,v 1.1 2004/03/11 22:43:28 dobomode Exp $
 * @package oki.authorization
 * @author Dobo Radichkov
 * @copyright 2004 Dobo Radichkov
 * @access public
 **/

class HarmoniFunctionDBE extends DBE {


	/**
	 * The index of the database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;
	
	
	/**
	 * The name of the table that stores all authorizatoin Functions.
	 * @attribute private string _table
	 */
	var $_table;
	
	
	/**
     * Constructor
     * @access protected
     */
	function HarmoniFunctionDBE($dbIndex, $table) {
		// ** argument validation **
		$rule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $rule, true);
		$rule =& new StringValidatorRule();
		ArgumentValidator::validate($table, $rule, true);
		// ** end of argument validation **
		
		$this->_dbIndex = $dbIndex;
		$this->_table = $table;
	}
	
}

?>