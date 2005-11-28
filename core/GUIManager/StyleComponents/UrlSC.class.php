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
 * @version $Id: UrlSC.class.php,v 1.7 2005/11/28 22:41:44 adamfranco Exp $
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
		
		$rule =& CSSUrlValidatorRule::getRule();

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
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern
	 * 
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule () {
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] =& new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

?>