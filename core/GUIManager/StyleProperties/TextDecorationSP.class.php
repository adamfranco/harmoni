<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextDecorationSC.class.php");

/**
 * The TextTransform represents the 'text-decoration' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: TextDecorationSP.class.php,v 1.1 2004/07/26 23:23:31 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class TextDecorationSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value specifies the text-decoration property.
	 **/
	function TextDecorationSP($value) {
		$this->StyleProperty("text-decoration", "Text Decoration", "This property specifies the text decoration.");
		$this->addSC(new TextDecorationSC($value));
	}

}

?>