<?php

/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.interface.php,v 1.3 2003/06/18 21:31:47 adamfranco Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class QueueInterface {

	/**
	 * Adds an object to the queue.
	 *
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add($object) {}

	/**
	 * Clears the queue.
	 *
	 * @access public
	 */
	function clear() {}

	/**
	 * Returns the object at the current position in the queue and increase the position by one.
	 *
	 * @return object [unknown] Object at the current position in the queue.
	 * @access public
	 */
	function next() {}

	/**
	 * Whether there exists an object in the queue at the current position.
	 *
	 * @return boolean True if there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {}
	
	/**
	 * Gets the number of objects in the queue.
	 *
	 * @return integer The size of the queue
	 * @access public
	 */
	function getSize() {}
	
}


?>
