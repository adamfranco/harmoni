<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/PositionSC.class.php");

/**
 * The PostionSP represents the 'position' StyleProperty.
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
 * @version $Id: PositionSP.class.php,v 1.3 2005/02/07 21:38:16 adamfranco Exp $
 */
class PositionSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the position.
	 **/
	function PositionSP($value) {
		$this->StyleProperty("position", "Position", "This property specifies the position.");
		$this->addSC(new PositionSC($value));
	}

}

?>