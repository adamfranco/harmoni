<?php

require_once("Queue.interface.php");
/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.class.php,v 1.2 2003/06/16 22:07:29 adamfranco Exp $
 * @copyright 2003 
 */

class Queue extends QueueInterface {

	var $_queue;
	var $_position;
	
	function Queue(){
		$this->_queue = array();
		$this->_position = 0;
	}

	/**
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add(& $object) {
		$this->_queue[] =& $object;
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
		$this->_position++;
		return $object;
	}

	/**
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {
		return ($this->_queue[$this->_position])?true:false;
	}
	
	/**
	 * @return integer The size of the queue
	 * @access public
	 */
	function getSize() {
		return count($this->_queue);
	}
	
}


?>