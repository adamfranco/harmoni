<?

/**
 * A class for passing an integer or a string representation of an integer as an
 * id.
 *
 * @package harmoni.osid_v1.shared
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniId.class.php,v 1.16 2005/03/29 19:44:21 adamfranco Exp $
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
		ArgumentValidator::validate($id, StringValidatorRule::getRule()("Id"), true);
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
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("Id"));
		
		return ($id->getIdString() == $this->_id) ? true : false;
	}

}

?>