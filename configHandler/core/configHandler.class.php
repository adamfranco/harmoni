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
	var $values = array();
	var $fields = array();
	var $numAttributes;
	
	
	function configHandler() {
		// check if we were passed anything, if so pass it off to addAttr
		if (func_num_args()) $this->addAttr(func_get_args());
	}
	
	/**
	 * adds an attribute to the config handler
	 * @param string $addrStr,... each arg is of the format "key:t[:opt1,opt2,...]" where key is whatever key you want to use, t is one of the allowed types: s=string; n=numeric; b=boolean; m=mixed; o=other
	 * 							if t is of the format 't[]' (ex 's[]') that tells configHandler that this key is an array. the optional ':opt1,...' gives configHandler a list of allowed values for this config
	 *							key if you want to limit the user to a certain set
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
		$options = array();
		foreach (explode(',',$o) as $opt) {
			$options[] = trim($opt);
		}
		
		$this->fields[$k] = & new configNode($k,$t,$options);
	}
	
	function set($key,& $val) {
		if (isset($this->fields[$key])) {
			$this->fields[$key]->set($val);
		} else error::fatal("configHandler::set - could not set '$key' because it is not a valid key");
	}
	
	function get($key) {
		if (isset($this->fields[$key])) return $this->fields[$key]->get();
		else error::fatal("configHandler::get - could not get '$key' because it is not a valid key");
	}
	
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
		/* s = string, n = numeric, m = mixed, o = other (like an object), b = bool */
		if (!ereg("(.)(\[\]){0,1}",$type,$r))
			error::fatal("configHandler::addAttr - '$type' is not a valid attribute type for key '$key'");
		$this->type = $r[0];
		if (!in_array($r[0],$types))
			error::fatal("configHandler::addAttr - '$type' is not a valid attribute type for key '$key'");
		if (!ereg("([A-Za-z0-9_-])",$key))
			error::fatal("configHandler::addAttr - '$key' is not a valid key string");
		if ($r[1]) $this->isarray = true;
		if (is_array($options)) $this->options = $options;
		$this->val = NULL;
	}
	
	function set( & $val ) {
		$e = false;
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
		foreach ($c as $val) {
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
			}
		}
		if ($e) error::fatal("configHandler::set - trying to set '$this->key' to invalid value '$val'");
		if ($this->isarray)
			$this->val = & $c;
		else $this->val = & $c[0];
		return true;
	}
	
	function & get() {
		return $this->val;
	}
}