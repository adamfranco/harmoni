<?php

require_once(OKI2."/osid/id/IdManager.php");
require_once(OKI2."/osid/id/IdException.php");

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
 * @package harmoni.osid_v2.id
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniIdManager.class.php,v 1.28 2008/04/18 15:43:19 adamfranco Exp $
 */

class HarmoniIdManager
	implements IdManager
{

	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access private
	 */
	var $_dbIndex;
	
	
	/**
	 * An array of all cached Id objects.
	 * @var array _ids 
	 * @access private
	 */
	var $_ids;
	
	
	/**
	 * Constructor. Set up any database connections needed.
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 */
	function __construct() {		
		// initialize cache
		$this->_ids = array();
		$this->_prefix = '';
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
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
	function assignConfiguration ( Properties $configuration ) { 
		$this->_configuration =$configuration;
		
		$dbIndex = $configuration->getProperty('database_index');
		$prefix = $configuration->getProperty('id_prefix');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($prefix, OptionalRule::getRule(
			StringValidatorRule::getRule(), true));
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		
		if ($prefix)
			$this->_prefix = $prefix;
		
		$harmoni_db_name = $this->_configuration->getProperty('harmoni_db_name');
        if (!is_null($harmoni_db_name)) {
			try {
				$this->harmoni_db = Harmoni_Db::getDatabase($harmoni_db_name);
				
				$this->setUpStatements();
			} catch (UnknownIdException $e) {
			}
        }
	}
	
	/**
	 * Set up our statements
	 * 
	 * @return void
	 * @access private
	 * @since 4/17/08
	 */
	private function setUpStatements () {
		$this->createId_stmt = $this->harmoni_db->prepare('INSERT INTO id () VALUES()');
				
		$query = $this->harmoni_db->delete();
		$query->setTable("id");
		$query->addWhereLessThan("id_value", NULL);
		$this->deleteId_stmt = $query->prepare();
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
	function getOsidContext () { 
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
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext =$context;
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
	function createId () { 
		if (isset($this->createId_stmt)) {
			$this->createId_stmt->execute();
			$newID = $this->harmoni_db->lastInsertId('id', 'id_value');
			
			$this->deleteId_stmt->bindValue(1, $newID);
			$this->deleteId_stmt->execute();
		} else {
			debug::output("Attempting to generate new id.", 20, "IdManager");
			$dbHandler = Services::getService("DatabaseManager");
			
			$query = new InsertQuery();
			$query->setAutoIncrementColumn("id_value", "id_id_value_seq");
			$query->setTable("id");
			$query->addRowOfValues(array());
			
			$result =$dbHandler->query($query,$this->_dbIndex);
			if ($result->getNumberOfRows() != 1) {
				throwError( new HarmoniError(IdException::CONFIGURATION_ERROR(), "IdManager", true));
			}
			
			$newID = $result->getLastAutoIncrementValue();
			
			// Clear out any values smaller than our last one to keep the table from 
			// exploding size.
			$query = new DeleteQuery();
			$query->setTable("id");
			$query->setWhere("id_value < '".$newID."'");
			$result =$dbHandler->query($query,$this->_dbIndex);
		}
		
		$newID = $this->_prefix.strval($newID);
		
		debug::output("Successfully created new id '$newID'.",DEBUG_SYS5,"IdManager");
		
		$id = new HarmoniId($newID);
		
		// cache the id
//		$this->_ids[$newID] = $id;
		
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
	function getId ( $idString ) { 
//		if (isset($this->_ids[$idString])) {
//			print "id:". $idString." and ".$this->_ids[$idString]->getIdString()."<br/>";
//			return $this->_ids[$idString];
//		}
		ArgumentValidator::validate($idString, 
			OrValidatorRule::getRule(
				NonzeroLengthStringValidatorRule::getRule(), 
				NumericValidatorRule::getRule()));
			
		$id = new HarmoniId($idString);
			
		// cache the id
//		$this->_ids[$idString] = $id;
		return $id;
	}
	
	/**
     * Verify to OsidLoader that it is loading
     * 
     * <p>
     * OSID Version: 2.0
     * </p>
     * .
     * 
     * @throws object OsidException 
     * 
     * @access public
     */
    public function osidVersion_2_0 () {}
}