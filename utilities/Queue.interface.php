<?php

/**
 * A generic queue of objects. It provides iterator functions next() and hasNext().
 *
 * @version $Id: Queue.interface.php,v 1.8 2003/06/27 02:00:04 dobomode Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class QueueInterface {

	/**
	 * Add an object to the queue.
	 * Add an object to the queue. The queue is automatically rewound at the end.
	 * @param object $object The object to add to the queue.
	 * @access public
	 */
	function add($object) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Clear the queue
	 *
	 * @access public
	 */
	function clear() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * @return object Object at the current position in the queue and increase the position by one.
	 * @access public
	 */
	function next() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * @return boolean Whether there exists an object in the queue at the current position.
	 * @access public
	 */
	function hasNext() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * @return integer The size of the queue
	 * @access public
	 */
	function getSize() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Rewind the queue if it is not reversed
	 * @return boolean True on sucess, false on failure (queue is reversed).
	 * @access public
	 */
	function rewind() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
}


?>
