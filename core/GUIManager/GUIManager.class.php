<?php

require_once(HARMONI."GUIManager/GUIManager.interface.php");
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
 * @version $Id: GUIManager.class.php,v 1.7 2005/01/19 23:23:00 adamfranco Exp $
 */
class GUIManager extends GUIManagerInterface {

	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access protected
	 */
	var $_dbIndex;

	
	/**
	 * The name of the GUIMAnager database.
	 * @var string _guiDB 
	 * @access protected
	 */
	var $_guiDB;
	
	/**
	 * Constructor
	 * @param integer dbIndex The database connection to use as returned by the DBHandler.
	 * @param string guiDB The name of the GUIManager database.
	 * manager.
	 * @access public
	 */
	function GUIManager($dbIndex, $guiDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($guiDB, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_guiDB = $guiDB;
	}	

	/**
	 * Returns a list of themes supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a theme.
	 **/
	function getSupportedThemes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported themes.
	 * @access public
	 * @return string The relative path to the Theme directory.
	 **/
	function getThemePath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns a list of style properties supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style property.
	 **/
	function getSPs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported style properties.
	 * @access public
	 * @return string The relative path to the style property directory.
	 **/
	function getSPPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	
	
	/**
	 * Returns a list of style components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a style components.
	 **/
	function getSCs() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported style component.
	 * @access public
	 * @return string The relative path to the style component directory.
	 **/
	function getSCPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns a list of components supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a component.
	 **/
	function getSupportedComponents() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported components.
	 * @access public
	 * @return string The relative path to the Component directory.
	 **/
	function getComponentPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}	
		
	/**
	 * Returns a list of layouts supported by the GUIManager.
	 * @access public
	 * @return array An array of strings; each element is the class name of a layout.
	 **/
	function getSupportedLayouts() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the path that contains all the supported layouts.
	 * @access public
	 * @return string The relative path to the Layout directory.
	 **/
	function getLayoutPath() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	// *************************************************************************


	/**
	 * Saves the theme state to the database. The theme state is saved by 
	 * exporting the theme's style properties, and then serializing the output
	 * and storing it into the database.
	 * @access public
	 * @param ref object theme The theme whose state needs to be saved.
	 * @return ref object A HarmoniId objecting identifying the saved state uniquely.
	 **/
	function &saveThemeState(& $theme) {
		// ** parameter validation
		ArgumentValidator::validate($theme, new ExtendsValidatorRule("ThemeInterface"), true);
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
		
		// 1. create an id for the theme state
		$sharedManager =& Services::requireService("Shared");
		$id =& $sharedManager->createId();
		$idValue = $id->getIdString();
		// 2. now simply insert the theme state
		$db = $this->_guiDB.".";
		$dbHandler =& Services::requireService("DBHandler");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		ArgumentValidator::validate($theme, new ExtendsValidatorRule("ThemeInterface"), true);
		ArgumentValidator::validate($stateId, new ExtendsValidatorRule("HarmoniId"), true);
		// ** end of parameter validation
		
		// get the theme state from the database
		$db = $this->_guiDB.".";
		$dbHandler =& Services::requireService("DBHandler");
		$idValue = $stateId->getIdString();
		$query =& new SelectQuery();
		$query->addColumn("gui_theme", "theme", $db."gui");
		$query->addColumn("gui_state", "state", $db."gui");
		$query->addTable($db."gui");
		$query->addWhere($db."gui.gui_id = ".$idValue);

		$queryResult =& $dbHandler->query($query, $this->_dbIndex);
		
		if ($queryResult->getNumberOfRows() != 1) {
			$err = "None or more than one theme states were returned.";
			throwError(new Error($err, "GUIManager", true));
		}
		
		$queryResult->bindField("theme", $themeName);
		$queryResult->bindField("state", $themeState);
		$row = $queryResult->getCurrentrow();
		
		if ($themeName != get_class($theme)) {
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
	 * Deletes the theme state with the given id from the database. Notice that
	 * this does not affect the Theme whose state is being deleted in any way!
	 * @access public
	 * @param ref object $id A HarmoniId identifying the theme state that needs to
	 * be deleted.
	 **/
	function deleteThemeState(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

}

?>