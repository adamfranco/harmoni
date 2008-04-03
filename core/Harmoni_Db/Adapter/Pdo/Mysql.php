<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Mysql.php,v 1.1.2.3 2008/04/03 23:54:50 adamfranco Exp $
 */ 

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

/**
 * Class for connecting to MySQL databases and performing common operations.
 * 
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Mysql.php,v 1.1.2.3 2008/04/03 23:54:50 adamfranco Exp $
 */
class Harmoni_Db_Adapter_Pdo_Mysql
	extends Zend_Db_Adapter_Pdo_Mysql
{
	
	/**
	 * Creates and returns a new Zend_Db_Select object for this adapter.
	 * 
	 * @return Harmoni_Db_Select
	 * @access public
	 * @since 4/3/08
	 */
    public function select() {
        return new Harmoni_Db_Select($this);
    }
    
    /**
     * Updates table rows with specified data based on a WHERE clause.
     *
     * @param  mixed        $table The table to update.
     * @param  array        $bind  Column-value pairs.
     * @param  mixed        $where UPDATE WHERE clause(s).
     * @return int          The number of affected rows.
     */
    public function update($table = null, array $bind = null, $where = '') {
    	if (is_null($table) && is_null($bind) && !strlen($where))
    		return new Harmoni_Db_Update($this);
    	else
    		return parent::update($table, $bind, $where);
    }
    
    /**
     * Deletes table rows based on a WHERE clause.
     *
     * @param  mixed        $table The table to update.
     * @param  array        $bind  Column-value pairs.
     * @param  mixed        $where UPDATE WHERE clause(s).
     * @return int          The number of affected rows.
     */
	public function delete($table = null, $where = '') {
    	if (is_null($table) && !strlen($where))
    		return new Harmoni_Db_Delete($this);
    	else
    		return parent::delete($table, $where);
    }
    
    /**
     * Inserts a table row with specified data.
     *
     * @param mixed $table The table to insert data into.
     * @param array $bind Column-value pairs.
     * @return int The number of affected rows.
     */
    public function insert($table = null, array $bind = null) {
    	if (is_null($table) && is_null($bind))
    		return new Harmoni_Db_Insert($this);
    	else
    		return parent::insert($table, $bind);
    }
	
}

?>