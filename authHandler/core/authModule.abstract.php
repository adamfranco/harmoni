<?

/**
 * this class is abstract -- defines the layout for authModules of any type and the functions that they should have defined.
 * @abstract
 */

class authModule {
	var $_name;
	var $_isValid = false;
	var $_extras=array();
	var $cfg;
	
	/**
	 * the _init() function, unless not re-defined in the module, MUST create a configHandler and store it in $this->cfg
	 * the function is called upon adding the module to the authHandler
	 */
	function _init() {
		// the init function must create a configHandler object in $this->cfg!!
		$this->cfg = & new configHandler();
		return;
	}
	
	/**
	 * this function sets up common config options for all modules and SHOULD NOT be redefined.
	 * a specific module should not even have knowledge of this
	 */
	function _doCommonConfig() {
		if (!is_object($this->cfg)) error::fatal(get_class($this)." - this class must create a configHandler in ".get_class($this)."->cfg!!");
		
		// set up config options that are common to ALL authModules
		$this->cfg->addAttr("dontAuth:b");
		$this->cfg->set("dontAuth",false);
	}
	
	/**
	 * this function SHOULD be redefined
	 *
	 * handles the actual validation of a username & password pair using whatever method the module is there for
	 * @param string $n the username to check
	 * @param string $p the password to pair w/ username
	 * @return bool if the user is valid or not
	 */
	function validate($n,$p) {
		return $this->_isValid;
	}
	
	/**
	 * this function just returns if the user was valid from a previous call to validate()
	 * @return bool if the user was previously validated
	 */
	function isValid() {
		return $this->_isValid;
	}
}