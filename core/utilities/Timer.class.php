<?

/**
 * Allows you to time with microtime() from start() to end().
 *
 * @version $Id: Timer.class.php,v 1.1 2003/12/27 19:56:21 gabeschine Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */
 
class Timer {
	var $_start;
	var $_end;
	
	function start() {
		$this->_start = microtime();
	}
	
	function end() {
		$this->_end = microtime();
	}
	
	function printTime() {
		list($sm, $ss) = explode(" ", $this->_start);
		list($em, $es) = explode(" ", $this->_end);
		
		$s = $ss + $sm;
		$e = $es + $em;
		
		print ($e-$s);
	}
}

?>