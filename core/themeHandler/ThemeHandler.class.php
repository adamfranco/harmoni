<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/Theme.abstract.php");

/**
 * ThemeSetting interface defines what methods are required of any theme widget.
 * 
 * A ThemeSetting is a manager and container for a display option for a theme or
 * theme widget. The ThemeSetting class is used to get and set the values for each
 * setting.
 *
 * @package harmoni.themes
 * @version $Id: ThemeHandler.class.php,v 1.4 2004/03/17 17:51:06 adamfranco Exp $
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
	function ThemeHandler ( $configuration = NULL ) {
		
		if (is_array($configuration)) {
			if ($configuation['storage_method'] == 'database') {
				$this->_storageMethod = 'database';
				$this->_storageLocation = $configuation['database_id'];
			} else if ($configuation['storage_method'] == 'xml_files') {
				$this->_storageMethod = 'xml_files';
				$this->_storageLocation = $configuation['directory'];
			}
		}
		
		$this->_themes = array();
		
		$this->_storedThemes = array();
		
		// Add any built-in themes
//		$this->addTheme(new SimpleTheme);
	}

	/**
	 * Adds a Theme class to those known to this manager.
	 * @access public
	 * @param string $class The class of the Theme to add.
	 * @return void
	 **/
	function addTheme ( $class ) {
		$this->_themes[$class] =& new $class;
	}
	
	/**
	 * Returns the Theme known to this manager of the specified class.
	 * @access public
	 * @param string $class The class of the desired Theme.
	 * @return object ThemeInterface The desired Theme object.
	 **/
	function & getThemeByClass ( $class ) {
		return $this->_themes[$class];
	}
	
	/**
	 * Returns the Themes known to the ThemeHandler.
	 * @access public
	 * @return object HarmoniIterator The an iterator of the Themes.
	 **/
	function & getThemes () {
		return new HarmoniIterator($this->_themes);
	}
	
	/**
	 * Returns the stored Theme of the specified id.
	 * @access public
	 * @param object Id $id The id of the desired Theme.
	 * @return object ThemeInterface The desired Theme object.
	 **/
	function & getStoredTheme ( & $id ) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		// If the requested theme is not cached, look for it in storage and
		// throw an error if it is not found.
		if (!$this->_storedThemes[$id->getIdString()]) {
			if ($this->_storageMethod == 'database') {
				$this->_loadThemeFromDB($id);
			} else if ($this->_storageMethod == 'xml_files') {
				$this->_loadThemeFromXMLFile($id);
			} else {
				throwError(new Error("Cannont get stored themes from storage method, ' ".$this->_storageMethod."'.", "ThemeHandler", TRUE));
			}
		}
				
		return $this->_storedThemes[$id->getIdString()];
	}
	
	/**
	 * Loads a stored theme from the database.
	 * @access private
	 * @param object Id $id The id of the theme to load.
	 * @return void.
	 */
	function _loadThemeFromDB ( & $id ) {
		if ($this->_dbid === NULL)
			throwError(new Error("Cannont get stored theme from non-existant database id, ' ".$this->_dbid."'.", "ThemeHandler", TRUE));
		
		$query =& new SelectQuery;
		$query->addColumn("theme.class_name", "theme_class");
		$query->addColumn("widget_type.type", "widget_type");
		$query->addColumn("setting.widget_index", "widget_index");
		$query->addColumn("setting.key", "setting_key");
		$query->addColumn("setting.value", "setting_value");
		
		$query->addTable("theme");
		$query->addTable("setting", INNER_JOIN, "theme.id = setting.fk_theme");
		$query->addTable("widget", LEFT_JOIN, "widget.id = setting.fk_widget");
		
		$dbhandler =& Services::getService("DBHandler");
		$result =& $dbhandler->query($query, $this->_dbid);
		
		// Create our theme object
		if (class_exists($result->field("theme_class"))) 
			$theme =& new $result->field("theme_class");
		else
			throwError(new Error("Cannont load theme, ' ".$result->field("theme_class")."'. Class does not exist.", "ThemeHandler", TRUE));
		
		// Load each of our settings
		while ($result->hasMoreRows()) {
			// Get the appropriate setting object.
			
			// If we don't have a widget_type, then this is a theme setting as
			// opposed to a widget setting.
			if (!$result->field("widget_type")) {
				$setting =& $theme->getSetting($result->field("setting_key"));
			} else {
				$widget =& $theme->getWidget($result->field("widget_type"), 
												$result->field("widget_index"));
			}
			
			$result->advanceRow();
		}
	}
}

?>