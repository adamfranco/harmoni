<?php

//require_once(HARMONI."debugHandler/DebugItem.interface.php");

/**
 * the DebugItem class holds debug text, a detail level and a category.
 *
 * @package harmoni.utilities.debugging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DebugItem.class.php,v 1.3 2005/01/19 21:09:59 adamfranco Exp $
 **/

class DebugItem {
	
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
	 * @access private
	 * @var array $_backtrace
	 **/
	var $_backtrace;
	
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
	
	
	/**
	 * Sets this Item's debug backtrace array.
	 * @param array $backtrace
	 * @access public
	 * @return void
	 **/
	function setBacktrace($backtrace) {
		$this->_backtrace = $backtrace;
	}
	
	/**
	 * Returns the backtrace array.
	 * @access public
	 * @return array
	 **/
	function getBacktrace() {
		return $this->_backtrace;
	}
}

?>