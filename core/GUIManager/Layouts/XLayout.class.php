<?php

require_once(HARMONI."GUIManager/Layout.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * <code>XLayout</code> renders components sequentially and horizontally.
 * <br /><br />
 * Layouts are assigned to Containers and they specify how (in terms of location, 
 * not appearance) the sub-<code>Components</code> are going to be rendered on the screen.
 *
 * @package harmoni.gui.layouts
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: XLayout.class.php,v 1.8 2006/11/30 22:02:02 adamfranco Exp $
 */
class XLayout extends LayoutInterface {

	/**
	 * The constructor.
	 * @access public
	 **/
	function XLayout() {
		$this->_renderDirection ='Left-Right/Top-Bottom';
	}
	
	/**
	 * Set the direction of component rendering from the default of Left-Right/Top-Bottom.
	 * Allowed values:
	 *		Left-Right/Top-Bottom
	 *		Top-Bottom/Left-Right
	 * 		Right-Left/Top-Bottom
	 *		Top-Bottom/Right-Left
	 *		Left-Right/Bottom-Top
	 *		Bottom-Top/Left-Right
	 *		Right-Left/Bottom-Top
	 *		Bottom-Top/Right-Left
	 * 
	 * @param string $direction
	 * @return void
	 * @access public
	 * @since 8/18/06
	 */
	function setRenderDirection ($direction) {
		ArgumentValidator::validate($direction, ChoiceValidatorRule::getRule(
			'Left-Right/Top-Bottom',
			'Top-Bottom/Left-Right',
			'Right-Left/Top-Bottom',
			'Top-Bottom/Right-Left',
			'Left-Right/Bottom-Top',
			'Bottom-Top/Left-Right',
			'Right-Left/Bottom-Top',
			'Bottom-Top/Right-Left'));
		
		$this->_renderDirection = $direction;			
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
		if (ereg('Right-Left', $this->_renderDirection))
			$keys = array_reverse(array_keys($components));
		else
			$keys = array_keys($components);
		
		foreach ($keys as $key) {
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
			echo "\n".$tabs."\t</td>\n";
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