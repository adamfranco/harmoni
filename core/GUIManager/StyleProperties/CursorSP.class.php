<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/CursorSC.class.php");

/**
 * The CursorSP represents the 'cursor' StyleProperty.
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
 * @version $Id: CursorSP.class.php,v 1.5 2006/06/02 15:56:07 cws-midd Exp $
 */
class CursorSP extends StyleProperty {

	/**
	 * The constructor. All parameters could be <code>null</code> and if so will be
	 * ignored.
	 * @access public
	 * @param string value This is the value of the property.
	 **/
	function CursorSP($value) {
		$this->StyleProperty("cursor", "Cursor", "Specifies the cursor type.");
		if (!is_null($value)) $this->addSC(new CursorSC($value));
	}

}

?>