<?php

require_once(HARMONI."GUIManager/Layout.interface.php");

/**
 * <code>FlowLayout</code> is the most simple <code>Layout</code>; it renders a 
 * container by simply rendering all of the container's components. The width, height,
 * and alignment options of the container and its components are ignored. No special 
 * arranging is done, and it is up to the browser or user to display the components properly. 
 * <br /><br />
 * Contrary to what one might think, this could be a very useful <code>Layout</code>. 
 * For eaxmple, it could be used to display components that are just 
 * <code>div</code> elements with aboslute positioning.
 * <br /><br />
 * Layouts are assigned to Containers and they specify how (in terms of location, 
 * not appearance) the sub-<code>Components</code> are going to be rendered on the screen.
 *
 * @package harmoni.gui.layouts
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FlowLayout.class.php,v 1.7 2007/09/04 20:25:22 adamfranco Exp $
 */
class FlowLayout extends LayoutInterface {

	/**
	 * The constructor.
	 * @access public
	 **/
	function __construct() {
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
	function render($container, $theme, $tabs = "") {
		// now output each component of the given container
		$components =$container->getComponents();
		foreach (array_keys($components) as $key) {
			$component =$components[$key];
			$component->render($theme, $tabs."\t");
		}
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