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
 * @version $Id: VerticalMenuLayout.class.php,v 1.5 2004/07/14 20:56:52 dobomode Exp $
 * @copyright 2003 
 **/

class VerticalMenuLayout extends Layout {
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function VerticalMenuLayout ( $themeWidgetType = MENU_WIDGET, $themeWidgetIndex = 1 ) {
		$this->setThemeWidgetType($themeWidgetType);
		$this->setThemeWidgetIndex($themeWidgetIndex);
	}
	
	/**
	 * Adds the "content" for the component in the next open index to $object.
	 * @param integer $index The index number for the component to be set.
	 * @param ref object $object The object that complies to the expected type for $index.
	 * @param optional boolean $valign Constants TOP = 0, CENTER = 1, BOTTOM = 2 define where
	 *			the child object will be aligned.
	 * @param optional boolean $halign Constants LEFT = 0, CENTER = 1, RIGHT = 2 define where
	 *			the child object will be aligned.
	 * @access public
	 * @return void
	 **/
	function addComponent( & $object, $valign = TOP, $halign = LEFT ) {
// 		ArgumentValidator::validate($themeWidgetType, new StringValidatorRule);
// 		ArgumentValidator::validate($themeWidgetIndex, new IntegerValidatorRule);
		
		ArgumentValidator::validate($valign, new StringValidatorRule);
		ArgumentValidator::validate($halign, new StringValidatorRule);
		
		// get the next open index;
		$this->_setComponents[] = NULL;
		end($this->_setComponents);
		$index = key($this->_setComponents);
		
		$rule = new ExtendsValidatorRule(MenuItem);
		if (!$rule->check($object)) {
			unset ($this->_setComponents[$index]);
			throwError(new Error(get_class($this)."::setComponent($index) - Could not set component for index $index because it is not of the required type: ".$this->_registeredComponents[$index],"layout",true));
			return false;
		}
		
		// set this component's level to $this->_level+1
		$object->setLevel($this->_level+1);
		
// 		$object->setThemeWidgetType($themeWidgetType);
 		$object->setThemeWidgetIndex($this->getThemeWidgetIndex());
		$object->setVerticalAlignment($valign);
		$object->setHorizontalAlignment($halign);

		// looks like it's good
		$this->_setComponents[$index] =& $object;
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function output(& $theme) {
		$this->verifyComponents();
		
		$childLayouts =& $this->getAllComponents();
		
		print "\n".$this->getPreSurroundingText();
		
		// output the table;
		print "\n".$this->_getTabs()."<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
		foreach (array_keys($childLayouts) as $i => $key) {
			print "\n".$this->_getTabs()."\t<tr><td valign='".$childLayouts[$key]->getVerticalAlignment()."' align='".$childLayouts[$key]->getHorizontalAlignment()."'>";
			$themeWidget =& $theme->getWidget( $childLayouts[$key]->getThemeWidgetType(), 
											$childLayouts[$key]->getThemeWidgetIndex());
			$themeWidget->output($childLayouts[$key], $theme);
			print "\n".$this->_getTabs()."\t</td></tr>";
		}
		print "\n".$this->_getTabs()."</table>\n";
		
		print "\n".$this->getPostSurroundingText();
	}
}

?>