<?php

	/**
	 * OsidLoader loads a particular implementation of an Open Service Interface Definition (OSID), sets the OsidOwner and its configuration information, and returns the instance of the implementation.  This service is how applications should bind a particular implementation to an OSID.  The value of this approach is that an application can defer which specific implementation is used until runtime.  In addition, the implementation package does not need to be specified elsewhere in application sources.  Changing implementations is simplified with this approach. <p> As an example, in order to create a new Hierarhcy, an application does not use the new operator.  Rather, the application uses OsidLoader to get an instance of a class that implements OsidManager and then asks that instance to create the Hierarchy.  It is the createHierarchy() method in some package (e.g. osid.hierarchy.impl.HierarchyManager) which does a new on osid.hierarchy.impl.Hierarchy, casts it as osid.hierarchy.Hierarchy, and returns it to the application.  This indirection offers the significant value of being able to change implementations in one spot with one modification, namely by using a different argument to OsidLoader. <p>Sample: <p>osid.OsidOwner myOwner = new osid.OsidOwner(); <p>String key = "myKey"; <p>myOwner.addContext(key, "I want to save this string as context"); <p>String whatWasMyContext = myOwner.getContext(key); <p>osid.hierarchy.HierarchyManager hierarchyManager = <br />&nbsp;&nbsp;&nbsp;osid.OsidLoader.getManager("osid.hierarchy.HierarchyManager","osid.shared.impl",myOwner); <p>osid.hierarchy.Hierarchy myHierarchy = hierarchyManager.createHierarchy(...); <p> A similar technique can be used for creating other objects.  OSIDs that have OsidManager implementations loaded by OsidLoader, will define an appropriate interface to create these objects. <p> The arguments to OsidLoader.getManager method are the OSID OsidManager interface name, the implementing package name and the OsidOwner.   <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid
	 */
class OsidLoader // :: normal class
//	implements java.io.Serializable
{

	/**
	 * Returns an instance of the OsidManager of the OSID specified by the OSID package OsidManager interface name and the implementation package name. The implementation class name is constructed from the SID package Manager interface name. A configuration file name is constructed in a similar manner and if the file exists it is loaded into the implementation's OsidManager's configuration.<p>Example:  To load an implementation of the osid.Filing SID implemented in a package "xyz", one would use:<p>osid.filing.FilingManager fm = (osid.filing.FilingManager)osid.OsidLoader.getManager(<p>"osid.filing.FilingManager" ,<p>"xyz" ,<p>new osid.OsidOwner());
	 * @param object SIDPackageManagerName SIDPackageManagerName is a fully qualified interface name
	 * @param object implPackageName implPackageName is a fully qualified package name
	 * @param object owner
	 * @return object OsidManager
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}, {@link OsidException#VERSION_ERROR VERSION_ERROR}, ={@link OsidException#INTERFACE_NOT_FOUND INTERFACE_NOT_FOUND}, ={@link OsidException#MANAGER_NOT_FOUND MANAGER_NOT_FOUND}, ={@link OsidException#MANAGER_INSTANTIATION_ERROR MANAGER_INSTANTIATION_ERROR}, ={@link OsidException#ERROR_UPDATING_OWNER ERROR_UPDATING_OWNER}, ={@link OsidException#ERROR_UPDATING_CONFIGURATION ERROR_UPDATING_CONFIGURATION}
	 * @package osid
	 */
}


	/**
	 * OsidManager defines three methods: getOwner, updateOwner, updateConfiguration. The update methods are performed by the OsidLoader.getManager method. An application can use the update methods, but this would only be for overriding the default behavior of the OsidLoader.getManager method. <p> The OsidLoader.getManager method checks its OsidOwner argument to make sure it is not null, and then calls the Osidmanager implementation class updateOwner method. <p> The OsidLoader.getManager method loads a properties file that contains the configuration information if one exists. The configuration information is set by the system integrator who has installed an implementation. The configuration properties file is loaded by by the OsidLoader.getManager method using java.lang.ClassLoader.getSystemResourceAsStream to search for the configuration properties file. The updateConfiguration method is then called. <p> Typically, the application calls the getOwner method only.  It is unusual for the application to override the OsidLoader.getManager and call updateOwner or updateConfiguration. <p> The implementation of OsidManager can use both the OsidOwner and the Configuration properties as needed.
	 * @package osid
	 */
