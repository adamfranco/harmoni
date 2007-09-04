<?php 
 
/**
 * OsidLoader loads a specific implementation of an Open Service Interface
 * Definition (OSID) with its getManager method. The getManager method loads
 * an instance of the OSID's OsidManager, assigns the manager's  OsidContext,
 * assigns any configuration information, and returns the instance of the OSID
 * implementation.  This usage of the getManager method in the OsidLoader is
 * how applications should bind a particular implementation to an OSID.  The
 * value of this approach is that an application can defer which specific OSID
 * implementation is used until runtime. The specific implementation package
 * name can then be part of the configuration information rather than being
 * hard coded.  Changing implementations is simplified with this approach.
 * 
 * <p>
 * As an example, in order to create a new Hierarchy, an application does not
 * use the new operator.  It uses the OsidLoader getManager method to get an
 * instance of a class that implements HierarchyManager (a subclass of
 * OsidManager). The application uses the HierarchyManager instance to create
 * the Hierarchy.  It is the createHierarchy() method in some package (e.g.
 * org.osid.hierarchy.impl.HierarchyManager) which uses the new operator on
 * org.osid.hierarchy.impl.Hierarchy, casts it as
 * org.osid.hierarchy.Hierarchy, and returns it to the application.  This
 * indirection offers the significant value of being able to change
 * implementations in one spot with one modification, namely by using a
 * implementation package name argument for the OsidLoader getManager method.
 * </p>
 * 
 * <p>
 * Sample:
 * <blockquote>
 * org.osid.OsidContext myContext = new org.osid.OsidContext();<br>
 * String key = "myKey";<br>
 * myContext.assignContext(key, "I want to save this string as context");<br>
 * String whatWasMyContext = myContext.getContext(key);<br>
 * org.osid.hierarchy.HierarchyManager hierarchyManager =
 * <blockquote>
 * org.osid.OsidLoader.getManager("org.osid.hierarchy.HierarchyManager","org.osid.shared.impl",myContext,null);
 * </blockquote>
 * org.osid.hierarchy.Hierarchy myHierarchy =
 * hierarchyManager.createHierarchy(...);<br>
 * </blockquote>
 * </p>
 * 
 * <p>
 * A similar technique can be used for creating other objects.  OSIDs that have
 * OsidManager implementations loaded by OsidLoader, will define an
 * appropriate interface to create these objects.
 * </p>
 * 
 * <p>
 * The arguments to OsidLoader.getManager method are the OSID OsidManager
 * interface name, the implementing package name, the OsidContext, and any
 * additional configuration information.
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
class OsidLoader
    extends stdClass
{
    /**
     * Returns an instance of the OsidManager of the OSID specified by the OSID
     * package OsidManager interface name and the implementation package name.
     * The implementation class name is constructed from the SID package
     * Manager interface name. A configuration file name is constructed in a
     * similar manner and if the file exists it is loaded into the
     * implementation's OsidManager's configuration.
     * 
     * <p>
     * Example:  To load an implementation of the org.osid.Filing OSID
     * implemented in a package "xyz", one would use:
     * </p>
     * 
     * <p>
     * org.osid.filing.FilingManager fm =
     * (org.osid.filing.FilingManager)org.osid.OsidLoader.getManager(
     * </p>
     * 
     * <p>
     * "org.osid.filing.FilingManager" ,
     * </p>
     * 
     * <p>
     * "xyz" ,
     * </p>
     * 
     * <p>
     * new org.osid.OsidContext());
     * </p>
     * 
     * @param string $osidPackageManagerName
     * @param string $implPackageName
     * @param object OsidContext $context
     * @param object Properties $additionalConfiguration (original type: java.util.Properties)
     *  
     * @return object OsidManager
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT},
     *         {@link org.osid.OsidException#VERSION_ERROR VERSION_ERROR},
     *         ={@link org.osid.OsidException#INTERFACE_NOT_FOUND
     *         INTERFACE_NOT_FOUND}, ={@link
     *         org.osid.OsidException#MANAGER_NOT_FOUND MANAGER_NOT_FOUND},
     *         ={@link org.osid.OsidException#MANAGER_INSTANTIATION_ERROR
     *         MANAGER_INSTANTIATION_ERROR}, ={@link
     *         org.osid.OsidException#ERROR_ASSIGNING_CONTEXT
     *         ERROR_ASSIGNING_CONTEXT}, ={@link
     *         org.osid.OsidException#ERROR_ASSIGNING_CONFIGURATION
     *         ERROR_ASSIGNING_CONFIGURATION}
     * 
     * @access public
     * @static 
     */
    function getManager ( $osidPackageManagerName, $implPackageName, $context, $additionalConfiguration )
    {
     /*   try {
            if ((null != context) && (null != osidPackageManagerName) &&
                    (null != implPackageName)) {
                String osidInterfaceName = osidPackageManagerName;
                String className = makeClassName(osidPackageManagerName);
                String managerClassName = makeFullyQualifiedClassName(implPackageName,
                        className);

                Class osidInterface = Class.forName(osidInterfaceName);

                if (null != osidInterface) {
                    Class managerClass = Class.forName(managerClassName);

                    if (null != managerClass) {
                        if (osidInterface.isAssignableFrom(managerClass)) {
                            OsidManager manager = (OsidManager) managerClass.newInstance();

                            if (null != manager) {
                                try {
                                    manager.osidVersion_2_0();
                                } catch (Throwable ex) {
                                    throw new OsidException(OsidException.VERSION_ERROR);
                                }

                                try {
                                    manager.assignOsidContext(context);
                                } catch (Exception ex) {
                                    throw new OsidException(OsidException.ERROR_ASSIGNING_CONTEXT);
                                }

                                try {
                                    java.util.Properties configuration = getConfiguration(manager);

                                    if (null == configuration) {
                                        configuration = new java.util.Properties();
                                    }

                                    if (null != additionalConfiguration) {
                                        java.util.Enumeration enum = additionalConfiguration.propertyNames();

                                        while (enum.hasMoreElements()) {
                                            java.io.Serializable key = (java.io.Serializable) enum.nextElement();

                                            if (null != key) {
                                                java.io.Serializable value = (java.io.Serializable) additionalConfiguration.get(key);

                                                if (null != value) {
                                                    configuration.put(key, value);
                                                }
                                            }
                                        }
                                    }

                                    manager.assignConfiguration(configuration);

                                    return manager;
                                } catch (Exception ex) {
                                    throw new OsidException(OsidException.ERROR_ASSIGNING_CONFIGURATION);
                                }
                            }

                            throw new OsidException(OsidException.MANAGER_INSTANTIATION_ERROR);
                        }

                        throw new OsidException(OsidException.MANAGER_NOT_OSID_IMPLEMENTATION);
                    }

                    throw new OsidException(OsidException.MANAGER_NOT_FOUND);
                }

                throw new OsidException(OsidException.INTERFACE_NOT_FOUND);
            }

            throw new OsidException(OsidException.NULL_ARGUMENT);
        } catch (OsidException oex) {
            throw new OsidException(oex.getMessage());
        } catch (java.lang.Throwable ex) {
            throw new org.osid.OsidException(org.osid.OsidException.OPERATION_FAILED);
        }
   */ }

