<?php

require_once(HARMONI."/themeHandler/ThemeSetting.abstract.php");

/**
 * A simple border setting that takes a positive integer border.
 *
 * @package harmoni.themes.included_themes
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ImageBoxImageSetting.class.php,v 1.6 2005/03/29 19:44:47 adamfranco Exp $
 */
class ImageBoxImageSetting
	extends ThemeSetting {
	

/******************************************************************************
 * Methods
 ******************************************************************************/

	/**
	 * Constructor.
	 */
 	function ImageBoxImageSetting () { 		

		// Set the Display Name:
		$this->_displayName = "Image Set";
		
		// Set the Descripiton:
		$this->_description = "Which image set to use for the main block's border.";

		// Set the Default Value:
		$this->_defaultValue = "dropshadow";
		$this->_value = "dropshadow";

		// Set the options: Since this takes open values, no options are specified.
		$this->_options = array("dropshadow", "outerbevel");
	}
	
	/**
	 * Sets the Value of this ThemeSetting.
	 * @access public
	 * @param string $value The new Value of the ThemeSetting. Throws an error if
	 *		an invalid $value is passed.
	 * @return void
	 **/
	function setValue($value) {
		ArgumentValidator::validate($value, StringValidatorRule::getRule());
		
		if(!in_array($value, $this->_options))
			throwError(new Error("Invalid border value, '".$value."'.","BorderSetting", FALSE));
		
		$this->_value = $value;
	}
	
	/**
	 * Sets the DefaultValue of this ThemeSetting.
	 * @access public
	 * @param string $defaultValue The DefaultValue of this ThemeSetting.
	 * @return void
	 **/
	function &setDefaultValue ($defaultValue) {
		ArgumentValidator::validate($defaultValue, StringValidatorRule::getRule());
		
		if(!in_array($defaultValue, $this->_options))
			throwError(new Error("Invalid border value, '".$defaultValue."'.","BorderSetting", FALSE));
		
		$this->_defaultValue = $defaultValue;
	}
}

?>