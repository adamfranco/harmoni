<?php
/**
 * @package osid.sql
 */

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
	   * @param object pos
	   * @param object len
	   *
	   * @return object osid.shared.ByteValueIterator
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#BLOB_GETBYTES_FAILED}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getBytes($pos, $len) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.ByteValueIterator getBytes(long pos, int len)

	  /**
	   * return the length of the object
	   *
	   * @return object Blob length
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	   * @param object pos
	   * @param object len
	   *
	   * @return object osid.shared.CharValueIterator
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#CLOB_GETCHARS_FAILED}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getChars($pos, $len) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.CharValueIterator getChars(long pos, int len)

	  /**
	   * return the length of the object
	   *
	   * @return object Clob length
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	   * @return object column index
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function getColumnIndex() { /* :: interface :: */ }
	// :: full java declaration :: int getColumnIndex()

	  /**
	   * Method getColumnName
	   *
	   * @return object column name
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function getColumnName() { /* :: interface :: */ }
	// :: full java declaration :: String getColumnName()

	  /**
	   * The SQL data type of this column is an instance of osid.shared.Type.  It represents one of the data types supported by the implementation.
	   *
	   * @return object column type
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getColumnType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getColumnType()

	  /**
	   * return whether this column allows nulls
	   *
	   * @return object true if column permits nulls
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	   * @param object sql The SQL statement to execute
	   *
	   * @return object table
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &executeQuery($sql) { /* :: interface :: */ }
	// :: full java declaration :: ResultTable executeQuery(String sql)

	  /**
	   * execute the SQL statement
	   *
	   * @param object sql The SQL statement to execute
	   * @param object objs
	   * @param object sqlTypes
	   * @param object scales
	   *
	   * @return object table
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   */
//	 :: this function hidden due to previous declaration
//	function &executeQuery($sql, & $objs, & $sqlTypes, & $scales) { /* :: interface :: */ }
//	 :: end
	// :: full java declaration :: ResultTable executeQuery(String sql, Object[] objs, osid.shared.Type[] sqlTypes, int[] scales)

	  /**
	   * Method executeUpdate
	   *
	   * @param object sql The SQL statement to execute
	   *
	   * @return object integer as a result of an update
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function executeUpdate($sql) { /* :: interface :: */ }
	// :: full java declaration :: int executeUpdate(String sql)

	  /**
	   * Method executeUpdate
	   *
	   * @param object sql The SQL statement to execute
	   * @param object objs
	   * @param object sqlTypes
	   * @param object scales
	   *
	   * @return object integer as a result of an update
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   */
//	 :: this function hidden due to previous declaration
//	function executeUpdate($sql, & $objs, & $sqlTypes, & $scales) { /* :: interface :: */ }
//	 :: end
	// :: full java declaration :: int executeUpdate(String sql, Object[] objs, osid.shared.Type[] sqlTypes, int[] scales)

	  /**
	   * return the SQL data types supported by this implementation
	   *
	   * @return object TypeIterator containing the valid SQL data types
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	   * @return object true if more rows are available
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
		   */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	  /**
	   * Method next
	   *
	   * @return object Row
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
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
	   * @return object true if more ResultMetaData are available
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
		   */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	  /**
	   * Method next
	   *
	   * @return object ResultMetaData
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
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
	   * @param object connectionString
	   *
	   * @return object Connection
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	 *     @param integer columnIndex
	 *     @return Object
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#INVALID_COLUMN_INDEX}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getColumnByIndex($columnIndex) { /* :: interface :: */ }
	// :: full java declaration :: public Object getColumnByIndex( int columnIndex )

	  /**
	 *     retrieve data from the column specified by name
	 *     @param string columnName
	 *     @return Object
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:   {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
		   */
	function &getColumnByName($columnName) { /* :: interface :: */ }
	// :: full java declaration :: public Object getColumnByName( String columnName )

	  /**
	 *    Method getColumns
	 *    @return osid.shared.ObjectIterator
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:   {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
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
	   * @return object number of columns
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
		   */
	function getColumnCount() { /* :: interface :: */ }
	// :: full java declaration :: int getColumnCount()

	  /**
	   * Method getResultMetaData
	   *
	   * @return object metadata for Rows
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
		   */
	function &getResultMetaData() { /* :: interface :: */ }
	// :: full java declaration :: ResultMetaDataIterator getResultMetaData()

	  /**
	   * Method getRows
	   *
	   * @return object Rows object
	   *
	 *    @throws osid.sql.SqlException An exception with one of the following messages defined in osid.sql.SqlException:  {@link SqlException#DATA_RETRIEVAL_ERROR}, {@link SqlException#OPERATION_FAILED OPERATION_FAILED}, {@link SqlException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SqlException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SqlException#UNIMPLEMENTED UNIMPLEMENTED}
	   *
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
 * string: Blob get bytes failed 
 * @name BLOB_GETBYTES_FAILED;
 */
define("BLOB_GETBYTES_FAILED", "Blob get bytes failed ";);

/**
 * string: Clob get chars failed 
 * @name CLOB_GETCHARS_FAILED;
 */
define("CLOB_GETCHARS_FAILED", "Clob get chars failed ";);

/**
 * string: Connection failed 
 * @name CONNECTION_FAILED;
 */
define("CONNECTION_FAILED", "Connection failed ";);

/**
 * string: Invalid arguments 
 * @name INVALID_ARGUMENTS;
 */
define("INVALID_ARGUMENTS", "Invalid arguments ";);

/**
 * string: Invalid column index 
 * @name INVALID_COLUMN_INDEX;
 */
define("INVALID_COLUMN_INDEX", "Invalid column index ";);

/**
 * string: Data retrieval error 
 * @name DATA_RETRIEVAL_ERROR;
 */
define("DATA_RETRIEVAL_ERROR", "Data retrieval error ";);

/**
 * string: Unknown or unsupported Type 
 * @name UNKNOWN_TYPE
 */
define("UNKNOWN_TYPE", "Unknown or unsupported Type ");

/**
 * string: Operation failed 
 * @name OPERATION_FAILED
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * string: Iterator has no more elements 
 * @name NO_MORE_ITERATOR_ELEMENTS
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * string: Null argument 
 * @name NULL_ARGUMENT
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * string: Permission denied 
 * @name PERMISSION_DENIED
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * string: Unimplemented method 
 * @name UNIMPLEMENTED
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * string: Configuration error 
 * @name CONFIGURATION_ERROR
 */
define("CONFIGURATION_ERROR", "Configuration error ");

?>
