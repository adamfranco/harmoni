<?

/**
 * A class for passing an integer or a string representation of an integer as an
 * id.
 * @package harmoni.osid.shared
 */

class HarmoniId extends Id {

	/**
	 * @var string $_id The id of this id.
	 */
	 var $_id;
	
	/**
	 * Constructor. Creates a HarmoniId with id = $id or a new unique id if $id is NULL.
	 * @param string $id The desired id. If NULL, a new unique id is used.
	 *
	 */
	function HarmoniId ( $id  ) {
		// ** parameter validation
		ArgumentValidator::validate($id, new StringValidatorRule("Id"), true);
		// ** end of parameter validation

		$this->_id = $id;
	}

	// public String getIdString();
	function getIdString() {
		return $this->_id;
	}

	// public boolean isEqual(osid.shared.Id & $id);
	function isEqual(& $id) {
		// Validate the arguments
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		return ($id->getIdString() == $this->_id) ? true : false;
	}

}

?>