<?php

/**
  V3.50 19 May 2003  (c) 2000-2003 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
	
  Set tabs to 4 for best viewing.
 
 	DOCUMENTATION:
	
		See adodb/tests/test-datadict.php for docs and examples.
*/

/*
	Test script for parser
*/
function Lens_ParseTest()
{
$str = "ACOL NUMBER(32,2) DEFAULT 'The \"cow\" (and Jim''s dog) jumps over the moon' PRIMARY, INTI INT AUTO DEFAULT 0";
print "<p>$str</p>";
$a= Lens_ParseArgs($str);
print "<pre>";
print_r($a);
print "</pre>";
}
//Lens_ParseTest();

/**
	Parse arguments, treat "text" (text) and 'text' as quotation marks.
	To escape, use "" or '' or ))
	
	@param endstmtchar    Character that indicates end of statement
	@param tokenchars     Include the following characters in tokens apart from A-Z and 0-9 
	@returns 2 dimensional array containing parsed tokens.
*/
function Lens_ParseArgs($args,$endstmtchar=',',$tokenchars='_.-')
{
	$pos = 0;
	$intoken = false;
	$stmtno = 0;
	$endquote = false;
	$tokens = array();
	$tokens[$stmtno] = array();
	$max = strlen($args);
	$quoted = false;
	
	while ($pos < $max) {
		$ch = substr($args,$pos,1);
		switch($ch) {
		case ' ':
		case "\t":
		case "\n":
		case "\r":
			if (!$quoted) {
				if ($intoken) {
					$intoken = false;
					$tokens[$stmtno][] = implode('',$tokarr);
				}
				break;
			}
			
			$tokarr[] = $ch;
			break;
			
		case '(':
		case ')':	
		case '"':
		case "'":
			
			if ($intoken) {
				if (empty($endquote)) {
					$tokens[$stmtno][] = implode('',$tokarr);
					if ($ch == '(') $endquote = ')';
					else $endquote = $ch;
					$quoted = true;
					$intoken = true;
					$tokarr = array();
				} else if ($endquote == $ch) {
					$ch2 = substr($args,$pos+1,1);
					if ($ch2 == $endquote) {
						$pos += 1;
						$tokarr[] = $ch2;
					} else {
						$quoted = false;
						$intoken = false;
						$tokens[$stmtno][] = implode('',$tokarr);
						$endquote = '';
					}
				} else
					$tokarr[] = $ch;
					
			}else {
			
				if ($ch == '(') $endquote = ')';
				else $endquote = $ch;
				$quoted = true;
				$intoken = true;
				$tokarr = array();
			}
			break;
			
		default:
			
			if (!$intoken) {
				if ($ch == $endstmtchar) {
					$stmtno += 1;
					$tokens[$stmtno] = array();
					break;
				}
			
				$intoken = true;
				$quoted = false;
				$endquote = false;
				$tokarr = array();
	
			}
			
			if ($quoted) $tokarr[] = $ch;
			else if (ctype_alnum($ch) || strpos($tokenchars,$ch) !== false) $tokarr[] = $ch;
			else {
				if ($ch == $endstmtchar) {			
					$tokens[$stmtno][] = implode('',$tokarr);
					$stmtno += 1;
					$tokens[$stmtno] = array();
					$intoken = false;
					$tokarr = array();
					break;
				}
				$tokens[$stmtno][] = implode('',$tokarr);
				$tokens[$stmtno][] = $ch;
				$intoken = false;
			}
		}
		$pos += 1;
	}
	
	return $tokens;
}


class ADODB_DataDict {
	var $connection;
	var $debug = false;
	var $dropTable = "DROP TABLE %s";
	var $addCol = ' ADD';
	var $alterCol = ' ALTER COLUMN';
	var $dropCol = ' DROP COLUMN';
	var $schema = false;
	var $serverInfo = array();
	var $autoIncrement = false;
	var $dataProvider;
	
	function GetCommentSQL($table,$col)
	{
		return false;
	}
	
