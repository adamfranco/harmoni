<?php

require_once(HARMONI."GUIManager/Layout.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * <code>YLayout</code> renders components sequentially and vertically.
 * <br><br>
 * Layouts are assigned to Containers and they specify how (in terms of location, 
 * not appearance) the sub-<code>Components</code> are going to be rendered on the screen.
 * @version $Id: YLayout.class.php,v 1.1 2004/07/19 23:59:51 dobomode Exp $
 * @package harmoni.gui.layouts
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class YLayout extends LayoutInterface {

	/**
	 * The StyleCollection of this Layout.
	 * @attribute private string _css
	 */
	var $_styleCollection;

	/**
	 * The constructor.
	 * @access public
	 **/
	function YLayout() {
		// initialize some CSS code
		$coll =& new StyleCollection("harmoni-y-layout");
		$coll->addSP(new MarginSP("0px"));
		$coll->addSP(new PaddingSP("0px"));
		$coll->addSP(new BorderSP("0px", null, null));

		$this->_styleCollection =& $coll;
	}
	

	/**
	 * Lays out and renders the given container and its components. The Layout 
	 * object should arrange the <code>Components</code> in a well-defined manner 
	 * and then call the <code>render()</code> methods of each individual component.
	 * @access public
	 * @param ref object The container to render.
	 * @param string tabs This is a string (normally a bunch of tabs) that will be
	 * prepended to each text line. This argument is optional but its usage is highly 
	 * recommended in order to produce a nicely formatted HTML output.
	 **/
	function render($container, $tabs = "") {
		// print html for container (a table)
		echo $tabs."<table cellspacing=\"0px\" class=\"harmoni-x-layout\">\n";
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
				case ALIGNMENT_LEFT: $halign = " align=\"left\""; break;
				case ALIGNMENT_CENTER: $halign = " align=\"center\""; break;
				case ALIGNMENT_RIGHT: $halign = " align=\"right\""; break;
			}
			switch ($container->getComponentAlignmentY($key + 1)) {
				case ALIGNMENT_TOP: $valign = " valign=\"top\""; break;
				case ALIGNMENT_CENTER: $valign = " valign=\"middle\""; break;
				case ALIGNMENT_BOTTOM: $valign =  "valign=\"bottom\""; break;
			}
			
			// render the component in separate table cell
			echo $tabs."\t<tr><td class=\"harmoni-x-layout\"$width$height$halign$valign>\n";
			$component->render($tabs."\t\t");
			echo $tabs."\t</td></tr>\n";
		}

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
		return $this->_styleCollection->getCSS($tabs);
	}
	
}

?>