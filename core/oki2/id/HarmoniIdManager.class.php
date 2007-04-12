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
 * @version $Id: HarmoniIdManager.class.php,v 1.24 2007/04/12 15:37:31 adamfranco Exp $
 */

class HarmoniIdManager
	extends IdManager
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
	 * @param string sharedDB The name of the shared database.
	 */
	function HarmoniIdManager() {		
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$dbIndex = $configuration->getProperty('database_index');
		$dbName = $configuration->getProperty('database_name');
		$prefix = $configuration->getProperty('id_prefix');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($dbName, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($prefix, OptionalRule::getRule(
			StringValidatorRule::getRule(), true));
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
		$this->_sharedDB = $dbName;
		if ($prefix)
			$this->_prefix = $prefix;
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
		$dbHandler =& Services::getService("DatabaseManager");
		
		$query =& new InsertQuery();
		$query->setAutoIncrementColumn("id_value", "id_sequence");
		$query->setTable($this->_sharedDB.".id");
		$query->addRowOfValues(array());
		
		$result =& $dbHandler->query($query,$this->_dbIndex);
		if ($result->getNumberOfRows() != 1) {
			throwError( new Error(IdException::CONFIGURATION_ERROR(), "IdManager", true));
		}
		
		$newID = $result->getLastAutoIncrementValue();
		
		// Clear out any values smaller than our last one to keep the table from 
		// exploding size.
		$query =& new DeleteQuery();
		$query->setTable($this->_sharedDB.".id");
		$query->setWhere("id_value < '".$newID."'");
		$result =& $dbHandler->query($query,$this->_dbIndex);
		
		
		$newID = $this->_prefix.strval($newID);
		
		debug::output("Successfully created new id '$newID'.",DEBUG_SYS5,"IdManager");
		
		$id =& new HarmoniId($newID);
		
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
	function &getId ( $idString ) { 
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
}
