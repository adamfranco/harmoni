<?php
/************************************************************************
  			authhandler.php - Copyright gabe

**************************************************************************/


/**
  * class authHandler
  * the authentication handler - creates and administers authModules for user
  * authentication
  */

class authHandler
{


  /**Attributes: */

    /**
      * array of authModules installed
      * @access private
      */
    var $modules = array();
    
    var $_lastAddedMod = '';
    
    var $_userName;
    
    /**
      * number of modules we've registered
      * @access private
      */
    var $_numModules = 0;
    /**
      * config handler
      * @access private
      */
    var $cfg = NULL;
    /**
      * has there been a login error?
      * @access private
      * @deprecated
      */
    var $error = false;
    /**
      * number of validated authModules
      * @access private
      */
    var $numValid = 0;
    /**
      * have we checked a user this session?
      * @access private
      */
    var $_checked = false;

  /**
    * called upon instantiation
    */
  function authHandler( )
  {
    $this->cfg = & new configHandler("authAll:b");
    $this->cfg->set("authAll",false);
    
    // this option may be unnecessary -- depends on how actions are implemented
//	$this->cfg->addAttr("actionsNoAuth:s[]");
  }

	function addModule($name,$type) {
		
		if (isset($this->modules[$name]) && is_object($this->modules[$name]))
			error::fatal("authHandler::addModule - trying to add module of type '$type' with existing name '$name'");
		
		$modobj = "authModule_".strtolower($type);
		if (!class_exists($modobj)) error::fatal("authHandler::addModule - can not instantiate non-existent class '$modobj'. NOT GOOD!");
		
		$obj = & new $modobj($name);
		$this->_lastAddedMod = $name;
		$this->_numModules++;
		$obj->_init();
		$obj->_doGlobalConfig();
		$this->modules[$name]=&$obj;
		return true;
	}
	
	function modCfg( ) {
		$n = func_num_args();
		if ($n == 2) {
			if (!$this->numModules) error::fatal("AuthHandler::modCfg - trying to configure a module before any have been added");
			$mod = $this->_lastAddedMod;
			$key = func_get_arg(0);
			$val = & func_get_arg(1);
		} else if ($n == 3) {
			$mod = func_get_arg(0);
			$key = func_get_arg(1);
			$val = & func_get_arg(2);
		} else error::fatal("AuthHandler::modCfg - wrong number of arguments ($n) to modCfg");
		
		if (!is_object($this->modules[$mod])) error::fatal("AuthHandler::modCfg - can not edit configuration for non-existent module name '$mod'");
		
		$this->modules[$mod]->cfg->set($key,$val);
		return true;
	}

  /**
    * checks user's password against all authModules until one is valid (or if cfg->get("authAll") is true, it continues through all modules)
    * @param string $username username to be checked
    * @param string $password user's password
    * @return bool returns if the user validated successfully with at least one module
    */
  function authUser( $username, $password )
  {
		if (!$this->_numModules) error::fatal("AuthHandler::authUser - could not authenticate user because not authModules have been defined!");
		
		if ($this->_checked) error::fatal("AuthHandler::authUser - authUser has already been called this session - it cannot be called more than once per session");
		
		$this->_userName = $username;
		
		foreach (array_keys($this->modules) as $mod) {
			if ($this->modules[$mod]->_valid($username,$password)) {
				$this->numValid++;
				if (!$this->cfg->get("authAll")) break;
			}
		}
		
		// flag that we've check a username and password this session -- but only if we were successful
		if ($this->numValid) $this->_checked=true;
		return $this->numValid;
  }


  /**
    * will check if the user (checked by checkUser) was valid.
    * @param string $inMods,... (optional) list of modules to check - otherwise checks all
    * @param string $method (optional) values: "and"|"or" must be first argument - can specify if we should check ALL ("and") modules specified (or all if none are specified) for validity, or check if at least one ("or") is valid
    * @return bool returns if the user is valid overall or in modules specified.
    */
  function isValid( )
  {
		
		if (func_num_args()) $mods = func_get_args();
		else {
			// if we have no arguments we can just return the number of valid modules
			// -- this is the same as calling ::isValid("or","mod1","mod2",...) and listing
			//    all the registered modules
			return ($this->_numValid > 0)?true:false;
		}
		
		// if the first argument is either "or" or "and", we set the method we use to that
		// and = we check ALL modules for validity -- all must have succeeded
		// or = we only care if AT LEAST one validated
		$method = "or";
		if ($mods[0] == "or" || $mods[0] == "and") {
			$method = array_shift($mods);
		}
		
		$numChecked = 0;
		$numValid = 0;
		foreach($mods as $mod) {
			$mod = trim($mod);
			if (!is_object($this->modules[$mod])) error::fatal("AuthHandler::isValid - no modules are registered under the name '$mod'");
			
			// if we're not using this module for authentication, skip it
			if ($this->modules[$mod]->cfg->get("dontAuth")) continue;
			
			// now check if this module was valid or not
			if ($this->modules[$mod]->isValid()) $numValid++;
			$numChecked++;
		}
		
		// now, if we're using $method = "or", at least one must have been good
		// if $method = "and", $numChecked must equal $numValid
		if ($method == "or") {
			if ($numValid > 0) return true;
			return false;
		} else if ($method == "and") {
			if ($numValid == $numChecked) return true;
			return false;
		}
  }
  
  /**
   * goes through the modules and gets the 'extra' info pulled down from the db/whatever
   * @param string $field the field to pull out
   * @return array returns an array of all values extracted
   */
	function getExtra( $field = NULL ) {
		
	}
	


}
?>
