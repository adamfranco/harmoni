<?

require_once(HARMONI."dataManager/primitives/Float.class.php");

/**
 * A simple Double data type.
 * @package harmoni.datamanager.primitives
 * @copyright 2004
 * @version $Id: Double.class.php,v 1.1 2004/07/26 04:21:16 gabeschine Exp $
 */
class Double extends Float {

	function Double($value) {
		parent::Float($value);
	}
	
}