<?php

require_once(HARMONI.'DBHandler/DBHandler.class.php');

/**
 * This is the common interface of all DBE (database engine) classes. A DBE
 * provides interface between an object's attribute values and their corresponding
 * physical location in a database. For example, suppose we have an Employee class
 * defined with its first name, last name, email, phone, etc. attributes. An
 * EmployeeDBE class would include the necessary methods to read/write those
 * attributes from/to a database.
 * @version $Id: DBE.interface.php,v 1.2 2004/04/01 22:44:14 dobomode Exp $
 * @package harmoni.utilities
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class DBE {

// there is not really any common funcionallity to DBE classes, and for this
// reason the body of this interface is left empty.


}

?>