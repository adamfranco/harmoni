<?

/**
 * Allows you to time with microtime() from start() to end().
 *
 * @version $Id: Timer.class.php,v 1.3 2004/07/07 15:09:26 dobomode Exp $
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
		if (!isset($this->_start) || !isset($this->_end)) {
			$err = "Must call start() and end() first.";
			throwError(new Error($err, "Timer", true));
		}
	
		list($sm, $ss) = explode(" ", $this->_start);
		list($em, $es) = explode(" ", $this->_end);
		
		$s = $ss + $sm;
		$e = $es + $em;
		
		return ($e-$s);
	}
}

?>