<?php
/**
 * @package osid.filing
 */

/**
 * @ignore
 */
require_once(OKI."/osid.interface.php");

	  /**
	   * The ByteStore is the fundamental interface of the Filing package.
	  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.filing
	   */
class ByteStore // :: API interface
	extends CabinetEntry
{

	  /**
	   * Returns the length of this ByteStore
	   *
	   * @return object The length, in bytes, of this ByteStore
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	   * @throws osid.filing.FilingException if an IO error occurs reading Object
		   */
	function length() { /* :: interface :: */ }
	// :: full java declaration :: long length()

	  /**
	   * Tests whether the Manager Owner may append to this ByteStore.
	   *
	   * @return object <code>true</code> if and only if the Manager Owner is
	   *          allowed to append to this ByteStore,
	   *          <code>false</code> otherwise.
	   * @throws osid.filing.FilingException
		   */
	function canAppend() { /* :: interface :: */ }
	// :: full java declaration :: boolean canAppend()

	   /**
	   * Marks this ByteStore so that only append operations are allowed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function updateAppendOnly() { /* :: interface :: */ }
	// :: full java declaration :: void updateAppendOnly()

	  /**
	   * Gets the mime-type of this ByteStore.
	   *
	   * @return object the mime-type (Content-Type in a jar file manifest)
	   * @throws osid.filing.FilingException
	 */
	function getMimeType() { /* :: interface :: */ }
	// :: full java declaration :: String getMimeType()

	  /**
	   * Set the mime-type of this ByteStore.
	   * <p>Returns the actual mime-type set for the ByteStore.  This may
	   * differ from the supplied mime-type for several reasons.  The
	   * implementation may not support the setting of the mime-type, in
	   * which case the default mime-type or one derived from the content
	   * bytes or file extension may be used.  Or a canonical, IANA
	   * mime-type (see
	   * <a href="http://www.iana.org/assignments/media-types/index.html">http://www.iana.org/assignments/media-types/index.html</a>)
	   * may be substituted for a vendor or experimental type.
	   *
	   * @param object mimeType
	   *
	   * @return object String
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function updateMimeType($mimeType) { /* :: interface :: */ }
	// :: full java declaration :: String updateMimeType(String mimeType)

	    /**
	   * Tests whether the Manager Owner may read this CabinetEntry.
	   *
	   * @return object <code>true</code> if and only if this CabinetEntry can be
	   *          read by the Manager Owner, <code>false</code> otherwise
	   *
	   * @throws osid.filing.FilingException
		   */
	function isReadable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isReadable()

	  /**
	   * Tests whether the Manager Owner may modify this CabinetEntry.
	   *
	   * @return object <code>true</code> if and only if the Manager Owner is
	   *          allowed to write to this CabinetEntry,
	   *          <code>false</code> otherwise.
	   *
	   * @throws osid.filing.FilingException
		   */
	function isWritable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isWritable()

	  /**
	   * Marks this ByteStore so that only read operations are allowed.
	   * After invoking this method this ByteStore is guaranteed not to
	   * change until it is either deleted or marked to allow write
	   * access.
	   *
	   * Note that whether or not a read-only ByteStore may be deleted
	   * depends upon the file system underlying the implementation.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function updateReadOnly() { /* :: interface :: */ }
	// :: full java declaration :: void updateReadOnly()

	  /**
	   * Marks this Cabinet so that write operations are allowed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function updateWritable() { /* :: interface :: */ }
	// :: full java declaration :: void updateWritable()

	 /**
	   * Returns the Digest of this ByteStore using the specified algorithm used,
	   * such as md5 or crc.
	   *
	   * @param object algorithmType digestAlgorithmType selected from possible implementation digest algorithm types.
	   *
	   * @return object String digest or null if digest is not supported for this ByteStore.
	   *
	   * @throws osid.filing.FilingException
		   */
	function getDigest(& $algorithmType) { /* :: interface :: */ }
	// :: full java declaration :: String getDigest(osid.shared.Type algorithmType)

	  /**
	   * Returns the Digest algorithm types supported by the implementation, such as md5 or crc.
	   *
	   * @return object osid.shared.TypeIterator the digest algorithm types supported by this implementation.
	   *
	   * @throws osid.filing.FilingException
		   */
	function &getDigestAlgorithmTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getDigestAlgorithmTypes()

	  /**
	   * Reads the data.
	   *
	   * @return object osid.shared.ByteValueIterator
	   *
	   * @throws osid.filing.FilingException
		   */
	function &read(& $version) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.ByteValueIterator read(java.util.Calendar version)

	  /**
	   * Writes b.length bytes to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
		   */
	function write(& $b) { /* :: interface :: */ }
	// :: full java declaration :: void write(byte[] b)

	  /**
	   * Writes <code>len</code> bytes from the specified byte array starting at
	   * offset <code>off</code> to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
		   */
	function writeBytesAtOffset(& $b, $off, $len) { /* :: interface :: */ }
	// :: full java declaration :: void writeBytesAtOffset(byte[] b, int off, int len)

	  /**
	   * Writes the specified byte to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
		   */
	function writeByte($b) { /* :: interface :: */ }
	// :: full java declaration :: void writeByte(int b)

	  /**
	   * Closes this Output Object and releases any system resources
	   * associated with it.
	   *
	   * @throws osid.filing.FilingException
		   */
	function commit() { /* :: interface :: */ }
	// :: full java declaration :: void commit()
}


	  /**
	   * Cabinets contain other Cabinets and ByteStores, and have
	   * implementation-dependent properties.
	   * <p>
	   * They may manage quotas, that is, if the implementation supports
	   * quotas, each Agent may be assigned a quota of space used in the
	   * Cabinet.
	   * <p>
	   * Cabinets contain CabinetEntries, each of which may be a ByteStore or a
	   * Cabinet.  They are known by their IDs and name, where
	   * the name is a string which does not include the
	   * implementation-dependent separationCharacter, and may represent a filename.
	   * <p>
	   * ByteStores and Cabinets are added to Cabinets. Cabinets are created
	   * in CabinetFactories or Cabinets, and ByteStores are created in Cabinets.
	  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.filing
	   */
