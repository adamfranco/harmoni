<?

class authModule {
	var $_name;
	var $_isValid = false;
	var $_extras=array();
	var $cfg;
	
	function _init() {
		// the init function must create a configHandler object in $this->cfg!!
		$this->cfg = & new configHandler();
		return;
	}
	
	function _doCommonConfig() {
		if (!is_object($this->cfg)) error::fatal(get_class($this)." - this class must create a configHandler in ".get_class($this)."->cfg!!");
		
		// set up config options that are common to ALL authModules
		$this->cfg->addAttr("dontAuth:b");
		$this->cfg->set("dontAuth",false);
	}
	
	function validate($n,$p) {
		return $this->_isValid;
	}
	
	function isValid() {
		return $this->_isValid;
	}
}