	function SetCommentSQL($table,$col,$cmt)
	{
		return false;
	}
	
	function MetaTables()
	{
		return $this->connection->MetaTables();
	}
	
	function MetaColumns($tab)
	{
		return $this->connection->MetaColumns($tab);
	}
	
	function MetaPrimaryKeys($tab,$owner=false,$intkey=false)
	{
		return $this->connection->MetaPrimaryKeys($tab.$owner,$intkey);
	}
	
	function MetaType($t,$len=-1,$fieldobj=false)
	{
		return ADORecordSet::MetaType($t,$len,$fieldobj);
	}
	
	// Executes the sql array returned by GetTableSQL and GetIndexSQL
	function ExecuteSQLArray($sql, $continueOnError = true)
	{
		$rez = 2;
		$conn = &$this->connection;
		$saved = $conn->debug;
		foreach($sql as $line) {
			
			if ($this->debug) $conn->debug = true;
			$ok = $conn->Execute($line);
			$conn->debug = $saved;
			if (!$ok) {
				if ($this->debug) ADOConnection::outp($conn->ErrorMsg());
				if (!$continueOnError) return 0;
				$rez = 1;
			}
		}
		return 2;
	}
	
	/*
	 	Returns the actual type given a character code.
		
		C:  varchar
		X:  CLOB (character large object) or largest varchar size if CLOB is not supported
		C2: Multibyte varchar
		X2: Multibyte CLOB
		
		B:  BLOB (binary large object)
		
		D:  Date
		T:  Date-time 
		L:  Integer field suitable for storing booleans (0 or 1)
		I:  Integer
		F:  Floating point number
		N:  Numeric or decimal number
	*/
	
	function ActualType($meta)
	{
		return $meta;
	}
	
	function CreateDatabase($dbname,$options=false)
	{
		$options = $this->_Options($options);
		$s = 'CREATE DATABASE '.$dbname;
		if (isset($options[$this->upperName])) $s .= ' '.$options[$this->upperName];
		$sql[] = $s;
		return $sql;
	}
	
	/*
	 Generates the SQL to create index. Returns an array of sql strings.
	*/
	function CreateIndexSQL($idxname, $tabname, $flds, $idxoptions = false)
	{
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		return $this->_IndexSQL($idxname, $tabname, $flds, $this->_Options($idxoptions));
	}
	
	function SetSchema($schema)
	{
		$this->schema = $schema;
	}
	
	function AddColumnSQL($tabname, $flds)
	{	
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		$sql = array();
		list($lines,$pkey) = $this->_GenFields($flds);
		foreach($lines as $v) {
			$sql[] = "ALTER TABLE $tabname $this->addCol $v";
		}
		return $sql;
	}
	
	function AlterColumnSQL($tabname, $flds)
	{
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		$sql = array();
		list($lines,$pkey) = $this->_GenFields($flds);

		foreach($lines as $v) {
			$sql[] = "ALTER TABLE $tabname $this->alterCol $v";
		}
		return $sql;
	}
	
	function DropColumnSQL($tabname, $flds)
	{
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		if (!is_array($flds)) $flds = explode(',',$flds);
		$sql = array();
		foreach($flds as $v) {
			$sql[] = "ALTER TABLE $tabname $this->dropCol $v";
		}
		return $sql;
	}
	
	function DropTableSQL($tabname)
	{
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		$sql[] = sprintf($this->dropTable,$tabname);
		return $sql;
	}
	
	/*
	 Generate the SQL to create table. Returns an array of sql strings.
	*/
	function CreateTableSQL($tabname, $flds, $tableoptions=false)
	{
		if (!$tableoptions) $tableoptions = array();
	
		list($lines,$pkey) = $this->_GenFields($flds);
		
		$taboptions = $this->_Options($tableoptions);
		if ($this->schema) $tabname = $this->schema.'.'.$tabname;
		$sql = $this->_TableSQL($tabname,$lines,$pkey,$taboptions);
		
		$tsql = $this->_Triggers($tabname,$taboptions);
		foreach($tsql as $s) $sql[] = $s;
		
		return $sql;
	}
	