class Cabinet // :: API interface
	extends CabinetEntry
{

	  /**
	   * Method getProperties
	   *
	   * Return properties of this cabinet.  The property map is
	   * specified using keys of osid.shared.Type, and values of
	   * e.g. Boolean, Long, or Double.  The application prepares a map of
	   * desired qualities, e.g.<br />
	   <code>
	   * key = new Type("Filing", "MIT", "supportsQuota"),
	   *    value = new Boolean(true)<br />
	   * key = new Type("Filing", "MIT", "supportsReplication"),
	   *    value = new Boolean(true)<br />
	   * key = new Type("Filing", "MIT", "minimumReplications"),
	   * value = new Integer(2)
	   </code>
	   *
	   * @return object java.util.Map of properties of this Cabinet and implementation
	   *
	   * @throws osid.filing.FilingException
		   */
	function &getProperties() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Map getProperties()

	  /**
	   * Create a new ByteStore and add it to this Cabinet under the given
	   * name.
	   *
	   * The name must not include this Cabinet's separationCharacter.
	   *
	   * @param string displayName  The name to be used
	   *
	   * @return object  The ByteStore created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}
		   */
	function &createByteStore($displayName) { /* :: interface :: */ }
	// :: full java declaration :: ByteStore createByteStore(String displayName)

	  /**
	   * Create a new Cabinet and add it to this Cabinet under the given
	   * name.
	   *
	   * The name must not include this Cabinet's separationCharacter.
	   *
	   * @param string displayName  The name to be used
	   *
	   * @return object  The Cabinet created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#NAME_CONTAINS_ILLEGAL_CHARS NAME_CONTAINS_ILLEGAL_CHARS}
		   */
	function &createCabinet($displayName) { /* :: interface :: */ }
	// :: full java declaration :: Cabinet createCabinet(String displayName)

	  /**
	   * Copy an existing ByteStore in this Cabinet by copying contents and
	   * the appropriate attributes of another ByteStore.
	   *
	   * @param string displayName
	   * @param object oldByteStore
	   *
	   * @return object ByteStore
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &copyByteStore($displayName, & $oldByteStore) { /* :: interface :: */ }
	// :: full java declaration :: ByteStore copyByteStore(String displayName, ByteStore oldByteStore)

	  /**
	   * Add a CabinetEntry, it must be from same Manager.
	   *
	   *
	   * @param object entry
	   * @param string displayName
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#NAME_CONTAINS_ILLEGAL_CHARS NAME_CONTAINS_ILLEGAL_CHARS}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function add(& $entry, $displayName) { /* :: interface :: */ }
	// :: full java declaration :: void add(CabinetEntry entry, String displayName)

	  /**
	   * Remove a CabinetEntry. Does not destroy the CabinetEntry.
	   *
	   *
	   * @param object entry
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function remove(& $entry) { /* :: interface :: */ }
	// :: full java declaration :: void remove(CabinetEntry entry)

	  /**
	   * Get a CabinetEntry from a Cabinet by its ID.
	   *
	   * @param object id
	   *
	   * @return object CabinetEntry which has given ID.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR},{@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
		   */
	function &getCabinetEntryById(& $id) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntryById(osid.shared.Id id)

	  /**
	   * Get a CabinetEntry by name.  Not all CabinetEntrys have names,
	   * but if it has a name, the name is unique within a Cabinet.
	   *
	   * @param string displayName
	   *
	   * @return object CabinetEntry which has given name
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#DELETE_FAILED DELETE_FAILED}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getCabinetEntryByName($displayName) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntryByName(String displayName)

	  /**
	   * Get an Iterator over all CabinetEntries in this Cabinet.
	   *
	   * @return object CabinetEntryIterator
	   *
	   * @throws osid.filing.FilingException
		   */
	function &entries() { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntryIterator entries()

	  /**
	   * Return the root Cabinet of this Cabinet.
	   *
	   *
	   * @return object root Cabinet
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getRootCabinet() { /* :: interface :: */ }
	// :: full java declaration :: Cabinet getRootCabinet()

	  /**
	   * Return true if this Cabinet is the root Cabinet.
	   *
	   *
	   * @return object true if and only if this Cabinet is the root Cabinet.
	   *
	   * @throws osid.filing.FilingException
		   */
	function isRootCabinet() { /* :: interface :: */ }
	// :: full java declaration :: boolean isRootCabinet()

	  /**
	   * Return true if this Cabinet can list its entries.
	   *
	   *
	   * @return object true if and only if this Cabinet can list its entries.
	   *
	   * @throws osid.filing.FilingException
		   */
	function isListable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isListable()

	  /**
	   * Return true if this Cabinet allows entries to be added or removed.
	   *
	   *
	   * @return object true if and only if this Cabinet allows entries to be added or removed.
	   *
	   * @throws osid.filing.FilingException
		   */
	function isManageable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isManageable()

	  /**
	   * Get space available in Cabinet, for bytes.
	   *
	   * @return object long Space available in this Cabinet, in bytes.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function getAvailableBytes() { /* :: interface :: */ }
	// :: full java declaration :: long getAvailableBytes()

	  /**
	   * Get number of bytes used in this Cabinet.
	   *
	   * @return object long Space used in this Cabinet, in bytes.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function getUsedBytes() { /* :: interface :: */ }
	// :: full java declaration :: long getUsedBytes()
}


	  /**
	   * An entry in a Cabinet, a CabinetEntry is either a ByteStore or a Cabinet. CabinetEntry contains information common to both Cabinets and Bytestores
	   <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.filing
	   */
