<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");

/**
 * ThemeSetting interface defines what methods are required of any theme widget.
 * 
 * A ThemeSetting is a manager and container for a display option for a theme or
 * theme widget. The ThemeSetting class is used to get and set the values for each
 * setting.
 *
 * @package harmoni.themes
 * @version $Id: ThemeHandler.class.php,v 1.2 2004/03/03 19:18:32 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeHandler {
	/**
	 * @access private
	 * @var array $_themes The Themes known to this ThemeHandler.
	 **/
	var $_themes;
	
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	function ThemeHandler () {
		$this->_themes = array();
		
		// Add any built-in themes
//		$this->addTheme(new SimpleTheme);
	}

	/**
	 * Adds a Theme to those known to this manager.
	 * @access public
	 * @param object ThemeInterface The Theme to add.
	 * @return void
	 **/
	function addTheme (& $theme) {
		$id =& $theme->getId();
		$this->_themes[$id->getIdString()] =& $theme;
	}
	
	/**
	 * Returns the Theme known to this manager with the specified Id.
	 * @access public
	 * @param object Id The id of the desired Theme.
	 * @return object ThemeInterface The desired Theme object.
	 **/
	function & getTheme (& $id) {
		return $this->_themes[$id->getIdString()];
	}
	
	/**
	 * Returns the Themes known to the ThemeHandler.
	 * @access public
	 * @return object HarmoniIterator The an iterator of the Themes.
	 **/
	function & getThemes () {
		return new HarmoniIterator($this->_themes);
	}
		
}

?>