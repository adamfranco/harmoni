<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The BackgroundAttachmentSC represents CSS background-attachment values. The allowed values are:
 * <ul style="font-family: monospace;">
 * 		<li> scroll </li>
 * 		<li> fixed </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: BackgroundAttachmentSC.class.php,v 1.1 2004/08/09 02:58:36 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class BackgroundAttachmentSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function BackgroundAttachmentSC($value) {
		$options = array("scroll", "fixed");
	
		$errDescription = "Could not validate the background-attachment StyleComponent value \"$value\". ";
		$errDescription .= "Allowed values are ".implode(", ", $options).".";
		
		$displayName = "Background Attachment";
		$description = "Specifies the background-attachment value. Allowed values are: ".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>