	function _GenFields($flds)
	{
		if (is_string($flds)) {
			$txt = $flds;
			$flds = array();
			$flds0 = Lens_ParseArgs($txt,',');
			$hasparam = false;
			foreach($flds0 as $f0) {
				$f1 = array();
				foreach($f0 as $token) {
					switch (strtoupper($token)) {
					case 'CONSTRAINT':
					case 'DEFAULT': 
						$hasparam = $token;
						break;
					default:
						if ($hasparam) $f1[$hasparam] = $token;
						else $f1[] = $token;
						$hasparam = false;
						break;
					}
				}
				$flds[] = $f1;
				
			}
		}
		$this->autoIncrement = false;
		$lines = array();
		$pkey = array();
		foreach($flds as $fld) {
			$fld = _array_change_key_case($fld);
		
			$fname = false;
			$fdefault = false;
			$fautoinc = false;
			$ftype = false;
			$fsize = false;
			$fprec = false;
			$fprimary = false;
			$fnoquote = false;
			$fdefts = false;
			$fdefdate = false;
			$fconstraint = false;
			$fnotnull = false;
			//-----------------
			// Parse attributes
			foreach($fld as $attr => $v) {
				if ($attr == 2 && is_numeric($v)) $attr = 'SIZE';
				else if (is_numeric($attr) && $attr > 1 && !is_numeric($v)) $attr = strtoupper($v);
				
				switch($attr) {
				case '0':
				case 'NAME': 	$fname = $v; break;
				case '1':
				case 'TYPE': 	$ty = $v; $ftype = $this->ActualType(strtoupper($v)); break;
				case 'SIZE': 	$dotat = strpos($v,'.');
								if ($dotat === false) $fsize = $v;
								else {
									$fsize = substr($v,0,$dotat);
									$fprec = substr($v,$dotat+1);
								}
								break;
				case 'AUTOINCREMENT':
				case 'AUTO':	$fautoinc = true; $fnotnull = true; break;
				case 'KEY':
				case 'PRIMARY':	$fprimary = $v; $fnotnull = true; break;
				case 'DEF':
				case 'DEFAULT': $fdefault = $v; break;
				case 'NOTNULL': $fnotnull = $v; break;
				case 'NOQUOTE': $fnoquote = $v; break;
				case 'DEFDATE': $fdefdate = $v; break;
				case 'DEFTIMESTAMP': $fdefts = $v; break;
				case 'CONSTRAINT': $fconstraint = $v; break;
				} //switch
			} // foreach $fld
			
			//--------------------
			// VALIDATE FIELD INFO
			if (!strlen($fname)) {
				if ($this->debug) ADOConnection::outp("Undefined NAME");
				return false;
			}
			
			if (!strlen($ftype)) {
				if ($this->debug) ADOConnection::outp("Undefined TYPE for field '$fname'");
				return false;
			} else
				$ftype = strtoupper($ftype);
			
			$ftype = $this->_GetSize($ftype, $ty, $fsize, $fprec);
			
			if ($fprimary) $pkey[] = $fname;
			
			// some databases do not allow blobs to have defaults
			if ($ty == 'X') $fdefault = false;
			
			//--------------------
			// CONSTRUCT FIELD SQL
			if ($fdefts) {
				if (substr($this->connection->databaseType,0,5) == 'mysql') {
					$ftype = 'TIMESTAMP';
				} else {
					$fdefault = $this->connection->sysTimeStamp;
				}
			} else if ($fdefdate) {
				if (substr($this->connection->databaseType,0,5) == 'mysql') {
					$ftype = 'TIMESTAMP';
				} else {
					$fdefault = $this->connection->sysDate;
				}
			} else if (strlen($fdefault) && !$fnoquote)
				if ($ty == 'C' or $ty == 'X' or 
					( substr($fdefault,0,1) != "'" && !is_numeric($fdefault)))
					if (strlen($fdefault) != 1 && substr($fdefault,0,1) == ' ' && substr($fdefault,strlen($fdefault)-1) == ' ') 
						$fdefault = trim($fdefault);
					else
						$fdefault = $this->connection->qstr($fdefault);
			$suffix = $this->_CreateSuffix($fname,$ftype,$fnotnull,$fdefault,$fautoinc,$fconstraint);
			
			$fname = str_pad($fname,16);
			$lines[] = "$fname $ftype$suffix";
			
			if ($fautoinc) $this->autoIncrement = true;
		} // foreach $flds
		
		
		return array($lines,$pkey);
	}
	/*
		 GENERATE THE SIZE PART OF THE DATATYPE
			$ftype is the actual type
			$ty is the type defined originally in the DDL
	*/
	function _GetSize($ftype, $ty, $fsize, $fprec)
	{
		if (strlen($fsize) && $ty != 'X' && $ty != 'B') {
			$ftype .= "(".$fsize;
			if ($fprec) $ftype .= ",".$fprec;				
			$ftype .= ')';
		}
		return $ftype;
	}
	
	
	// return string must begin with space
	function _CreateSuffix($fname,$ftype,$fnotnull,$fdefault,$fautoinc,$fconstraint)
	{	
		$suffix = '';
		if (strlen($fdefault)) $suffix .= " DEFAULT $fdefault";
		if ($fnotnull) $suffix .= ' NOT NULL';
		if ($fconstraint) $suffix .= ' '.$fconstraint;
		return $suffix;
	}
	
