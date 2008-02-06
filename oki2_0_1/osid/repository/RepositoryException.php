<?php 
 
include_once(dirname(__FILE__)."/../shared/SharedException.php");
/**
 * OsidException or one of its subclasses is thrown by all methods of all
 * interfaces of an Open Service Interface Definition (OSID). This requires
 * the caller of an OSID package method handle the OsidException. Since the
 * application using an OSID can not determine where an implementation method
 * will ultimately execute, it must assume a worst case scenerio and protect
 * itself. OSID Implementations should throw their own subclasses of
 * OsidException and limit exception messages to those predefined by their own
 * OsidException or its superclasses. This approach to exception messages
 * allows Applications and OSID implementations using an OsidException's
 * predefined messages to handle exceptions in an interoperable way.
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
 * @package org.osid.repository
 */
class RepositoryException
    extends SharedException
{
    /**
     * Unknown Repository
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_REPOSITORY = "Unknown Repository ";

    /**
     * No object has this date
     * @return string
     * @access public 
     * @static 
     */
    const  NO_OBJECT_WITH_THIS_DATE = "No object has this date ";

    /**
     * Cannot copy or inherit RecordStructure from itself
     * @return string
     * @access public 
     * @static 
     */
    const  CANNOT_COPY_OR_INHERIT_SELF = "Cannot copy or inherit RecordStructure from itself ";

    /**
     * Already inheriting this RecordStructure
     * @return string
     * @access public 
     * @static 
     */
    const  ALREADY_INHERITING_STRUCTURE = "Already inheriting this RecordStructure ";

    /**
     * Effective date must precede expiration date
     * @return string
     * @access public 
     * @static 
     */
    const  EFFECTIVE_PRECEDE_EXPIRATION = "Effective date must precede expiration date ";
}

?>