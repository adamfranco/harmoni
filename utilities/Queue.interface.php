<?php

/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.interface.php,v 1.2 2003/06/16 22:07:29 adamfranco Exp $
 * @copyright 2003 
 */

class QueueInterface {

	/**
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add($object) {}

	/**
	 * Clear the queue
	 *
	 * @access public
	 */
	function clear() {}

	/**
	 * @return object Object at the current position in the queue and increase the position by one.
	 * @access public
	 */
	function next() {}

	/**
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() {}
	
	/**
	 * @return integer The size of the queue
	 * @access public
	 */
	function getSize() {}
	
}


?>
