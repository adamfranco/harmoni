<?php

require_once(HARMONI."GUIManager/Theme.class.php");

require_once(HARMONI."GUIManager/StyleCollection.class.php");

require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderLeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSizeSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontWeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextAlignSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextDecorationSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/DisplaySP.class.php");

/**
 * A very basic theme based on simple borders and colored blocks.
 * <br><br>
 * A <code>Theme</code> is a combination of two things: first, it stores a variety
 * of reusable <code>StyleCollections</code> and second, it offers a mechanism for
 * printing an HTML web page.
 * <br><br>
 * Each <code>Theme</code> has a set of style collections that correspond to 
 * each component type.
 * <br><br>
 * Each <code>Theme</code> has a single component (could be container) that will
 * be printed when <code>printPage()</code> is called.
 *
 * @package harmoni.gui.themes
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GenericTheme.class.php,v 1.3 2005/02/07 21:38:17 adamfranco Exp $
 */
class GenericTheme extends Theme {

	/**
	 * The constructor. All initialization and Theme customization is performed
	 * here. 
	 * @access public
	 **/
	function GenericTheme() {
		$this->Theme(null,null);
		
	}

}

?>