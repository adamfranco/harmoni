<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/Theme.abstract.php");

// Built-in Themes
require_once(HARMONI."/themeHandler/themes/SimpleLines.theme.php");
require_once(HARMONI."/themeHandler/themes/ImageBox/ImageBox.theme.php");

/**
 * ThemeSetting interface defines what methods are required of any theme widget.
 * 
 * A ThemeSetting is a manager and container for a display option for a theme or
 * theme widget. The ThemeSetting class is used to get and set the values for each
 * setting.
 *
 * @package harmoni.themes
 * @version $Id: ThemeHandler.class.php,v 1.9 2004/04/13 23:37:19 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeHandler {

	/**
	 * @access private
	 * @var string $_storageMethod The method used to store themes.
	 */
	var $_storageMethod;
	
	/**
	 * @access private
	 * @var string $_storageLocation The location used to store themes.
	 */
	var $_storageLocation;
	
	/**
	 * @access private
	 * @var array $_registeredThemes The Themes registered this ThemeHandler.
	 **/
	var $_registeredThemes;
	
	/**
	 * @access private
	 * @var array $_storedThemes The stored Themes known to this ThemeHandler.
	 **/
	var $_storedThemes;
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	function ThemeHandler ( $configuration = NULL ) {
			
		if (is_array($configuration)) {
			if ($configuration['storage_method'] == 'database') {
				$this->_storageMethod = 'database';
				$this->_storageLocation = $configuration['database_id'];
			} else if ($configuration['storage_method'] == 'xml_files') {
				$this->_storageMethod = 'xml_files';
				$this->_storageLocation = $configuration['directory'];
			}
		}
		
		$this->_registeredThemes = array();
		
		$this->_storedThemes = array();
		
		// Add any built-in themes
		$this->registerThemeClass("SimpleLinesTheme");
		$this->registerThemeClass("ImageBoxTheme");
	}

	/**
	 * Adds a Theme class to those known to this manager.
	 * @access public
	 * @param string $class The class of the Theme to add.
	 * @return void
	 **/
	function registerThemeClass ( $class ) {
		$this->_registeredThemes[strtolower($class)] =& new $class;
	}
	
	/**
	 * Returns the Theme known to this manager of the specified class.
	 * @access public
	 * @param string $class The class of the desired Theme.
	 * @return object ThemeInterface The desired Theme object.
	 **/
	function & getRegisteredThemeByClass ( $class ) {
		return $this->_registeredThemes[strtolower($class)];
	}
	
	/**
	 * Returns the Themes known to the ThemeHandler.
	 * @access public
	 * @return object HarmoniIterator The an iterator of the Themes.
	 **/
	function & getRegisteredThemes () {
		return new HarmoniIterator($this->_registeredThemes);
	}
	
	/**
	 * Returns the stored Themes.
	 * @access public
	 * @return object HarmoniIterator The an iterator of the Themes.
	 **/
	function & getStoredThemes () {
		$query =& new SelectQuery;
		$query->addColumn("theme.id", "theme_id");
		$query->addColumn("theme.class_name", "theme_class");
		$query->addColumn("widget_type.type", "widget_type");
		$query->addColumn("setting.widget_index", "widget_index");
		$query->addColumn("setting.setting_key", "setting_key");
		$query->addColumn("setting.value", "setting_value");
		
		$query->addTable("theme");
		$query->addTable("setting", INNER_JOIN, "theme.id = setting.fk_theme");
		$query->addTable("widget_type", LEFT_JOIN, "widget_type.id = setting.fk_widget_type");
				
		$dbhandler =& Services::getService("DBHandler");
		$result =& $dbhandler->query($query, $this->_storageLocation);
		
		$sharedManager =& Services::getService("Shared");
		
		while ($result->hasMoreRows()) {
			// Create our theme object
			if (class_exists($result->field("theme_class"))) {
				$class = $result->field("theme_class");
				$theme =& new  $class;
				
				$theme->setId($sharedManager->getId($result->field("theme_id")));
				$themeId =& $theme->getId();
			} else
				throwError(new Error("Cannont load theme, ' ".$result->field("theme_class")."'. Class does not exist.", "ThemeHandler", TRUE));
			
			// Load each of our settings
			while ($result->hasMoreRows() && $result->field("theme_id") == $themeId->getIdString()) {
				// Get the appropriate setting object.
				
				// If we don't have a widget_type, then this is a theme setting as
				// opposed to a widget setting.
				if (!$result->field("widget_type")) {
					$setting =& $theme->getSetting($result->field("setting_key"));
				} else {
					$widget =& $theme->getWidget($result->field("widget_type"), 
													$result->field("widget_index"));
					$setting =& $widget->getSetting($result->field("setting_key"));
				}
				
				// Set the value of the setting
				$setting->setValue($result->field("setting_value"));
				
				$result->advanceRow();
			}
		
			// put the theme in our storedThemes array
			$this->_storedThemes[$themeId->getIdString()] =& $theme;
		}

		return new HarmoniIterator($this->_storedThemes);
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
			if ($this->_storageLocation === NULL)
				throwError(new Error("Cannont get stored theme from non-existant database id, ' ".$this->_storageLocation."'.", "ThemeHandler", TRUE));
			
			$query =& new SelectQuery;
			$query->addColumn("theme.class_name", "theme_class");
			$query->addColumn("widget_type.type", "widget_type");
			$query->addColumn("setting.widget_index", "widget_index");
			$query->addColumn("setting.setting_key", "setting_key");
			$query->addColumn("setting.value", "setting_value");
			
			$query->addTable("theme");
			$query->addTable("setting", INNER_JOIN, "theme.id = setting.fk_theme");
			$query->addTable("widget_type", LEFT_JOIN, "widget_type.id = setting.fk_widget_type");
			
			$query->addWhere("theme.id='".$id->getIdString()."'");
			
			$dbhandler =& Services::getService("DBHandler");
			$result =& $dbhandler->query($query, $this->_storageLocation);
			
			// Create our theme object
			if (class_exists($result->field("theme_class"))) {
				$class = $result->field("theme_class");
				$theme =& new $class;
				$theme->setId($id);
			} else
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
					$setting =& $widget->getSetting($result->field("setting_key"));
				}
				
				// Set the value of the setting
				$setting->setValue($result->field("setting_value"));
				
				$result->advanceRow();
			}
		
			// put the theme in our storedThemes array
			$this->_storedThemes[$id->getIdString()] =& $theme;
		}
				
		return $this->_storedThemes[$id->getIdString()];
	}
	
	/**
	 * Stores the Theme.
	 * @access public
	 * @param object Id $id The id of the desired Theme.
	 **/
	function storeTheme( & $theme) {
		ArgumentValidator::validate($theme, new ExtendsValidatorRule("ThemeInterface"));
		
		if ($theme->hasId()) {
			$id =& $theme->getId();
		} else {
			$sharedManager =& Services::getService("Shared");
			$id =& $sharedManager->createId();
			$theme->setId($id);
		}
		
		$dbhandler =& Services::getService("DBHandler");
		
		// Remove the old version of the theme from the DB if it exists:		
		$query =& new DeleteQuery;
		$query->setTable("setting");
		$query->addWhere("fk_theme='".$id->getIdString()."'");
		$dbhandler->query($query, $this->_storageLocation);
		$query =& new DeleteQuery;
		$query->setTable("theme");
		$query->addWhere("id='".$id->getIdString()."'");
		$dbhandler->query($query, $this->_storageLocation);
		
		// Store the theme
		$query =& new InsertQuery;
		$query->setTable("theme");
		$query->setColumns(array("id","class_name"));
		$query->addRowOfValues(array($id->getIdString(), "'".get_class($theme)."'"));
		$dbhandler->query($query, $this->_storageLocation);		
		
		// Store all of the settings
		$query =& new InsertQuery;
		$query->setTable("setting");
		$query->setColumns(array("fk_theme","fk_widget_type","widget_index","setting_key","value"));
		
		$widgetTypes = array();
		
		// Store the theme settings
		$settings =& $theme->getSettings();
		while ($settings->hasNext()) {
			$setting =& $settings->next();
			$query->addRowOfValues(array("'".$id->getIdString()."'",
										 "'0'", 
										 "'0'", 
										 "'".$setting->getKey()."'", 
										 "'".$setting->getValue()."'"));
		}
		
		// Store the widget settings
		$allWidgets =& $theme->getAllWidgets();
		while ($allWidgets->hasNext()) {
			$widget =& $allWidgets->next();
			
			if ($widget->hasSettings()) {
			
				// we need to find the keys for our widget types, so lets
				// cache them as we find/create them.
				if (in_array($widget->getType(), $widgetTypes)) {
					$keys = array_keys($widgetTypes, $widget->getType());
					$widgetKeys = $keys[0];
				} else {
					// It seems we don't know the key, so lets select for it
					$widgetTypeQuery =& new SelectQuery();
					$widgetTypeQuery->addTable("widget_type");
					$widgetTypeQuery->addColumn("id");
					$widgetTypeQuery->addWhere("type='".$widget->getType()."'");
					$result =& $dbhandler->query($widgetTypeQuery, $this->_storageLocation);
	
					if ($result->getNumberOfRows()) {
						// if we got a result, use its key
						$widgetKey = $result->field("id");
						$widgetTypes[$widgetKey] = $widget->getType();
					} else {
						// otherwise, insert into the widget table.
						$widgetTypeQuery =& new InsertQuery();
						$widgetTypeQuery->setTable("widget_type");
						$widgetTypeQuery->setColumns(array("type"));
						$widgetTypeQuery->addRowOfValues(array("'".$widget->getType()."'"));
						$result =& $dbhandler->query($widgetTypeQuery, $this->_storageLocation);
						$widgetKey = $result->getLastAutoIncrementValue();
						$widgetTypes[$widgetKey] = $widget->getType();
					}
				}


				$settings =& $widget->getSettings();
				while ($settings->hasNext()) {
					$setting =& $settings->next();
					$query->addRowOfValues(array("'".$id->getIdString()."'",
												 "'".$widgetKey."'", 
												 "'".$widget->getIndex()."'", 
												 "'".$setting->getKey()."'", 
												 "'".$setting->getValue()."'"));
				}
			}
		}
		$dbhandler->query($query, $this->_storageLocation);
	}
	
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
}

?>