<?

require_once(OKI."/shared.interface.php");

/**
 * Properties is a mechanism for returning read-only data about an Agent.  
 * Each Agent can have data associated with a PropertiesType.  For each 
 * PropertiesType, there are Properties which are Serializable values identified 
 * by a key.  
 *
 * @package harmoni.osid_v1.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniProperties.class.php,v 1.4 2005/01/19 23:23:07 adamfranco Exp $
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
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"), true);
		$this->_type = $type;
		$this->_properties = array();
	}

	/**
	 * Get the Type associated with these Properties. Properties
	 * @return object Type
	 * @throws osid.shared.SharedException An exception with one of the following 
	 * messages defined in osid.shared.SharedException:  
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getType() {
		return $this->_type;
	}

	/**
	 * Get the Property associated with this key.
	 * @return object java.io.Serializable
	 * @throws osid.shared.SharedException An exception with one of the following
	 *  messages defined in osid.shared.SharedException:  
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link SharedException#UNKNOWN_KEY UNKNOWN_KEY}
	 */
	function &getProperty(& $key) {
		return $this->_properties[serialize($key)];
	}

	/**
	 * Get the Keys associated with these Properties.
	 * @return object ObjectIterator
	 * @throws osid.shared.SharedException An exception with one of the following 
	 * messages defined in osid.shared.SharedException:  
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getKeys() {
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
	 * @since 11/18/04
	 */
	function addProperty (& $key, & $value) {
		$this->_properties[serialize($key)] =& $value;
	}
	
	
}