<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/LengthSC.class.php");

/**
 * The MarginTopSP represents the 'margin-top' StyleProperty.
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
 * @version $Id: MarginTopSP.class.php,v 1.4 2005/02/07 21:38:16 adamfranco Exp $
 */
class MarginTopSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin.
	 **/
	function MarginTopSP($length) {
		$this->StyleProperty("margin-top", "Top Margin", "This property specifies the top margin.");
		$this->addSC(new LengthSC($length));
	}

}

?>