<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The UrlSC represents CSS "url" values. The URL format is: 
 * <ul style="font-family: monospace;">
 * 		<li> url(URL) - where URL is an absolute or relative link (optionally quoted
 * 						with single or double quotes).</li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 *
 * @package  harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UrlSC.class.php,v 1.8 2006/08/15 20:44:58 sporktim Exp $
 */
class UrlSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function UrlSC($value) {
		$errDescription = "Could not validate the url StyleComponent value \"%s\".
						   Allowed values are: url(URL), where URL is an absolute or relative link 
	   					   (optionally quoted with single or double quotes).";
		
		$rule =& RegexValidatorRule::getRule("^url\(.+\)$");

		$displayName = "URL";
		$description = "Specifies a url linking to a resource (an image, an audio file, etc).
						Allowed values are: url(URL), where URL is an absolute or relative link 
						(optionally quoted with single or double quotes).";
  					    		
		$this->StyleComponent($value, $rule, null, null, $errDescription, $displayName, $description);
	}
}

?>