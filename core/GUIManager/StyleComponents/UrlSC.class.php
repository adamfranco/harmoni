<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The UrlSC represents CSS "url" values. The URL format is: 
 * <ul style="font-family: monospace;">
 * 		<li> url(URL) - where URL is an absolute or relative link (optionally quoted
 * 						with single or double quotes).</li>
 * </ul>
 * <br><br>
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br><br>
 * @version $Id: UrlSC.class.php,v 1.1 2004/08/09 02:58:36 dobomode Exp $ 
 * @package harmoni.gui.scs
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class UrlSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function UrlSC($value) {
		$errDescription = "Could not validate the url StyleComponent value \"$value\".
						   Allowed values are: url(URL), where URL is an absolute or relative link 
	   					   (optionally quoted with single or double quotes).";
		
		$rule =& new CSSUrlValidatorRule();

		$displayName = "URL";
		$description = "Specifies a url linking to a resource (an image, an audio file, etc).
						Allowed values are: url(URL), where URL is an absolute or relative link 
						(optionally quoted with single or double quotes).";
  					    		
		$this->StyleComponent($value, $rule, null, null, $errDescription, $displayName, $description);
	}
}

class CSSUrlValidatorRule extends ValidatorRuleInterface {

	function check(& $val) {
		$regs = array();

		if (!ereg("^url\( *", $val))
			return false;
		if (!ereg(" *\)$", $val))
			return false;
		
		return true;
	}
}

?>