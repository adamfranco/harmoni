<?php

/**
 * Allows you to time with microtime() from start() to end().
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Timer.class.php,v 1.5.2.1 2008/04/07 19:28:22 adamfranco Exp $
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
	
	/**
	 * Answer a float of the time spent
	 * 
	 * @return float
	 * @access public
	 * @since 4/7/08
	 */
	public function getTime () {
		return $this->printTime();
	}
}

?>