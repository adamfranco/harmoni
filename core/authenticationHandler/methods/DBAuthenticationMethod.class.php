<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/DBMethodOptions.class.php");

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: DBAuthenticationMethod.class.php,v 1.2 2003/08/23 23:56:20 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authentication.database
 **/
 
class DBAuthenticationMethod
	extends AuthenticationMethod 
{
	/**
	 * The options passed to us by the user.
	 * @access private
	 * @var object DBMethodOptions $_opt
	 **/
	var $_opt;
	
	/**
	 * The DBHandler we will use for DB connectivity.
	 * @access private
	 * @var object DBHandler $_DBHandler
	 **/
	var $_DBHandler;
	
	/**
	 * The connection ID for our DB connection.
	 * @access private
	 * @var int $_id
	 **/
	var $_id;
	
	/**
	 * Are we connected?
	 * @access private
	 * @var boolean $_connected
	 **/
	var $_connected = false;	

	/**
	 * the constructor
	 *
	 * @param ref object DBMethodOptions $options a FieldSet object with all the necessary options for this module
	 * @access public
	 * @return void
	 **/
	function DBAuthenticationMethod ( & $options ) {
		// store the options
		$options->checkAll();
		$this->_opt =& $options;
		
		// get the DBHandler
		$this->_DBHandler = & Services::getService("DBHandler");
		
		$this->_id = $options->get("databaseIndex");
	}

	/**
	 * authenticate will check a systemName/password pair against the defined method
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) {
		if ($this->agentExists($systemName)) {
		
			$id = $this->_connect();
			if (!isset($id)) return false;
			$o =& $this->_opt;
			// they exist, now check their password
			
			// get the encrypted version of the pwd we got passed
			$ourPass = $this->_getEncryptedPassword($systemName,$password);
			
			// now get the one from the DB
			$a = $this->_getFieldsFromDB( $systemName, $o->get("passwordField"));
			$dbPass = $a[$o->get("passwordField")];
			
			// disconnect
			$this->_disconnect();
			
			// now compare the two
			if ($ourPass == $dbPass) // they're good!
				return true;
			else					// or not...
				return false; // denied.
		}
		return false;
	}
	
	/**
	 * Encrypts $password using the method specified by the user.
	 * @param string $systemName The users's system name.
	 * @param string $password The password to encrypt.
	 * @access private
	 * @return string The encrypted version of $password.
	 **/
	function _getEncryptedPassword( $systemName, $password ) {
		$o = & $this->_opt;
		// check if the password in the DB is encrypted
		if ($o->get("passwordFieldEncrypted")) {
			switch($o->get("passwordFieldEncryptionType")){
				case "databaseSHA1":
					$passwordQuery = & new SelectQuery;
					$passwordQuery->addColumn("SHA1('".$password."')","encryptedPassword");
					$passwordResult = & $this->_DBHandler->query($passwordQuery,$this->_id);
					return $passwordResult->field("encryptedPassword");
					break;
				case "databaseMD5":
					$passwordQuery = & new SelectQuery;
					$passwordQuery->addColumn("MD5('".$password."')","encryptedPassword");
					$passwordResult = & $this->_DBHandler->query($passwordQuery,$this->_id);
					return $passwordResult->field("encryptedPassword");
					break;
				case "crypt": 
					$r = $this->_getFieldsFromDB($systemName,$o->get("passwordField"));
					$dbPassword = $r[$o->get("passwordField")];
					return crypt($password,$dbPassword);
					break;
				default:
					return $password;
			} // switch
		}
		return $password;
	}
	
	/**
	 * Fetches the specified fields from the DB form $systemName.
	 * @param string $systemName The system name to fetch info for.
	 * @param string $field1,... List of fields to fetch.
	 * @access private
	 * @return array An associative array of fields: [field1]=>data1,... 
	 **/
	function _getFieldsFromDB( $systemName ) {
		if (func_num_args() < 2) return array();
		
		$toFetch = array();
		for ($i = 1; $i < func_num_args(); $i++)
			$toFetch[] = func_get_arg($i);
		
		// get the options
		$o = & $this->_opt;
		
		// get the DBHandler
		$DBHandler = & $this->_DBHandler;
		
		$query = & new SelectQuery;
		$query->addTable($o->get("tableName"));
		
		foreach ($toFetch as $field) {
			if (is_array($field))
				foreach ($field as $f) $query->addColumn($f);
			else
				$query->addColumn($field);
		}
		
		$where = $o->get("usernameField")."='" . $systemName ."'";
		$query->setWhere($where);
		
		$result = & $DBHandler->query($query,$this->_id);
		if ($result->getNumberOfRows()) {
			return $result->getCurrentRow();
		}
		return array();
	}
	

	/**
	 * connects to the database
	 * @access private
	 * @return int The connection ID. 
	 **/
	function _connect( ) {
		
		// if we already connected this session, just return
		if ($this->_connected) return $this->_id;

		$this->_DBHandler->pConnect($this->_id);
		
		// check if we're connected
		if (!$this->_DBHandler->isConnected($this->_id)) {
			throwError( new Error("DBAuthenticationMethod - could not connect to the Database!","System",true));
			return false;
		}
		$this->_connected = true;
		return $this->_id;
	}
	
	/**
	 * disconnects from the DB
	 * @access private
	 * @return void 
	 **/
	function _disconnect( ) {
		// :: we actually don't want to disconnect any more.
		return;
		if ($this->_connected) {
			$this->_DBHandler->disconnect($this->_id);
			$this->_connected = false;
		}
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc)
	 * 
	 * @param string $systemName The system name to get info for.
	 * @param boolean $searchMode Specifies if we are searching for users
	 * or just trying to get info for one user.
	 * @access public
	 * @return array An array of associative arrays corresponding to all the users found
	 * that match systemName. The format is [systemName]=>array([key1]=>value1,...),...
	 **/
	function getAgentInformation( $systemName, $searchMode=false ) {
		$id = $this->_connect();
		if (!isset($id)) return false;
		
		// what fields do we need to get?
		$o = & $this->_opt;
		$fields = $o->get("agentInformationFields");
		if (!is_array($fields) || !count($fields)) return array();
		
		// get the DBHandler
		$DBHandler = & $this->_DBHandler;
		
		$query = & new SelectQuery;
		$query->addTable($o->get("tableName"));
		
		foreach ($fields as $key=>$field) {
			$query->addColumn($field);
		}
		$query->addColumn($o->get("usernameField"));
		
		// build the appropriate where clause for this query, depending
		// on if we're in searchMode or not.
		if ($searchMode) {
			$whereArray = array();
			foreach ($fields as $key=>$field)
				$whereArray[] = "$field LIKE '%$systemName%'";
			$whereArray[] = $o->get("usernameField")." LIKE '%$systemName%'";
			$where = implode(" OR ",$whereArray);
		} else
			$where = $o->get("usernameField")."='" . $systemName ."'";
		$query->setWhere($where);
		
		$result = & $DBHandler->query($query,$this->_id);
		
		for ($i=0; $i<$result->getNumberOfRows(); $i++) {
    		$row = $result->getCurrentRow();
			$result->advanceRow();
			
			$userName = $row[$o->get("usernameField")];

			// make a [key]=>value array for the results
    		$info = array();
    		foreach ($fields as $key=>$val) {
    			$info[$userName][$key] = $row[$val];
    		}
		}
		
		$this->_disconnect();
		return $info;
	}
	
	/**
	 * Checks to see if $systemName exists in this method.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		$id = $this->_connect();
		if (!isset($id)) return false;

		// get the options
		$o = & $this->_opt;
		
		// get the DBHandler
		$DBHandler = & $this->_DBHandler;
		
		$query = & new SelectQuery;
		$query->addTable($o->get("tableName"));
		
		$query->addColumn($o->get("usernameField"));
		
		$where = $o->get("usernameField")."='" . $systemName ."'";
		$query->setWhere($where);
		
		$result = & $DBHandler->query($query,$this->_id);
		$this->_disconnect();
		if ($result->getNumberOfRows()) // yep
			return true;
		return false;
	}
}

?>