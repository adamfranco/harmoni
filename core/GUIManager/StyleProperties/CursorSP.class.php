<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/CursorSC.class.php");

/**
 * The CursorSP represents the 'cursor' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 * @version $Id: CursorSP.class.php,v 1.1 2004/07/19 23:59:51 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class CursorSP extends StyleProperty {

	/**
	 * The constructor. All parameters could be <code>null</code> and if so will be
	 * ignored.
	 * @access public
	 * @param string value This is the value of the property.
	 **/
	function CursorSP($value) {
		$this->StyleProperty("cursor", "Cursor", "Specifies the cursor type.");
		$this->addSC(new CursorSC($value));
	}

}

?>