class CabinetEntry // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Returns the Cabinet in which this CabinetEntry is an entry, or null if it has
	   * no parent (for example is the root Cabinet).
	   *
	   *
	   * @return object Cabinet the parent Cabinet of this entry, or null if it has
	   * no parent (e.g. is the root Cabinet)
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}
		   */
	function &getParent() { /* :: interface :: */ }
	// :: full java declaration :: Cabinet getParent()

	  /**
	   * Return the name of this CabinetEntry in its parent Cabinet.
	   *
	   * @return object name
	   *
	   * @throws osid.filing.FilingException
		   */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	  /**
	   * Get Id of this CabinetEntry
	   *
	   * @return object Id
	   *
	   * @throws osid.filing.FilingException
		   */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	  /**
	   * Returns when this Cabinet was last modified.
	   *
	   * @return object  java.util.Calendar The time this cabinet was last modified
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	  */
	function &getLastModifiedTime() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getLastModifiedTime()

	  /**
	   * Returns all the times that this Cabinet was modified.
	   *
	   * @return object  osid.shared.CalendarInterator The times this cabinet was modified
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	  */
	function &getAllModifiedTimes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.CalendarIterator getAllModifiedTimes()

	  /**
	   * Sets the last-modified time to the current time for this CabinetEntry.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function touch() { /* :: interface :: */ }
	// :: full java declaration :: void touch()

	   /**
	   * Returns when this Cabinet was last accessed.
	   *
	   * Not all implementations will record last access times accurately,
	   * due to caching and for performance.  The value returned will be
	   * at least the last modified time, the actual time when a read was
	   * performed may be later.
	   *
	   * @return object  java.util.Calendar The time the file was last accessed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getLastAccessedTime() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getLastAccessedTime()

	  /**
	   * Returns when this CabinetEntry was created.
	   *
	   * Not all implementations will record the time of creation
	   * accurately.  The value returned will be at least the last
	   * modified time, the actual creation time may be earlier.
	   *
	   * @return object java.util.Calendar The time the file was created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getCreatedTime() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getCreatedTime()

	  /**
	   * Return the Agent that owns this CabinetEntry.
	   *
	   * @return object osid.shared.Agent
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getCabinetEntryAgent() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Agent getCabinetEntryAgent()

	  /**
	   * Change the name of this entry to <code>displayName</code>
	   *
	   * @param string displayName the new name for the entry
	   *
	   * @throws osid.filing.FilingException
		   */
	function updateDisplayName($displayName) { /* :: interface :: */ }
	// :: full java declaration :: void updateDisplayName(String displayName)
}


	  /**
	    * The FilingManager provides a service for creating a Root Cabinet and
	    * getting ByteStores and Cabinets. Refer to the OsidLoader for more
	    * information on Managers.
	    * <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	    *
	    * @see osid.OsidLoader
	    * @see osid.OsidManager
	    *
	 * @package osid.filing
	    */
