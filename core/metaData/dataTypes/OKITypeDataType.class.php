<?

/**
 * A simple integer data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: OKITypeDataType.class.php,v 1.2 2004/07/16 21:03:10 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class OKITypeDataType
	extends DataType {
	
	var $_type;
	
	function OKITypeDataType($type=null) {
		$this->_type =& $type;
	}
	
	function makeSearchString(& $val ) {
		$type =& $val->getTypeObject();
		return "(data_okitype.data_okitype_domain='".addslashes($type->getDomain())."' AND ".
		 "data_okitype.data_okitype_authority='".addslashes($type->getAuthority())."' AND ".
		 "data_okitype.data_okitype_keyword='".addslashes($type->getKeyword())."')";
	}
	
	function &getTypeObject() {
		return $this->_type;
	}
	
	function toString() {
		if (!$this->_type) return "";
		return "Domain: ".$this->_type->getDomain() . ", Authority: ".$this->_type->getAuthority().", Keyword: ".$this->_type->getKeyword();
	}
	
	function isEqual(&$dataType) {
		if ($this->_type->isEqual($dataType->getTypeObject())) return true;
		return false;
	}
	
	function insert() {		
		$sharedManager =& Services::getService("Shared");
		$newID =& $sharedManager->createId();
		
		$query =& new InsertQuery();
		$query->setTable("data_okitype");
		$query->setColumns(array("data_okitype_id","data_okitype_domain","data_okitype_authority","data_okitype_keyword"));
		
		$query->addRowOfValues(array($newID->getIdString(), "'".addslashes($this->_type->getDomain())."'",
															"'".addslashes($this->_type->getAuthority())."'",
															"'".addslashes($this->_type->getKeyword())."'"));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("OKITypeDataType") );
			return false;
		}
		
		$this->_setMyID($newID->getIdString());
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_okitype");
		$query->setColumns(array("data_okitype_domain","data_okitype_authority","data_okitype_keyword"));
		$query->setWhere("data_okitype_id=".$this->getID());
		
		$query->setValues(array("'".addslashes($this->_type->getDomain())."'",
								"'".addslashes($this->_type->getAuthority())."'",
								"'".addslashes($this->_type->getKeyword())."'"));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("OKITypeDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_okitype";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_okitype",LEFT_JOIN,"data_okitype_id = fk_data");
		$query->addColumn("data_okitype_domain");
		$query->addColumn("data_okitype_authority");
		$query->addColumn("data_okitype_keyword");
	}
	
	function populate( &$dbRow ) {
		$this->_type =& new HarmoniType($dbRow['data_okitype_domain'],$dbRow['data_okitype_authority'],$dbRow['data_okitype_keyword']);
	}
	
	function takeValue(&$fromObject) {
		$this->_type = $fromObject->getTypeObject();
	}
	
	function &clone() {
		return new OKITypeDataType($this->_type);
	}
}

?>