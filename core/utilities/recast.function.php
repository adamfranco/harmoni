<?

/**
 * Re-casts a given object $old_object to a new class ($new_classname).
 * @param ref object $old_object Any object.
 * @param string $new_classname
 * @return ref object Returns the object re-cast as $new_classname.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: recast.function.php,v 1.3 2005/01/19 21:10:15 adamfranco Exp $
 */
function &recast(&$old_object, $new_classname) {
	if(class_exists($new_classname)) {
		$old_serialized_object = serialize($old_object);
		$old_object_name_length = strlen(get_class($old_object));
		$subtring_offset = $old_object_name_length + strlen($old_object_name_length) + 6;
		$new_serialized_object = 'O:' . strlen($new_classname) . ':"' . 
			$new_classname . '":'.substr($old_serialized_object, $subtring_offset);
		return unserialize($new_serialized_object);
	} else {
		return false;
	}
}

?>