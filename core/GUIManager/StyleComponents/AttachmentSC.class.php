<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The RepeatSC represents CSS "attachment" value. The allowed values are: 
 * <ul style="font-family: monospace;">
 * 		<li> scroll </li>
 * 		<li> fixed </li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: AttachmentSC.class.php,v 1.1 2004/08/17 02:22:34 gabeschine Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class AttachmentSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function AttachmentSC($value) {
		$options = array("scroll","fixed");

		$errDescription = "Could not validate the Attachment StyleComponent value \"$value\".
						   Allowed values are: ".implode(", ", $options).".";
		
		$displayName = "Attachment";
		$description = "Specifies the values for CSS property 'attachment'. Allowed values are: 
						".implode(", ", $options).".";
		
		$this->StyleComponent($value, null, $options, true, $errDescription, $displayName, $description);
	}
}
?>