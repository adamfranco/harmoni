<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextSpacingSC.class.php");

/**
 * The LetterSpacingSP represents the 'letter-spacing' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: LetterSpacingSP.class.php,v 1.1 2004/07/21 17:09:51 tjigmes Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class LetterSpacingSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin, but CANNOT be in % format.
	 **/
	function LetterSpacingSP($length) {
		$this->StyleProperty("letter-spacing", "Letter Spacing", "This property specifies the letter spacing.");
		$this->addSC(new TextSpacingSC($length));
	}

}

?>