<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextAlignSC.class.php");

/**
 * The TextAlign represents the 'text-align' StyleProperty.
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
 * @version $Id: TextAlignSP.class.php,v 1.2 2005/01/19 21:09:35 adamfranco Exp $
 */
class TextAlignSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value: left, center, right, justify.
	 **/
	function TextAlignSP($value) {
		$this->StyleProperty("text-align", "Text Alignment", "This property specifies the text alignment.");
		$this->addSC(new TextAlignSC($value));
	}

}

?>