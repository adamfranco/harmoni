<?

require_once(OKI."/hierarchy/hierarchyApi.interface.php");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

class HarmoniNodeIterator
	extends NodeIterator
{ // begin NodeIterator

	/**
	 * @var array $_nodes The stored nodes.
	 * @access private
	 */
	var $_nodes = array();
	 
	/**
	 * @var int $_i The current posititon.
	 * @access private
	 */
	var $_i = -1;
	
	/**
	 * Constructor
	 */
	function HarmoniNodeIterator (& $nodeArray) {
		// make sure that we get an array of Node objects
		ArgumentValidator::validate($nodeArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("Node")));
		
		// load the types into our private array
		foreach ($nodeArray as $key => $val) {
			$this->_nodes[] =& $nodeArray[$key];
		}
	}

	// public boolean hasNext();
	function hasNext() {
		return ($this->_i < count($this->_nodes)-1);
	}

	// public Type & next();
	function & next() {
		if ($this->hasNext()) {
			$this->_i++;
			return $this->_nodes[$this->_i];
		} else {
			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "NodeIterator", 1));
		}
	}

} // end NodeIterator

?>