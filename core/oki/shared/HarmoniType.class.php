<?

require_once(OKI."/shared.interface.php");

class HarmoniType
	extends Type
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

function OKITypeToString(&$type) {
	return $type->getDomain() . "/" . $type->getAuthority() . "/" . $type->getKeyword();
}

?>