<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The topmenu {@link Layout} contains only a menu and another layout component. 
 * Useful for building navigation with a menu on top.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Menu object.
 * <li />Index: 1, A Layout object.
 * </ul>
 *
 * @package harmoni.layout.components
 * @version $Id: TopMenuLayout.class.php,v 1.4 2003/07/25 00:53:43 gabeschine Exp $
 * @copyright 2003 
 **/

class TopMenuLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function TopMenuLayout() {
		$this->addComponent(0,MENU);
		$this->addComponent(1,LAYOUT);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @access public
	 * @return void
	 **/
	function outputLayout(&$theme, $level) {
		$this->verifyComponents();
		
		$menu =& $this->getComponent(0);
		$layout =& $this->getComponent(1);
		
		// output the table;
		print "<table border=0 cellpadding=0 cellspacing=0 width=100%>\n";
		print "<tr><td align=center>\n";
		$menu->output($theme, $level+1, HORIZONTAL);
		print "</td></tr>\n<tr><td>\n";
		$layout->output($theme, $level+1);
		print "</td></tr>\n";
		print "</table>\n";
	}
}

?>