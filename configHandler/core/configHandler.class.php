<?

/**
 * class configHandler
 * this class handles configuration stuff -- it's just an easy way to keep track of a bunch of variables
 * and make sure they're of the right format
 */
class configHandler {
	/**
	 * @access private
	 */
	var $fields = array();
	var $numAttributes = 0;
	
	
	function configHandler() {
		// check if we were passed anything, if so pass it off to addAttr
		if (func_num_args()) $this->addAttr(func_get_args());
	}
	
	/**
	 * adds an attribute to the config handler
	 * @param string $addrStr,... each arg is of the format "key:t[<:opt1,opt2,...>|array]" where key is whatever key you want to use, t is one of the allowed types: s=string; n=numeric; b=boolean; m=mixed; o=other
	 * 							the optional ':opt1,...' gives configHandler a list of allowed values for this config
	 *							key if you want to limit the user to a certain set, or by specifying 'array' configHandler will expect an array
	 */
	function addAttr( $addrStr ) {
		$n = func_num_args();
		if (!$n) return false;
		for ($i = 0; $i < $n; $i++) {
			$arg = func_get_arg($i);
			if (is_array($arg)) {
				foreach($arg as $a) $this->_addAttr($a);
			} else $this->_addAttr($arg);
		}
		return true;
	}
	
	function _addAttr( $str ) {
		$p = explode(":",$str);
		$k = $p[0];		//key
		$t = $p[1];		//type
		$o = ($p[2])?$p[2]:NULL;		//options
		if (!$k) error::fatal("configHandler::addAttr - trying to add attribute with no key");
		
		// if this key already exists -- exit quietly
		if (is_object($this->fields[$k])) return false;
		
		// go through the options and trim off white space
		// and then create an array
		if ($o && $o != 'array') {
			$options = $o;
			$o = array();
			foreach (explode(',',$options) as $opt) {
				$o[] = trim($opt);
			}
		}
		
		$this->fields[$k] = & new configNode($t,$k,$o);
		$this->numAttributes++;
	}
	
	/**
	 * sets $key to $val
	 * @param string $key the key to set
	 * @param mixed $val the value to set key to. pass $val as reference if you want to use something like an object
	 */
	function set($key, $val) {
		if (isset($this->fields[$key])) {
			$this->fields[$key]->set($val);
		} else error::fatal("configHandler::set - could not set '$key' because it is not a valid key");
	}
	
	/**
	 * returns the contents of $key as a reference (in case it was set to something like an object)
	 * @param string $key the key to return
	 * @return mixed returns a reference to the value of $key
	 */
	function & get($key) {
		if (isset($this->fields[$key])) return $this->fields[$key]->get();
		else error::fatal("configHandler::get - could not get '$key' because it is not a valid key");
	}
	
	/**
	 * will return if $key exists as a node of this configHandler
	 * @return bool true/false if key exists/doesnt' exist
	 */
	function keyExists($key) {
		if (is_object($this->fields[$key])) return true;
		return false;
	}
}

class configNode {
	var $type = 's';
	var $options = array();
	var $isarray = false;
	var $key;
	var $val;
	
	function configNode( $type, $key, $options = NULL) {
		static $types = array('s','n','m','o','b');
		static $defaults = array('s'=>'','n'=>0,'m'=>NULL,'o'=>NULL,'b'=>false);
		/* s = string, n = numeric, m = mixed, o = object, b = bool */
		
		if (!in_array($type,$types))
			error::fatal("configHandler::addAttr - '$type' is not a valid attribute type for key '$key'");
		if (!ereg("([A-Za-z0-9_-])",$key))
			error::fatal("configHandler::addAttr - '$key' is not a valid key string");
		if ($options == 'array') $this->isarray = true;
		$this->type = $type;
		$this->key = $key;
		$this->val = $defaults[$type];
		if ($this->isarray) $this->val = array();
		if (is_array($options)) {
			foreach ($options as $opt) {
				if (!$this->_validate($opt)) error::fatal("configHandler::newAttr - can not have '$opt' as an option for '$key': it does not match the type '$type'");
			}
			$this->options = $options;
		}
	}
	
	function set( & $val ) {
		$c = array();
		
		// if we have a set number of options that we accept from the user, check if $val is one of them
		if (count($this->options)) {
			if (!in_array($val,$this->options)) { // uh-oh
				$str = implode(", ",$this->options);
				error::fatal("configHandler::set - '$val' is not one of the permitted values for key '$this->key': $str");
			}
		}
		if ($this->isarray) $c = & $val;
		else $c[] = & $val;
		if (!is_array($c)) error::fatal("configHandler::set - trying to set key '$this->key' to non-array when expecting array");
		foreach (array_keys($c) as $i) {
			if (!$this->_validate($c[$i])) error::fatal("configHandler::set - trying to set '$this->key' to invalid value '$val' for type '$this->type'");
		}
		if ($this->isarray)
			$this->val = & $c;
		else $this->val = & $c[0];
		return true;
	}
	
	function _validate( & $val ) {
		$e = false;
		switch($this->type) {
			case 's':
				if (!is_string($val)) $e=true;
				break;
			case 'n':
				if (!is_numeric($val)) $e=true;
				break;
			case 'b':
				if (!($val === true || $val === false)) $e=true;
				break;
			case 'o':
				if (!is_object($val)) $e = true;
				break;
		}
		if ($e) return false;
		return true;
	}
	
	function & get() {
		return $this->val;
	}
}