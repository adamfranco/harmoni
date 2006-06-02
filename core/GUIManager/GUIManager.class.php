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
 * @version $Id: GUIManager.class.php,v 1.26 2006/06/02 15:56:06 cws-midd Exp $
 */
class GUIManager 
	extends GUIManagerAbstract 
{

	/*********************************************************
	 * GUIManager Setup Stuff
	 *********************************************************/

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

	/*********************************************************
	 * Helper Functions
	 *********************************************************/

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
				if (ereg(".class.php", $file) && !ereg('^._', $file)){ 
					
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

	/*********************************************************
	 * Theme Retrieving from the database
	 *********************************************************/

	/**
	 * Loads the theme stored earlier with <code>saveTheme()</code>. This 
	 * method reverses the steps of <code>saveTheme()</code>. It first obtains
	 * the database-stored theme, then instantiates a Theme object with the data.
	 *
	 * @access public
	 * @param ref object HarmoniId $themeId The id of the theme that will be loaded.
	 * @return ref object Theme
	 **/
	function &getThemeById(& $themeId) {
		// ** parameter validation
		ArgumentValidator::validate($themeId, ExtendsValidatorRule::getRule("HarmoniId"), true);
		// ** end of parameter validation
		
		// get the theme state from the database
		$dbHandler =& Services::getService("DatabaseManager");
		$idValue = $themeId->getIdString();
		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_theme");
		$query->addWhere("theme_id = $idValue");
		$query->addColumn("*");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		if ($queryResult->getNumberOfRows() == 1) {
			$row =& $queryResult->next();
			$theme =& new Theme( $row['theme_display_name'],
								 $row['theme_description']);
			$theme->setTemplate($row['theme_template']);
			$theme->setCustom($row['theme_custom_lev']);
			$theme->setId($themeId);
			$queryResult->free();
			// passes execution to collection loading from DB
			$this->loadStyleCollectionsForTheme($theme);
		} else {
			throwError( new Error( "GUIManager", "NO or MULTIPLE THEMES FOR ID"));
		}
		return $theme;
	}
	
	/**
	 * Load theme
	 * 
	 * @param object HarmoniId $themeId
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function loadTheme (&$themeId) {
		$this->setTheme($this->getTheme($themeId));
	}
	
	/**
	 * Creates a new theme object with an Id
	 * @access static
	 * @param string $displayName
	 * @param string $description
	 * @return ref object Theme
	 **/
	function &createTheme($displayName, $description) {
		$idManager =& Services::getService("Id");
		$theme =& new Theme($displayName, $description);
		
		$theme->_id =& $idManager->createId();
		
		return $theme;
	}
	
	/**
	 * Loads the Style Collections for the given theme_id from the database
	 * and adds them to the current theme
	 * 
	 * @param object Theme $theme The theme for which we are loading Collections
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStyleCollectionsForTheme (&$theme) {
		$dbHandler =& Services::getService("DBHandler");
		$themeId =& $theme->getId();
		$idValue =& $themeId->getIdString();
		$idManager =& Services::getService("Id");

		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_style_collection");
		$query->addWhere("FK_theme_id = $idValue");
		$query->addColumn("*");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		// build a new theme object for the results returned and set it as the theme
		while ($queryResult->hasMoreRows()) {
			$row =& $queryResult->next();
			
			// this is where we decide on style collection class for image borders
			if ($row['collection_class'] == '') {
				$styleCollection =& new StyleCollection(
					$row['collection_selector'],
					$row['collection_class_selector'],
					$row['collection_display_name'],
					$row['collection_description']);
			} else if (in_array(
								$row['collection_class']."StyleCollection",
								$this->getSupportedStyleCollections())) {
				$class = $row['collection_class']."StyleCollection";
				$styleCollection =& new $class(
					$row['collection_selector'],
					$row['collection_class_selector'],
					$row['collection_display_name'],
					$row['collection_description']);
					
					// deal with border urls here
			}
			$styleCollection->setId($idManager->getId($row['collection_id']));
			$styleCollection->setComponent($row['collection_component']);
			$styleCollection->setIndex($row['collection_index']);
			// passes execution to property loading from DB
			$this->loadStylePropertiesForCollection($styleCollection);
			if (is_null($row['collection_selector']))
				$theme->addGlobalStyle($styleCollection);
			else
				$theme->addStyleForComponentType($styleCollection,
												$styleCollection->getComponent(),
												$styleCollection->getIndex());
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
	 * @param object StyleCollection $collection The style collection object
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStylePropertiesForCollection(&$collection) {
		$dbHandler =& Services::getService("DBHandler");
		$collectionId =& $collection->getId();
		$idValue =& $collectionId->getIdString();

		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_style_property");
		$query->addWhere("FK_collection_id = $idValue");
		$query->addColumn("*");
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
	 * @param object StyleProperty the style property object
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function loadStyleComponentsForProperty (&$property) {
		$dbHandler =& Services::getService("DBHandler");
		$propertyId =& $property->getId();
		$idValue =& $propertyId->getIdString();

		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_style_component");
		$query->addWhere("FK_property_id = $idValue");
		$query->addColumn("*");
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
	 * Answers the set of templates stored in the Database
	 * Display name is 'Template'
	 * 
	 * @return ref array The array of theme objects that are templates
	 * @access public
	 * @since 5/3/06
	 */
	function &getThemeTemplates () {
		$guiManager =& Services::getService("GUI");
		$dbHandler =& Services::getService("DBHandler");
		$idManager =& Services::getService("Id");
		$templates = array();
		
		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_theme");
		$query->addWhere("theme_template = 1");
		$query->addColumn("theme_id");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		while ($queryResult->hasMoreRows()) {
			$row = $queryResult->next();
			
			$templates[] =& $this->getTheme($idManager->getId($row['theme_id']));
		}
		
		return $templates;
	}
	
	/*********************************************************
	 * Theme Saving to the database
	 *********************************************************/

	/**
	 * Saves the current theme by updating the theme settings in the database
	 * 
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function saveTheme () {
		// get the theme from the database (if it exists)
		$dbHandler =& Services::getService("DatabaseManager");
		$id =& $this->_theme->getId();
		$idValue = $themeId->getIdString();
		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_theme");
		$query->addWhere("theme_id = $themeId");
		$query->addColumn("theme_id");
		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		if ($queryResult->getNumberOfRows() > 1) {
			throwError( new Error("GUIManager", "Theme id multiplicity"));
		} else if ($queryResult->getNumberOfRows == 1) {
			$queryResult->free();
			$query =& new UpdateQuery();
			$query->setWhere("theme_id = $idValue");
		} else {
			$queryResult->free();
			$query =& new InsertQuery();
		}
		$query->setTable($this->_dbName.".tm_themes");
		$query->setColumns(array('theme_id', 'theme_display_name',
			'theme_description', 'theme_template', 'theme_custom_lev'));
		$query->setValues(array("'".addslashes($idValue)."'",
			"'".addslashes($this->_theme->getDisplayName())."'",
			"'".addslashes($this->_theme->getDescription())."'",
			"'".addslashes($this->_theme->getTemplate())."'",
			"'".addslashes($this->_theme->getCustom())."'"));
		$dbHandler->query($query, $this->_dbIndex);

		$this->saveStyleCollections();
	}
	
	/**
	 * Saves the Style Collections associated with the current theme
	 * 
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function saveStyleCollections () {
		// get the style collections for the theme and make sure they're in the DB
		$dbHandler =& Services::getService("DatabaseManager");
		
		$styleCollections =& $this->_theme->getStyleCollections();
		foreach ($styleCollections as $styleCollection) {
			$id =& $styleCollection->getId();
			$idValue = $id->getIdString();
			$query =& new SelectQuery();
			$query->addTable($this->_dbName.".tm_style_collection");
			$query->addWhere('collection_id = $idValue');
			$query->addColumn("collection_id");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() > 1)
				throwError( new Error("GUIManager", "collection id multiplicity"));
			else if ($query->result->getNumberOfRows() == 1) {
				$queryResult->free();
				$query =& new UpdateQuery();
				$query->setWhere("collection_id = $idValue");
			} else {
				$queryResult->free();
				$query =& new InsertQuery();
			}
			$query->setTable($this->_dbName.".tm_style_collection");
			$query->setColumns(array('collection_id', 'collection_display_name',
				'collection_description', 'collection_class_selector',
				'collection_selector', 'collection_component', 'collection_index',
				'collection_class'));
			$query->setValues(array("'".addslashes($idValue)."'",
				"'".addslashes($styleCollection->getDisplayName())."'",
				"'".addslashes($styleCollection->getDescription())."'",
				"'".addslashes($styleCollection->getClassSelector())."'",
				"'".addslashes($styleCollection->getSelector())."'",
				"'".addslashes($styleCollection->getComponent())."'",
				"'".addslashes($styleCollection->getIndex())."'",
				"'".addslashes(trim(get_class($styleCollection), "StyleCollection"))."'"));
			$dbHandler->query($query, $this->_dbIndex);
			// save the style properties for this theme
			$this->saveStylePropertiesForCollection($styleCollection);
		}
	}
	
	/**
	 * Saves the style properties of a style collection with id $id
	 * 
	 * @param object StyleCollection $collection
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function saveStylePropertiesForCollection (&$collection) {
		// get the style properties for the collection
		$dbHandler =& Services::getService("DatabaseManager");
		
		$styleProperties =& $collection->getSPs();
		foreach ($styleProperties as $styleProperty) {
			$id =& $styleProperty->getId();
			$idValue = $id->getIdString();
			$query =& new SelectQuery();
			$query->addTable($this->_dbName.".tm_style_property");
			$query->addWhere('property_id = $idValue');
			$query->addColumn("property_id");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() > 1)
				throwError( new Error("GUIManager", "property id multiplicity"));
			else if ($query->result->getNumberOfRows() == 1) {
				$queryResult->free();
				$query =& new UpdateQuery();
				$query->setWhere("property_id = $idValue");
			} else {
				$queryResult->free();
				$query =& new InsertQuery();
			}
			$query->setTable($this->_dbName.".tm_style_property");
			$query->setColumns(array('property_id', 'property_display_name',
				'property_description', 'property_name'));
			$query->setValues(array("'".addslashes($idValue)."'",
				"'".addslashes($styleProperty->getDisplayName())."'",
				"'".addslashes($styleProperty->getDescription())."'",
				"'".addslashes($styleProperty->getName())."'"));
			$dbHandler->query($query, $this->_dbIndex);
			// save the style properties for this theme
			$this->saveStyleComponentsForProperty($styleProperty);
		}
	}
	
	/**
	 * Saves the style components of a style property
	 * 
	 * @param object StyleCollection $property
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function saveStyleComponentsForProperty (&$property) {
		// get the style components for the property
		$dbHandler =& Services::getService("DatabaseManager");
		
		$styleComponents =& $property->getSCs();
		foreach ($styleComponents as $styleComponent) {
			$id =& $styleComponent->getId();
			$idValue = $id->getIdString();
			$query =& new SelectQuery();
			$query->addTable($this->_dbName.".tm_style_component");
			$query->addWhere('component_id = $idValue');
			$query->addColumn("component_id");
			$queryResult =& $dbHandler->query($query, $this->_dbIndex);
			if ($queryResult->getNumberOfRows() > 1)
				throwError( new Error("GUIManager", "component id multiplicity"));
			else if ($query->result->getNumberOfRows() == 1) {
				$queryResult->free();
				$query =& new UpdateQuery();
				$query->setWhere("component_id = $idValue");
			} else {
				$queryResult->free();
				$query =& new InsertQuery();
			}
			$query->setTable($this->_dbName.".tm_style_component");
			$query->setColumns(array('component_id', 'component_class_name',
				'component_value'));
			$query->setValues(array("'".addslashes($idValue)."'",
				"'".addslashes(get_class($styleComponent))."'",
				"'".addslashes($styleComponent->getValue())."'"));
			$dbHandler->query($query, $this->_dbIndex);
			// save the style properties for this theme
		}
	}

	/*********************************************************
	 * Theme Removal from the database
	 *********************************************************/

	/**
	 * Deletes the theme from the database
	 * 
	 * @param object HarmoniId $id
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function deleteTheme (&$id) {
		$dbHandler =& Services::getService("DatabaseManager");
				
		$this->deleteCollectionsForTheme($this->getTheme($id));
		
		$idValue =& $id->getIdString();
		$query =& new DeleteQuery();
		$query->addTable($this->_dbName.".tm_theme");
		$query->addWhere("theme_id = $idValue");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows != 1)
			throwError( new Error("GUIManager", "Theme Deletion Error"));
		
	}

	/**
	 * Deletes the style collections from the database
	 * 
	 * @param object Theme $theme the theme
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function deleteCollectionsForTheme (&$theme) {
		$dbHandler =& Services::getService("DatabaseManager");

		$styleCollections =& $theme->getStyleCollections();
		foreach ($styleCollections as $styleCollection) {
			$this->deletePropertiesForCollection($styleCollection);
		}
		
		$themeId =& $theme->getId();
		$idValue =& $themeId->getIdString();
		$query =& new DeleteQuery();
		$query->addTable($this->_dbName.".tm_style_collection");
		$query->addWhere("FK_theme_id = $idValue");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows != 1)
			throwError( new Error("GUIManager", "Collections Deletion Error"));
	}

	/**
	 * Deletes the style properties from the database
	 * 
	 * @param object StyleCollection $styleCollection the id of the theme
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function deletePropertiesForCollection (&$styleCollection) {
		$dbHandler =& Services::getService("DatabaseManager");

		$sps =& $styleCollection->getSPs();
		foreach ($sps as $sp) {
			$this->deleteComponentsForProperty($sp);
		}
		$id =& $styleCollection->getId();
		$idValue =& $id->getIdString();
		$query =& new DeleteQuery();
		$query->addTable($this->_dbName.".tm_style_property");
		$query->addWhere("FK_collection_id = $idValue");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows != 1)
			throwError( new Error("GUIManager", "Properties Deletion Error"));
	}
	
	/**
	 * Deletes the components for the property from the db
	 * 
	 * @param object StyleProperty $sp
	 * @return void
	 * @access public
	 * @since 4/26/06
	 */
	function deleteComponentsForProperty ($sp) {
		$dbHandler =& Services::getService("DatabaseManager");

		$id =& $sp->getId();
		$idValue =& $id->getIdString();
		$query =& new DeleteQuery();
		$query->addTable($this->_dbName.".tm_style_component");
		$query->addWhere("FK_property_id = $idValue");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($result->getNumberOfRows != 1)
			throwError( new Error("GUIManager", "Components Deletion Error"));
	}

/*********************************************************
 * Functionality for Theme Management
 *********************************************************/

	/**
	 * Answers a list of themes that the User has access to edit
	 * 
	 * @return array keyed on id's and valued to DisplayName
	 * @access public
	 * @since 5/30/06
	 */
	function getThemeListForUser () {
		$authN =& Services::getService("AuthN");
		$authTypes =& $authN->getAuthenticationTypes();
		$users = array();
		while ($authTypes->hasNext()) {
			$authType =& $authTypes->next();
			$id =& $authN->getUserId($authType);
			$users[] = $id->getIdString();
		}
		
		$db =& Services::getService('DatabaseManager');
		
		$query =& new SelectQuery();
		$query->addTable($this->_dbName.".tm_theme");
		$query->addColumn("theme_id");
		$query->addColumn("theme_display_name");
		$query->addWhere("theme_owner_id = '".addslashes($users[0])."'");
		for ($i = 1; $i < count($users); $i++) {
			$query->addWhere("theme_owner_id = '".addslashes($users[$i])."'", _OR);
		}
		$query->addWhere("theme_template = '1'", _OR);
		
		$result =& $db->query($query, $this->_dbIndex);
		
		$returnArray = array();
		while ($result->hasMoreRows()) {
			$row = $result->next();
			
			$returnArray[$result['theme_id']] = $result['theme_display_name'];
		}
		
		return $returnArray;
	}
	
	/**
	 * Answers the style property containing the Global Background Color for the theme
	 * 
	 * @return ref object StyleProperty
	 * @access public
	 * @since 5/30/06
	 */
	function &getGlobalBGColor () {
		$globalStyles =& $this->_theme->getGlobalStyles();

		// empty SP for returning if SP is 'background'
		$return =& new BackgroundColorSP();

		if (isset($globalStyles['body'])) {
			$body =& $globalStyles['body'];
			$SPs =& $body->getSPs();
			if (isset($SPs['background-color']))
				return $SPs['background-color'];
			else if (isset($SPs['background'])) {
				$SCs =& $SPs['background']->getSCs();
				if (isset($SCs['colorsc']))
					$return->addSC($SCs['colorsc']);
			}
		}
		return $return;
	}
	
	/**
	 * Answers the style property containing the Global Font for the theme
	 * 
	 * @return ref object StyleProperty
	 * @access public
	 * @since 5/30/06
	 */
	function &getGlobalFont () {
		$globalStyles =& $this->_theme->getGlobalStyles();

		// empty SP for returning if SP is not set
		$return =& new FontSP();

		if (isset($globalStyles['body'])) {
			$body =& $globalStyles['body'];
			$SPs =& $body->getSPs();
			if (isset($SPs['font']))
				return $SPs['font'];
		}
		return $return;
	}

	/**
	 * Answers the class of the style collections being used by this theme
	 * 
	 * @return string the class for the collections
	 * @access public
	 * @since 5/30/06
	 */
	function getCollectionClass () {
		return $this->_theme->getCollectionClass();
	}
}

?>