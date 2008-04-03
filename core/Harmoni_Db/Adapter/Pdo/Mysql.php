<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Mysql.php,v 1.1.2.1 2008/04/03 21:54:40 adamfranco Exp $
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
 * @version $Id: Mysql.php,v 1.1.2.1 2008/04/03 21:54:40 adamfranco Exp $
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
	
}

?>