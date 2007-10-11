<?php
/**
 * @since 9/11/07
 * @package harmoni.dbc.postrgresql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostgreSQLUtils.class.php,v 1.1 2007/10/11 20:00:26 adamfranco Exp $
 */ 

/**
 * This is a static class with some utility functions.
 * 
 * @since 9/11/07
 * @package harmoni.dbc.postrgresql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostgreSQLUtils.class.php,v 1.1 2007/10/11 20:00:26 adamfranco Exp $
 */
class PostgreSQLUtils {

	/**
	 * Add the creator column to the dr_asset_info table.
	 * 
	 * @param int $dbIndex
	 * @return void
	 * @access public
	 * @since 10/8/07
	 */
	public static function harmoni_0_12_4_update ($dbIndex) {
		$dbc = Services::getService("DBHandler");
		
		try {
			$dbc->query(new GenericSQLQuery(
				"DROP INDEX log_entry_timestamp_index"
			), $dbIndex);
			printpre("Dropping index 'log_entry_timestamp_index'.");
		} catch (DatabaseException $e) {
			printpre("NOT dropping index 'log_entry_timestamp_index'.");
			printpre($e->getMessage());
		}
		
		try {
			$dbc->query(new GenericSQLQuery(
				'CREATE INDEX log_entry_format_index ON log_entry (log_name, fk_format_type, fk_priority_type, "timestamp");'
			), $dbIndex);
			printpre("Creating index 'log_entry_format_index'.");
		} catch (DatabaseException $e) {
			printpre("NOT creating index 'log_entry_format_index'.");
			printpre($e->getMessage());
		}
		
		try {
			$dbc->query(new GenericSQLQuery(
				'CREATE INDEX log_agent_fk_entry_index ON log_agent (fk_entry);'
			), $dbIndex);
			printpre("Creating index 'log_agent_fk_entry_index'.");
		} catch (DatabaseException $e) {
			printpre("NOT creating index 'log_agent_fk_entry_index'.");
			printpre($e->getMessage());
		}
		
		try {
			$dbc->query(new GenericSQLQuery(
				'CREATE INDEX log_node_fk_entry_index ON log_node (fk_entry);'
			), $dbIndex);
			printpre("Creating index 'log_node_fk_entry_index'.");
		} catch (DatabaseException $e) {
			printpre("NOT creating index 'log_node_fk_entry_index'.");
			printpre($e->getMessage());
		}
	}
	
	/**
	 * Add the creator column to the dr_asset_info table.
	 * 
	 * @param int $dbIndex
	 * @return void
	 * @access public
	 * @since 10/8/07
	 */
// 	public static function harmoni_0_11_0_update ($dbIndex) {
// 		$dbc = Services::getService("DBHandler");
// 		
// 		// Add the creator column to the dr_asset_info table
// 		$hasCreator = false;
// 		$result = $dbc->query(new GenericSQLQuery("DESCRIBE dr_asset_info"), $dbIndex);
// 		$result = $result->returnAsSelectQueryResult();
// 		while ($result->hasNext()) {
// 			if ($result->field("Field") == 'creator') {
// 				$hasCreator = true;
// 				break;
// 			}
// 			$result->advanceRow();
// 		}
// 		
// 		if (!$hasCreator) {
// 			// Alter the table
// 			printpre("Adding column creator to dr_asset_info");
// 			$dbc->query(new GenericSQLQuery("ALTER TABLE `dr_asset_info` ADD `creator` VARCHAR( 75 ) AFTER `create_timestamp` ;"), $dbIndex);
// 		}
// 	}
	
}

?>