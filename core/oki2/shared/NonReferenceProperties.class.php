<?

require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");
require_once(HARMONI."oki2/shared/ConfigurationPropertiesType.class.php");


/**
 * Properties that can be added to without doing so by reference. Useful 
 * for building Properties of strings, integers, etc.
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
 * @version $Id: NonReferenceProperties.class.php,v 1.1 2005/03/31 22:02:55 adamfranco Exp $
 */
class NonReferenceProperties
	extends HarmoniProperties
{

	/**
	 * Add a Property to these Properties.
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
	function addProperty ( $key, $value ) {
		$this->_properties[serialize($key)] = $value;
	}
}