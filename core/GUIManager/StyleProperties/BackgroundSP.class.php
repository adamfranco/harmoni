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
 
 * @version $Id: BackgroundSP.class.php,v 1.1 2004/08/09 02:59:13 dobomode Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BackgroundSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundSP($color, $url, $repeat, $attachment) {
		$this->StyleProperty("background", "Background", "This property specifies the background settings.");
		$this->addSC(new ColorSC($color));
		$this->addSC(new UrlSC($url));
		if (isset($repeat)) $this->addSC(new BackgroundRepeatSC($repeat));
		if (isset($attachment)) $this->addSC(new BackgroundAttachmentSC($attachment));
	}

}

?>