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
 * @version $Id: PaddingTopSP.class.php,v 1.6 2006/06/02 15:56:08 cws-midd Exp $
 */
class PaddingTopSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of the padding.
	 **/
	function __construct($length) {
		parent::__construct("padding-top", "Top Padding", "This property specifies the top padding.");
		if (!is_null($length)) $this->addSC(new LengthSC($length));
	}

}

?>