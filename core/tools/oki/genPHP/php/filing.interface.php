<?php


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
	   * @return The length, in bytes, of this ByteStore
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	   * @throws osid.filing.FilingException if an IO error occurs reading Object
	 * @package osid.filing
	   */
	function length() { /* :: interface :: */ }
	// :: full java declaration :: long length()

	  /**
	   * Tests whether the Manager Owner may append to this ByteStore.
	   *
	   * @return <code>true</code> if and only if the Manager Owner is
	   *          allowed to append to this ByteStore,
	   *          <code>false</code> otherwise.
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function canAppend() { /* :: interface :: */ }
	// :: full java declaration :: boolean canAppend()

	   /**
	   * Marks this ByteStore so that only append operations are allowed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function updateAppendOnly() { /* :: interface :: */ }
	// :: full java declaration :: void updateAppendOnly()

	  /**
	   * Gets the mime-type of this ByteStore.
	   *
	   * @return the mime-type (Content-Type in a jar file manifest)
	   * @throws osid.filing.FilingException
	 * @package osid.filing
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
	   * @param mimeType
	   *
	   * @return String
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function updateMimeType($mimeType) { /* :: interface :: */ }
	// :: full java declaration :: String updateMimeType(String mimeType)

	    /**
	   * Tests whether the Manager Owner may read this CabinetEntry.
	   *
	   * @return <code>true</code> if and only if this CabinetEntry can be
	   *          read by the Manager Owner, <code>false</code> otherwise
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function isReadable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isReadable()

	  /**
	   * Tests whether the Manager Owner may modify this CabinetEntry.
	   *
	   * @return <code>true</code> if and only if the Manager Owner is
	   *          allowed to write to this CabinetEntry,
	   *          <code>false</code> otherwise.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
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
	 * @package osid.filing
	   */
	function updateReadOnly() { /* :: interface :: */ }
	// :: full java declaration :: void updateReadOnly()

	  /**
	   * Marks this Cabinet so that write operations are allowed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function updateWritable() { /* :: interface :: */ }
	// :: full java declaration :: void updateWritable()

	 /**
	   * Returns the Digest of this ByteStore using the specified algorithm used,
	   * such as md5 or crc.
	   *
	   * @param algorithmType digestAlgorithmType selected from possible implementation digest algorithm types.
	   *
	   * @return String digest or null if digest is not supported for this ByteStore.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function getDigest(& $algorithmType) { /* :: interface :: */ }
	// :: full java declaration :: String getDigest(osid.shared.Type algorithmType)

	  /**
	   * Returns the Digest algorithm types supported by the implementation, such as md5 or crc.
	   *
	   * @return osid.shared.TypeIterator the digest algorithm types supported by this implementation.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function &getDigestAlgorithmTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getDigestAlgorithmTypes()

	  /**
	   * Reads the data.
	   *
	   * @return osid.shared.ByteValueIterator
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function &read(& $version) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.ByteValueIterator read(java.util.Calendar version)

	  /**
	   * Writes b.length bytes to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function write(& $b) { /* :: interface :: */ }
	// :: full java declaration :: void write(byte[] b)

	  /**
	   * Writes <code>len</code> bytes from the specified byte array starting at
	   * offset <code>off</code> to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function writeBytesAtOffset(& $b, $off, $len) { /* :: interface :: */ }
	// :: full java declaration :: void writeBytesAtOffset(byte[] b, int off, int len)

	  /**
	   * Writes the specified byte to this ByteStore.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function writeByte($b) { /* :: interface :: */ }
	// :: full java declaration :: void writeByte(int b)

	  /**
	   * Closes this Output Object and releases any system resources
	   * associated with it.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
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
	   * @return java.util.Map of properties of this Cabinet and implementation
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function &getProperties() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Map getProperties()

	  /**
	   * Create a new ByteStore and add it to this Cabinet under the given
	   * name.
	   *
	   * The name must not include this Cabinet's separationCharacter.
	   *
	   * @param displayName  The name to be used
	   *
	   * @return  The ByteStore created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}
	 * @package osid.filing
	   */
	function &createByteStore($displayName) { /* :: interface :: */ }
	// :: full java declaration :: ByteStore createByteStore(String displayName)

	  /**
	   * Create a new Cabinet and add it to this Cabinet under the given
	   * name.
	   *
	   * The name must not include this Cabinet's separationCharacter.
	   *
	   * @param displayName  The name to be used
	   *
	   * @return  The Cabinet created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#NAME_CONTAINS_ILLEGAL_CHARS NAME_CONTAINS_ILLEGAL_CHARS}
	 * @package osid.filing
	   */
	function &createCabinet($displayName) { /* :: interface :: */ }
	// :: full java declaration :: Cabinet createCabinet(String displayName)

	  /**
	   * Copy an existing ByteStore in this Cabinet by copying contents and
	   * the appropriate attributes of another ByteStore.
	   *
	   * @param displayName
	   * @param oldByteStore
	   *
	   * @return ByteStore
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function &copyByteStore($displayName, & $oldByteStore) { /* :: interface :: */ }
	// :: full java declaration :: ByteStore copyByteStore(String displayName, ByteStore oldByteStore)

	  /**
	   * Add a CabinetEntry, it must be from same Manager.
	   *
	   *
	   * @param entry
	   * @param displayName
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#NAME_CONTAINS_ILLEGAL_CHARS NAME_CONTAINS_ILLEGAL_CHARS}, {@link FilingException#ITEM_ALREADY_EXISTS ITEM_ALREADY_EXISTS}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function add(& $entry, $displayName) { /* :: interface :: */ }
	// :: full java declaration :: void add(CabinetEntry entry, String displayName)

	  /**
	   * Remove a CabinetEntry. Does not destroy the CabinetEntry.
	   *
	   *
	   * @param entry
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function remove(& $entry) { /* :: interface :: */ }
	// :: full java declaration :: void remove(CabinetEntry entry)

	  /**
	   * Get a CabinetEntry from a Cabinet by its ID.
	   *
	   * @param id
	   *
	   * @return CabinetEntry which has given ID.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR},{@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
	 * @package osid.filing
	   */
	function &getCabinetEntryById(& $id) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntryById(osid.shared.Id id)

	  /**
	   * Get a CabinetEntry by name.  Not all CabinetEntrys have names,
	   * but if it has a name, the name is unique within a Cabinet.
	   *
	   * @param displayName
	   *
	   * @return CabinetEntry which has given name
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#DELETE_FAILED DELETE_FAILED}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function &getCabinetEntryByName($displayName) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntryByName(String displayName)

	  /**
	   * Get an Iterator over all CabinetEntries in this Cabinet.
	   *
	   * @return CabinetEntryIterator
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function &entries() { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntryIterator entries()

	  /**
	   * Return the root Cabinet of this Cabinet.
	   *
	   *
	   * @return root Cabinet
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function &getRootCabinet() { /* :: interface :: */ }
	// :: full java declaration :: Cabinet getRootCabinet()

	  /**
	   * Return true if this Cabinet is the root Cabinet.
	   *
	   *
	   * @return true if and only if this Cabinet is the root Cabinet.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function isRootCabinet() { /* :: interface :: */ }
	// :: full java declaration :: boolean isRootCabinet()

	  /**
	   * Return true if this Cabinet can list its entries.
	   *
	   *
	   * @return true if and only if this Cabinet can list its entries.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function isListable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isListable()

	  /**
	   * Return true if this Cabinet allows entries to be added or removed.
	   *
	   *
	   * @return true if and only if this Cabinet allows entries to be added or removed.
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function isManageable() { /* :: interface :: */ }
	// :: full java declaration :: boolean isManageable()

	  /**
	   * Get space available in Cabinet, for bytes.
	   *
	   * @return long Space available in this Cabinet, in bytes.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function getAvailableBytes() { /* :: interface :: */ }
	// :: full java declaration :: long getAvailableBytes()

	  /**
	   * Get number of bytes used in this Cabinet.
	   *
	   * @return long Space used in this Cabinet, in bytes.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
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
	   * @return Cabinet the parent Cabinet of this entry, or null if it has
	   * no parent (e.g. is the root Cabinet)
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}
	 * @package osid.filing
	   */
	function &getParent() { /* :: interface :: */ }
	// :: full java declaration :: Cabinet getParent()

	  /**
	   * Return the name of this CabinetEntry in its parent Cabinet.
	   *
	   * @return name
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	  /**
	   * Get Id of this CabinetEntry
	   *
	   * @return Id
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
	   */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	  /**
	   * Returns when this Cabinet was last modified.
	   *
	   * @return  java.util.Calendar The time this cabinet was last modified
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	  */
	function &getLastModifiedTime() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getLastModifiedTime()

	  /**
	   * Returns all the times that this Cabinet was modified.
	   *
	   * @return  osid.shared.CalendarInterator The times this cabinet was modified
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	  */
	function &getAllModifiedTimes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.CalendarIterator getAllModifiedTimes()

	  /**
	   * Sets the last-modified time to the current time for this CabinetEntry.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
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
	   * @return  java.util.Calendar The time the file was last accessed.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
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
	   * @return java.util.Calendar The time the file was created
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function &getCreatedTime() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getCreatedTime()

	  /**
	   * Return the Agent that owns this CabinetEntry.
	   *
	   * @return osid.shared.Agent
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.filing
	   */
	function &getCabinetEntryAgent() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Agent getCabinetEntryAgent()

	  /**
	   * Change the name of this entry to <code>displayName</code>
	   *
	   * @param displayName the new name for the entry
	   *
	   * @throws osid.filing.FilingException
	 * @package osid.filing
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
	   * @return CabinetEntryIterator
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}
	 * @package osid.filing
	   */
	function &listRoots() { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntryIterator listRoots()

	  /**
	   * Get a CabinetEntry by ID.
	   *
	   * @param id
	   *
	   * @return CabinetEntry with a given ID
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
	 * @package osid.filing
	   */
	function &getCabinetEntry(& $id) { /* :: interface :: */ }
	// :: full java declaration :: CabinetEntry getCabinetEntry(osid.shared.Id id)

	  /**
	   * Deletes this CabinetEntry.
	   *
	   * If the CabinetEntry is a Cabinet it must be empty, and the Owner of
	   * the Manager must have sufficient permissions to perform this action.
	   *
	   * @param cabinetEntryId id is the CabinetEntry's id.
	   *
	   * @throws osid.filing.FilingException An exception with one of the following messages defined in osid.filing.FilingException may be thrown: {@link FilingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link FilingException#IO_ERROR IO_ERROR}, {@link FilingException#DELETE_FAILED DELETE_FAILED}, {@link FilingException#CABINET_NOT_EMPTY CABINET_NOT_EMPTY}, {@link FilingException#ITEM_DOES_NOT_EXIST ITEM_DOES_NOT_EXIST}
	 * @package osid.filing
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
	    * @return boolean
	    *
	    * @throws osid.filing.FilingException
	 * @package osid.filing
	    */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	    /**
	    *    Returns the next CabinetEntry in the collection.
	    *
	    *    @return CabinetEntry
	    *
	    * @throws osid.filing.FilingException
	 * @package osid.filing
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
 * @const string ITEM_ALREADY_EXISTS public final static String ITEM_ALREADY_EXISTS = "Selected item already exists";
 * @package osid.filing
 */
define("ITEM_ALREADY_EXISTS", "Selected item already exists";);

/**
 * @const string ITEM_DOES_NOT_EXIST public final static String ITEM_DOES_NOT_EXIST = "Selected item does not exist";
 * @package osid.filing
 */
define("ITEM_DOES_NOT_EXIST", "Selected item does not exist";);

/**
 * @const string UNSUPPORTED_OPERATION public final static String UNSUPPORTED_OPERATION = "Unsupported operation";
 * @package osid.filing
 */
define("UNSUPPORTED_OPERATION", "Unsupported operation";);

/**
 * @const string IO_ERROR public final static String IO_ERROR = "IO error";
 * @package osid.filing
 */
define("IO_ERROR", "IO error";);

/**
 * @const string UNSUPPORTED_TYPE public final static String UNSUPPORTED_TYPE = "Unsupported CabinetEntry Type";
 * @package osid.filing
 */
define("UNSUPPORTED_TYPE", "Unsupported CabinetEntry Type";);

/**
 * @const string CABINET_NOT_EMPTY public final static String CABINET_NOT_EMPTY = "Cabinet is not empty";
 * @package osid.filing
 */
define("CABINET_NOT_EMPTY", "Cabinet is not empty";);

/**
 * @const string NOT_A_CABINET public final static String NOT_A_CABINET = "Object is not a Cabinet";
 * @package osid.filing
 */
define("NOT_A_CABINET", "Object is not a Cabinet";);

/**
 * @const string NOT_A_BYTESTORE public final static String NOT_A_BYTESTORE = "Object is not a ByteStore";
 * @package osid.filing
 */
define("NOT_A_BYTESTORE", "Object is not a ByteStore";);

/**
 * @const string NAME_CONTAINS_ILLEGAL_CHARS public final static String NAME_CONTAINS_ILLEGAL_CHARS = "Name contains illegal characters";
 * @package osid.filing
 */
define("NAME_CONTAINS_ILLEGAL_CHARS", "Name contains illegal characters";);

/**
 * @const string NULL_OWNER public final static String NULL_OWNER = "Owner is null";
 * @package osid.filing
 */
define("NULL_OWNER", "Owner is null";);

/**
 * @const string DELETE_FAILED public final static String DELETE_FAILED = "Delete failed";
 * @package osid.filing
 */
define("DELETE_FAILED", "Delete failed";);

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed"
 * @package osid.filing
 */
define("OPERATION_FAILED", "Operation failed");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements"
 * @package osid.filing
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.filing
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied"
 * @package osid.filing
 */
define("PERMISSION_DENIED", "Permission denied");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument"
 * @package osid.filing
 */
define("NULL_ARGUMENT", "Null argument");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error"
 * @package osid.filing
 */
define("CONFIGURATION_ERROR", "Configuration error");

/**
 * @const string CANNOT_DELETE_ROOT_CABINET public static final String CANNOT_DELETE_ROOT_CABINET = "Cannot delete root Cabinet"
 * @package osid.filing
 */
define("CANNOT_DELETE_ROOT_CABINET", "Cannot delete root Cabinet");

?>
