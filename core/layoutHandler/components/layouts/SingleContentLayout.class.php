<?php

require_once(HARMONI."layoutHandler/components/Layout.abstract.php");

/**
 * The single content {@link Layout} contains only one content component. Useful for
 * filling the space in a layout that expects another layout as a component with just
 * some content.
 * <br />
 * Content: <br />
 * <ul><li />Index: 0, A Content object.</ul>
 *
 * @package harmoni.layout.components
 * @version $Id: SingleContentLayout.class.php,v 1.5 2004/04/01 19:22:21 adamfranco Exp $
 * @copyright 2003 
 **/

class SingleContentLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function SingleContentLayout ( $themeWidgetType = BLANK_WIDGET, $themeWidgetIndex = 1 ) {
		$this->addComponentRequirement(0,CONTENT);
		$this->setThemeWidgetType($themeWidgetType);
		$this->setThemeWidgetIndex($themeWidgetIndex);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function output(& $theme) {
		ArgumentValidator::validate($theme, new ExtendsValidatorRule("ThemeInterface"));

		$this->verifyComponents();

		$component =& $this->getComponent(0);
		
		print "\n".$this->getPreSurroundingText();
		
		$themeWidget =& $theme->getWidget( $component->getThemeWidgetType(), 
											$component->getThemeWidgetIndex());
		
		$themeWidget->output($component, $theme);
		
		print "\n".$this->getPostSurroundingText();
	}
}

?>