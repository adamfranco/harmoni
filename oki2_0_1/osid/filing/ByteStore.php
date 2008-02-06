<?php 
 
include_once(dirname(__FILE__)."/../filing/CabinetEntry.php");
/**
 * The ByteStore is the fundamental interface of the Filing package.
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
 * @package org.osid.filing
 */
interface ByteStore
    extends CabinetEntry
{
    /**
     * Returns the length of this ByteStore
     *  
     * @return int
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link org.osid.filing.FilingException#IO_ERROR
     *         IO_ERROR}, {@link org.osid.filing.FilingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * @throws org.osid.filing.FilingException if an IO error occurs reading
     *         Object
     * 
     * @access public
     */
    public function length (); 

    /**
     * Tests whether the Manager Owner may append to this ByteStore.
     *  
     * @return boolean
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function canAppend (); 

    /**
     * Marks this ByteStore so that only append operations are allowed.
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function updateAppendOnly (); 

    /**
     * Gets the mime-type of this ByteStore.
     *  
     * @return string
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function getMimeType (); 

    /**
     * Set the mime-type of this ByteStore. Returns the actual mime-type set
     * for the ByteStore.  This may differ from the supplied mime-type for
     * several reasons.  The implementation may not support the setting of the
     * mime-type, in which case the default mime-type or one derived from the
     * content bytes or file extension may be used.  Or a canonical, IANA
     * mime-type (see <a
     * href="http://www.iana.org/assignments/media-types/index.html">http://www.iana.org/assignments/media-types/index.html</a>)
     * may be substituted for a vendor or experimental type.
     * 
     * @param string $mimeType
     *  
     * @return string
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function updateMimeType ( $mimeType ); 

    /**
     * Tests whether the Manager Owner may read this CabinetEntry.
     *  
     * @return boolean
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function isReadable (); 

    /**
     * Tests whether the Manager Owner may modify this CabinetEntry.
     *  
     * @return boolean
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function isWritable (); 

    /**
     * Marks this ByteStore so that only read operations are allowed. After
     * invoking this method this ByteStore is guaranteed not to change until
     * it is either deleted or marked to allow write access. Note that whether
     * or not a read-only ByteStore may be deleted depends upon the file
     * system underlying the implementation.
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function updateReadOnly (); 

    /**
     * Marks this Cabinet so that write operations are allowed.
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function updateWritable (); 

    /**
     * Returns the Digest of this ByteStore using the specified algorithm used,
     * such as md5 or crc.
     * 
     * @param object Type $algorithmType
     *  
     * @return string
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function getDigest ( Type $algorithmType ); 

    /**
     * Returns the Digest algorithm types supported by the implementation, such
     * as md5 or crc.
     *  
     * @return object TypeIterator
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function getDigestAlgorithmTypes (); 

    /**
     * Reads the data.
     * 
     * @param int $version
     *  
     * @return object ByteValueIterator
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function read ( $version ); 

    /**
     * Writes b.length bytes to this ByteStore.
     * 
     * @param array $b (original type: java.lang.Byte[])
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function write ( $b ); 

    /**
     * Writes bytes from the specified byte array starting at offset in this
     * ByteStore.
     * 
     * @param array $b (original type: java.lang.Byte[])
     * @param int $offset
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function writeBytesAtOffset ( $b, $offset ); 

    /**
     * Writes the specified byte to this ByteStore.
     * 
     * @param int $b
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function writeByte ( $b ); 

    /**
     * Closes this Output Object and releases any system resources associated
     * with it.
     * 
     * @throws object FilingException 
     * 
     * @access public
     */
    public function commit (); 
}

?>