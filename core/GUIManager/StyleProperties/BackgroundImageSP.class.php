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
 
 *
 * @package  harmoni.gui.sps
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BackgroundImageSP.class.php,v 1.3 2005/01/19 21:09:34 adamfranco Exp $
 */
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
