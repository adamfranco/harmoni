<?php

require_once(HARMONI."debugHandler/DebugItem.interface.php");

/**
 * the DebugItem class holds debug text, a detail level and a category.
 *
 * @version $Id: DebugItem.class.php,v 1.1 2003/06/23 23:59:40 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugHandler
 **/

class DebugItem extends DebugItemInterface {
	
	/**
	 * @var int $_level The debug detail level.
	 * @access private
	 **/
	var $_level;
	
	/**
	 * @var int $_category The debug category.
	 * @access private
	 **/
	var $_category;

	/**
	 * @var int $_text The debug text.
	 * @access private
	 **/
	var $_text;
	
	/**
	 * The constructor.
	 * 
	 * @access public
	 * @return void
	 **/
	function DebugItem( $text, $level=5, $category="general" ) {
		$this->_text = $text;
		$this->_category = $category;
		$this->_level = $level;
	}
	
	/**
	 * Returns the level (0-9) of the debug text.
	 * 
	 * @access public
	 * @return int The debug level.
	 **/
	function getLevel() {
		return $this->_level;
	}
	/**
	 * Returns the category of the debug text.
	 * 
	 * @access public
	 * @return string The category.
	 **/
	function getCategory() {
		return $this->_category;
	}
	
	/**
	 * Returns the DebugItem's text.
	 * 
	 * @access public
	 * @return string The text.
	 **/
	function getText() {
		return $this->_text;
	}
}

?>