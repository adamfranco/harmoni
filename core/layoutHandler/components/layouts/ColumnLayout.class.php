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
 * @version $Id: ColumnLayout.class.php,v 1.6 2004/03/11 16:02:47 adamfranco Exp $
 * @copyright 2003 
 **/

class ColumnLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function ColumnLayout ( $themeWidgetType = BLANK_WIDGET, $themeWidgetIndex = 1 ) {
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
		print "\n".$this->_getTabs()."<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
		foreach (array_keys($childLayouts) as $i => $key) {
			print "\n".$this->_getTabs()."\t<td valign='".$childLayouts[$key]->getVerticalAlignment()."' align='".$childLayouts[$key]->getHorizontalAlignment()."'>";
			$themeWidget =& $theme->getWidget( $childLayouts[$key]->getThemeWidgetType(), 
											$childLayouts[$key]->getThemeWidgetIndex());
			$themeWidget->output($childLayouts[$key], $theme);
			print "\n".$this->_getTabs()."\t</td>";
		}
		print "\n".$this->_getTabs()."</tr></table>\n";
	}
}

?>