<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/DirectionSC.class.php");

/**
 * The DirectionSP represents the 'direction' StyleProperty.
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
 * @version $Id: DirectionSP.class.php,v 1.2 2005/01/19 21:09:34 adamfranco Exp $
 */
class DirectionSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the direction property.
	 **/
	function DirectionSP($value) {
		$this->StyleProperty("direction", "Direction", "This property specifies the text direction.");
		$this->addSC(new DirectionSC($value));
	}

}

?>