<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FontWeightSC.class.php");

/**
 * The FontWeightSP represents the 'font-weight' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 * @version $Id: FontWeightSP.class.php,v 1.1 2004/07/26 23:23:31 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FontWeightSP extends StyleProperty {

	/**
	 * The constructor. All parameters but weight and weight could be null, 
	 * in which case they will not be taken in consideration.
	 * @access public
	 * @param string weight The font weight.
	 **/
	function FontWeightSP($weight) {
		$this->StyleProperty("font-weight", "Font Weight", "This property sets the font weight.");

		$this->addSC(new FontWeightSC($weight));
	}

}

?>