<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FloatSC.class.php");

/**
 * The FloatSP represents the 'float' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: FloatSP.class.php,v 1.1 2004/07/21 17:09:51 tjigmes Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class FloatSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of float.
	 **/
	function FloatSP($value) {
		$this->StyleProperty("float", "Float", "This property specifies the float value.");
		$this->addSC(new FloatSC($value));
	}

}

?>