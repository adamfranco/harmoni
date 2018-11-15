<?php

//require_once(HARMONI."utilities/FieldSetValidator/FieldSetValidator.interface.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");
require_once(HARMONI."utilities/FieldSetValidator/RuleSet.class.php");

/**
 * the FieldSetValidator takes a FieldSet and a RuleSet and validates values between the two
 *
 * @package harmoni.utilities.fieldsetvalidator
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FieldSetValidator.class.php,v 1.5 2007/09/04 20:25:55 adamfranco Exp $
 */
class FieldSetValidator {
	/**
	 * the FieldSet object
	 * 
	 * @access private
	 * @var object FieldSet $_fieldset 
	 */ 
	var $_fieldset;
	
	/**
	 * the RuleSet object
	 * 
	 * @access private
	 * @var object RuleSet $_ruleset 
	 */ 
	var $_ruleset;
	
	/**
	 * the constructor
	 * 
	 * @param object FieldSet $fieldset the FieldSet object to use for values
	 * @param object RuleSet $ruleset the RuleSet object to use for rules/validation
	 * @access public
	 * @return void 
	 **/
	function __construct( $fieldset, $ruleset ) {
		$this->_fieldset =  $fieldset;
		$this->_ruleset =  $ruleset;
	}
	
	/**
	 * sets the fieldset object to use to $fieldset
	 * 
	 * @param object FieldSet $fieldset the object to use
	 * @access public
	 * @return void 
	 **/
	function setFieldSet( $fieldset ) {
		$this->_fieldset =  $fieldset;
	}
	
	/**
	 * sets the ruleset object to use to $ruleset
	 * 
	 * @param object RuleSet $ruleset the object to use
	 * @access public
	 * @return void 
	 **/
	function setRuleSet( $ruleset ) {
		$this->_ruleset =  $ruleset;
	}
	
	/**
	 * validates the value of $key against the rules defined for it
	 * 
	 * @param string $key the key to validate
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validate( $key, $throwErrors=true ) {
		// get the value from the FieldSet
		$val =  $this->_fieldset->get($key);
		
		// run the rules and return
		return $this->_ruleset->validate( $key, $val, $throwErrors );
	}
	
	/**
	 * validates all defined keys in the FieldSet against those in the RuleSet
	 * 
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validateAll( $throwErrors=true ) {
		// get all the defined keys
		$keys = array_unique(array_merge($this->_fieldset->getKeys(),$this->_ruleset->getKeys()));
		
		$error = false; // assume no error
		// go through them and validate
		foreach ($keys as $key) {
			if (!$this->validate( $key, $throwErrors )) $error = true;
		}
		if ($error) return false;
		return true;
	}
	
}