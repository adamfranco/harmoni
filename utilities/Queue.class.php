<?php

require_once("Queue.interface.php");

/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.class.php,v 1.4 2003/06/18 21:31:47 adamfranco Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class Queue extends QueueInterface {

	/**
	 * @var array $_queue The queue of objects.
	 * @access private
	 */
	var $_queue;
	
	/**
	 * @var integer $_position The current position in the queue.
	 * @access private
	 */
	var $_position;
	
	/**
	 * The constructor for a Queue.
	 * @access public
	 */
	function Queue(){
		$this->_queue = array();
		$this->_position = 0;
	}

	/**
	 * Adds an object to the queue.
	 *
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add(& $object) {
		$this->_queue[] =& $object;
	}

	/**
	 * Clears the queue.
	 *
	 * @access public
	 */
	function clear() {
		$this->Queue();
	}

	/**
	 * Returns the object at the current position in the queue and increase the position by one.
	 *
	 * @return object [unknown] Object at the current position in the queue.
	 * @access public
	 */
	function & next() {
		$object =& $this->_queue[$this->_position];
		$this->_position++;
		return $object;
	}

	/**
	 * Whether there exists an object in the queue at the current position.
	 *
	 * @return boolean True if there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {
		return ($this->_queue[$this->_position]) ? true : false;
	}
	
	/**
	 * Gets the number of objects in the queue.
	 *
	 * @return integer The size of the queue.
	 * @access public
	 */
	function getSize() {
		return count($this->_queue);
	}
	
}


?>