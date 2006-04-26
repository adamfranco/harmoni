<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The MarginBottomSP represents the 'margin-bottom' StyleProperty.
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
 * @version $Id: MarginBottomSP.class.php,v 1.5 2006/04/26 14:21:31 cws-midd Exp $
 */
class MarginBottomSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin.
	 **/
	function MarginBottomSP($length) {
		$this->StyleProperty("margin-bottom", "Bottom Margin", "This property specifies the bottom margin.");
		if (isset($length)) $this->addSC(new LengthSC($length));
	}

}

?>