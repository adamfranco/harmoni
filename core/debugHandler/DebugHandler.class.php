<?php

require_once(HARMONI."debugHandler/DebugItem.class.php");
require_once(HARMONI."debugHandler/DebugHandler.interface.php");

/**
 * The DebugHandler keeps track of multiple DebugItems.
 *
 * @version $Id: DebugHandler.class.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugging
 **/

class DebugHandler extends DebugHandlerInterface {
	/**
	 * @var array $_queue The array of DebugItems.
	 * @access private
	 **/
	var $_queue;
	
	/**
	 * @access private
	 * @var integer $_outputLevel The internal output level.
	 **/
	var $_outputLevel;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function DebugHandler() {
		$this->_queue = array();
		$this->_outputLevel = 9;
	}
	
	/**
	 * Adds debug text to the handler.
	 *
	 * @param mixed $debug Either a string with debug text or a DebugItem object.
	 * @param optional int $level The detail level of the debug text.
	 * @param optional string $category The text category.
	 * @access public
	 * @return void
	 **/
	function add( $debug, $level=5, $category="general") {
		if (is_object($debug))
			$this->_add($debug, debug_backtrace());
		else if (is_string($debug)) {
			$this->_add( new DebugItem($debug, $level, $category), debug_backtrace());
		}
		else
			return "Exception";
	}
	
	/**
	 * Adds a DebugItem to the queue.
	 *
	 * @param object DebugItem $debugItem The DebugItem to add to the queue.
	 * @param optional array $debugBacktrace A DebugBacktrace array.
	 * @access private
	 * @return void
	 **/
	function _add( & $debugItem, $debugBacktrace ) {
		$debugItem->setBacktrace($debugBacktrace);
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
	 * @param optional string $category The category.
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

	/**
	 * Sets the internal output level to $level. This can be overridden at output time.
	 * @param integer $level
	 * @access public
	 * @return void
	 **/
	function setOutputLevel($level) {
		$this->_outputLevel = $level;
	}
	
	/**
	 * Returns the internal output level.
	 * @access public
	 * @return integer
	 **/
	function getOutputLevel() {
		return $this->_outputLevel;
	}

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
	
}

?>