<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontFamilySC.class.php");

/**
 * The FontFamilySP represents the 'font-family' StyleProperty.
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
 * @version $Id: FontFamilySP.class.php,v 1.2 2005/01/19 21:09:34 adamfranco Exp $
 */
class FontFamilySP extends StyleProperty {

	/**
	 * The constructor. All parameters but family and family could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string family The font family.
	 **/
	function FontFamilySP($family) {
		$this->StyleProperty("font-family", "Font Family", "This property sets the font family.");

		$this->addSC(new FontFamilySC($family));
	}

}

?>