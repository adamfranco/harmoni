<?

require_once(OKI2."/osid/shared/Properties.php");

/**
 * Properties is a mechanism for returning read-only data about an object.	An
 * object can have data associated with a PropertiesType.  For each
 * PropertiesType, there are Properties which are Serializable values
 * identified by a key.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid.shared
 */
class HarmoniProperties
	extends Properties
{

	/**
	 * Constructor. Create a new Properties object.
	 * 
	 * @param object Type $type
	 * @return object
	 * @access public
	 * @date 11/18/04
	 */
	function HarmoniProperties (& $type) {
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		$this->_type = $type;
		$this->_properties = array();
	}

	/**
	 * Get the Type for this Properties instance.
	 *	
	 * @return object Type
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
	 * @access public
	 */
	function &getType () { 
		return $this->_type;
	}

	/**
	 * Get the Property associated with this key.
	 * 
	 * @param object mixed $key (original type: java.io.Serializable)
	 *	
	 * @return object mixed (original type: java.io.Serializable)
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
	 *		   {@link org.osid.shared.SharedException#UNKNOWN_KEY UNKNOWN_KEY}
	 * 
	 * @access public
	 */
	function &getProperty ( &$key ) { 
		return $this->_properties[serialize($key)];
	}

	/**
	 * Get the Keys associated with these Properties.
	 *	
	 * @return object ObjectIterator
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
	 * @access public
	 */
	function &getKeys () { 
		$keys = array();
		foreach (array_keys($this->_properties) as $key) {
			$keys[] = unserialize($key);
		}
		
		return new HarmoniIterator($keys);
	}
	
	/**
	 * Add a Property to these Properties.
	 * WARNING: This method is not in the OSIDs as of version 2.0
	 * Use at your own risk
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * @return void
	 * @access public
	 * @date 11/18/04
	 */
	function addProperty ( &$key, &$value ) {
		$this->_properties[serialize($key)] =& $value;
	}
	
	
}