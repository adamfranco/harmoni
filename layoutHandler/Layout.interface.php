<?php

require_once(HARMONI."layoutHandler/VisualComponent.interface.php");

/**
 * LayoutInterface defines the methods required of any {@link Layout}.
 *
 * @package harmoni.layout
 * @version $Id: Layout.interface.php,v 1.1 2003/07/15 16:12:18 gabeschine Exp $
 * @copyright 2003 
 **/

class LayoutInterface extends VisualComponent {
	/**
	 * Adds a component required by this layout with index $index and type $type. The class
	 * must specify which components are required, a user then sets them using {@link LayoutInterface::setComponent setComponent()},
	 * and the layout prints them using {@link LayoutInterface::printComponent printComponent()}.
	 * @param integer $index The index number for this layout -- must be unique.
	 * @param string $type The component type. Options are set up by each component class. The string is also the interface name.
	 * @access protected
	 * @return void
	 **/
	function addComponent($index, $type) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>