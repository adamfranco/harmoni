<?php


	/**
	 * A Blob is a variable length representation of binary (byte) values.  (Blob stands for <u>B</u>inary <u>L</u>arge <u>Ob</u>ject.)  The contents of a Blob are returned in a ByteValueIterator by the getBytes() method.  Its length is returned by the method length().
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class Blob // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Method getBytes
	   *
	   * @param pos
	   * @param len
	   *
	   * @return osid.shared.ByteValueIterator
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#BLOB_GETBYTES_FAILED}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getBytes($pos, $len) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.ByteValueIterator getBytes(long pos, int len)

	  /**
	   * return the length of the object
	   *
	   * @return Blob length
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function length() { /* :: interface :: */ }
	// :: full java declaration :: long length()
}


	/**
	 * A Clob is a variable length representation of character values.  (Clob stands for <u>C</u>haracter <u>L</u>arge <u>Ob</u>ject.)  The contents of a Clob are returned in a CharValueIterator by the getChars() method.  Its length is returned by the method length().
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class Clob // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Method getChars
	   *
	   * @param pos
	   * @param len
	   *
	   * @return osid.shared.CharValueIterator
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#CLOB_GETCHARS_FAILED}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getChars($pos, $len) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.CharValueIterator getChars(long pos, int len)

	  /**
	   * return the length of the object
	   *
	   * @return Clob length
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function length() { /* :: interface :: */ }
	// :: full java declaration :: long length()
}


	/**
	 * ResultMetaData contains information about a specific column in the ResultTable.  You may retrieve the ResultMetaData for each column by calling the ResultTable method getResultMetaData().
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class ResultMetaData // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * return the column index.  Columns are numbered beginning with one.
	   *
	   * @return column index
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function getColumnIndex() { /* :: interface :: */ }
	// :: full java declaration :: int getColumnIndex()

	  /**
	   * Method getColumnName
	   *
	   * @return column name
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function getColumnName() { /* :: interface :: */ }
	// :: full java declaration :: String getColumnName()

	  /**
	   * The SQL data type of this column is an instance of osid.shared.Type.  It represents one of the data types supported by the implementation.
	   *
	   * @return column type
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getColumnType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getColumnType()

	  /**
	   * return whether this column allows nulls
	   *
	   * @return true if column permits nulls
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function areNullsAllowed() { /* :: interface :: */ }
	// :: full java declaration :: boolean areNullsAllowed()
}


	/**
	 * The Connection represents the channel of communication with the database.  It is the means of submitting a query or update for execution.  A ResultTable is returned by the executeQuery() methods.  The executeUpdate() methods are used to execute commands that do not return resultsets such as inserts, deletes, and other data management commands.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class Connection // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * execute the SQL statement
	   *
	   * @param sql The SQL statement to execute
	   *
	   * @return table
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &executeQuery($sql) { /* :: interface :: */ }
	// :: full java declaration :: ResultTable executeQuery(String sql)

	  /**
	   * execute the SQL statement
	   *
	   * @param sql The SQL statement to execute
	   * @param objs
	   * @param sqlTypes
	   * @param scales
	   *
	   * @return table
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
//	 :: this function hidden due to previous declaration
//	function &executeQuery($sql, & $objs, & $sqlTypes, & $scales) { /* :: interface :: */ }
//	 :: end
	// :: full java declaration :: ResultTable executeQuery(String sql, Object[] objs, osid.shared.Type[] sqlTypes, int[] scales)

	  /**
	   * Method executeUpdate
	   *
	   * @param sql The SQL statement to execute
	   *
	   * @return integer as a result of an update
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function executeUpdate($sql) { /* :: interface :: */ }
	// :: full java declaration :: int executeUpdate(String sql)

	  /**
	   * Method executeUpdate
	   *
	   * @param sql The SQL statement to execute
	   * @param objs
	   * @param sqlTypes
	   * @param scales
	   *
	   * @return integer as a result of an update
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
//	 :: this function hidden due to previous declaration
//	function executeUpdate($sql, & $objs, & $sqlTypes, & $scales) { /* :: interface :: */ }
//	 :: end
	// :: full java declaration :: int executeUpdate(String sql, Object[] objs, osid.shared.Type[] sqlTypes, int[] scales)

	  /**
	   * return the SQL data types supported by this implementation
	   *
	   * @return TypeIterator containing the valid SQL data types
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getSqlTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getSqlTypes()
}


	/**
	 * RowIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class RowIterator // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Return <code>true</code> if there are additional  Rows; <code>false</code> otherwise.
	   *
	   * @return true if more rows are available
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	  /**
	   * Method next
	   *
	   * @return Row
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Row next()
}


	/**
	 * ResultMetaDataIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class ResultMetaDataIterator // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Return <code>true</code> if there are additional  ResultMetaData; <code>false</code> otherwise.
	   *
	   * @return true if more ResultMetaData are available
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	  /**
	   * Method next
	   *
	   * @return ResultMetaData
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: ResultMetaData next()
}


	/**
	<p>The SqlManager provides a means to retrieve a connection to the database. </p>
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class SqlManager // :: interface
	extends OsidManager
{

	  /**
	   * Method getConnection
	   *
	   * @param connectionString
	   *
	   * @return Connection
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getConnection($connectionString) { /* :: interface :: */ }
	// :: full java declaration :: public Connection getConnection( String connectionString)
}


	/**
	 * A Row contains the row contents from a ResultTable.  Its methods provide access to the data returned in a ResultTable.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class Row // :: interface
//	extends java.io.Serializable
{

	  /**
	 *     retrieve data from the column specified by index
	 *     @param columnIndex
	 *     @return Object
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#INVALID_COLUMN_INDEX}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getColumnByIndex($columnIndex) { /* :: interface :: */ }
	// :: full java declaration :: public Object getColumnByIndex( int columnIndex )

	  /**
	 *     retrieve data from the column specified by name
	 *     @param columnName
	 *     @return Object
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:   {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getColumnByName($columnName) { /* :: interface :: */ }
	// :: full java declaration :: public Object getColumnByName( String columnName )

	  /**
	 *    Method getColumns
	 *    @return osid.shared.ObjectIterator
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:   {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.sql
	   */
	function &getColumns() { /* :: interface :: */ }
	// :: full java declaration :: public osid.shared.ObjectIterator getColumns()
}


	/**
	 * A ResultTable is tabular data returned by a query.  You access the returned data by calling the method getRows() which returns a RowIterator.
	<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. <p>SID Version: 1.0 rc6
	 * @package osid.sql
	 */
