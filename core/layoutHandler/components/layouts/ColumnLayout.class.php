<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The Column {@link Layout} contains only an arbitrary number of layout components.
 * One child component is printed per row.
 * Useful for building navigation with a menu on top.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Menu object.
 * <li />Index: 1, A Layout object.
 * </ul>
 *
 * @package harmoni.layout.components
 * @version $Id: ColumnLayout.class.php,v 1.1 2004/02/28 00:00:58 adamfranco Exp $
 * @copyright 2003 
 **/

class ColumnLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function ColumnLayout($numCols = 1) {
		for ($i = 0; $i < $numCols; $i++) {
			$this->addComponent($i,LAYOUT);
		}
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function outputLayout(&$theme) {
		$this->verifyComponents();
		
		$childLayouts =& $this->getAllComponents();
		
		// output the table;
		print "\n<table border=0 cellpadding=0 cellspacing=0 width=100%><tr>";
		foreach (array_keys($childLayouts) as $i => $key) {
			print "\n<td align=center>\n";
			$childLayouts[$key]->output($theme);
			print "\n</td>";
		}
		print "\n</tr></table>\n";
	}
}

?>