<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Sqlite.php,v 1.3 2008/04/21 17:50:29 adamfranco Exp $
 */ 

require_once 'Zend/Db/Adapter/Pdo/Ibm.php';

/**
 * Class for connecting to SQLite2 and SQLite3 databases and performing common operations.
 * All of the Harmoni_Db_Adapter_Pdo_xxxx classes should be identical except for 
 * the class names.
 * 
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Sqlite.php,v 1.3 2008/04/21 17:50:29 adamfranco Exp $
 */
class Harmoni_Db_Adapter_Pdo_Sqlite
	extends Zend_Db_Adapter_Pdo_Sqlite
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
    
    /**
     * @var int $numPrepared; A counter for the number of statements prepared 
     * @access private
     * @since 4/4/08
     */
    private $numPrepared;
    
    /**
     * Prepares an SQL statement.
     *
     * @param string $sql The SQL statement with placeholders.
     * @param array $bind An array of data to bind to the placeholders.
     * @return PDOStatement
     */
    public function prepare($sql) {
		$this->_connect();
        $stmt = new Harmoni_Db_Statement_Pdo($this, $sql);
        $stmt->setFetchMode($this->_fetchMode);
        
        $this->numPrepared++;
        if (isset($this->recordQueryCallers) && $this->recordQueryCallers) {
			if (!isset($this->queryCallers))
				$this->queryCallers = array();
			$backtrace = debug_backtrace();
			if (isset($backtrace[2]['class']))
				$caller = $backtrace[2]['class'].$backtrace[2]['type'].$backtrace[2]['function']."()";
			else
				$caller = $backtrace[2]['function']."()";
			$this->queryCallers[$caller] = 0;
			$stmt->caller = $caller;
		}
        
        return $stmt;
    }
    
    /**
     * @var int $numExecuted; A counter for the number of statements executed 
     * @access private
     * @since 4/4/08
     */
    private $numExecuted;
    
    /**
     * Increment the execution counter. This should only be called by statements.
     * 
     * @return void
     * @access public
     * @since 4/4/08
     */
    public function incrementExecCounter ($caller = null) {
    	if (!is_null($caller) && isset($this->recordQueryCallers) && $this->recordQueryCallers) {
    		$this->queryCallers[$caller]++;
    	}
    		
    	$this->numExecuted++;
    }

	/**
	 * Answer a statistics string.
	 *
	 * @return string
	 * @access public
	 * @since 4/4/08
	 */
	public function getStats () {
		ob_start();
		print "Statements Prepared: ".$this->numPrepared;
		print " <br/>\nStatement Executions: ".$this->numExecuted;
		if (isset($this->recordQueryCallers) && $this->recordQueryCallers && is_array($this->queryCallers)) {
			$callers = array_keys($this->queryCallers);
			$numbers = array_values($this->queryCallers);
			array_multisort($numbers, SORT_DESC, $callers);
			print "\n<pre>Statement Executions by Preparer:\n";
			for ($i = 0; $i < count ($callers); $i++) {
				print "\n".$numbers[$i]."\t".$callers[$i];
			}
			print "</pre>";
		}
		return ob_get_clean();
	}
	
	/**
	 * Answer the number of statements prepared
	 * 
	 * @return int
	 * @access public
	 * @since 4/7/08
	 */
	public function getNumPrepared () {
		return $this->numPrepared;
	}
	
	/**
	 * Answer the number of statements executed
	 * 
	 * @return int
	 * @access public
	 * @since 4/7/08
	 */
	public function getNumExecuted () {
		return $this->numExecuted;
	}
}

?>