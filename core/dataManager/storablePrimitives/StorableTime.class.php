<?php

/**
 * This is the {@link StorablePrimitive} equivalent of {@link Time}.
 *
 * @package harmoni.datamanager.storableprimitives
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableTime.class.php,v 1.21 2007/10/10 22:58:36 adamfranco Exp $
 */
class StorableTime 
	extends DateAndTime
	implements StorablePrimitive
{
	
	var $_table;

/*********************************************************
 * Class Methods
 *********************************************************/
	
	/**
	 * Takes a single database row, which would contain the columns added by alterQuery()
	 * and extracts the values to setup the object with the appropriate data.
	 *
	 * All times are stored in the database as UTC.
	 *
	 * @param array $dbRow
	 * @access public
	 * @return object StorableTime
	 * @static
	 */
	static function createAndPopulate( $dbRow ) {
		$date = StorableTime::withJulianDayNumber($dbRow["time_jdn"]);
		$timeComponent = Duration::withSeconds($dbRow["time_seconds"]);
		$date =$date->plus($timeComponent);
		
		// The date in the DB was UTC, so be sure to set the offset to zero here.
		$date =$date->withOffset(Duration::zero());
		
		// Convert the time to the local offset, maintain equivalent time to the 
		// UTC version
		return $date->asLocal();
	}
	
	/**
	 * Returns a string that could be inserted into an SQL query's WHERE clause, based on the
	 * {@link Primitive} value that is passed. It is used when searching for datasets that contain a certain
	 * field=value pair.
	 * @param ref object $value The {@link Primitive} object to search for.
	 * @param int $searchType One of the SEARCH_TYPE_* constants, defining what type of search this should be (ie, equals, 
	 * contains, greater than, less than, etc)
	 * @return string or NULL if no searching is allowed.
	 * @static
	 */
	static function makeSearchString($value, $searchType = SEARCH_TYPE_EQUALS) {
		// Convert to UTC
		$utc =$this->asUTC();
		$utcTime =$utc->asTime();
		$jdn = $utc->julianDayNumber();
		$seconds = $utcTime->asSeconds();
		
		switch ($searchType) {
			case SEARCH_TYPE_EQUALS:
				return "(dm_time.jdn=$jdn AND dm_time.seconds=$seconds)";
			case SEARCH_TYPE_GREATER_THAN:
				return "(dm_time.jdn<$jdn OR (dm_time.jdn=$jdn AND dm_time.seconds<$seconds))";
			case SEARCH_TYPE_LESS_THAN:
				return "(dm_time.jdn>$jdn OR (dm_time.jdn=$jdn AND dm_time.seconds>$seconds))";
			case SEARCH_TYPE_GREATER_THAN_OR_EQUALS:
				return "(dm_time.jdn>$jdn OR (dm_time.jdn=$jdn AND dm_time.seconds>=$seconds))";
			case SEARCH_TYPE_LESS_THAN_OR_EQUALS:
				return "(dm_time.jdn<$jdn OR (dm_time.jdn=$jdn AND dm_time.seconds<=$seconds))";
			case SEARCH_TYPE_IN_LIST:
				$string = "(";
				while ($value->hasNext()) {
					$valueObj =$value->next();
					$string .= "(dm_time.jdn=$jdn AND dm_time.seconds=$seconds)";
					if ($value->hasNext())
						$string .= " OR ";
				}
				$string .= ")";
				return $string;
			case SEARCH_TYPE_NOT_IN_LIST:
				$string = "NOT (";
				while ($value->hasNext()) {
					$valueObj =$value->next();
					$string .= "(dm_time.jdn=$jdn AND dm_time.seconds=$seconds)";
					if ($value->hasNext())
						$string .= " OR ";
				}
				$string .= ")";
				return $string;
		}
		return null;
	}
	
/*********************************************************
 * Class Methods - Instance Creation
 *
 * All static instance creation methods have an optional
 * $class parameter which is used to get around the limitations 
 * of not being	able to find the class of the object that 
 * recieved the initial method call rather than the one in
 * which it is implemented. These parameters SHOULD NOT BE
 * USED OUTSIDE OF THIS PACKAGE.
 *********************************************************/
 	
 	/**
 	 * Answer a StorableTime representing now
 	 * 
 	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
 	 * @access public
 	 * @since 5/13/05
 	 */
 	function current ( $class = 'StorableTime' ) {
 		eval('$result = '.$class.'::now();');
 		return $result;
 	}
	
	/**
	 * Answer a StorableTime representing the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	static function epoch ( $class = 'StorableTime' ) {
		return parent::epoch($class);
	}
	
	/**
	 * Answer a new instance represented by a string:
	 * 
	 *	- '-1199-01-05T20:33:14.321-05:00' 
	 *	- ' 2002-05-16T17:20:45.00000001+01:01' 
  	 *	- ' 2002-05-16T17:20:45.00000001' 
 	 *	- ' 2002-05-16T17:20' 
	 *	- ' 2002-05-16T17:20:45' 
	 *	- ' 2002-05-16T17:20:45+01:57' 
 	 *	- ' 2002-05-16T17:20:45-02:34' 
 	 *	- ' 2002-05-16T17:20:45+00:00' 
	 *	- ' 1997-04-26T01:02:03+01:02:3'  
	 *
	 * @param string $aString The input string.
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function fromString ( $aString, $class = 'StorableTime' ) {
		return parent::fromString( $aString, $class);
	}
	
	/**
	 * Create a new TimeStamp from a UNIX timestamp.
	 * 
	 * @param integer $aUnixTimeStamp The number of seconds since the Unix Epoch 
	 *		(January 1 1970 00:00:00 GMT/UTC)
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Timestamp
	 * @access public
	 * @since 5/27/05
	 */
	function fromUnixTimeStamp ( $aUnixTimeStamp, $class = 'StorableTime' ) {
		$sinceUnixEpoch = Duration::withSeconds($aUnixTimeStamp);
		
		eval('$unixEpoch = '.$class.'::withYearMonthDayHourMinuteSecondOffset(
						1970, 1, 1, 0, 0, 0, Duration::zero());');
		return $unixEpoch->plus($sinceUnixEpoch);
	}
	
	/**
	 * Answer a new instance starting at midnight local time.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	static function midnight ( $class = 'StorableTime' ) {
		return parent::midnight( $class );
	}
	
	/**
	 * Answer the current time.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function now ( $class = 'StorableTime' ) {
		return parent::now( $class );
	}
	
	/**
	 * Answer a new instance starting at noon local time.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	static function noon ( $class = 'StorableTime' ) {
		return parent::noon( $class );
	}
	
	/**
	 * Answer a new instance representing today
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function today ( $class = 'StorableTime' ) {
		return parent::today( $class );
	}
	
	/**
	 * Answer a new instance representing tomorow
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function tomorrow ( $class = 'StorableTime' ) {
		return parent::tomorrow( $class );
	}
	
	/**
	 * Create a new instance from Date and Time objects
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function withDateAndTime ( $aDate, $aTime, $class = 'StorableTime' ) {
		return parent::withDateAndTime( $aDate, $aTime, $class );
	}
	
	/**
	 * Create a new instance for a given Julian Day Number.
	 * 
	 * @param integer $aJulianDayNumber
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	static function withJulianDayNumber ( $aJulianDayNumber, $class = 'StorableTime' ) {
		return parent::withJulianDayNumber($aJulianDayNumber, $class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearDay ( $anIntYear, $anIntDayOfYear, $class = 'StorableTime') {
		return parent::withYearDay ( $anIntYear, $anIntDayOfYear, $class );
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearDayHourMinuteSecond ( $anIntYear, $anIntDayOfYear, 
		$anIntHour, $anIntMinute, $anIntSecond, $class = 'StorableTime' ) 
	{
		return parent::withYearDayHourMinuteSecond ( $anIntYear, $anIntDayOfYear, 
			$anIntHour, $anIntMinute, $anIntSecond, $class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearDayHourMinuteSecondOffset ( $anIntYear, $anIntDayOfYear, 
		$anIntHour, $anIntMinute, $anIntSecond, $aDurationOffset, $class = 'StorableTime' ) 
	{
		return parent::withYearDayHourMinuteSecondOffset ( $anIntYear, $anIntDayOfYear, 
			$anIntHour, $anIntMinute, $anIntSecond, $aDurationOffset, $class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @access public
	 * @return object StorableTime
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, 
		$class = 'StorableTime' ) 
	{
		return parent::withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, 
			$class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearMonthDayHourMinute ( $anIntYear, $anIntOrStringMonth, 
		$anIntDay, $anIntHour, $anIntMinute, $class = 'StorableTime' ) 
	{
		return parent::withYearMonthDayHourMinute ( $anIntYear, $anIntOrStringMonth, 
			$anIntDay, $anIntHour, $anIntMinute, $class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearMonthDayHourMinuteSecond ( $anIntYear, $anIntOrStringMonth, 
		$anIntDay, $anIntHour, $anIntMinute, $anIntSecond, $class = 'StorableTime' ) 
	{
		return parent::withYearMonthDayHourMinuteSecond ( $anIntYear, $anIntOrStringMonth, 
			$anIntDay, $anIntHour, $anIntMinute, $anIntSecond, $class);
	}
	
	/**
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	static function withYearMonthDayHourMinuteSecondOffset ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay, $anIntHour, $anIntMinute, 
		$anIntSecond, $aDurationOffset, $class = 'StorableTime'  ) 
	{
		return parent::withYearMonthDayHourMinuteSecondOffset ( $anIntYear, 
			$anIntOrStringMonth, $anIntDay, $anIntHour, $anIntMinute, 
			$anIntSecond, $aDurationOffset, $class);
	}
	
	/**
	 * Answer a new instance representing yesterday
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object StorableTime
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	static function yesterday ( $class = 'StorableTime' ) {
		return parent::yesterday($class);
	}
	
	/**
	 * Takes an existing {@link SelectQuery} and adds a table join and some columns so that
	 * when it is executed the actual data can be retrieved from the row. The join condition must
	 * be "fk_data = data_id_field", since the field "fk_data" is already part of the DataManager's
	 * table structure.
	 * @access public
	 * @return void
	 * @static
	 */
	static function alterQuery( $query ) {
		$query->addTable("dm_time",LEFT_JOIN,"dm_time.id = fk_data");
		$query->addColumn("jdn","time_jdn","dm_time");
		$query->addColumn("seconds","time_seconds","dm_time");
	}
	
/*********************************************************
 * Instance Methods
 *********************************************************/
	
	/**
	 * Inserts a new row into the Database with the data contained in the object.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @access public
	 * @return integer Returns the new ID of the data stored.
	 */
	function insert($dbID) {
		$idManager = Services::getService("Id");
		$newID =$idManager->createId();
		
		$query = new InsertQuery();
		$query->setTable("dm_time");
		$query->setColumns(array("id","jdn", "seconds"));
		$dbHandler = Services::getService("DatabaseManager");
		
		// Convert to UTC for storage
		$utc =$this->asUTC();
		$utcTime =$utc->asTime();
		
		$query->addRowOfValues(array(
			"'".addslashes($newID->getIdString())."'",
			"'".addslashes($utc->julianDayNumber())."'",
			"'".addslashes($utcTime->asSeconds())."'"));
		
		$result =$dbHandler->query($query, $dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("StorableTime") );
			return false;
		}
		
		return $newID->getIdString();
	}
	
	/**
	 * Uses the ID passed and updates the database row with
	 * new data.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @param integer $dataID The ID in the database of the data to be updated.
	 * @access public
	 * @return void
	 */
	function update($dbID, $dataID) {
		if (!$dataID) return false;
		
		$query = new UpdateQuery();
		$query->setTable("dm_time");
		$query->setColumns(array("jdn", "seconds"));
		$query->setWhere("id='".addslashes($dataID)."'");
		
		// Convert to UTC for storage
		$utc =$this->asUTC();
		$utcTime =$utc->asTime();
		
		$query->setValues(array(
			"'".addslashes($utc->julianDayNumber())."'",
			"'".addslashes($utcTime->asSeconds())."'"));
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query, $dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("StorableTime") );
			return false;
		}
		return true;
	}
	
	/**
	 * Deletes the data row from the appropriate table.
	 * @param integer $dbID The {@link DBHandler} database ID to query.
	 * @param integer $dataID The ID in the database of the data to be deleted.
	 * @access public
	 * @return void
	 */
	function prune($dbID, $dataID) {
		if (!$dataID) return;
		// delete ourselves from our data table
		
		$query = new DeleteQuery;
		$query->setTable("dm_time");
		$query->setWhere("id='".addslashes($dataID)."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		$res =$dbHandler->query($query, $dbID);
		
		if (!$res) throwError( new UnknownDBError("StorablePrimitive"));
	}
	

	
/*********************************************************
 * Conversion Methods
 *********************************************************/
	
	/**
	 * Convert this object to a StorableBlob
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asABlob () {
		return Blob::fromString($this->asString());
	}
	
	/**
	 * Convert this object to a StorableString
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAString () {
		return HarmoniString::fromString($this->asString());
	}
	
	/**
	 * Convert this object to a StorableShortString
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAShortString () {
		return HarmoniString::fromString($this->asString());
	}
	
	/**
	 * Convert this object to a StorableTime
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asADateTime () {
		return $this;
	}
	
	/**
	 * Convert this object to a StorableInteger
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAInteger() {
		$tstamp =$this->asTimestamp();
		return Integer::withValue($tstamp->asUnixTimeStamp());
	}
	
	/**
	 * Convert this object to a StorableFloat
	 * 
	 * @return object
	 * @access public
	 * @since 6/9/06
	 */
	function asAFloat () {
		$tstamp =$this->asTimestamp();
		return HarmoniFloat::withValue($tstamp->asUnixTimeStamp());
	}
}