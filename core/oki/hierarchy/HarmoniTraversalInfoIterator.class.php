<?

require_once(OKI."/hierarchy/hierarchyAPI.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

class HarmoniTraversalInfoIterator
	extends TraversalInfoIterator
{ // begin TraversalInfoIterator

	/**
	 * @var array $_traversalInfos The stored traversalInfos.
	 * @access private
	 */
	var $_traversalInfos = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniTraversalInfoIterator (& $traversalInfoArray) {
		// make sure that we get an array of TraversalInfo objects
		ArgumentValidator::validate($traversalInfoArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("TraversalInfo")));
		
		// load the types into our private array
		foreach ($traversalInfoArray as $key => $val) {
			$this->_traversalInfos[] =& $traversalInfoArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_traversalInfos)-1);
	}

	// public Type & next();
	function & next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_traversalInfos[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "TraversalInfoIterator", 1));
		}
	}

} // end TraversalInfoIterator

?>