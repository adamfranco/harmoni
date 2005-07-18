<?php
/**
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DataManager.abstract.php,v 1.15 2005/07/18 14:45:25 gabeschine Exp $
 */
 
require_once(HARMONI."dataManager/schema/SchemaManager.class.php");
require_once(HARMONI."dataManager/DataTypeManager.class.php");
require_once(HARMONI."dataManager/record/RecordManager.class.php");
require_once(HARMONI."dataManager/record/TagManager.class.php");
require_once(HARMONI."dataManager/record/RecordSet.class.php");

require_once(HARMONI."dataManager/search/include.php");

require_once(HARMONI."dataManager/versionConstraints/include.php");

/**
 * The HarmoniDataManager class is used purely to setup the services required to use the
 * other DataManager classes such as the {@link DataSetTypeManager} or the {@link RecordManager}.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DataManager.abstract.php,v 1.15 2005/07/18 14:45:25 gabeschine Exp $
 *
 * @author Gabe Schine
 * @abstract
 */
class DataManager {

	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	preload_types			object TypeIterator
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
		$dbIndex = $configuration->getProperty('database_index');
		$preloadTypes =& $configuration->getProperty('preload_types');
		
		$this->setup($dbIndex, $preloadTypes);
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
		$this->_osidContext =& $context;
	} 
	
	/**
	 * Sets up the services required for the DataManager, including: DataSetTypeManager,
	 * DataTypeManager, DataSetManager, DataSetTagManager
	 * @return void
	 * @access public
	 * @param int $dbID The DB index from the {@link DBHandler} that we should use to look for our data.
	 * @param optional array An array of {@link HarmoniType} objects corresponding to Schemas that should be pre-loaded in one DB query.
	 * @abstract
	 */
	function setup( $dbID, $preloadTypes=null ) {
		if (ini_get("magic_quotes_runtime")) {
			throwError(
				new Error(
					"The DataManager requires that the php.ini config option <B>magic_quotes_runtime</B> be OFF.",
					"DataManager",
					true));
		}
		
		// let's setup all our services
		
		define("DATAMANAGER_DBID",$dbID);

		// ok, now on to registering everything
		$schemaManager =& new SchemaManager($preloadTypes);
		$dataTypeManager =& new DataTypeManager();
		$recordManager =& new RecordManager();
		$tagManager =& new TagManager();

		Services::registerObjectAsService("SchemaManager",$schemaManager);
		Services::registerObjectAsService("DataTypeManager",$dataTypeManager);
		Services::registerObjectAsService("RecordManager",$recordManager);
		Services::registerObjectAsService("TagManager",$tagManager);
		
		if (!Services::serviceRunning("Id")) {
			throwError(
				new Error(
					"The DataManager requires the IdManager, but it is not running.",
					"DataManager",
					true));
		}
		
		debug::output("Activated Harmoni Data Manager.",DEBUG_SYS1,"DataManager");
	}
	
	/**
	 * Returns if the DataManager was previously loaded or not.
	 * @access public
	 * @return bool
	 */
	function loaded()
	{
		return (
			Services::serviceRunning("SchemaManager") && 
			Services::serviceRunning("DataTypeManager") && 
			Services::serviceRunning("RecordManager") && 
			Services::serviceRunning("TagManager")
		);
	}
	
}

?>