<?php

require_once(HARMONI.'DBHandler/DBHandler.class.php');

/**
 * This is the common interface of all DBE (database engine) classes. A DBE
 * provides interface between an object's attribute values and their corresponding
 * physical location in a database. For example, suppose we have an Employee class
 * defined with its first name, last name, email, phone, etc. attributes. An
 * EmployeeDBE class would include the necessary methods to read/write those
 * attributes from/to a database.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBE.interface.php,v 1.3 2005/01/19 21:10:15 adamfranco Exp $
 */
class DBE {

// there is not really any common funcionallity to DBE classes, and for this
// reason the body of this interface is left empty.


}

?>