<?

require_once(OKI."/shared.interface.php");

/**
 * A generic type for Harmoni. Constructor takes the desired authority, domain, keyword,
 * and description.
 * @package harmoni.osid.shared
 */

class HarmoniType
	extends TypeInterface
{ // begin Type


	/**
	 * Construct a Type object for this domain, authority and keyword.
	 */
	function HarmoniType($domain, $authority, $keyword, $description = "") { 
		$this->_domain = $domain;
		$this->_authority = $authority;
		$this->_keyword = $keyword;
		$this->_description = $description;
	}
	// :: full java declaration :: public Type(String domain, String authority, String keyword)

	// public boolean isEqual(Type & $type2);
	function isEqual(& $type2) {
		ArgumentValidator::validate($type2, new ExtendsValidatorRule("TypeInterface"));
		
		// the domain, authority, and keyword need to be alike for the types to be equivallent
		if (strtolower($this->getDomain()) == strtolower($type2->getDomain()) && 
			strtolower($this->getAuthority()) == strtolower($type2->getAuthority()) &&
			strtolower($this->getKeyword()) == strtolower($type2->getKeyword())) {
			return TRUE;
		}
		// otherwise, return FALSE
		return FALSE;		
	}

	// public String getDomain();
	function getDomain() {
		return $this->_domain;
	}

	// public String getAuthority();
	function getAuthority() {
		return $this->_authority;
	}

	// public String getKeyword();
	function getKeyword() {
		return $this->_keyword;
	}

	// public String getDescription();
	function getDescription() {
		return $this->_description;
	}

} // end Type

function OKITypeToString(&$type, $glue=", ") {
	ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"));
	return $type->getAuthority() . $glue . $type->getDomain() . $glue . $type->getKeyword();
}

?>