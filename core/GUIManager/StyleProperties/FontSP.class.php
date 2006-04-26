<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontStyleSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontVariantSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontWeightSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontSizeSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontFamilySC.class.php");

/**
 * The FontSP represents the 'font' StyleProperty.
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
 * @version $Id: FontSP.class.php,v 1.6 2006/04/26 14:21:31 cws-midd Exp $
 */
class FontSP extends StyleProperty {

	/**
	 * The constructor. All parameters but size and family could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string family The font family.
	 * @param string size The font size.
	 * @param optional string style The font style.
	 * @param optional string weight The font weight.
	 * @param optional string variant The font variant.
	 **/
	function FontSP($family, $size, $style, $weight, $variant) {
		$this->StyleProperty("font", "Font", "This property sets the current 
											  font family, size, style, weight,
											  variant.");

		if (isset($style)) $this->addSC(new FontStyleSC($style));
		if (isset($variant)) $this->addSC(new FontVariantSC($variant));
		if (isset($weight)) $this->addSC(new FontWeightSC($weight));
		if (isset($size)) $this->addSC(new FontSizeSC($size));
		if (isset($family)) $this->addSC(new FontFamilySC($family));
	}

}

?>