	function _IndexSQL($idxname, $tabname, $flds, $idxoptions)
	{
		if (isset($idxoptions['REPLACE'])) $sql[] = "DROP INDEX $idxname";
		if (isset($idxoptions['UNIQUE'])) $unique = ' UNIQUE';
		else $unique = '';
		
		if (is_array($flds)) $flds = implode(', ',$flds);
		$s = "CREATE$unique INDEX $idxname ON $tabname ";
		if (isset($idxoptions[$this->upperName])) $s .= $idxoptions[$this->upperName];
		$s .= "($flds)";
		$sql[] = $s;
		
		return $sql;
	}
	
	function _DropAutoIncrement($tabname)
	{
		return false;
	}
	
	function _TableSQL($tabname,$lines,$pkey,$tableoptions)
	{
		$sql = array();
		
		if (isset($tableoptions['REPLACE'])) {
			$sql[] = sprintf($this->dropTable,$tabname);
			if ($this->autoIncrement) {
				$sInc = $this->_DropAutoIncrement($tabname);			
				if ($sInc) $sql[] = $sInc;
			}
		}
		$s = "CREATE TABLE $tabname (\n";
		$s .= implode(",\n", $lines);
		if (sizeof($pkey)>0) {
			$s .= ",\n                 PRIMARY KEY (";
			$s .= implode(", ",$pkey).")";
		}
		if (isset($tableoptions['CONSTRAINTS'])) 
			$s .= "\n".$tableoptions['CONSTRAINTS'];
		
		if (isset($tableoptions[$this->upperName.'_CONSTRAINTS'])) 
			$s .= "\n".$tableoptions[$this->upperName.'_CONSTRAINTS'];
		
		$s .= "\n)";
		if (isset($tableoptions[$this->upperName])) $s .= $tableoptions[$this->upperName];
		$sql[] = $s;
		
		return $sql;
	}
	
	/*
		GENERATE TRIGGERS IF NEEDED
		used when table has auto-incrementing field that is emulated using triggers
	*/
	function _Triggers($tabname,$taboptions)
	{
		return array();
	}
	
	/*
		Sanitize options, so that array elements with no keys are promoted to keys
	*/
	function _Options($opts)
	{
		if (!is_array($opts)) return array();
		$newopts = array();
		foreach($opts as $k => $v) {
			if (is_numeric($k)) $newopts[strtoupper($v)] = $v;
			else $newopts[strtoupper($k)] = $v;
		}
		return $newopts;
	}
}
?>