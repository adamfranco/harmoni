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
 * @version $Id: FontFamilySP.class.php,v 1.1 2004/07/26 23:23:31 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

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