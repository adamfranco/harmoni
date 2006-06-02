<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/UrlSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BackgroundRepeatSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/BackgroundAttachmentSC.class.php");

/**
 * The BackgroundSP represents the 'background' StyleProperty.
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
 * @version $Id: BackgroundSP.class.php,v 1.5 2006/06/02 15:56:07 cws-midd Exp $
 */
class BackgroundSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundSP($color, $url, $repeat, $attachment) {
		$this->StyleProperty("background", "Background", "This property specifies the background settings.");
		if (!is_null($color)) $this->addSC(new ColorSC($color));
		if (!is_null($url)) $this->addSC(new UrlSC($url));
		if (!is_null($repeat)) $this->addSC(new BackgroundRepeatSC($repeat));
		if (!is_null($attachment)) $this->addSC(new BackgroundAttachmentSC($attachment));
	}

}

?>