<?php

require_once(HARMONI."GUIManager/Layout.interface.php");
require_once(HARMONI."GUIManager/StyleCollection.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");

/**
 * The <code>TableLayout</code> renders components sequentially in rows that contain
 * the specifed number of columns. They are a replacement for HTML tables in that
 * they allow the same effect while rendering their component elements.
 *
 * Layouts are assigned to Containers and they specify how (in terms of location, 
 * not appearance) the sub-<code>Components</code> are going to be rendered on the screen.
 *
 * @package harmoni.gui.layouts
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TableLayout.class.php,v 1.2.2.2 2006/09/18 14:51:19 adamfranco Exp $
 */
class TableLayout 
	extends LayoutInterface 
{

	/**
	 * The constructor.
	 *
	 * @param integer $numberOfColumns
	 * @access public
	 **/
	function TableLayout( $numberOfColumns, $tdStyles = null ) {
		ArgumentValidator::validate($numberOfColumns, IntegerValidatorRule::getRule());
		
		$this->_numColumns = $numberOfColumns;
		$this->_tdStyles = $tdStyles;
		$this->_renderDirection ='Left-Right/Top-Bottom';
	}
	
	/**
	 * Set the direction of component rendering from the default of Left-Right/Top-Bottom.
	 * Allowed values:
	 *		Left-Right/Top-Bottom
	 *		Top-Bottom/Left-Right
	 * 		Right-Left/Top-Bottom
	 *		Top-Bottom/Right-Left
	 *
	 * The other possible directions, listed below, are not implemented due to
	 * lack of utility:
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
			'Top-Bottom/Right-Left'));
		
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
		
		// extra tdStyles (not themed)
		if ($this->_tdStyles)
			$tdStyles = "style='".$this->_tdStyles."'";
		else
			$tdStyles = '';
		
		
		// Get the components
		$components =& $container->getComponents();
		
		// Get the cell order, a mapping between the cells in the table
		// and the original component order, as based on the flow direction
		// of this layout, i.e Left-Right/Top-Bottom or Top-Bottom/Left-Right
		$cellOrder = $this->_getCellOrder(count($components));
		$numElements = count($cellOrder);
		
		// Go through each cell in the table
		for ($i = 0; $i < $numElements; $i++) {
			$key = $cellOrder[$i];
			
			// if there isn't a component for that index
			// render a blank table cell
			if (!isset($components[$key])) {
				echo $tabs."\t<td $tdStyles>\n";
				echo $tabs."\t</td>\n";
			} 
			
			// otherwise render the component in a table cell
			else {
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
				echo $tabs."\t<td $width$height$halign$valign$tdStyles>\n";
				$component->render($theme, $tabs."\t\t");
				echo $tabs."\t</td>\n";
			}
			
			// Print the table-row divisions if we've reached the end of a row.
			if (($i+1) < $numElements
				&& (($i+1) % $this->_numColumns) == 0)
			{
				echo $tabs."\t</tr>\n";
				echo $tabs."\t<tr>\n";
			}
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
	
	/**
	 * Return an array mapping the order of the cells .
	 * 
	 * @param int $numComponents
	 * @return array
	 * @access public
	 * @since 8/18/06
	 */
	function _getCellOrder ($numComponents) {
		// The $order is an array the keys
		// are the new positions, the values are the
		// old position.
		$order = array();
		$numCols = $this->_numColumns;
		$numRows = ceil($numComponents/$numCols);
		
		switch ($this->_renderDirection) {
			
			// Top-Bottom/Left-Right
			case 'Top-Bottom/Left-Right':
				$tmpRows = array();
				for ($i = 0; $i < ($numRows * $numCols); $i++) {
	 				$row = $i % $numRows;
	 				if (!isset($tmpRows[$row]))
	 					$tmpRows[$row] = array();
	 				$tmpRows[$row][] = $i;
	 			}
	 				 			
	 			foreach ($tmpRows as $row) {
	 				foreach ($row as $i)
	 					$order[] = $i;
	 			}
				
				break;
			
			// Right-Left/Top-Bottom
			case 'Right-Left/Top-Bottom':
				$tmpRows = array();
				$i = 0;
				for ($row = 0; $row < $numRows; $row++) {
					$tmpRows[$row] = array();
	 				for ($col = $numCols - 1; $col >= 0; $col--) {
	 					$tmpRows[$row][$col] = $i;
	 					$i++;
	 				}
	 				ksort($tmpRows[$row]);
	 			}
	 				 			
	 			foreach ($tmpRows as $row) {
	 				foreach ($row as $i)
	 					$order[] = $i;
	 			}
	 			
				break;
			
			// Top-Bottom/Right-Left
			case 'Top-Bottom/Right-Left':
				$tmpRows = array();
				for ($i = 0; $i < ($numRows * $numCols); $i++) {
	 				$row = $i % $numRows;
	 				if (!isset($tmpRows[$row]))
	 					$tmpRows[$row] = array();
	 				$tmpRows[$row][] = $i;
	 			}
	 				 			
	 			foreach ($tmpRows as $row) {
	 				krsort($row);
	 				foreach ($row as $i)
	 					$order[] = $i;
	 			}
	 			
	 			break;
			
			
			// Left-Right/Top-Bottom
			default:
				for ($i = 0; $i < ($numRows * $numCols); $i++)
					$order[] = $i;
		}
		
		return $order;
	}
}

?>