class OsidManager // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Return owner of this OsidManager.
	 * @return object osid.OsidOwner
	 * @package osid
	 */
	function &getOwner() { /* :: interface :: */ }
	// :: full java declaration :: osid.OsidOwner getOwner()

	/**
	 * Update the owner of this OsidManager.
	 * @param object owner
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */
	function updateOwner(& $owner) { /* :: interface :: */ }
	// :: full java declaration :: void updateOwner(osid.OsidOwner owner)

	/**
	 * Update the configuration of this OsidManager.
	 * @param object configuration
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#PERMISSION_DENIED PERMISSION_DENIED}, {@link OsidException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */
	function updateConfiguration(& $configuration) { /* :: interface :: */ }
	// :: full java declaration :: void updateConfiguration(java.util.Map configuration)

	/**
	 * Verify to OsidLoader that it is loading a version 1.0 SID.
	 * @package osid
	 */
	function osidVersion_1_0() { /* :: interface :: */ }
	// :: full java declaration :: void osidVersion_1_0
}


	/**
	 * Operations involved with these methods have the following characteristics:<p> either the entire set of actions occurs or nothing happens;<p>actions occurring within a transaction are hidden from other concurrent transactions; and<p>successfully committed transactions result in a consistent persisted data store.<p>mark() identifies a point in processing.  After mark(), at any point up until commit() is called, a call to rollback() causes all processing after mark() to be ignored.  The system is the same state it was at the time mark() was called.  If instead commit() is called after mark(), all processing since mark() was called is made permanent.  Once committed, these actions cannot be rolled back.
	 * @package osid
	 */
class OsidTransactionManager // :: API interface
	extends OsidManager
{

	/**
	 * Marks the beginning of a transaction.
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#PERMISSION_DENIED PERMISSION_DENIED}, {@link OsidException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link OsidException#ALREADY_MARKED ALREADY_MARKED}
	 * @package osid
	 */
	function mark() { /* :: interface :: */ }
	// :: full java declaration :: public void mark()

	/**
	 * Commits a transaction, persisting its operations since a call to mark().
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#PERMISSION_DENIED PERMISSION_DENIED}, {@link OsidException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link OsidException#NOTHING_MARKED NOTHING_MARKED}
	 * @package osid
	 */
	function commit() { /* :: interface :: */ }
	// :: full java declaration :: public void commit()

	/**
	 * Rolls back a transaction's operations since a call to mark().
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#PERMISSION_DENIED PERMISSION_DENIED}, {@link OsidException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link OsidException#NOTHING_MARKED NOTHING_MARKED}
	 * @package osid
	 */
	function rollback() { /* :: interface :: */ }
	// :: full java declaration :: public void rollback()
}


	/**
	 * This interface assists in accessing remote resources from an application.  Applications usually are unaware of whether a resource being used is remote or local.  The OSID implementation used by an application can be implemented as a local service, a remote service, or both.  Applications using only OSIDs and their implementations can leave issues associated with remote resources to the implementation.  Although implementations are expected to handle accessing most remote resources, there are cases where a special implementation, designed for this purpose, is needed.  An application should not handle remote access on its own and in an ad hoc way, because the application will no longer be interoperable across the O.K.I. community.  If the application can find no way to a resource through OSID implementations supporting OsidManager, the application should load an implementation of the OsidRomiManager interface.  This interface provides extra support for access to remote resources.
	 * @package osid
	 */
class OsidRomiManager // :: API interface
	extends OsidManager
{

	/**
	 * Invokes a method remotely.
	 * @return object java.io.Serializable
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#OPERATION_FAILED OPERATION_FAILED}, {@link OsidException#PERMISSION_DENIED PERMISSION_DENIED}, {@link OsidException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */
	function &invoke(& $object, $methodname, & $argTypes, & $args) { /* :: interface :: */ }
	// :: full java declaration :: public java.io.Serializable invoke
}


	/**
	<p>OsidOwner is the holder of contextual information for the application and the OSID implementations. The OSIDs are designed to work and not interfere with frameworks. That is why OSIDs, with a few exceptions, are interfaces and not classes. If OSIDs were Java(TM) classes, it would be very difficult for them to work with frameworks because of Java(TM)'s inability to define classes that extend more than one class. Since there is no framework for the OSIDs, it is necessary to create a mechanism to pass around contextual information. <p> The OsidOwner class has the ability to hold and retrieve context. The only requirement for the context is that it is serializable. There are OsidOwner methods to add and remove context. OsidOwner uses an unambiguous String as a key to store the serializable context information. To retrieve the contextual information from the OsidOwner the getContext method is called with the key. This approach ignores the details of particular context instances, but does not substitute for encrypting data or other security measures. <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid
	 */
