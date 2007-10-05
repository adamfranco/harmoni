<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableIdManager.class.php,v 1.1 2007/10/05 14:02:56 adamfranco Exp $
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
 * @version $Id: SimpleTableIdManager.class.php,v 1.1 2007/10/05 14:02:56 adamfranco Exp $
 */
class SimpleTableIdManager
	// implements IdManager
{
		
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