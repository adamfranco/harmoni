<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The PaddingLeftSP represents the 'padding-left' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: PaddingLeftSP.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class PaddingLeftSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of padding.
	 **/
	function PaddingLeftSP($length) {
		$this->StyleProperty("padding-left", "Left Padding", "This property specifies the left padding.");
		$this->addSC(new LengthSC($length));
	}

}

?>