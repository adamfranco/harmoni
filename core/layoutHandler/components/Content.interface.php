<?php
require_once(HARMONI."layoutHandler/VisualComponent.interface.php");

/**
 * @const string CONTENT The constant defined for a content {@link VisualComponent}, to be used with {@link Layout::addComponent()}.
 * @package harmoni.layout.components
 **/
define("CONTENT","ContentInterface");


/**
 * The Content interface defines what methods are required by any Content {@link VisualComponent}.
 *
 * @package harmoni.interfaces.layout.components
 * @version $Id: Content.interface.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @copyright 2003 
 **/
class ContentInterface extends VisualComponent {
	/**
	 * Sets the content to $contentString.
	 * @param string $contentString The content.
	 * @access public
	 * @return void
	 **/
	function setContent($contentString) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns this component's content.
	 * @access public
	 * @return string The content.
	 **/
	function getContent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>