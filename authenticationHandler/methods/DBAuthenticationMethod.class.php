<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/DBMethodOptions.class.php");

/**
 * the DB Authentication Method will contact an SQL database and check a username/password pair
 * against fields in a specified table.
 *
 * @version $Id: DBAuthenticationMethod.class.php,v 1.5 2003/06/25 21:46:54 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
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
	 * the constructor
	 *
	 * @param object DBMethodOptions $options a FieldSet object with all the necessary options for this module
	 * @access public
	 * @return void
	 **/
	function DBAuthenticationMethod ( & $options ) {
		// store the options
		$this->_opt = & $options;
		
		// get the DBHandler
		$this->_DBHandler = & Services::getService("DBHandler");
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
		if (!$id = $this->_connect()) return false;
		if ($this->agentExists($systemName)) {
			// they exist, now check their password
			
			// get the encrypted version of the pwd we got passed
			$ourPass = $this->_getEncryptedPassword($systemName,$password);
			
			// now get the one from the DB
			$a = $this->_fetchFieldFromDB( $systemName, $o->get("passwordField"));
			$dbPass = $a[$o->get("passwordField")];
			
			// disconnect
			$this->_disconnect();
			
			// now compare the two
			if ($ourPass == $dbPass) // they're good!
				return true;
			else					// or not...
				return false; // denied.
		}
	}
	
	/**
	 * Encrypts $password using the method specified by the user.
	 * @param string $systemName The users's system name.
	 * @param string $password The password to encrypt.
	 * @access public
	 * @return string The encrypted version of $password.
	 **/
	function _getEncryptedPassword( $systemName, $password ) {
		$o = & $this->_opt;
		// check if the password in the DB is encrypted
		if ($o->get("passwordFieldEncrypted")) {
			switch($o->get("passwordFieldEncryptionType")){
				case "database":
					$passwordQuery = & new SelectQuery;
					$passwordQuery->addColumn("PASSWORD('".$password."')","encryptedPassword");
					$passwordResult = & $this->_DBHandler->query($passwordQuery,$this->_id);
					return $passwordResult->field("encryptedPassword");
					break;
				case "crypt": 
					$r = $this->_getFieldsFromDB($systemName,$o->get("passwordField"));
					$dbPassword = $r[$o->get("passwordField")];
					return crypt($password,substr($dbPassword, 0, CRYPT_SALT_LENGTH));
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
	 * @access public
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
		if ($this->_id) return $this->_id;
		
		$o = &$this->_opt;
		$DBHandler = & $this->_DBHandler;
		$id = $DBHandler->createDatabase(
				$o->get("databaseType"),
				$o->get("databaseHost"),
				$o->get("databaseName"),
				$o->get("databaseUsername"),
				$o->get("databasePassword"));
		// persistent connect
		$DBHandler->pConnect($id);
		
		// check if we're connected
		if (!$DBHandler->isConnected($id)) {
			// @todo -cDBAuthenticationMethod throw an error!
			return false;
		}
		$this->_id = $id;
		return $id;
	}
	
	/**
	 * disconnects from the DB
	 * @access private
	 * @return void 
	 **/
	function _disconnect( ) {
		if ($this->_id)$this->_DBHandler->disconnect($this->_id);
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc)
	 * 
	 * @param string $systemName The system name to get info for.
	 * @access public
	 * @return array An associative array of [key]=>value pairs. 
	 **/
	function getAgentInformation( $systemName ) {
		if (!$id = $this->_connect()) return false;
		
		// what fields do we need to get?
		$o = & $this->_opt;
		$fields = $o->get("agentInformationFields");
		if (!is_array($fields) || !count($fields)) return array();
		
		$results = $this->_fetchFieldsFromDB($systemName,$fields);
		
		// make a [key]=>value array for the results
		$info = array();
		foreach ($fields as $key=>$val) {
			$info[$key] = $results[$val];
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
		if (!$id = $this->_connect()) return false;

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