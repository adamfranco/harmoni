<?php

/**
 * include all the classes in the current dir
 *
 * @package harmoni.utilities
 * @version $Id: inc.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003 
 **/

$_dh = opendir(dirname(__FILE__));
while ($_f = readdir($_dh)) {
	if (ereg(".class.php$", $_f)) require_once(dirname(__FILE__)."/$_f");
}
unset($_f,$_dh);

?>