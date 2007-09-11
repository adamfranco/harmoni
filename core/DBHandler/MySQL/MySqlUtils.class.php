<?php
/**
 * @since 9/11/07
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySqlUtils.class.php,v 1.1 2007/09/11 17:34:38 adamfranco Exp $
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
 * @version $Id: MySqlUtils.class.php,v 1.1 2007/09/11 17:34:38 adamfranco Exp $
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
	
}

?>