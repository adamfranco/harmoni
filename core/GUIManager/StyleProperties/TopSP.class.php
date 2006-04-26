<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AutoLengthSC.class.php");

/**
 * The TopSP represents the 'top' StyleProperty.
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
 * @version $Id: TopSP.class.php,v 1.4 2006/04/26 14:21:31 cws-midd Exp $
 */
class TopSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The distance of from the top of the block .
	 **/
	function TopSP($length) {
		$this->StyleProperty("top", "top", "This property specifies the distance from the top.");
		if (isset($length)) $this->addSC(new AutoLengthSC($length));
	}

}

?>