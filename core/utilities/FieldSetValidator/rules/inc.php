<?php

/**
 * include all the classes in the current dir
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: inc.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */
$_dh = opendir(dirname(__FILE__));
while ($_f = readdir($_dh)) {
	if (ereg(".class.php$", $_f)) require_once(dirname(__FILE__)."/$_f");
}
unset($_f,$_dh);

?>