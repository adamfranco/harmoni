<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/MaxDimensionSC.class.php");

/**
 * The MaxHeightSP represents the 'max-height' StyleProperty.
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
 * @version $Id: MaxHeightSP.class.php,v 1.3 2005/02/07 21:38:16 adamfranco Exp $
 */
class MaxHeightSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the dimension.
	 **/
	function MaxHeightSP($value) {
		$this->StyleProperty("max-height", "Maximum Height", "This property specifies the maximum height.");
		$this->addSC(new MaxDimensionSC($value));
	}

}

?>