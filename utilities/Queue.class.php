<?php

require_once(HARMONI."utilities/Queue.interface.php");
/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.class.php,v 1.10 2003/06/25 15:13:48 movsjani Exp $
 * @copyright 2003 
 */

class Queue extends QueueInterface {

	var $_queue;

	var $_position;

	/**
	 * The order of extraction from the queue.
	 * Indicates whether the order in which objects are extracted from the queue 
	 * is FIFO ($_reversed = false) or FILO ($_reversed = true).
	 * 
	 * @var boolean $_reversed   
	 */
	var $_reversed;
	

	/**
     * Create a new Queue
	 * 
	 * @param boolean $reversed The order of extraction from the queue.
	 * @access public
	 */
	function Queue($reversed = false){
		$this->_queue = array();
		$this->_reversed = $reversed;
		($this->_reversed) ? $this->_position = -1 : $this->_position = 0;
	}
	
	/**
	 * Add an object to the queue.
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add(& $object) {
		$this->_queue[] =& $object;
		if ($this->_reversed) $this->_position++;
	}

	/**
	 * Clear the queue
	 *
	 * @access public
	 */
	function clear() {
		$this->Queue();
	}

	/**
	 * @return object Object at the current position in the queue and increase the position by one.
	 * @access public
	 */
	function & next() {
		$object =& $this->_queue[$this->_position];
		if($this->_reversed){
			$this->_position--; 
			array_pop($this->_queue);
		}
		else
			$this->_position++;
		return $object;
	}

	/**
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {
		return ($this->_queue[$this->_position]) ? true : false;
	}
	
	/**
	 * @return integer The size of the queue
	 * @access public
	 */
	function getSize() {
		return count($this->_queue);
	}

	/**
	 * Rewind the queue if it is not reversed
	 * @return boolean True on sucess, false on failure (queue is reversed).
	 * @access public
	 */
	function rewind() { 
		if($this->_reversed)
			return false;
		else{
			$this->_position=0;
			return true;
		}
	}
}


?>