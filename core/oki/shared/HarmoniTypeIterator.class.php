<?

require_once(OKI."/shared.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

class HarmoniTypeIterator
	extends TypeIterator
{ // begin TypeIterator

	/**
	 * @var array $_types The stored types.
	 * @access private
	 */
	var $_types = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniTypeIterator (& $typeArray) {
		// make sure that we get an array of Type objects
		ArgumentValidator::validate($typeArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("TypeInterface")));
		
		// load the types into our private array
		foreach ($typeArray as $key => $val) {
			$this->_types[] =& $typeArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_types)-1);
	}

	// public Type & next();
	function &next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_types[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "TypeIterator", 1));
		}
	}

} // end TypeIterator




?>