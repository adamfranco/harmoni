<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/TextSpacingSC.class.php");

/**
 * The WordSpacingSP represents the 'word-spacing' StyleProperty.
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
 * @version $Id: WordSpacingSP.class.php,v 1.5 2006/06/02 15:56:08 cws-midd Exp $
 */
class WordSpacingSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string length The length of margin, but CANNOT be in % format.
	 **/
	function WordSpacingSP($length) {
		$this->StyleProperty("word-spacing", "Word Spacing", "This property specifies the word spacing.");
		if (!is_null($length)) $this->addSC(new TextSpacingSC($length));
	}

}

?>