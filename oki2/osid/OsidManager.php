<?php 
 
/**
 * OsidManager is the key to binding an application to an OSID implementation.
 * An OSID is required to define an interface that extends OsidManager.  The
 * OSID implementation is required to have a class that implements its
 * OsidManager. The application loads an OSID implementation by using the
 * OsidLoader to get an instance of the OSID's OsidManager.  The application
 * accesses all OSID objects directly or indirectly through the OSID's
 * OsidManager.
 * 
 * <p>
 * OsidManager defines three methods: getOsidContext, assignOsidContext,
 * assignConfiguration. The assign methods are called by the
 * OsidLoader.getManager method. An application can use the assign methods,
 * but this would only be for overriding the default behavior of the
 * OsidLoader.getManager method.
 * </p>
 * 
 * <p>
 * The OsidLoader.getManager method checks its OsidContext argument to make
 * sure it is not null, and then calls the Osidmanager implementation class
 * assignOsidContext method.
 * </p>
 * 
 * <p>
 * The OsidLoader.getManager method loads a properties file that contains the
 * configuration information if one exists. The configuration information is
 * set by the system integrator who has installed an implementation. The
 * configuration properties file is loaded by by the OsidLoader.getManager
 * method using the getResourceAsStream method of the OSID's OsidManager class
 * to search for the configuration properties file. The properties from the
 * loaded configuration file are overlaid with any configuration properties
 * supplied by the application in the call to the OsidLoader.getManager call
 * in the additionalConfiguration argument. The assignConfiguration method is
 * then called.
 * </p>
 * 
 * <p>
 * Typically, the application calls the getOsidContext method only.  It is
 * unusual for the application to override the OsidLoader.getManager and call
 * assignOsidContext or assignConfiguration.
 * </p>
 * 
 * <p>
 * The implementation of OsidManager can use both the OsidContext and the
 * Configuration properties as needed.
 * </p>
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
 * @package org.osid
 */
class OsidManager
{
    /**
     * Return context of this OsidManager.
     *  
     * @return object OsidContext
     * 
     * @throws object OsidException 
     * 
     * @public
     */
    function &getOsidContext () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
     * @public
     */
    function assignOsidContext ( &$context ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
     * @public
     */
    function assignConfiguration ( $configuration ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
     * @public
     */
    function osidVersion_2_0 () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>