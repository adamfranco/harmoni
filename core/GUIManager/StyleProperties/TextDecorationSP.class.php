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
 
 *
 * @package  harmoni.gui.sps
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TextDecorationSP.class.php,v 1.5 2006/06/02 15:56:08 cws-midd Exp $
 */
class TextDecorationSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value specifies the text-decoration property.
	 **/
	function __construct($value) {
		parent::__construct("text-decoration", "Text Decoration", "This property specifies the text decoration.");
		if (!is_null($value)) $this->addSC(new TextDecorationSC($value));
	}

}

?>