class OsidOwner // :: normal class
//	implements java.io.Serializable
{
	// :: defined globally :: define("contextInfo",new java.util.Hashtable());

	/**
	 * Add a context to the OsidOwner. Context is associated with an unambiguous key, for example the context's fully qualified class name.  There is only one context asscociated with a particular key.  If a context already exists for this key, that context is overwritten.
	 * @param object key key is an unambiguous String identifier associated with a particular context. Any application or implementation knowing the key can add or remove the context.  The key may not be null.
	 * @param object context context is any serializable information that either an application or an implementation needs to store, retrieve, or share. For context to be sharable both parties must know the key.  The context may not be null.
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */

	/**
	 * Remove a context from the OsidOwner.  If the context is not known, no exception is raised.
	 * @param object context context is the object to be removed from the OsidOwner
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */

	/**
	 * Remove a context from the OsidOwner.  If the context is not known, no exception is raised.
	 * @param object key key is an unambiguous String identifier
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */

	/**
	 * Get the context associated with this key.  If the key is unknown, null is returned.
	 * @param object key key is an unambiguous String identifier
	 * @return object java.io.Serializable context
	 * @throws osid.OsidException An exception with one of the following messages defined in osid.OsidException:  {@link OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid
	 */
}

// :: post-declaration code ::
/**
 * @const object contextInfo private final java.util.Hashtable contextInfo = new java.util.Hashtable()
 * @package osid
 */
//define("contextInfo", new java.util.Hashtable());


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	 * @package osid
	 */
class OsidException // :: normal class
//	extends java.lang.Exception
{

	/**
	 * Operation failed
	 * @package osid
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Null argument
	 * @package osid
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument");

	/**
	 * Unimplemented method
	 * @package osid
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * OSID Version mismatch
	 * @package osid
	 */
	// :: defined globally :: define("VERSION_ERROR","OSID Version mismatch error ");

	/**
	 * Transaction already marked
	 * @package osid
	 */
	// :: defined globally :: define("ALREADY_MARKED","Transaction already marked ");

	/**
	 * No transaction marked
	 * @package osid
	 */
	// :: defined globally :: define("NOTHING_MARKED","No transaction marked ");

	/**
	 * Interface not found
	 * @package osid
	 */
	// :: defined globally :: define("INTERFACE_NOT_FOUND","Interface not found ");

	/**
	 * Manager not found
	 * @package osid
	 */
	// :: defined globally :: define("MANAGER_NOT_FOUND","Manager not found ");

	/**
	 * Manager instantiation error
	 * @package osid
	 */
	// :: defined globally :: define("MANAGER_INSTANTIATION_ERROR","Manager instantiation error ");

	/**
	 * Error updating owner
	 * @package osid
	 */
	// :: defined globally :: define("ERROR_UPDATING_OWNER","Error updating owner ");

	/**
	 * Error updating configuration
	 * @package osid
	 */
	// :: defined globally :: define("ERROR_UPDATING_CONFIGURATION","Error updating configuration ");

	/**
	 * Permission denied
	 * @package osid
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied");

	/**
	 * Configuration error
	 * @package osid
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error");
}

// :: post-declaration code ::
/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument"
 * @package osid
 */
define("NULL_ARGUMENT", "Null argument");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string VERSION_ERROR public static final String VERSION_ERROR = "OSID Version mismatch error "
 * @package osid
 */
define("VERSION_ERROR", "OSID Version mismatch error ");

/**
 * @const string ALREADY_MARKED public static final String ALREADY_MARKED = "Transaction already marked "
 * @package osid
 */
define("ALREADY_MARKED", "Transaction already marked ");

/**
 * @const string NOTHING_MARKED public static final String NOTHING_MARKED = "No transaction marked "
 * @package osid
 */
define("NOTHING_MARKED", "No transaction marked ");

/**
 * @const string INTERFACE_NOT_FOUND public static final String INTERFACE_NOT_FOUND = "Interface not found "
 * @package osid
 */
define("INTERFACE_NOT_FOUND", "Interface not found ");

/**
 * @const string MANAGER_NOT_FOUND public static final String MANAGER_NOT_FOUND = "Manager not found "
 * @package osid
 */
define("MANAGER_NOT_FOUND", "Manager not found ");

/**
 * @const string MANAGER_INSTANTIATION_ERROR public static final String MANAGER_INSTANTIATION_ERROR = "Manager instantiation error "
 * @package osid
 */
define("MANAGER_INSTANTIATION_ERROR", "Manager instantiation error ");

/**
 * @const string ERROR_UPDATING_OWNER public static final String ERROR_UPDATING_OWNER = "Error updating owner "
 * @package osid
 */
define("ERROR_UPDATING_OWNER", "Error updating owner ");

/**
 * @const string ERROR_UPDATING_CONFIGURATION public static final String ERROR_UPDATING_CONFIGURATION = "Error updating configuration "
 * @package osid
 */
define("ERROR_UPDATING_CONFIGURATION", "Error updating configuration ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied"
 * @package osid
 */
define("PERMISSION_DENIED", "Permission denied");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error"
 * @package osid
 */
define("CONFIGURATION_ERROR", "Configuration error");

?>
