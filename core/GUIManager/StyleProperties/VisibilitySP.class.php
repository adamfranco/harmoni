<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/VisibilitySC.class.php");

/**
 * The VisibilitySP represents the 'visibility' StyleProperty.
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
 * @version $Id: VisibilitySP.class.php,v 1.2 2005/01/19 21:09:35 adamfranco Exp $
 */
class VisibilitySP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin.
	 **/
	function VisibilitySP($value) {
		$this->StyleProperty("visibility", "Visibility", "This property specifies the visibility.");
		$this->addSC(new VisibilitySC($value));
	}

}

?>