<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The Row {@link Layout} contains only an arbitrary number of layout components.
 * One child component is printed per row.
 * Useful for building navigation with a menu on top.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Menu object.
 * <li />Index: 1, A Layout object.
 * </ul>
 *
 * @package harmoni.layout.components
 * @version $Id: RowLayout.class.php,v 1.5 2004/03/10 00:10:29 adamfranco Exp $
 * @copyright 2003 
 **/

class RowLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function RowLayout ( $themeWidgetType = BLANK_WIDGET, $themeWidgetIndex = 1 ) {
		$this->setThemeWidgetType($themeWidgetType);
		$this->setThemeWidgetIndex($themeWidgetIndex);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function output(&$theme) {
		$this->verifyComponents();
		
		$childLayouts =& $this->getAllComponents();
		
		// output the table;
		print "\n".$this->_getTabs()."<table border=0 cellpadding=0 cellspacing=0 width=100%>";
		foreach (array_keys($childLayouts) as $i => $key) {
			print "\n".$this->_getTabs()."\t<tr><td valign='".$childLayouts[$key]->getVerticalAlignment()."' align='".$childLayouts[$key]->getHorizontalAlignment()."'>";
			$themeWidget =& $theme->getWidget( $childLayouts[$key]->getThemeWidgetType(), 
											$childLayouts[$key]->getThemeWidgetIndex());
			$themeWidget->output($childLayouts[$key], $theme);
			print "\n".$this->_getTabs()."\t</td></tr>";
		}
		print "\n".$this->_getTabs()."</table>\n";
	}
}

?>