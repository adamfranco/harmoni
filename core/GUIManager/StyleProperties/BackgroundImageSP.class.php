<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/UrlSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/RepeatSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AttachmentSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AlignmentPositionSC.class.php");

/**
 * The BackgroundImageSP represents the 'background' StyleProperty.
 * 
 * A StyleProperty (SP) is one of the tree building pieces of CSS styles. It stores 
 * information about a single CSS style property by storing one or more 
 * <code>StyleComponents</code>.
 * 
 * The other two CSS styles building pieces are <code>StyleComponents</code> and
 * <code>StyleCollections</code>. 
 
 * @version $Id: BackgroundImageSP.class.php,v 1.2 2004/09/09 16:53:24 gabeschine Exp $
 * @package harmoni.gui.sps
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BackgroundImageSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function BackgroundImageSP($imageURL, $repeat="repeat", $attachment="scroll", $xpos=null, $ypos=null) {
		$this->StyleProperty("background", "Background Image", "This property specifies the background image and its settings.");
		$this->addSC(new UrlSC($imageURL));
		$this->addSC(new RepeatSC($repeat));
		$this->addSC(new AttachmentSC($attachment));
		if ($xpos && $ypos) {
			$this->addSC(new AlignmentPositionSC($xpos, array("top","center","bottom")));
			$this->addSC(new AlignmentPositionSC($ypos, array("left","center","right")));
		}
	}

}

?>
