<?php

require_once(HARMONI."utilities/Queue.interface.php");
/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.class.php,v 1.13 2003/06/27 02:00:04 dobomode Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class Queue extends QueueInterface {

	/**
	 * An array used to store the elements of the queue.
	 * An array used to store the elements of the queue.
	 * @var array $_queue An array used to store the elements of the queue.
	 */
	var $_queue;

	/**
	 * The position in the array of the next element of the queue that will be returned when next() is called.
	 * The position in the array of the next element of the queue that will be returned when next() is called.
	 * @var integer $_nextPosition The position in the array of the next element of the queue that will be returned when next() is called.
	 */
	var $_nextPosition;

	/**
	 * The start position of the queue in the array.
	 * The start position of the queue in the array. In a reversed queue, this
	 * would be the last element of the array. In a normal queue, this would equal
	 * zero.
	 * @var integer $_startPosition The start position of the queue in the array.
	 */
	var $_startPosition;

	/**
	 * The order of extraction from the queue.
	 * Indicates whether the order in which objects are extracted from the queue 
	 * is FIFO ($_reversed = false) or FILO ($_reversed = true).
	 * 
	 * @var boolean $_reversed TRUE, if the queue is reversed.
	 */
	var $_reversed;
	

	/**
     * Create a new Queue
	 * 
	 * @param boolean $reversed The order of extraction from the queue.
	 * @access public
	 */
	function Queue($reversed = false){
		$this->_reversed = $reversed;
		$this->clear();
	}

	
	
	/**
	 * Clear the queue
	 *
	 * @access public
	 */
	function clear() {
		$this->_queue = array();
		
		// these will be set correctly when the first element gets added		
		$this->_startPosition = null;
		$this->_nextPosition = null;
	}

	
	
	/**
	 * Add an object to the queue.
	 * Add an object to the queue. The queue is automatically rewound at the end.
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add(& $object) {
		$this->_queue[] =& $object;

		// if we just inserted the first element in the queue, then reset the position indices
		if ($this->getSize() == 1) {
			$this->_startPosition = 0;
			if ($this->_reversed)
				$this->_nextPosition = 0;
			else
				$this->_nextPosition = 0;
		}
		// if the inserted element is not the first, then just adjust _startPosition if
		// the queue is reversed
		elseif ($this->_reversed)
			$this->_startPosition++;

		// when adding a new element, the queue is automatically rewound
		$this->rewind();
	}

	
	/**
	 * @return object Object at the current position in the queue and increase the position by one.
	 * @access public
	 */
	function & next() {
		// get next element
		$object =& $this->_queue[$this->_nextPosition];

		if($this->_reversed)
			$this->_nextPosition--; 
		else
			$this->_nextPosition++;
			
		return $object;
	}

	/**
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {
		return (isset($this->_queue[$this->_nextPosition])) ? true : false;
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
		$this->_nextPosition = $this->_startPosition;
	}
}


?>