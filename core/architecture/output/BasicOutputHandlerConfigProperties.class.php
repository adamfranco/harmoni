<?php
/**
 * @package harmoni.architecture.output
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicOutputHandlerConfigProperties.class.php,v 1.7 2008/02/06 15:37:42 adamfranco Exp $
 */

require_once(OKI2."/osid/shared/Properties.php");
require_once(HARMONI."oki2/shared/HarmoniObjectIterator.class.php");
require_once(HARMONI."oki2/shared/ConfigurationPropertiesType.class.php");


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
 * @package harmoni.architecture.output
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BasicOutputHandlerConfigProperties.class.php,v 1.7 2008/02/06 15:37:42 adamfranco Exp $
 */
class BasicOutputHandlerConfigProperties
	implements Properties
{

	/**
	 * Constructor. Create a new Properties object.
	 * 
	 * @param object Type $type
	 * @return object
	 * @access public
	 * @since 11/18/04
	 */
	function __construct() {
		$this->_type = new ConfigurationPropertiesType;
		$this->_properties = array(
			serialize('document_type') => serialize('text/html'),
			serialize('character_set') => serialize('utf-8'),
			serialize('document_type_definition') => serialize('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">')
		);
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
	function getType () { 
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
	function getProperty ( $key ) { 
		if (!isset($this->_properties[serialize($key)]))
			return null;
		
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
	function getKeys () { 
		$keys = array();
		foreach (array_keys($this->_properties) as $key) {
			$keys[] = unserialize($key);
		}
		
		$obj = new HarmoniObjectIterator($keys);
		
		return $obj;
	}
	
	/**
	 * Set the value of a Property/
	 * 
	 * WARNING: NOT IN OSID - This method is not in the OSIDs as of version 2.0
	 * Use at your own risk
	 * 
	 * @param mixed $key
	 * @param mixed $value
	 * @return void
	 * @access public
	 * @since 11/18/04
	 */
	function setProperty ( $key, $value ) {
		if (!isset($this->_properties[serialize($key)]))
			throwError(new HarmoniError("Invalid configuration key, '$key'.", "BasicOutputHandlerConfigProperties", true));
		
		$this->_properties[serialize($key)] = $value;
	}
	
	
}