<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/MaxDimensionSC.class.php");

/**
 * The MaxWidthSP represents the 'min-width' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 *
 * @package  harmoni.gui.sps
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MinWidthSP.class.php,v 1.1 2005/11/21 18:56:47 adamfranco Exp $
 */
class MinWidthSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the dimension.
	 **/
	function MinWidthSP($value) {
		$this->StyleProperty("min-width", "Minimum Width", "This property specifies the minimum width.");
		$this->addSC(new MaxDimensionSC($value));
	}

}

?>