<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/OverflowSC.class.php");

/**
 * The OverflowSP represents the 'overflow' StyleProperty.
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
 * @version $Id: OverflowSP.class.php,v 1.3 2005/01/19 21:09:35 adamfranco Exp $
 */
class OverflowSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of overflow.
	 **/
	function OverflowSP($value) {
		$this->StyleProperty("overflow", "overflow", "This property specifies the overflow.");
		$this->addSC(new OverflowSC($value));
	}

}

?>