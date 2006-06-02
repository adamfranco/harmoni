<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AutoLengthSC.class.php");

/**
 * The BottomSP represents the 'bottom' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 *
 * @package harmoni.gui.sps
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BottomSP.class.php,v 1.6 2006/06/02 15:56:07 cws-midd Exp $
 */
class BottomSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The distance of from the bottom of the block .
	 **/
	function BottomSP($length) {
		$this->StyleProperty("bottom", "bottom", "This property specifies the distance from the bottom.");
		if (!is_null($length)) $this->addSC(new AutoLengthSC($length));
	}

}

?>