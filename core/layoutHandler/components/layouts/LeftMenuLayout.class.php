<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The leftmenu {@link Layout} contains only a menu and another layout component. 
 * Useful for building navigation with a menu on the left.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Menu object.
 * <li />Index: 1, A Layout object.
 * </ul>
 *
 * @package harmoni.layout.components
 * @version $Id: LeftMenuLayout.class.php,v 1.2 2004/03/01 15:48:36 adamfranco Exp $
 * @copyright 2003 
 **/

class LeftMenuLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function LeftMenuLayout() {
		$this->addComponent(0,MENU);
		$this->addComponent(1,LAYOUT);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function outputLayout($theme) {
		$this->verifyComponents();
		
		$menu =& $this->getComponent(0);
		$layout =& $this->getComponent(1);
		
		// output the table;
		print "\n".$this->_getTabs()."<table border=0 cellpadding=0 cellspacing=0 width=100%>";
		print "\n".$this->_getTabs()."\t<tr><td width=10% valign=top>";
		$menu->output($theme, VERTICAL);
		print "\n".$this->_getTabs()."\t</td><td>";
		$layout->output($theme);
		print "\n".$this->_getTabs()."\t</td></tr>";
		print "\n".$this->_getTabs()."</table>\n";
	}
}

?>