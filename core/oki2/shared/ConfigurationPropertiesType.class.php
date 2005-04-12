<?

require_once(HARMONI."oki2/shared/HarmoniType.class.php");

/**
 * This Type is that which makes use of the Harmoni AuthenticationHandler.
 *
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ConfigurationPropertiesType.class.php,v 1.2 2005/04/12 19:26:46 adamfranco Exp $
 */
class ConfigurationPropertiesType
	 extends HarmoniType 
{

	function ConfigurationPropertiesType() {
		$this->HarmoniType("Harmoni", 
						   "Harmoni", 
						   "Configuration", 
						   "Things for configuring services.");	
	}

}

?>