<?php

require_once(HARMONI."GUIManager/GUIManager.abstract.php");
require_once(HARMONI."GUIManager/Theme.class.php");
require_once(HARMONI."GUIManager/StyleComponent.class.php");
require_once(HARMONI."GUIManager/StyleProperty.class.php");
require_once(HARMONI."GUIManager/Component.class.php");

/**
 * An implmentation of the GUIManagerInterface. This implementation
 * is pretty straightforward and does not maintain any sort of caching
 * data structures. Theme states are dealt with on the fly whenever one of 
 * the load/replace/save/delete methods is called.<br /><br />
 * This class provides methods for theme management: saving/loading of theme state,
 * obtaining information about supported GUI components, etc.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GUIManager.class.php,v 1.25 2006/04/26 14:21:29 cws-midd Exp $
 */
class GUIManager 
	extends GUIManagerAbstract 
{

	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbIndex;

	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbName;
		
	/**
	 * Constructor
	 * @param integer dbIndex The database connection to use as returned by the DBHandler.
	 * @param string guiDB The name of the GUIManager database.
	 * manager.
	 * @access public
	 */
	function GUIManager() {
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 *	default_theme			object Theme
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$dbIndex =& $configuration->getProperty('database_index');
		$dbName =& $configuration->getProperty('database_name');
		$theme =& $configuration->getProperty('default_theme');
		$id =& $configuration->getProperty('default_state_id');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($theme, ExtendsValidatorRule::getRule("ThemeInterface"), true);
		// ** end of parameter validation
		
		$this->_dbName = $dbName;
		$this->_dbIndex = $dbIndex;
		$this->setTheme($theme);
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function &getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( &$context ) { 
		ArgumentValidator::validate($context->getContext('harmoni'),
			ExtendsValidatorRule::getRule('Harmoni'));
		
		$this->_osidContext =& $context;
		
		$this->attachToHarmoni();
	}

	/**
	 * Returns a list of styleCollections supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a theme.
	 **/
	function getSupportedStyleCollections() {
		$themesDir = dirname(__FILE__).$this->getStyleCollectionPath();
		
		//the array of supported themes
		$themes = array();
		
		//make sure the specified name is indeed a directory
		if(is_dir($themesDir)){
			
		$dh = opendir($themesDir);
			while (($file = readdir($dh)) !== false) {
				//ignore other files or directories
				if (ereg(".class.php", $file)){ 
					
					//strip the ".class.php" from the end of the file
					$file = rtrim($file,".class.php");
					$themes[] = $file;
				}
			}
		unset($file,$dh);
		}
		return $themes;
	}
	
	/**
	 * Returns the path that contains all the supported themes.
	 * @access public
	 * @return string The relative path to the Theme directory.
	 **/
	function getSytleCollectionPath() {
		return "/StyleCollections/";
	}
	
	/**
	 * Returns a list of style properties supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style property.
	 **/
	function getSupportedSPs() {
		$SPDir = dirname(__FILE__).$this->getSPPath();
		
		//the array of supported SPs
		$SPs = array();
		
		//make sure the specified name is indeed a directory
		if(is_dir($SPDir)){
			
		$dh = opendir($SPDir);
			while (($file = readdir($dh)) !== false) {
				//ignore other files or directories
				if (ereg(".class.php", $file)){ 
					
					//strip the ".class.php" from the end of the file
					$file = rtrim($file,".class.php");
					$SPs[] = $file;
				}
			}
		unset($file,$dh);
		}
		return $SPs;
			
	}
	
	/**
	 * Returns the path that contains all the supported style properties.
	 * @access public
	 * @return string The relative path to the style property directory.
	 **/
	function getSPPath() {
		return "/StyleProperties/";
	}	
	
	/**
	 * Returns a list of style components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style components.
	 **/
	function getSupportedSCs() {
		$SCDir = dirname(__FILE__).$this->getSCPath();
		
		//the array of supported SCs
		$SCs = array();
		
		//make sure the specified name is indeed a directory
		if(is_dir($SCDir)){
			
		$dh = opendir($SCDir);
			while (($file = readdir($dh)) !== false) {
				//ignore other files or directories
				if (ereg(".class.php", $file)){ 
					
					//strip the ".class.php" from the end of the file
					$file = rtrim($file,".class.php");
					$SCs[] = $file;
				}
			}
		unset($file,$dh);
		}
		return $SCs;
	}
	
	/**
	 * Returns the path that contains all the supported style component.
	 * @access public
	 * @return string The relative path to the style component directory.
	 **/
	function getSCPath() {
		return "/StyleComponents/";
	}
	
	/**
	 * Returns a list of components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a component.
	 **/
	function getSupportedComponents() {
		$ComponentDir = dirname(__FILE__).$this->getComponentPath();
		
		//the array of supported Components
		$Components = array();
		
		//make sure the specified name is indeed a directory
		if(is_dir($ComponentDir)){
			
		$dh = opendir($ComponentDir);
			while (($file = readdir($dh)) !== false) {
				//ignore other files or directories
				if (ereg(".class.php", $file)){ 
					
					//strip the ".class.php" from the end of the file
					$file = rtrim($file,".class.php");
					$Components[] = $file;
				}
			}
		unset($file,$dh);
		}
		return $Components;
	}
	
	/**
	 * Returns the path that contains all the supported components.
	 * @access public
	 * @return string The relative path to the Component directory.
	 **/
	function getComponentPath() {
		return "/Components/";
	}	
	
	/**
	 * Returns a list of layouts supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a layout.
	 **/
	function getSupportedLayouts() {
		$LayoutDir = dirname(__FILE__).$this->getLayoutPath();
		
		//the array of supported Layouts
		$Layouts = array();
		
		//make sure the specified name is indeed a directory
		if(is_dir($LayoutDir)){
			
		$dh = opendir($LayoutDir);
			while (($file = readdir($dh)) !== false) {
				//ignore other files or directories
				if (ereg(".class.php", $file)){ 
					
					//strip the ".class.php" from the end of the file
					$file = rtrim($file,".class.php");
					$Layouts[] = $file;
				}
			}
		unset($file,$dh);
		}
		return $Layouts;
	}
	
	/**
	 * Returns the path that contains all the supported layouts.
	 * @access public
	 * @return string The relative path to the Layout directory.
	 **/
	function getLayoutPath() {
		return "/Layouts/";
	}
	
/*********************************************************
 * Customization of A Theme Instance (Create, Save, Load, Delete)
 *********************************************************/

	/**
	 * Saves the theme state to the database. The theme state is saved by 
	 * exporting the theme's style properties, and then serializing the output
	 * and storing it into the database.
	 * @access public
	 * @param ref object theme The theme whose state needs to be saved.
	 * @return ref object A HarmoniId objecting identifying the saved state uniquely.
	 **/
	function &saveThemeState(& $theme, $idValue) {
		// ** parameter validation
		ArgumentValidator::validate($theme, ExtendsValidatorRule::getRule("ThemeInterface"), true);
		// ** end of parameter validation

		$exportData = $theme->exportAllRegisteredSPs();
		
		if (count($exportData) == 0) {
		    // no theme state to save
			$err = "Attempted to save a theme with no intrinsic state.";
			throwError(new Error($err, "GUIManager", false));
			return;
		}
		
		// create the theme state to go into the database.
		$themeState = serialize($exportData);
		/*
		// 1. create an id for the theme state
		$sharedManager =& Services::getService("Shared");
		$id =& $sharedManager->createId();
		$idValue = $id->getIdString();
		*/
		// 2. now simply insert the theme state
		$db = $this->_guiDB.".";
		$dbHandler =& Services::getService("DatabaseManager");
		$query =& new InsertQuery();
		$query->setTable($db."gui");
		$columns = array();
		$columns[] = $db."gui.gui_id";
		$columns[] = $db."gui.gui_theme";
		$columns[] = $db."gui.gui_state";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes(get_class($theme))."'";
		$values[] = "'".addslashes($themeState)."'";
		$query->setValues($values);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		return $id;		
	}

	/**
	 * Saves the theme state to the database. The theme state is saved by 
	 * exporting the theme's style properties, and then serializing the output
	 * and storing it into the database.
	 * @access public
	 * @param ref object theme The theme whose state needs to be saved.
	 * @return ref object A HarmoniId objecting identifying the saved state uniquely.
	 **/
	function &saveTheme(& $theme, $idValue) {
		// ** parameter validation
		ArgumentValidator::validate($theme, ExtendsValidatorRule::getRule("ThemeInterface"), true);
		// ** end of parameter validation

		$exportData = $theme->exportAllRegisteredSPs();
		
		if (count($exportData) == 0) {
		    // no theme state to save
			$err = "Attempted to save a theme with no intrinsic state.";
			throwError(new Error($err, "GUIManager", false));
			return;
		}
		
		// create the theme state to go into the database.
		$themeState = serialize($exportData);
		/*
		// 1. create an id for the theme state
		$sharedManager =& Services::getService("Shared");
		$id =& $sharedManager->createId();
		$idValue = $id->getIdString();
		*/
		// 2. now simply insert the theme state
		$db = $this->_guiDB.".";
		$dbHandler =& Services::getService("DatabaseManager");
		$query =& new InsertQuery();
		$query->setTable($db."gui");
		$columns = array();
		$columns[] = $db."gui.gui_id";
		$columns[] = $db."gui.gui_theme";
		$columns[] = $db."gui.gui_state";
		$query->setColumns($columns);
		$values = array();
		$values[] = "'".addslashes($idValue)."'";
		$values[] = "'".addslashes(get_class($theme))."'";
		$values[] = "'".addslashes($themeState)."'";
		$query->setValues($values);
		
//		echo "<pre>\n";
//		echo MySQL_SQLGenerator::generateSQLQuery($query);
//		echo "</pre>\n";
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		return $id;		
	}
	
	/**
	 * This method is like <code>saveThemeState</code>, but instead of creating
	 * a new database entry for the theme state, it replaces an existing theme state.
	 * @access public
	 * @param ref object stateId The id of the theme state that will be replaced.
	 * @param ref object theme The theme whose state needs to be saved.
	 **/
	function replaceThemeState(& $stateId, & $theme) {
		// ** parameter validation
		ArgumentValidator::validate($stateId, ExtendsValidatorRule::getRule("HarmoniId"), true);
		ArgumentValidator::validate($theme, ExtendsValidatorRule::getRule("ThemeInterface"), true);
		// ** end of parameter validation
		
		$exportData = $theme->exportAllRegisteredSPs();
		
		//add verification that the themestate with 
		//$stateId really exists
		
		
		if (count($exportData) == 0) {
		    // no date to update the theme state
			$err = "There are no registered Style Properties in your theme";
			throwError(new Error($err, "GUIManager", true));
			return;
		}
		
		
		
		// create the theme state to go into the database.
		$themeState = serialize($exportData);
		
		//set up the query
		$db = $this->_guiDB.".";
		$dbHandler =& Services::getService("DatabaseManager");
		$idValue = $stateId->getIdString();
		$query =& new UpdateQuery;
		$query->setTable($db."gui");
		$query->setColumns(array($db."gui.gui_state"));
		$values = array();
		$values[] = "'".addslashes($themeState)."'";
		$query->setValues($values);
		$query->addWhere($db."gui.gui_id=$idValue");
		
		//echo "<pre>\n";
		//echo MySQL_SQLGenerator::generateSQLQuery($query);
		//echo "</pre>\n";
		//exit();
		//run the query
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "None or more than one theme states were updated.";
			throwError(new Error($err, "GUIManager", true));
		}
	}
	
	/**
	 * Loads the theme state stored priorly with <code>saveThemeState()</code>. This 
	 * method reverses the steps of <code>saveThemeState()</code>. It first obtains
	 * the database-stored theme state, unserializes it, and finally imports
	 * it into the theme.
	 * @access public
	 * @param ref object stateId The id of the theme state that will be loaded.
	 * @param ref object theme The theme whose state needs to be loaded.
	 **/
	function loadThemeState(& $stateId, & $theme) {
		// ** parameter validation
		ArgumentValidator::validate($theme, ExtendsValidatorRule::getRule("ThemeInterface"), true);
		ArgumentValidator::validate($stateId, ExtendsValidatorRule::getRule("HarmoniId"), true);
		// ** end of parameter validation
		
		// get the theme state from the database
		$db = $this->_guiDB.".";
		$dbHandler =& Services::getService("DatabaseManager");
		$idValue = $stateId->getIdString();
		$query =& new SelectQuery();
		$query->addColumn("gui_theme", "theme", $db."gui");
		$query->addColumn("gui_state", "state", $db."gui");
		$query->addTable($db."gui");
		$query->addWhere($db."gui.gui_id = ".$idValue);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$queryResult->free();
			$err = "None or more than one theme states were returned.";
			throwError(new Error($err, "GUIManager", true));
		}
		
		$queryResult->bindField("theme", $themeName);
		$queryResult->bindField("state", $themeState);
		$row = $queryResult->getCurrentrow();
		$queryResult->free();
		if (strtolower($themeName) != strtolower(get_class($theme))) {
			$err = "Attempted to load an incomptaible theme state (the theme state was saved for a different theme class).";
			throwError(new Error($err, "GUIManager", true));
		}
		
		// now import the theme state
		$importData = unserialize($themeState);
//		printpre($importData);
		
		foreach ($importData as $id => $data)
			$theme->importRegisteredSP($id, $data);
		
	}

	/**
	 * Loads the theme state stored priorly with <code>saveThemeState()</code>. This 
	 * method reverses the steps of <code>saveThemeState()</code>. It first obtains
	 * the database-stored theme state, unserializes it, and finally imports
	 * it into the theme.
	 * @access public
	 * @param ref object themeId The id of the theme that will be loaded.
	 **/
	function loadTheme(& $themeId) {
		// ** parameter validation
		ArgumentValidator::validate($themeId, ExtendsValidatorRule::getRule("HarmoniId"), true);
		// ** end of parameter validation
		
		// get the theme state from the database
		$dbHandler =& Services::getService("DatabaseManager");
		$idValue = $themeId->getIdString();
		$query =& new SelectQuery();
		$query->addTable($this->_dbName."tm_themes");
		$query->addWhere("theme_id = $themeId");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		if ($queryResult->getNumberOfRows() == 1) {
			$row =& $queryResult->next();
			$this->setTheme(new Theme( $row['theme_display_name'],
									   $row['theme_description']));
			$this->_theme->_template = $row['theme_template'];
			$this->_theme->_custom_lev = $row['theme_custom_lev'];
			$queryResult->free();
			// passes execution to collection loading from DB
			$this->loadStyleCollectionsForTheme($themeId);
		} else {
			throwError( new Error( "GUIManager", "NO or MULTIPLE THEMES FOR ID"));
		}
	}
	
	/**
	 * Loads the Style Collections for the given theme_id from the database
	 * and adds them to the current theme
	 * 
	 * @param object HarmoniId $themeId the id of the theme
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStyleCollectionsForTheme (&$themeId) {
		$dbHandler =& Services::getService("DBHandler");
		$idValue =& $themeId->getIdString();

		$query =& new SelectQuery();
		$query->addTable($this->_dbName."tm_style_collection");
		$query->addWhere("FK_theme_id = $themeId");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		while ($queryResult->hasMoreRows()) {
			$row =& $queryResult->next();
			
			// this is where we decide on style collection class for image borders
			if ($row['collection_template'] == '') {
				$styleCollection =& new StyleCollection(
					$row['collection_selector'],
					$row['collection_class_selector'],
					$row['collection_display_name'],
					$row['collection_description']);
			} else if (in_array(
								$row['collection_template']."StyleCollection",
								$this->getSupportedStyleCollections())) {
				$class = $row['collection_template']."StyleCollection";
				$styleCollection =& new $class(
					$row['collection_selector'],
					$row['collection_class_selector'],
					$row['collection_display_name'],
					$row['collection_description']);
					
					// deal with border urls here
			}

			// passes execution to property loading from DB
			$this->loadStylePropertiesForCollection($row['collection_id'], $styleCollection);
			if (is_null($row['collection_selector']))
				$this->_theme->addGlobalStyle($styleCollection);
			else
				$this->_theme->addStyleForComponentType($styleCollection,
												$row['collection_type'],
												$row['collection_index']);
		}
		if ($queryResult->getNumberOfRows == 0) {
//			throwError( new Error( "GUIManager", "NO STYLE COLLECTIONS FOR THEME ID"));
		}
		$queryResult->free();
	}
	
	/**
	 * Loads the Style Properties for the given collection_id from the database
	 * and adds them to the style collection.
	 * 
	 * @param string $collectionId the id of the style collection
	 * @param object StyleCollection the style collection object
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStylePropertiesForCollection($collectionId, &$collection) {
		$dbHandler =& Services::getService("DBHandler");
		$idValue =& $collectionId;

		$query =& new SelectQuery();
		$query->addTable($this->_dbName."tm_style_property");
		$query->addWhere("FK_collection_id = $collectionId");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		while ($queryResult->hasMoreRows()) {
			$row =& $queryResult->next();
			
			$class = $row['property_name']."SP";
			
			$styleProperty =& new $class();
			
			// passes execution to component loading from DB
			$this->loadStyleComponentsForProperty($row['property_id'], $styleProperty);

			$collection->addSP($styleProperty);
		}
		if ($queryResult->getNumberOfRows == 0) {
//			throwError( new Error( "GUIManager", "NO STYLE PROPERTIES FOR THEME ID"));
		}
		$queryResult->free();
	}
	
	/**
	 * Loads the Style Components for the given property_id from the database
	 * and adds them to the style property
	 * 
	 * @param string $propertyId the id of the style property
	 * @param object StyleProperty the style property object
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStyleComponentsForProperty ($propertyId, &$property) {
		$dbHandler =& Services::getService("DBHandler");
		$idValue =& $collectionId;

		$query =& new SelectQuery();
		$query->addTable($this->_dbName."tm_style_component");
		$query->addWhere("FK_property_id = $propertyId");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		while ($queryResult->hasMoreRows()) {
			$row =& $queryResult->next();
			
			$class = $row['component_class_name']."SC";
			
			$styleComponent =& new $class($row['component_value']);

			$property->addSC($styleComponent);
		}
		if ($queryResult->getNumberOfRows == 0) {
//			throwError( new Error( "GUIManager", "NO STYLE PROPERTIES FOR THEME ID"));
		}
		$queryResult->free();
	}
	
	/**
	 * Deletes the theme state with the given id from the database. Notice that
	 * this does not affect the Theme whose state is being deleted in any way!
	 * @access public
	 * @param ref object $id A HarmoniId identifying the theme state that needs to
	 * be deleted.
	 **/
	function deleteThemeState(& $id) {
		// ** parameter validation
		ArgumentValidator::validate($id, ExtendsValidatorRule::getRule("HarmoniId"), true);
		// ** end of parameter validation
		
		$db = $this->_guiDB.".";
		$dbHandler =& Services::getService("DatabaseManager");
		$idValue = $id->getIdString();
		$query =& new DeleteQuery;
		$query->setTable($db."gui");
		$query->addWhere($db."gui.gui_id = ".$idValue);
		
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		$affectedStates = $queryResult->getNumberOfRows();
		if ($affectedStates == 0) {
			$err = "The requested theme state was not found";
			throwError(new Error($err, "GUIManager", false));
		}
		
		if ($affectedStates > 1) {
			$err = "More than one entry was affected by the Query. Maybe something nasty has happened!";
			throwError(new Error($err, "GUIManager", false));
		}
		
	}
}

?>