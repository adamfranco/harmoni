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
 * @version $Id: FontSizeSP.class.php,v 1.1 2004/07/26 23:23:31 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

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