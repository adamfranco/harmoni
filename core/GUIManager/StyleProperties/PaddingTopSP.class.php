<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The PaddingTopSP represents the 'padding-top' StyleProperty.
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
 * @version $Id: PaddingTopSP.class.php,v 1.5 2006/04/26 14:21:31 cws-midd Exp $
 */
class PaddingTopSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of the padding.
	 **/
	function PaddingTopSP($length) {
		$this->StyleProperty("padding-top", "Top Padding", "This property specifies the top padding.");
		if (isset($length)) $this->addSC(new LengthSC($length));
	}

}

?>