<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */
 
require_once("QueryResult.interface.php");

/**
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 *
 * For example, you can get the primary key for the last UPDATEion, get number of UPDATEed rows, etc.
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */

interface UpdateQueryResultInterface 
	extends QueryResultInterface 
{

}

?>