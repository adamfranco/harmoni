<?php

require_once(HARMONI."debugHandler/DebugItem.class.php");
require_once(HARMONI."debugHandler/DebugHandler.interface.php");

/**
 * The DebugHandler keeps track of multiple DebugItems.
 *
 * @version $Id: DebugHandler.class.php,v 1.3 2003/06/25 14:34:23 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugHandler
 **/

class DebugHandler extends DebugHandlerInterface {
	/**
	 * @var array $_queue The array of DebugItems.
	 * @access private
	 **/
	var $_queue;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function DebugHandler() {
		$this->_queue = array();
	}
	
	/**
	 * Adds debug text to the handler.
	 *
	 * @param mixed $debug Either a string with debug text or a DebugItem object.
	 * @param int [$level] (optional) The detail level of the debug text.
	 * @param string [$category] (optional) The text category.
	 * @access public
	 * @return void
	 **/
	function add( $debug, $level=5, $category="general") {
		if (is_object($debug))
			$this->_add($debug);
		else if (is_string($debug)) {
			$this->_add( new DebugItem($debug, $level, $category));
		}
		else
			return "Exception";
	}
	
	/**
	 * Adds a DebugItem to the queue.
	 *
	 * @param object DebugItem $debugItem The DebugItem to add to the queue.
	 * @access private
	 * @return void
	 **/
	function _add( & $debugItem ) {
		$this->_queue[] = & $debugItem;
	}
	
	/**
	 * Returns the number of DebugItems registered.
	 * 
	 * @access public
	 * @return int The DebugItem count.
	 **/
	function getDebugItemCount() {
		return count($this->_queue);
	}
	
	/**
	 * Returns an array of DebugItems, optionally limited to category $category.
	 * 
	 * @param string [$category] (optional) The category.
	 * @access public
	 * @return array The array of DebugItems.
	 **/
	function & getDebugItems( $category="" ) {
		$array = array();
		for ($i = 0; $i < $this->getDebugItemCount(); $i++) {
			if ($category == "" || $this->_queue[$i]->getCategory() == $category)
				$array[] = &$this->_queue[$i];
		}
		return $array;
	}
}

?>