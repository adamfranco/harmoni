<?php



class IDManager
	extends ServiceInterface {
	
	var $_db;
	var $_dbID;
	
	function IDManager($dbID) {
		$this->_dbID = $dbID;
		$this->_db =& Services::requireService("DBHandler");
	}

	function newID(&$type) {
		ArgumentValidator::validate($type,new ExtendsValidatorRule("Type"));
		debug::output("trying to generate new id for type \"".
			$type->getDomain().", ".$type->getAuthority().", ".$type->getKeyword()."\"",
			DEBUG_SYS4,"IDManager");
		
		$domain = $type->getDomain();
		$authority = $type->getAuthority();
		$keyword = $type->getKeyword();
		
		$query =& new SelectQuery();
		$query->addTable("harmoni_id");
		$query->addColumn("MAX(harmoni_id_number)");
		
		$result =& $this->_db->query($query,$this->_dbID);
		if (!$result) throwError( new Error("Could not fetch largest ID from the database.","IDManager",true));
		$max = $result->field(0);
		
		debug::output("got current max of '$max' from the database",DEBUG_SYS2,"IDManager");
		
		unset($query,$result);
		
		$max++;
		$query =& new InsertQuery;
		$query->setTable("harmoni_id");
		$query->setColumns(array("harmoni_id_number","harmoni_id_domain","harmoni_id_authority","harmoni_id_keyword"));
		$query->addRowOfValues(array($max,
								"'".addslashes($domain)."'",
								"'".addslashes($authority)."'",
								"'".addslashes($keyword)."'"));
		
		$result =& $this->_db->query($query,$this->_dbID);
		if ($result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("IDManager"));
		}
		
		debug::output("successfully created new id '$max'",DEBUG_SYS1,"IDManager");
		
		return $max;
	}
	
	function & getIDType($id) {
		ArgumentValidator::validate($id, new IntegerValidatorRule());
		$query =& new SelectQuery();
		$query->addTable("harmoni_id");
		$query->addColumn("harmoni_id_domain");
		$query->addColumn("harmoni_id_authority");
		$query->addColumn("harmoni_id_keyword");
		$query->addWhere("harmoni_id_number=$id");
		
		$result =& $this->_db->query($query,$this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1)
			$type = null;
		else
			$type =& new HarmoniType($result->field(0),$result->field(1),$result->field(2));
		
		return $type;
	}
	
	function getAllIDsofType(&$type) {
		ArgumentValidator::validate($type, new ExtendsValidatorRule("Type"));
	}
	
	function start() {}
	function stop() {}
}

?>