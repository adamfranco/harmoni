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
 * @package harmoni.osid_v2.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniProperties.class.php,v 1.11 2005/03/02 23:15:12 adamfranco Exp $
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
	 * @since 11/18/04
	 */
	function HarmoniProperties (& $type) {
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"), true);
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
	function &getProperty ( $key ) { 
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
		
		return new HarmoniObjectIterator($keys);
	}
	
	/**
	 * Add a Property to these Properties.
	 * 
	 * WARNING: NOT IN OSID - This method is not in the OSIDs as of version 2.0
	 * Use at your own risk
	 *
	 * Since PHP4's reference handling sucks royally and call-time-pass-by-reference
	 * currently throws errors since it is depricated, there is no way to pass
	 * objects as references and primatives by value to the same arguement. As such,
	 * in order to allow Properties to hold references to objects (such as in an
	 * Osid Context or Osid Configuration) the param-by reference must stay. To
	 * pass strings or other primatives you must set the primatives to variables
	 * first as in the following example:
	 *
	 * $configuration =& new HarmoniProperties(new ConfigurationPropertiesType);
	 * $configuration->addProperty('database_id', $arg1 = 0);
	 * $configuration->addProperty('authentication_table', $arg2 = 'auth_db_user');
	 * $configuration->addProperty('username_field', $arg3 = 'username');
	 * $configuration->addProperty('password_field', $arg4 = 'password');
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * @return void
	 * @access public
	 * @since 11/18/04
	 */
	function addProperty ( $key, &$value ) {
		$this->_properties[serialize($key)] =& $value;
	}
	
	
}