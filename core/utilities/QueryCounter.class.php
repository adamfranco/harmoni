<?

/**
 * Allows you count the number of DB queries from start() to end().
 *
 * @version $Id: QueryCounter.class.php,v 1.1 2003/12/28 01:48:06 gabeschine Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */
 
class QueryCounter {
	var $_start;
	var $_end;
	
	function start() {
		$db =& Services::getService("DBHandler");
		$this->_start = $db->getTotalNumberOfQueries();
	}
	
	function end() {
		$db =& Services::getService("DBHandler");
		$this->_end = $db->getTotalNumberOfQueries();
	}
	
	function count() {		
		return ($this->_end-$this->_start);
	}
}

?>