<?php
require_once(HARMONI."layoutHandler/components/Content.interface.php");

/**
 * The Content interface defines what methods are required by any Content {@link VisualComponent}.
 *
 * @package harmoni.layout.components
 * @version $Id: Content.class.php,v 1.6 2003/07/25 00:53:43 gabeschine Exp $
 * @copyright 2003 
 **/
class Content extends ContentInterface {
	/**
	 * @access private
	 * @var string $_content The content.
	 **/
	var $_content;
	
	/**
	 * The constructor.
	 * @param optional string $content The content to put in this object.
	 * @access public
	 * @return void
	 **/
	function Content( $content="" ) {
		$this->_content = $content;
	}
	
	
	/**
	 * Sets the content to $contentString.
	 * @param string $contentString The content.
	 * @access public
	 * @return void
	 **/
	function setContent($contentString) {
		$this->_content = $contentString;
	}
	
	/**
	 * Returns this component's content.
	 * @access public
	 * @return string The content.
	 **/
	function getContent() {
		return $this->_content;
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output(&$theme, $level=0, $orientation=HORIZONTAL) {
		$theme->printContent($this,$level);
	}
}

?>