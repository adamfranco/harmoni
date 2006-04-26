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
 * @version $Id: LineHeightSP.class.php,v 1.5 2006/04/26 14:21:31 cws-midd Exp $
 */
class LineHeightSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The line height value.
	 **/
	function LineHeightSP($value) {
		$this->StyleProperty("line-height", "Line Height", "Specifies the line height.");
		if (isset($value)) $this->addSC(new LineHeightSC($value));
	}

}

?>