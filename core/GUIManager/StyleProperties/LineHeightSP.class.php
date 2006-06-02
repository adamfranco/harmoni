<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LineHeightSC.class.php");

/**
 * The LineHeightSP represents the 'line-height' StyleProperty.
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
 * @version $Id: LineHeightSP.class.php,v 1.6 2006/06/02 15:56:07 cws-midd Exp $
 */
class LineHeightSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The line height value.
	 **/
	function LineHeightSP($value) {
		$this->StyleProperty("line-height", "Line Height", "Specifies the line height.");
		if (!is_null($value)) $this->addSC(new LineHeightSC($value));
	}

}

?>