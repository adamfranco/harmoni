<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BorderStyleSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");

/**
 * The BorderSP represents the 'border' StyleProperty.
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
 * @version $Id: BorderSP.class.php,v 1.6 2005/02/07 21:38:16 adamfranco Exp $
 */
class BorderSP extends StyleProperty {

	/**
	 * The constructor. All parameters could be <code>null</code> and if so will be
	 * ignored.
	 * @access public
	 * @param string width The width of the border.
	 * @param string style The style of the border.
	 * @param string color The color of the border.
	 **/
	function BorderSP($width, $style, $color) {
		$this->StyleProperty("border", "Border", "This property specifies all four borders at once.");
		if (isset($width)) $this->addSC(new LengthSC($width));
		if (isset($style)) $this->addSC(new BorderStyleSC($style));
		if (isset($color)) $this->addSC(new ColorSC($color));
	}

}

?>