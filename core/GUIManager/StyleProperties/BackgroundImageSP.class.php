<?php

require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/StyleComponents/UrlSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/RepeatSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/AttachmentSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/VerticalAlignmentPositionSC.class.php");
require_once(HARMONI."GUIManager/StyleComponents/HorizontalAlignmentPositionSC.class.php");


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
 * @version $Id: BackgroundImageSP.class.php,v 1.6 2006/06/02 15:56:07 cws-midd Exp $
 */
class BackgroundImageSP extends StyleProperty {

	/**
	 * The constructor.
	 * @access public
	 * @param string value The HTML color value for this SP.
	 **/
	function __construct($imageURL=null, $repeat="repeat", $attachment="scroll", $xpos=null, $ypos=null) {
		parent::__construct("background", "Background Image", "This property specifies the background image and its settings.");
		if (!is_null($imageURL)) $this->addSC(new UrlSC($imageURL));
		if (!is_null($repeat)) $this->addSC(new RepeatSC($repeat));
		if (!is_null($attachment)) $this->addSC(new AttachmentSC($attachment));
		if (!is_null($xpos) && !is_null($ypos)) {
			$this->addSC(new VerticalAlignmentPositionSC($xpos));
			$this->addSC(new HorizontalAlignmentPositionSC($ypos));
		}
	}

}