class ResultTable // :: API interface
//	extends java.io.Serializable
{

	  /**
	   * Method getColumnCount
	   *
	   * @return number of columns
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function getColumnCount() { /* :: interface :: */ }
	// :: full java declaration :: int getColumnCount()

	  /**
	   * Method getResultMetaData
	   *
	   * @return metadata for Rows
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function &getResultMetaData() { /* :: interface :: */ }
	// :: full java declaration :: ResultMetaDataIterator getResultMetaData()

	  /**
	   * Method getRows
	   *
	   * @return Rows object
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
	 * @package osid.sql
	   */
	function &getRows() { /* :: interface :: */ }
	// :: full java declaration :: RowIterator getRows()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	 * @package osid.sql
	 */
class SqlException // :: normal class
	extends OsidException
{

	  /**
	 *     Blob get bytes failed
	 * @package osid.sql
	  */
	// :: defined globally :: define("BLOB_GETBYTES_FAILED","Blob get bytes failed ";);

	  /**
	 *     Clob get chars failed
	 * @package osid.sql
	  */
	// :: defined globally :: define("CLOB_GETCHARS_FAILED","Clob get chars failed ";);

	  /**
	 *     Connection failed
	 * @package osid.sql
	  */
	// :: defined globally :: define("CONNECTION_FAILED","Connection failed ";);

	  /**
	 *     Invalid arguments
	 * @package osid.sql
	  */
	// :: defined globally :: define("INVALID_ARGUMENTS","Invalid arguments ";);

	  /**
	 *     Invalid column index.  Note that column numbering begins with one, not zero.
	 * @package osid.sql
	  */
	// :: defined globally :: define("INVALID_COLUMN_INDEX","Invalid column index ";);

	  /**
	 *     Data retrieval error
	 * @package osid.sql
	  */
	// :: defined globally :: define("DATA_RETRIEVAL_ERROR","Data retrieval error ";);

	  /**
	 *     Unknown or unsupported Type
	 * @package osid.sql
	  */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown or unsupported Type ");

	  /**
	 *     Operation failed
	 * @package osid.sql
	   */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	  /**
	 *     Iterator has no more elements
	 * @package osid.sql
	   */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	  /**
	 *     Null argument
	 * @package osid.sql
	   */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	  /**
	 *     Permission denied
	 * @package osid.sql
	   */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	  /**
	 *     Unimplemented method
	 * @package osid.sql
	   */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	  /**
	 *     Configuration error
	 * @package osid.sql
	   */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");
}

// :: post-declaration code ::
/**
 * @const string BLOB_GETBYTES_FAILED public static final String BLOB_GETBYTES_FAILED = "Blob get bytes failed ";
 * @package osid.sql
 */
define("BLOB_GETBYTES_FAILED", "Blob get bytes failed ";);

/**
 * @const string CLOB_GETCHARS_FAILED public static final String CLOB_GETCHARS_FAILED = "Clob get chars failed ";
 * @package osid.sql
 */
define("CLOB_GETCHARS_FAILED", "Clob get chars failed ";);

/**
 * @const string CONNECTION_FAILED public static final String CONNECTION_FAILED = "Connection failed ";
 * @package osid.sql
 */
define("CONNECTION_FAILED", "Connection failed ";);

/**
 * @const string INVALID_ARGUMENTS public static final String INVALID_ARGUMENTS = "Invalid arguments ";
 * @package osid.sql
 */
define("INVALID_ARGUMENTS", "Invalid arguments ";);

/**
 * @const string INVALID_COLUMN_INDEX public static final String INVALID_COLUMN_INDEX = "Invalid column index ";
 * @package osid.sql
 */
define("INVALID_COLUMN_INDEX", "Invalid column index ";);

/**
 * @const string DATA_RETRIEVAL_ERROR public static final String DATA_RETRIEVAL_ERROR = "Data retrieval error ";
 * @package osid.sql
 */
define("DATA_RETRIEVAL_ERROR", "Data retrieval error ";);

/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown or unsupported Type "
 * @package osid.sql
 */
define("UNKNOWN_TYPE", "Unknown or unsupported Type ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.sql
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.sql
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.sql
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.sql
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.sql
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.sql
 */
define("CONFIGURATION_ERROR", "Configuration error ");

?>
