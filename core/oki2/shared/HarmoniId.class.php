<?

require_once(OKI2."/osid/shared/Id.php");

/**
 * Id represents a unique identifier. A String representation of the unique
 * identifier is available with getIdString().	To convert from a String
 * representation of the identifier to the identifier object,
 * org.osid.shared.Id, use getId(String). Id can determine if it is equal to
 * another Id.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid.shared
 */
class HarmoniId 
	extends Id 
{

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

	/**
	 * Return the String representation of this unique Id.
	 *	
	 * @return string
	 * 
	 * @throws object SharedException An exception with one of the
	 *		   following messages defined in org.osid.shared.SharedException
	 *		   may be thrown:  {@link
	 *		   org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.shared.SharedException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.shared.SharedException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function getIdString () { 
		return $this->_id;
	}

	/**
	 * Tests if an unique Id equals this unique Id.
	 * 
	 * @param object Id $id
	 *	
	 * @return boolean
	 * 
	 * @throws object SharedException An exception with one of the
	 *		   following messages defined in org.osid.shared.SharedException
	 *		   may be thrown:  {@link
	 *		   org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
	 *		   {@link org.osid.shared.SharedException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.shared.SharedException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.shared.SharedException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @public
	 */
	function isEqual ( &$id ) {
		// Validate the arguments
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		return ($id->getIdString() == $this->_id) ? true : false;
	}

}

?>