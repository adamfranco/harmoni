<?

require_once(OKI2."/osid/id/IdManager.php");

require_once(HARMONI."oki2/shared/HarmoniId.class.php");

/**
 * IdManager creates and gets Ids.	Ids are used in many different contexts
 * throughout the OSIDs.  As with other Managers, use the OsidLoader to load
 * an implementation of this interface.
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p>
 * Unlike most Managers, IdManager does not have methods to return Type
 * information.
 * </p>
 * 
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 *
 * @package harmoni.osid.id
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIdManager.class.php,v 1.7 2005/01/19 17:39:14 adamfranco Exp $
 */

class HarmoniIdManager
	extends IdManager
{

	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;

	
	/**
	 * The name of the shared database.
	 * @attribute private string _sharedD
	 */
	var $_sharedDB;
	
	
	/**
	 * An array that will store the cached agent objects.
	 * @attribute private array _agentsCache
	 */
	var $_agentsCache;
	
	
	/**
	 * An array that will store the cached group objects.
	 * @attribute private array _groupsCache
	 */
	var $_groupsCache;
	
	
	/**
	 * Will be set to true if all agents have been cached;
	 * @attribute private boolean _allAgentsCached
	 */
	var $_allAgentsCached;
	
	
	/**
	 * Will be set to true if all groups have been cached;
	 * @attribute private boolean _allAgentsCached
	 */
	var $_allGroupsCached;
	
	
	/**
	 * An array of all cached Id objects.
	 * @attribute private array _ids
	 */
	var $_ids;
	
	
	/**
	 * Constructor. Set up any database connections needed.
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
	 */
	function HarmoniIdManager($dbIndex, $sharedDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($sharedDB, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_sharedDB = $sharedDB;
		
		// initialize cache
		$this->_ids = array();
	}

	/**
	 * Create a new unique identifier.
	 *	
	 * @return object Id
	 * 
	 * @throws object IdException An exception with one of the following
	 *		   messages defined in org.osid.id.IdException:	 {@link
	 *		   org.osid.id.IdException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.id.IdException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.id.IdException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.id.IdException#UNIMPLEMENTED UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &createId () { 
		debug::output("Attempting to generate new id.", 20, "IdManager");
		$dbHandler =& Services::requireService("DBHandler");
		
		$query =& new InsertQuery();
		$query->setAutoIncrementColumn("id_value", "id_sequence");
		$query->setTable($this->_sharedDB.".id");
		$query->addRowOfValues(array());
		
		$result =& $dbHandler->query($query,$this->_dbIndex);
		if ($result->getNumberOfRows() != 1) {
			throwError( new Error(IdException::CONFIGURATION_ERROR(), "IdManager", true));
		}
		
		$newID = $result->getLastAutoIncrementValue();
		$newID = strval($newID);
		
		debug::output("Successfully created new id '$newID'.",DEBUG_SYS5,"IdManager");
		
		$id =& new HarmoniId($newID);
		
		// cache the id
		$this->_ids[$newId];
		
		return $id;
	}

	/**
	 * Get the unique Id with this String representation or create a new unique
	 * Id with this representation.
	 * 
	 * @param string $idString
	 *	
	 * @return object Id
	 * 
	 * @throws object IdException An exception with one of the following
	 *		   messages defined in org.osid.id.IdException:	 {@link
	 *		   org.osid.id.IdException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.id.IdException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.id.IdException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.id.IdException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.id.IdException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function &getId ( $idString ) { 
		if (isset($this->_ids[$idString]))
			return $this->_ids[$idString];
	
		$id =& new HarmoniId($idString);
			
		// cache the id
		$this->_ids[$idString] =& $id;

		return $id;
	}

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return void
	 */
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @access public
	 * @return void
	 */
	function stop() {
	}

}