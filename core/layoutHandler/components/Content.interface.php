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
 * @package harmoni.layout.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Content.interface.php,v 1.4 2005/01/19 21:10:01 adamfranco Exp $
 */
class ContentInterface extends VisualComponent {
	/**
	 * Sets the content to $contentString.
	 * @param string $contentString The content.
	 * @access public
	 * @return void
	 **/
	function setContent($contentString) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns this component's content.
	 * @access public
	 * @return string The content.
	 **/
	function getContent() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
}

?>