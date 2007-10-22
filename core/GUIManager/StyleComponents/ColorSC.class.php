<?php

require_once(HARMONI."GUIManager/StyleComponent.class.php");

/**
 * The ColorSC represents CSS color values. For efficiency reasons, constant 
 * color name values, i.e. "Blue", are not supported because there are just 
 * too many of them (nearly 200). The allowed formats are:
 * <ul style="font-family: monospace;">
 * 		<li> #RGB            - "#A48" (R,G,B are 0-F hexadecimal digits)</li>
 * 		<li> #RRGGBB         - "#AA4488" (R,G,B are 0-F hexadecimal digits)</li>
 * 		<li> rgb(R,G,B)      - "rgb(100, 20, 230)" (R,G,B are 0-255 decimals)</li>
 * 		<li> rgb(R%,G%,B%)   - "rgb(0%, 20.25%, 100%)" (R%,G%,B% are floating-point 0-100 percentages)</li>
 * </ul>
 * <br /><br />
 * The <code>StyleComponent</code> (SC) is the most basic of the three building pieces
 * of CSS styles. It combines a CSS property value with a ValidatorRule to ensure that
 * the value follows a certain format.<br /><br />
 *
 * @package harmoni.gui.scs
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ColorSC.class.php,v 1.13 2007/10/22 18:05:27 adamfranco Exp $
 */
class ColorSC extends StyleComponent {

	/**
	 * The constructor.
	 * @param string value The value to assign to this SC.
	 * @access public
	 **/
	function ColorSC($value) {
		$errDescription = "Could not validate the color StyleComponent value \"%s\". ";
		$errDescription .= "Allowed formats are: #RGB, #RRGGBB, rgb(R,G,B), and rgb(R%%,G%%,B%%).";
		
		$rule = CSSColorValidatorRule::getRule();
		
		$displayName = "Color";
		$description = "Specifies the color using one of the following formats
		(R stands for Red, G stands for Green, and B stands for Blue):
		#RGB, #RRGGBB (R,G,B are 0-F hexadecimal digits), rgb(R,G,B) (R,G,B are
		0-255 decimals), rgb(R%,G%,B%) (R%,G%,B% are floating-point 0-100 percentages).";
		$this->StyleComponent($value, $rule, null, null, $errDescription, $displayName, $description);
	}
	

	/**
	* Converts the color to a standard format--an array of the form (R, G, B).
	*
	*@ return array The resulting array.
	*/
	function getRGBArray($val=null){//@todo this has not been rigorously tested
		
		if(func_num_args()<1){
			$val = $this->getValue();
		}
		
		$array = array();
		// check for #RGB and #RRGGBB format
		if (ereg("^#[0-9a-fA-F]{3}$", $val)){
			$array[0] = 17 * hexdec(substr($val,1,1));
			$array[1] = 17 * hexdec(substr($val,2,1));
			$array[2] = 17 * hexdec(substr($val,3,1));
			return $array;
		}
		if (ereg("^#[0-9a-fA-F]{6}$", $val)){
			$array[0] = hexdec(substr($val,1,2));
			$array[1] = hexdec(substr($val,3,2));
			$array[2] = hexdec(substr($val,5,2));
			return $array;
		}
		
		
		$regs = array();	
		// check for rgb(R,G,B) format
		if (ereg("^rgb\(([0-9]{0,3}),\ *([0-9]{0,3}),\ *([0-9]{0,3})\)$", $val, $regs)) {
			if (($regs[1] >= 0) && ($regs[1] <= 255) &&
				($regs[2] >= 0) && ($regs[2] <= 255) &&
				($regs[3] >= 0) && ($regs[3] <= 255)){
					$array = array($regs[1],$regs[2],$regs[3]);
					return $array;	
				}else{
					return null;
				}				
		}
		// check for rgb(R%,G%,B%) format
		if (ereg("^rgb\(([0-9]{0,3}(\.[0-9]+)?)%,\ *([0-9]{0,3}(\.[0-9]+)?)%,\ *([0-9]{0,3}(\.[0-9]+)?)%\)$",
		    $val, $regs)) {
			if (($regs[1] >= 0) && ($regs[1] <= 100) &&
				($regs[3] >= 0) && ($regs[3] <= 100) &&
				($regs[5] >= 0) && ($regs[5] <= 100)){
					$array[0] = ($regs[1].$regs[2])*2.55;
					$array[1] = ($regs[3].$regs[4])*2.55;
					$array[2] = ($regs[5].$regs[6])*2.55;
					return $array;	
				}else{
					return null;
				}				
		}
		
		//not valid
		return null;
		
	}
	
}



class CSSColorValidatorRule extends RegexValidatorRule {
	//@todo not tested
	
	var $_regex;
	
	
	
	function CSSColorValidatorRule(){
		
		$type1 = "#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?";
		
		
		$intUpTo256 = "(1?[0-9]{1,2}|2([0-4][0-9]|5[0-5]))";
		$type2 = "rgb(".$intUpTo256.",".$intUpTo256.",".$intUpTo256.")";
		
		$oneHundred ="100(\.0+)?";
		$underOneHundred = "[0-9]{1,2}(\.[0-9]+)?";
		
		$percent = "(".$oneHundred."|".$underOneHundred.")%";
		$type3 = "rgb(".$percent.",".$percent.",".$percent.")";
		
		$re = "^(".$type1."|".$type2."|".$type3.")$";
		$this->_regex=$re;
	}
	
	/*
	
	function check($val) {
		$regs = array();
		// check for #RGB and #RRGGBB format
		if (ereg("^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$", $val))
			return true;
		// check for rgb(R,G,B) format
		if (ereg("^rgb\(([0-9]{0,3}),\ *([0-9]{0,3}),\ *([0-9]{0,3})\)$", $val, $regs)) {
			if (($regs[1] >= 0) && ($regs[1] <= 255) &&
				($regs[2] >= 0) && ($regs[2] <= 255) &&
				($regs[3] >= 0) && ($regs[3] <= 255))
				return true;
			else
				return false;
		}
		// check for rgb(R%,G%,B%) format
		if (ereg("^rgb\(([0-9]{0,3}(\.[0-9]+)?)%,\ *([0-9]{0,3}(\.[0-9]+)?)%,\ *([0-9]{0,3}(\.[0-9]+)?)%\)$",
		    $val, $regs)) {
			if (($regs[1] >= 0) && ($regs[1] <= 100) &&
				($regs[3] >= 0) && ($regs[3] <= 100) &&
				($regs[5] >= 0) && ($regs[5] <= 100))
				return true;
			else
				return false;
		}
		
		return false;
	}
	*/
	
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
	static function getRule ($regex) {
		if ($regex)
			throw new HarmoniException("Passing of a custom string to this rule is not allowed.");
		
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] = new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

?>