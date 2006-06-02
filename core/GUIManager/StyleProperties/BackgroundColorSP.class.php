<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");

/**
 * The BackgroundColorSP represents the 'background-color' StyleProperty.
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
 * @version $Id: BackgroundColorSP.class.php,v 1.6 2006/06/02 15:56:07 cws-midd Exp $
 */
class BackgroundColorSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundColorSP($value=null) {
		$this->StyleProperty("background-color", "Background Color", "This property specifies the background color.");
		if (!is_null($value)) $this->addSC(new ColorSC($value));
	}

}

?>