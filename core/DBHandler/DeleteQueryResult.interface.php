<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DeleteQueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */
require_once("QueryResult.interface.php");

/**
 * The DELETEQueryResult interface provides the functionality common to all DELETE query results.
 *
 * For example, you can get the primary key for the last DELETEion, get number of DELETEed rows, etc.
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DeleteQueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */

interface DeleteQueryResultInterface 
	extends QueryResultInterface 
{


}

?>