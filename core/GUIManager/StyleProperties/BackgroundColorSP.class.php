<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");

/**
 * The BackgroundColorSP represents the 'background-color' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: BackgroundColorSP.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BackgroundColorSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundColorSP($value) {
		$this->StyleProperty("background-color", "Background Color", "This property specifies the background color.");
		$this->addSC(new ColorSC($value));
	}

}

?>