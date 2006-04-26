<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/FloatSC.class.php");

/**
 * The FloatSP represents the 'float' StyleProperty.
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
 * @version $Id: FloatSP.class.php,v 1.4 2006/04/26 14:21:31 cws-midd Exp $
 */
class FloatSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of float.
	 **/
	function FloatSP($value) {
		$this->StyleProperty("float", "Float", "This property specifies the float value.");
		if (isset($value)) $this->addSC(new FloatSC($value));
	}

}

?>