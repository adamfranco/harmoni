<?php
/**
 * @since 9/11/07
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySqlUtils.class.php,v 1.2 2007/09/13 18:14:02 adamfranco Exp $
 */ 

/**
 * This is a static class with some utility functions.
 * 
 * @since 9/11/07
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySqlUtils.class.php,v 1.2 2007/09/13 18:14:02 adamfranco Exp $
 */
class MySqlUtils {
		
	/**
	 * Make all column names lowercase
	 * 
	 * @param integer $dbIndex
	 * @return void
	 * @access public
	 * @since 9/11/07
	 */
	public function columnNamesToLowercase ($dbIndex) {
		$dbc = Services::getService("DBHandler");
		$tables = $dbc->getTableList($dbIndex);
		$numChanged = 0;
		
		foreach ($tables as $table) {
			$result = $dbc->query(new GenericSQLQuery("DESCRIBE ".$table), $dbIndex);
			$result = $result->returnAsSelectQueryResult();
			while ($result->hasNext()) {
				$field = $result->field("Field");
				if ($field != strtolower($field)) {
					$query = new GenericSQLQuery("ALTER TABLE ".$table." CHANGE `".$field."` `".strtolower($field)."` ".$result->field("Type"));
					$dbc->query($query, $dbIndex);
					$numChanged++;
					printpre($query->asString());
				}				
				$result->advanceRow();
			}
		}
		
		print "$numChanged columns were renamed.";
	}
	
	/**
	 * Make the changes to the database required to go from harmoni-0.11.0 to harmoni-0.12.0.
	 * 
	 * @param integer $dbIndes
	 * @return void
	 * @access public
	 * @since 9/13/07
	 */
	public function harmoni_0_12_0_update ($dbIndex) {
		$dbc = Services::getService("DBHandler");
		$tables = $dbc->getTableList($dbIndex);
		
		$changeTables = array ('j_node_node', 'node_ancestry');
		$changeTableStatus = array('j_node_node' => false, 'node_ancestry' => false);
		
		// Check which tables need to be updated and update if needed.
		foreach ($changeTables as $table) {
			if (in_array($table, $tables)) {		
				$result = $dbc->query(new GenericSQLQuery("DESCRIBE ".$table), $dbIndex);
				$result = $result->returnAsSelectQueryResult();
				while ($result->hasNext()) {
					if ($result->field("Field") == 'fk_hierarchy') {
						$changeTableStatus[$table] = true;
						break;
					}
					$result->advanceRow();
				}
				
				if (!$changeTableStatus[$table]) {
					// Alter the table
					printpre("Adding column fk_hierarchy to $table");
					$dbc->query(new GenericSQLQuery("ALTER TABLE `".$table."` ADD `fk_hierarchy` VARCHAR( 170 ) FIRST ;"), $dbIndex);
				}
			}
		}
		
		// Select the hierarchy ids and update the table
		if (in_array(false, $changeTableStatus)) {
			// Look up which nodes belong to which hierarchy
			$query = new SelectQuery;
			$query->addTable("node");
			$query->addColumn("node_id");
			$query->addColumn("fk_hierarchy");
			$query->addOrderBy("fk_hierarchy");
			
			$hierarchies = array();
			$result = $dbc->query($query, $dbIndex);
			while ($result->hasMoreRows()) {
				// Create an array to hold the ids of all nodes in the hierarchy
				if (!isset($hierarchies[$result->field('fk_hierarchy')]))
					$hierarchies[$result->field('fk_hierarchy')] = array();
				
				$hierarchies[$result->field('fk_hierarchy')][] = $result->field('node_id');
				
				$result->advanceRow();
			}
			$result->free();
			
			// Update each table's fk_hierarchy
			foreach ($hierarchies as $hierarchyId => $nodeIds) {
				if (!$changeTableStatus['j_node_node']) {
					$query = new UpdateQuery;
					$query->addValue('fk_hierarchy', $hierarchyId);
					$query->setTable('j_node_node');
					$query->addWhere("fk_child IN ('".implode("', '", $nodeIds)."')");
					$result = $dbc->query($query, $dbIndex);
					printpre("Updated fk_hierarchy on ".$result->getNumberOfRows()." rows in j_node_node.");
				}
				
				if (!$changeTableStatus['j_node_node']) {
					$query = new UpdateQuery;
					$query->addValue('fk_hierarchy', $hierarchyId);
					$query->setTable('node_ancestry');
					$query->addWhere("fk_node IN ('".implode("', '", $nodeIds)."')");
					$result = $dbc->query($query, $dbIndex);
					printpre("Updated fk_hierarchy on ".$result->getNumberOfRows()." rows in node_ancestry.");
				}
			}
			
			// Alter the table to be NOT NULL
			foreach ($changeTables as $table) {
				if (!$changeTableStatus[$table]) {
					// Alter the table
					$dbc->query(new GenericSQLQuery("ALTER TABLE `".$table."` CHANGE `fk_hierarchy` `fk_hierarchy`  VARCHAR( 170 ) NOT NULL"), $dbIndex);
					printpre("Altering column fk_hierarchy in $table to be NOT NULL.");
				}
			}
		}
		
		// Alter the names of the Scheduling columns
		if (in_array('sc_item', $tables)) {
			try {
				$dbc->query(new GenericSQLQuery("ALTER TABLE `sc_item` CHANGE `start` `start_date` BIGINT( 20 ) NULL DEFAULT NULL , CHANGE `end` `end_date` BIGINT( 20 ) NULL DEFAULT NULL "), $dbIndex);
					printpre("Renaming columns start and end to start_date and end_date in the sc_item table.");
			} catch (QueryDatabaseException $e) {}
		}
	}
	
}

?>