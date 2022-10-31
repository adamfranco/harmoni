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
 * @version $Id: FontFamilySP.class.php,v 1.5 2006/06/02 15:56:07 cws-midd Exp $
 */
class FontFamilySP extends StyleProperty {

	/**
	 * The constructor. All parameters but family and family could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string family The font family.
	 **/
	function __construct($family) {
		parent::__construct("font-family", "Font Family", "This property sets the font family.");

		if (!is_null($family)) $this->addSC(new FontFamilySC($family));
	}

}

?>