<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNMethodManager.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */ 

/**
 * The AuthNMethodManager handles the management of Authentication Types and the
 * AuthNMethods that correspond to those types. Neither the AuthNMethodManager nor
 * AuthNMethods maintain any information about authentication states. They simply
 * provide the means of checking that authentication when desired.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNMethodManager.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */
class AuthNMethodManager
	extends OsidManager
{
		
	/**
	 * Constructor. We wish to ensure that the manager is properly configured
	 * via the assignConfiguration() method and any needed context information
	 * has been passed via assignOsidContext(), so an instance variable is set
	 * here to false untill the necessary initialization has occurred.
	 * 
	 * @return object
	 * @access public
	 * @since 3/1/05
	 */
	function AuthNMethodManager () {
		$this->_isInitialized = FALSE;
		$this->_osidContext = NULL;
		$this->_configuration = NULL;
		
		$this->_authNTypes = array();
		$this->_authNMethods = array();
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
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignOsidContext ( &$context ) { 
        $this->_osidContext =& $context;
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
    function assignConfiguration ( &$configuration ) { 
        $this->_configuration =& $configuration;
    }
    
    /**
     * Add an Authentication Type-Method pair.
     * 
     * @param object AuthNMethod $authNMethod
     * @param object Type $authNType
     * @return object AuthNMethod The method that was passed.
     * @access public
     * @since 3/2/05
     */
    function &addAuthNMethodWithType ( &$authNMethod, &$authNType ) {
    	ArgumentValidator::validate($authNMethod, new ExtendsValidatorRule("AuthNMethod"));
    	ArgumentValidator::validate($authNType, new ExtendsValidatorRule("Type"));
    	
    	if ($this->_getKey($authNType) !== NULL)
    		throwError( new Error("Cannot add again, Type '"
						.$this->_typeToString($authNType)."' already added.",
						"AuthNMethodManager", true));
		
		$this->_authNTypes[] =& $authNType;
		$this->_authNMethods[] =& $authNMethod;
		
		$authNMethod->setType($authNType);
		
		return $authNMethod;
    }
    
	/**
	 * Get all AuthN Types
	 * 
	 * @return object TypeIterator
	 * @access public
	 * @since 3/2/05
	 */
	function &getAuthNTypes () {
		$iterator =& new HarmoniTypeIterator($this->_authNTypes);
		return $iterator;
	}
	
	/**
	 * Get an AuthNMethod based on its Type
	 * 
	 * @param object Type $authNType
	 * @return object AuthNMethod
	 * @access public
	 * @since 3/2/05
	 */
	function &getAuthNMethodForType ( &$authNType ) {
		$key = $this->_getKey($authNType);
		return $this->_authNMethods[$key];
	}
	
	/**
	 * Private method for matching keys to Types.
	 * 
	 * @param object Type $authNType
	 * @return integer
	 * @access public
	 * @since 3/2/05
	 */
	function _getKey ( &$authNType ) {
		foreach(array_keys($this->_authNTypes) as $key) {
			if ($authNType->isEqual($this->_authNTypes[$key]))
				return $key;
		}
		
		// If not found, return NULL
		return NULL;
	}
	
	/**
	 * Private method for converting Types to strings.
	 * 
	 * @param object Type $type
	 * @return string
	 * @access public
	 * @since 3/2/05
	 */
	function _typeToString ( &$type ) {
		return $type->getDomain()."::".$type->getAuthority()."::".$type->getKeyword();
	}
	
	
}

?>