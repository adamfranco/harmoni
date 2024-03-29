<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/WhiteSpaceSC.class.php");

/**
 * The WhiteSpaceSP represents the 'white-space' StyleProperty.
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
 * @version $Id: WhiteSpaceSP.class.php,v 1.5 2006/06/02 15:56:08 cws-midd Exp $
 */
class WhiteSpaceSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The value of the white space.
	 **/
	function __construct($value) {
		parent::__construct("white-space", "White Space", "This property specifies the white space.");
		if (!is_null($value)) $this->addSC(new WhiteSpaceSC($value));
	}

}

?>