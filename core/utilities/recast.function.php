<?

function &recast(&$old_object, $new_classname) {
	if(class_exists($new_classname)) {
		$old_serialized_object = serialize($old_object);
		$old_object_name_length = strlen(get_class($old_object));
		$subtring_offset = $old_object_name_length + strlen($old_object_name_length) + 6;
		$new_serialized_object  = 'O:' . strlen($new_classname) . ':"' . $new_classname . '":';
		$new_serialized_object .= substr($old_serialized_object, $subtring_offset);
		return unserialize($new_serialized_object);
	} else {
		return false;
	}
}

?>