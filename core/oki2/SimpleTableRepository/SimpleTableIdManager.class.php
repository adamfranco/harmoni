<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableIdManager.class.php,v 1.2 2008/03/06 16:32:06 adamfranco Exp $
 */ 

require_once(HARMONI."/oki2/shared/HarmoniId.class.php");

/**
 * A basic Id manager that can return an Id object
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableIdManager.class.php,v 1.2 2008/03/06 16:32:06 adamfranco Exp $
 */
class SimpleTableIdManager
	implements IdManager
{

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
		return $this->context;
	} 
	
	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *         messages defined in org.osid.OsidException:  {@link
	 *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( OsidContext $context ) { 
		$this->context = $context;
	} 
	
	/**
	 * Assign the configuration of this OsidManager.
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *         messages defined in org.osid.OsidException:  {@link
	 *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *         {@link org.osid.OsidException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.OsidException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( Properties $configuration ) {
	
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
		
	/**
	 * Answer a new Id Object
	 * 
	 * @param string Id
	 * @return object Id
	 * @access public
	 * @since 10/4/07
	 */
	public function getId ($string) {
		return new HarmoniId($string);
	}
	
	 /**
     * Create a new unique identifier.
     *  
     * @return object Id
     * 
     * @throws object IdException An exception with one of the following
     *         messages defined in org.osid.id.IdException:  {@link
     *         org.osid.id.IdException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.id.IdException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.id.IdException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.id.IdException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function createId () { 
    	throw new UnimplementedException ();
    }
}



?>