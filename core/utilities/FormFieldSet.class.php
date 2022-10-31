<?php
/**
 * @package harmoni.utilities
 */

require_once HARMONI."utlities/FieldSetValidator/FieldSet.class.php";

/**
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FormFieldSet.class.php,v 1.3 2005/02/04 15:59:13 adamfranco Exp $
 */
class FormFieldSet extends FieldSet {

	var $_changed;
	var $_valid;
	
	function __construct( $fields = null ) {
		$this->_changed=array();
		$this->_valid = array();
		if ($fields && is_array($fields)) {
			foreach (array_keys($fields) as $k) {
				$this->_changed[$k] = false;
				$this->_valid[$k] = true;
			}
		}
		parent::__construct( $fields );
	}
	
	function set( $key, $val ) {
		$oldVal = $this->get($key);
		if ($oldVal == $val) return; // we would use '===' here, but we can't be sure
									// that form data from the user will be of the same
									// variable type. ie, "5" == 5 is true, but "5" === 5
									// is not
		
		parent::set($key,$val);
		$this->_changed[$key] = true;
	}
	
	function clear() {
		$this->_changed = array();
		parent::clear();
	}
	
	function validate( $key, $rule, $error = null, $errorHandler=null ) {
		if (!$rule->check($this->get($key))) {
			$this->_valid[$key] = false;
			if ($error) {
				if (!$errorHandler) $errorHandler=&Services::getService("UserError");
				$errorHandler->addError($error);
				return false;
			}
		}
		return true;
	}
	
	function hasErrors() {
		foreach ($this->_valid as $v) {
			if (!$v) return false;
		}
		return true;
	}
	
	function changed($key) {
		return $this->_changed[$key];
	}
}

?>