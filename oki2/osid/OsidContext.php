<?php 
 
/**
 * <p>
 * OsidContext holds contextual information that is shared by the application
 * and the OSID implementations it uses. The osid package has some design
 * constraints that create the need for OsidContext.  They are:
 * 
 * <ul>
 * <li>
 * OSIDs must work with all frameworks.
 * </li>
 * <li>
 * OSID implementations are independent of each other.
 * </li>
 * </ul>
 * 
 * These design constraints mean that there this no obvious place to put global
 * information.  The OsidContext argument of the OsidLoader.getManager method
 * is intended to provide access to information that is global to an
 * application and the OSID implementations that it loads.  OsidContext can
 * hold and retrieve context. The only requirement is that the information is
 * serializable. There are OsidContext methods to get and assign context.
 * </p>
 * 
 * <p>
 * With few exceptions OSID objects are interfaces and not classes. The use of
 * interfaces in the definition of OSID objects has some important
 * characteristics:
 * 
 * <ul>
 * <li>
 * There is no OSID framework for storing contextual (global) information.
 * </li>
 * <li>
 * The OSID implementation developer can define OSID objects by implementing
 * the OSID interface and extending a framework class.
 * </li>
 * <li>
 * Contextual (global) information can only be communicated when the
 * application loads an implementation.
 * </li>
 * </ul>
 * 
 * These characteristics of OSIDs and the need to provide sharable contextual
 * (global) information led to the definition of OsidContext. An application
 * is responsible for supplying a valid OsidContext instance when it loads an
 * OSID implementation using the OsidLoader.getManager method. This approach
 * provides all the benefits and limitations of any system of global data.
 * </p>
 * 
 * <p>
 * OsidContext uses an unambiguous String as a key to assign the serializable
 * context information. To retrieve the contextual information from the
 * OsidContext the getContext method is called with the key.
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
class OsidContext
    extends stdClass
{
    /**
     * Assign the context of the OsidContext. Context is associated with an
     * unambiguous key, for example the context's fully qualified class name.
     * There is only one context asscociated with a particular key.  If a
     * context already exists for this key, that context is overwritten.
     * 
     * @param string $key
     * @param object mixed $context (original type: java.io.Serializable)
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignContext ( $key, $context )
    {
    	
    	if (!is_array($this->contextInfo))
    		$this->contextInfo = array();
    	
        if ((null != $key) && (null != $context)) {
            $this->contextInfo[serialize($key)] =$context;
        } else if ((null != $key) && (null == $context)) {
            if (isset($this->contextInfo[serialize($key)])) {
                unset($this->contextInfo[serialize($key)]);
            }
        } else {
            die(NULL_ARGUMENT);
        }
    }

    /**
     * Get the context associated with this key.  If the key is unknown, null
     * is returned.
     * 
     * @param string $key
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function getContext ( $key )
    {
        if (null != $key) {
            if ($this->contextInfo[serialize($key)]) {
                return $this->contextInfo[serialize($key)];
            } else {
                return null;
            }
        }

        die(NULL_ARGUMENT);
    }


	/**
	 * Constructor
	 */
	function OsidContext () {
		$this->contextInfo = array();
	}
}

?>