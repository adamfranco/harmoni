<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/OverflowSC.class.php");

/**
 * The OverflowSP represents the 'overflow' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: OverflowSP.class.php,v 1.2 2004/07/22 16:31:55 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class OverflowSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of overflow.
	 **/
	function OverflowSP($value) {
		$this->StyleProperty("overflow", "overflow", "This property specifies the overflow.");
		$this->addSC(new OverflowSC($value));
	}

}

?>