<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleSelectQueryResultTestCase.class.php,v 1.6 2007/09/04 20:25:21 adamfranco Exp $
 */
 
require_once(HARMONI . 'DBHandler/Oracle/OracleDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleSelectQueryResultTestCase.class.php,v 1.6 2007/09/04 20:25:21 adamfranco Exp $
 */

class OracleSelectQueryResultTestCase extends UnitTestCase {
	// OracleSelectQueryResult object
	var $queryResult; 
	// OracleDatabase object
	var $db; 
	// Resource id
	var $rid;
	
	/**
	 * Sets up unit test wide variables at the start
	 *       of each test method.
	 * 
	 * @access public 
	 */
	function setUp()
	{ 
		// perhaps, initialize $obj here
		// connect to some database and do a select query
		$this->db = new OracleDatabase("localhost", "harmoniTest", "test", "test");
		$this->db->connect();
		$this->rid = $this->db->_query("SELECT * FROM test ORDER BY id LIMIT 4 OFFSET 100"); 
		// create the query result
		$this->queryResult = new OracleSelectQueryResult($this->rid, $this->db->_linkId);
	} 
	
	/**
	 * Clears the data set in the setUp() method call.
	 * 
	 * @access public 
	 */
	function tearDown()
	{ 
			// perhaps, unset $obj here
			unset($this->queryResult);
	} 
	
	/**
	 * Tests a simple SELECT with one column and table. No WHERE, ORDER BY, GROUP BY, etc.
	 */
	function test_Constructor()
	{
		$this->assertEqual($this->rid, $this->queryResult->_resourceId);
		$this->assertEqual($this->db->_linkId, $this->queryResult->_linkId);
		$this->assertEqual($this->queryResult->getResourceId(), $this->queryResult->_resourceId);
	} 
	
	/**
	 * Tests all functions.
	 */
	function test_All_Functions()
	{ 
		// number of fields must be 3
		$this->assertEqual($this->queryResult->getNumberOfFields(), 3); 
		// only 4 rows must be returned
		$this->assertEqual($this->queryResult->getNumberOfRows(), 4); 
		// we have more rows left
		$this->assertTrue($this->queryResult->hasMoreRows()); 
		// see if field names are correct
		$fieldNames = $this->queryResult->getFieldNames();
		
		$this->assertEqual($fieldNames, array("id", "fk", "value"));
	
		$id = $this->queryResult->field("id");
		$fk = $this->queryResult->field("fk");
		$value = $this->queryResult->field("value");
		$row["id"] = $id;
		$row["fk"] = $fk;
		$row["value"] = $value;
		$this->assertEqual($id, "101");
		$this->assertEqual($fk, "5");
		$this->assertEqual($value, "This is the value");
		$this->assertEqual($row, $this->queryResult->getCurrentRow(ASSOC)); 
		
		// after 4 advances, no more rows should be left
		for ($i = 0; $i < 4; $i++)
			$this->queryResult->advanceRow();
			
		$this->assertFalse($this->queryResult->hasMoreRows()); 
		
		// test moveToRow()
		$this->queryResult->moveToRow(0); 
		
		// after 4 advances, no more rows should be left
		$this->assertTrue($this->queryResult->hasMoreRows());
		for ($i = 0; $i < 4; $i++)
			$this->assertTrue($this->queryResult->advanceRow());
			
		$this->assertFalse($this->queryResult->hasMoreRows());
		
		// test moveToRow()
		$this->queryResult->moveToRow(1); 
		
		// after 4 advances, no more rows should be left
		$this->assertTrue($this->queryResult->hasMoreRows());
		for ($i = 0; $i < 3; $i++)
			$this->assertTrue($this->queryResult->advanceRow());
			
		$this->assertFalse($this->queryResult->hasMoreRows());
		
		// test moveToRow()
		$this->queryResult->moveToRow(2); 
		
		// after 4 advances, no more rows should be left
		$this->assertTrue($this->queryResult->hasMoreRows());
		for ($i = 0; $i < 2; $i++)
			$this->assertTrue($this->queryResult->advanceRow());
			
		$this->assertFalse($this->queryResult->hasMoreRows());
		
		// test moveToRow()
		$this->queryResult->moveToRow(3); 
		
		// after 4 advances, no more rows should be left
		$this->assertTrue($this->queryResult->hasMoreRows());
		for ($i = 0; $i < 1; $i++)
			$this->assertTrue($this->queryResult->advanceRow());
			
		$this->assertFalse($this->queryResult->hasMoreRows());
	} 
} 

?>