class FilingManager // :: API interface
	extends OsidManager
{

	  /**
	   * List all the root Cabinets currently available in this Manager.
	   *
	   * @return object CabinetEntryIterator
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}
		   */
	function &listRoots() { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntryIterator listRoots()

	  /**
	   * Get a CabinetEntry by ID.
	   *
	   * @param object id
	   *
	   * @return object CabinetEntry with a given ID
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
		   */
	function &getCabinetEntry(& $id) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntry(osid.shared.Id id)

	  /**
	   * Deletes this CabinetEntry.
	   *
	   * If the CabinetEntry is a Cabinet it must be empty, and the Owner of
	   * the Manager must have sufficient permissions to perform this action.
	   *
	   * @param object cabinetEntryId id is the CabinetEntry's id.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#DELETE_FAILED DELETE_FAILED}, {@link FilingException#CABINET_NOT_EMPTY CABINET_NOT_EMPTY}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
		   */
	function delete(& $cabinetEntryId) { /* :: interface :: */ }
	// :: full java declaration :: void delete(osid.shared.Id cabinetEntryId)
}


	    /**
	    * CabinetEntryIterator is the iterator for a collection of CabinetEntries.
	    * <p>
	    * OSID provides a set of iterator interfaces for base types.  The purpose of these iterators is to offer
	    * a way for SID methods to return multiple values of a common type while avoiding the use arrays.  Returning an
	    * array may not be appropriate if the number of values returned is large or if the array is fetched remotely.
	    * <p>
	    * Note that iterators do not allow access to values by index; you must access values sequentially.
	    * There is no way to go backwards through the sequence.
	    * <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	    * @see CabinetEntry
	    * @see osid.OsidManager
	 * @package osid.filing
	    */
class CabinetEntryIterator // :: API interface
{

	   /**
	    * Method hasNext
	    *
	    * @return object boolean
	    *
	    * @throws osid.filing.FilingException
	    */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	    /**
	    *    Returns the next CabinetEntry in the collection.
	    *
	    *    @return CabinetEntry
	    *
	    * @throws osid.filing.FilingException
	    */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry next()
}


	    /**
	 *     All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an osid manager can not determine where the manager will ultimately execute, it must assume a worst case scenario and protect itself.
	    <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.filing
	    */
class FilingException // :: normal class
	extends OsidException
{

	    /**
	 *     Selected item already exists
	 * @package osid.filing
	    */
	// :: defined globally :: define("ITEM_ALREADY_EXISTS","Selected item already exists";);

	    /**
	 *     Selected item does not exist
	 * @package osid.filing
	    */
	// :: defined globally :: define("ITEM_DOES_NOT_EXIST","Selected item does not exist";);

	    /**
	 *     Unsupported operation
	 * @package osid.filing
	    */
	// :: defined globally :: define("UNSUPPORTED_OPERATION","Unsupported operation";);

	    /**
	 *     IO error
	 * @package osid.filing
	    */
	// :: defined globally :: define("IO_ERROR","IO error";);

	    /**
	 *     Unsupported CabinetEntry Type
	 * @package osid.filing
	    */
	// :: defined globally :: define("UNSUPPORTED_TYPE","Unsupported CabinetEntry Type";);

	    /**
	 *     Cabinet is not empty
	 * @package osid.filing
	    */
	// :: defined globally :: define("CABINET_NOT_EMPTY","Cabinet is not empty";);

	    /**
	 *     Object is not a Cabinet
	 * @package osid.filing
	    */
	// :: defined globally :: define("NOT_A_CABINET","Object is not a Cabinet";);

	    /**
	 *     Object is not a ByteStore
	 * @package osid.filing
	    */
	// :: defined globally :: define("NOT_A_BYTESTORE","Object is not a ByteStore";);

	    /**
	 *     Name contains illegal characters
	 * @package osid.filing
	    */
	// :: defined globally :: define("NAME_CONTAINS_ILLEGAL_CHARS","Name contains illegal characters";);

	    /**
	 *     Owner is null
	 * @package osid.filing
	    */
	// :: defined globally :: define("NULL_OWNER","Owner is null";);

	    /**
	 *     Delete failed
	 * @package osid.filing
	    */
	// :: defined globally :: define("DELETE_FAILED","Delete failed";);

	    /**
	 *     Operation failed
	 * @package osid.filing
	    */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed");

	    /**
	 *     Iterator has no more elements
	 * @package osid.filing
	    */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements");

	    /**
	 *     Unimplemented method
	 * @package osid.filing
	    */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	    /**
	 *     Permission denied
	 * @package osid.filing
	    */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied");

	    /**
	 *     Null argument
	 * @package osid.filing
	    */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument");

	    /**
	 *     Configuration error
	 * @package osid.filing
	    */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error");

	    /**
	 *     Can't delete root Cabinet
	 * @package osid.filing
	    */
	// :: defined globally :: define("CANNOT_DELETE_ROOT_CABINET","Cannot delete root Cabinet");
}

// :: post-declaration code ::
/**
 * string: Selected item already exists
 * @name ITEM_ALREADY_EXISTS;
 */
define("ITEM_ALREADY_EXISTS", "Selected item already exists";);

/**
 * string: Selected item does not exist
 * @name ITEM_DOES_NOT_EXIST;
 */
define("ITEM_DOES_NOT_EXIST", "Selected item does not exist";);

/**
 * string: Unsupported operation
 * @name UNSUPPORTED_OPERATION;
 */
define("UNSUPPORTED_OPERATION", "Unsupported operation";);

/**
 * string: IO error
 * @name IO_ERROR;
 */
define("IO_ERROR", "IO error";);

/**
 * string: Unsupported CabinetEntry Type
 * @name UNSUPPORTED_TYPE;
 */
define("UNSUPPORTED_TYPE", "Unsupported CabinetEntry Type";);

/**
 * string: Cabinet is not empty
 * @name CABINET_NOT_EMPTY;
 */
define("CABINET_NOT_EMPTY", "Cabinet is not empty";);

/**
 * string: Object is not a Cabinet
 * @name NOT_A_CABINET;
 */
define("NOT_A_CABINET", "Object is not a Cabinet";);

/**
 * string: Object is not a ByteStore
 * @name NOT_A_BYTESTORE;
 */
define("NOT_A_BYTESTORE", "Object is not a ByteStore";);

/**
 * string: Name contains illegal characters
 * @name NAME_CONTAINS_ILLEGAL_CHARS;
 */
define("NAME_CONTAINS_ILLEGAL_CHARS", "Name contains illegal characters";);

/**
 * string: Owner is null
 * @name NULL_OWNER;
 */
define("NULL_OWNER", "Owner is null";);

/**
 * string: Delete failed
 * @name DELETE_FAILED;
 */
define("DELETE_FAILED", "Delete failed";);

/**
 * string: Operation failed
 * @name OPERATION_FAILED
 */
define("OPERATION_FAILED", "Operation failed");

/**
 * string: Iterator has no more elements
 * @name NO_MORE_ITERATOR_ELEMENTS
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements");

/**
 * string: Unimplemented method 
 * @name UNIMPLEMENTED
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * string: Permission denied
 * @name PERMISSION_DENIED
 */
define("PERMISSION_DENIED", "Permission denied");

/**
 * string: Null argument
 * @name NULL_ARGUMENT
 */
define("NULL_ARGUMENT", "Null argument");

/**
 * string: Configuration error
 * @name CONFIGURATION_ERROR
 */
define("CONFIGURATION_ERROR", "Configuration error");

/**
 * string: Cannot delete root Cabinet
 * @name CANNOT_DELETE_ROOT_CABINET
 */
define("CANNOT_DELETE_ROOT_CABINET", "Cannot delete root Cabinet");

?>
