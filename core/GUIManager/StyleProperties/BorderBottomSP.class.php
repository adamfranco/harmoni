<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BorderStyleSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");

/**
 * The BorderBottomSP represents the 'border-top' StyleProperty.
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
 * @version $Id: BorderBottomSP.class.php,v 1.5 2006/06/02 15:56:07 cws-midd Exp $
 */
class BorderBottomSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string width The width of the border.
	 * @param string style The style of the border.
	 * @param string color The color of the border.
	 **/
	function BorderBottomSP($width, $style, $color) {
		$this->StyleProperty("border-bottom", "Bottom Border", "This property specifies the bottom border.");
		if (!is_null($width)) $this->addSC(new LengthSC($width));
		if (!is_null($style)) $this->addSC(new BorderStyleSC($style));
		if (!is_null($color)) $this->addSC(new ColorSC($color));
	}

}

?>