<?php

require_once(HARMONI."GUIManager/Layout.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * <code>XLayout</code> renders components sequentially and horizontally.
 * <br><br>
 * Layouts are assigned to Containers and they specify how (in terms of location, 
 * not appearance) the sub-<code>Components</code> are going to be rendered on the screen.
 * @version $Id: XLayout.class.php,v 1.3 2004/07/26 23:23:31 dobomode Exp $
 * @package harmoni.gui.layouts
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class XLayout extends LayoutInterface {

	/**
	 * The constructor.
	 * @access public
	 **/
	function XLayout() {
	}
	

	/**
	 * Lays out and renders the given container and its components. The Layout 
	 * object should arrange the <code>Components</code> in a well-defined manner 
	 * and then call the <code>render()</code> methods of each individual component.
	 * @access public
	 * @param ref object The container to render.
	 * @param ref object theme The Theme object to use in producing the result
	 * of this method.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 **/
	function render(& $container, & $theme, $tabs = "") {
		// print html for container (a table)
		echo $tabs."<table width=\"100%\" border=\"0\" cellpadding=\"0px\" cellspacing=\"0px\">\n";
		echo $tabs."\t<tr>\n";
		
		// Get the components
		$components =& $container->getComponents();
		foreach (array_keys($components) as $key) {
			$component =& $components[$key];
			
			// width and height of the component
			$width = $height = "";
			$width = $container->getComponentWidth($key + 1);
			$height = $container->getComponentHeight($key + 1);
			if (isset($width)) $width = " width=\"$width\"";
			if (isset($height)) $height = " height=\"$height\"";

			// include halign and valign
			$halign = $valign = "";
			switch ($container->getComponentAlignmentX($key + 1)) {
				case LEFT: $halign = " align=\"left\""; break;
				case CENTER: $halign = " align=\"center\""; break;
				case RIGHT: $halign = " align=\"right\""; break;
			}
			switch ($container->getComponentAlignmentY($key + 1)) {
				case TOP: $valign = " valign=\"top\""; break;
				case CENTER: $valign = " valign=\"middle\""; break;
				case BOTTOM: $valign =  " valign=\"bottom\""; break;
			}
			
			// render the component in separate table cell
			echo $tabs."\t<td $width$height$halign$valign>\n";
			$component->render($theme, $tabs."\t\t");
			echo $tabs."\t</td>\n";
		}

		echo $tabs."\t</tr>\n";
		echo $tabs."</table>\n";
	}
	
	/**
	 * Returns any CSS code that might be needed in order for this <code>Layout</code>
	 * to render properly.
	 * @access public
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 * @return string The CSS code that might be needed in order for this <code>Layout</code>
	 * to render properly.
	 **/
	function getCSS($tabs = "") {
		return "";
	}
	
}

?>