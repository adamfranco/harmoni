<?php

/**
 * The IDManager is responsible for creating new numeric ID numbers for database objects.
 * Each ID is associated with an OKI-style Type. Across an entire DB scheme no two IDs
 * will be the same.
 * @package harmoni.datamanager
 * @version $Id: IDManager.class.php,v 1.6 2004/01/01 19:03:42 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/

class IDManager
	extends ServiceInterface {
	
	var $_dbID;
	
	function IDManager($dbID) {
		$this->_dbID = $dbID;
	}

	function newID(&$type) {
		ArgumentValidator::validate($type,new ExtendsValidatorRule("Type"));
		debug::output("trying to generate new id for type \"".
			$type->getDomain().", ".$type->getAuthority().", ".$type->getKeyword()."\"",
			20,"IDManager");
		
		$domain = $type->getDomain();
		$authority = $type->getAuthority();
		$keyword = $type->getKeyword();
		
		$dbHandler =& Services::requireService("DBHandler");
		
/*		$query =& new SelectQuery();
		$query->addTable("harmoni_id");
		$query->addColumn("MAX(harmoni_id_number)");
		
		
		$result =& $dbHandler->query($query,$this->_dbID);
		if (!$result) throwError( new Error("Could not fetch largest ID from the database.","IDManager",true));
		$max = $result->field(0);
		
		debug::output("got current max of '$max' from the database",20,"IDManager");
		
		unset($query,$result);*/
		
//		$max++;
		$query =& new InsertQuery;
		$query->setAutoIncrementColumn("harmoni_id_number","harmoni_id_number_seq");
		$query->setTable("harmoni_id");
		$query->setColumns(array("harmoni_id_domain","harmoni_id_authority","harmoni_id_keyword"));
		$query->addRowOfValues(array(
								"'".addslashes($domain)."'",
								"'".addslashes($authority)."'",
								"'".addslashes($keyword)."'"));
		
		$result =& $dbHandler->query($query,$this->_dbID);
		if ($result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("IDManager"));
		}
		
		$newID = $result->getLastAutoIncrementValue();
		
		debug::output("successfully created new id '$newID'",DEBUG_SYS5,"IDManager");
		
		return $newID;
	}
	
	function & getIDType($id) {
		ArgumentValidator::validate($id, new IntegerValidatorRule());
		$query =& new SelectQuery();
		$query->addTable("harmoni_id");
		$query->addColumn("harmoni_id_domain");
		$query->addColumn("harmoni_id_authority");
		$query->addColumn("harmoni_id_keyword");
		$query->addWhere("harmoni_id_number=$id");
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,$this->_dbID);
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