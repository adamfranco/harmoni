<?

class authModule_db extends authModule {
	var $_conn;


	function _init() {
		$this->cfg = & new configHandler();
		
		// database specific options
		$this->cfg->addAttr("databaseType:s");
		$this->cfg->addAttr("host:s","username:s","password:s","database:s","table:s");
		
		// fields to use
		$this->cfg->addAttr("usernameField:s","passwordField:s","otherFields:s[]");
		$this->cfg->addAttr("passwordFieldEncrypted:b","passwordEncryptionType:s:md5,des,crypt");
	}

	function valid($name,$pass) {
		
		// if the password is encrypted, handle that here
		if ($this->cfg->get("passwordFieldEncrypted")) {
			$type = $this->cfg->get("passwordEncryptionType");
			// handle encryption -- write later
		}
		
		// create an array of fields we are going to fetch from the db
		$flds = array($this->cfg->get("usernameField"));
		if ($otherFields = $this->cfg->get("otherFields"))
			$flds = array_merge($flds,array_values($otherFields));
		
		// if we are using this module for authentication, add the password
		$pstring='';
		if (!$this->cfg->get("dontAuth")) $pstring = " and ".$this->cfg->get("passwordField")."='$pass'";
		
		// build the SQL query
		$sql = "
			SELECT 
				".implode(",",$flds)."
			FROM
				".$this->cfg->get("table")."
			WHERE
				".$this->cfg->get("usernameField")."='$name'$pstring";
		
		// connect and query the database
		$this->_connect();
		$rset = & $this->_conn->Execute($sql);
		if (!$rset) error::fatal("authModule_db - Could not execute username/password check query for user '$user'");
		
		if ($rset->RecordCount()) {
			$a = $rset->FetchRow();

			if ($otherFields && count($otherFields)) {
				$extras = array();
				foreach ($otherFields as $lbl=>$extra) {
					$extras[$lbl] = $a[$extra];
				}
				$this->_extras = $extras;
			}
			$this->_isValid = true;
		}
		// if we aren't using this module for authentication, make sure we're "not valid"
		if ($this->cfg->get("dontAuth")) $this->_isValid=false;
		$this->_disconnect();
		return $this->_isValid;
	}
	
	function _connect() {
		// set up the db connection
		$this->_conn = ADONewConnection($this->dbtype);
		$this->_conn->PConnect($this->host,$this->user,$this->pass,$this->db);
		$this->_conn->setFetchMode(ADODB_FETCH_ASSOC);
		if (!$this->_conn) error::fatal("authModule_db - Could not connect to DB server ".$this->cfg->get("host"));
	}
	
	function _disconnect() {
		if (is_object($this->_conn)) {
			$this->_conn->Close();
		}
	}
}
