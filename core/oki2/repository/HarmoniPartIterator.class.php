<?require_once(OKI."dr.interface.php");// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");class HarmoniInfoFieldIterator	extends InfoFieldIterator{ // begin InfoFieldIterator	/**	 * @var array $_infoFields The stored InfoFields.	 * @access private	 */	var $_infoFields = array();	 	/**	 * @var int $_i The current posititon.	 * @access private	 */	var $_i = -1;		/**	 * Constructor	 */	function HarmoniInfoFieldIterator (& $infoFieldArray) {		// make sure that we get an array of DigitalRepository objects		ArgumentValidator::validate($infoFieldArray, new ArrayValidatorRuleWithRule(new ExtendsValidatorRule("InfoField")));				// load the types into our private array		foreach ($infoFieldArray as $key => $val) {			$this->_infoFields[] =& $infoFieldArray[$key];		}	}	// public boolean hasNext();	function hasNext() {		return ($this->_i < count($this->_infoFields)-1);	}	// public Type & next();	function &next() {		if ($this->hasNext()) {			$this->_i++;			return $this->_infoFields[$this->_i];		} else {			throwError(new Error(NO_MORE_ITERATOR_ELEMENTS, "InfoFieldIterator", 1));		}	}} // end InfoFieldIterator?>