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
 
 *
 * @package  harmoni.gui.sps
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TextTransformSP.class.php,v 1.2 2005/01/19 21:09:35 adamfranco Exp $
 */
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