/*private static java.lang.String makeClassName(java.lang.String packageManagerName) throws org.osid.OsidException{
        String className = packageManagerName;

        if (null != className) {
            className = (className.endsWith(".")
                ? className.substring(0, className.length() - 1) : className);

            int lastdot = className.lastIndexOf(".");

            if (-1 != lastdot) {
                className = className.substring(lastdot + 1);
            }
        }

        return className;
    }

private static java.lang.String makeFullyQualifiedClassName(java.lang.String packageName, java.lang.String className) throws org.osid.OsidException{
        String cName = className;

        if (null != packageName) {
            String pName = (packageName.endsWith(".") ? packageName
                                                      : new String(packageName +
                    "."));
            cName = pName + className;
        }

        return cName;
    }

private static java.util.Properties getConfiguration(org.osid.OsidManager manager) throws org.osid.OsidException{
        java.util.Properties properties = null;

        if (null != manager) {
            Class managerClass = manager.getClass();

            try {
                String managerClassName = managerClass.getName();
                int index = managerClassName.lastIndexOf(".");

                if (-1 != index) {
                    managerClassName = managerClassName.substring(index + 1);
                }

                java.io.InputStream is = managerClass.getResourceAsStream(managerClassName +
                        ".properties");

                if (null != is) {
                    properties = new java.util.Properties();
                    properties.load(is);
                }
            } catch (Throwable ex) {
            }
        }

        return properties;
    }
*/
}

?>