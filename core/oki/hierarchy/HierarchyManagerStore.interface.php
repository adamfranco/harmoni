<?php

/******************************************************************************
 * A storage class for HierarchyManager[s]. This class provides saving and loading
 * of the HierarchyManager from persistable storage.
 * @author Adam Franco
 * @version $$
 ******************************************************************************/


class HierarchyManagerStore
{

	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

}
?>