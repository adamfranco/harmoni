<?

/**
 * Allows you count the number of DB queries from start() to end().
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: QueryCounter.class.php,v 1.3 2005/04/04 18:24:12 adamfranco Exp $
 */
class QueryCounter {
	var $_start;
	var $_end;
	
	function start() {
		$db =& Services::getService("DatabaseManager");
		$this->_start = $db->getTotalNumberOfQueries();
	}
	
	function end() {
		$db =& Services::getService("DatabaseManager");
		$this->_end = $db->getTotalNumberOfQueries();
	}
	
	function count() {		
		return ($this->_end-$this->_start);
	}
}

?>