<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontSizeSC.class.php");

/**
 * The FontSizeSP represents the 'font-size' StyleProperty.
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
 * @version $Id: FontSizeSP.class.php,v 1.3 2005/02/07 21:38:16 adamfranco Exp $
 */
class FontSizeSP extends StyleProperty {

	/**
	 * The constructor. All parameters but size and family could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string size The font size.
	 **/
	function FontSizeSP($size) {
		$this->StyleProperty("font-size", "Font Size", "This property sets the current font size.");

		$this->addSC(new FontSizeSC($size));
	}

}

?>