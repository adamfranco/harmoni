<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AutoLengthSC.class.php");

/**
 * The BottomSP represents the 'bottom' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: BottomSP.class.php,v 1.2 2004/07/22 16:31:55 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copybottom 2004 Middlebury College, ETS
 * @access public
 **/

class BottomSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The distance of from the bottom of the block .
	 **/
	function BottomSP($length) {
		$this->StyleProperty("bottom", "bottom", "This property specifies the distance from the bottom.");
		$this->addSC(new AutoLengthSC($length));
	}

}

?>