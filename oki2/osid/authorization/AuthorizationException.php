<?php 
 
include_once(dirname(__FILE__)."/../shared/SharedException.php");
/**
 * All methods of all interfaces of the Open Service Interface Definition
 * (OSID) throw a subclass of org.osid.OsidException. This requires the caller
 * of an osid package method to handle the OsidException. Since the
 * application using an osid manager can not determine where the manager will
 * ultimately execute, it must assume a worst case scenario and protect
 * itself.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package org.osid.authorization
 */
class AuthorizationException
    extends SharedException
{
    /**
     * Effective date must precede expiration date
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function EFFECTIVE_PRECEDE_EXPIRATION () {
        return "Effective date must precede expiration date ";
    }

    /**
     * Cannot delete last root Qualifier
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function CANNOT_DELETE_LAST_ROOT_QUALIFIER () {
        return "Cannot delete last root Qualifier ";
    }


	function AuthorizationException ( $message ) {
        die($message);
    }

}

?>