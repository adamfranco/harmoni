<?

class HarmoniId
	extends Id

	// extends java.io.Serializable

{ // begin Id

	/**
	 * @var string $_id The id of this id.
	 */
	 var $_id;
	
	/**
	 * Constructor. Creates a HarmoniId with id = $id or a new unique id if $id is NULL.
	 * @param string $id The desired id. If NULL, a new unique id is used.
	 *
	 */
	function HarmoniId ( $id = NULL ) {
		if ($id != NULL) {
			// use this id
			// SLOW-VALIDATE -- comment validation out to increase program speed.
			
			// Make sure that we have a non-zero integer
			if (ereg("^[1-9][0-9]*$",$idString))
				throwError(new Error(OPERATION_FAILED.": Non-integer Id String: '".(($idString == NULL)?"NULL":$idString)."'.","HarmoniId",true));
			
			$this->_id = $id;
		} else {
			// get a new unique id
		}
	}

	// public String getIdString();
	function getIdString() {
		return $this->_id;
	}

	// public boolean isEqual(osid.shared.Id & $id);
	function isEqual(& $id) {
		return ($id->getIdString() == $this->_id)?true:false;
	}

} // end Id

?>