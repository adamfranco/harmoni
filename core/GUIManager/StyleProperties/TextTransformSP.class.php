<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextTransformSC.class.php");

/**
 * The TextTransform represents the 'text-transform' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: TextTransformSP.class.php,v 1.1 2004/07/21 17:09:51 tjigmes Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class TextTransformSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value specifies the text-transformation property.
	 **/
	function TextTransformSP($value) {
		$this->StyleProperty("text-transform", "Text Transformation", "This property specifies the text transformation.");
		$this->addSC(new TextTransformSC($value));
	}

}

?>