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
 * @version $Id: BackgroundSP.class.php,v 1.4 2006/04/26 14:21:31 cws-midd Exp $
 */
class BackgroundSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundSP($color, $url, $repeat, $attachment) {
		$this->StyleProperty("background", "Background", "This property specifies the background settings.");
		if (isset($color)) $this->addSC(new ColorSC($color));
		if (isset($url)) $this->addSC(new UrlSC($url));
		if (isset($repeat)) $this->addSC(new BackgroundRepeatSC($repeat));
		if (isset($attachment)) $this->addSC(new BackgroundAttachmentSC($attachment));
	}

}

?>