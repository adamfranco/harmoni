<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/WhiteSpaceSC.class.php");

/**
 * The WhiteSpaceSP represents the 'white-space' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: WhiteSpaceSP.class.php,v 1.1 2004/07/21 17:09:51 tjigmes Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class WhiteSpaceSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the white space.
	 **/
	function WhiteSpaceSP($value) {
		$this->StyleProperty("white-space", "White Space", "This property specifies the white space.");
		$this->addSC(new WhiteSpaceSC($value));
	}

}

?>