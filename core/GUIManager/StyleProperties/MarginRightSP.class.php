<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The MarginRightSP represents the 'margin-right' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: MarginRightSP.class.php,v 1.2 2004/07/19 23:59:51 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class MarginRightSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin.
	 **/
	function MarginRightSP($length) {
		$this->StyleProperty("margin-right", "Right Margin", "This property specifies the right margin.");
		$this->addSC(new LengthSC($length));
	}

}

?>