<?php

require_once(OKI2."/osid/id/IdManager.php");

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
 * @version $Id: JavaPOCIdManager.class.php,v 1.7 2007/09/04 20:25:42 adamfranco Exp $
 */

class JavaPOCIdManager
	extends IdManager
{	
	var $_javaClassName;
	var $_javaClass;
	
	/**
	 * Constructor.
	 */
	function __construct( $className ) {
		$this->_javaClassName = $className;
		$testClass = new Java($className);
		$ex = java_last_exception_get();
		if ($ex) die("Could not instantiate '$className' (Java): ".$ex->toString);
		java_last_exception_clear();
		
		$this->_javaClass =$testClass;
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
		$result = $this->_javaClass->createId();
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
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
		$result = $this->_javaClass->getId($idString);
		$ex = java_last_exception_get();
		if ($ex) { java_last_exception_clear(); return $ex->toString(); }
		java_last_exception_clear();
		return $result;
	}

?>