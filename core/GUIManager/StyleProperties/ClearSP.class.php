<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ClearSC.class.php");

/**
 * The ClearSP represents the 'clear' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: ClearSP.class.php,v 1.1 2004/07/21 17:09:51 tjigmes Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class ClearSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of clear.
	 **/
	function ClearSP($value) {
		$this->StyleProperty("clear", "Clear", "This property specifies the clear value.");
		$this->addSC(new ClearSC($value));
	}

}

?>