<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @package harmoni.osid_v2.hierarchy.tree.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.4 2005/04/13 20:17:40 adamfranco Exp $
 */

	define("LOAD_HIERARCHY", false);

	if (!defined('HARMONI')) {
		require_once("../../../../../harmoni.inc.php");
	}

	if (!defined('SIMPLE_TEST')) {
		define('SIMPLE_TEST', HARMONI.'simple_test/');
	}

	require_once(SIMPLE_TEST . 'simple_unit.php');
	require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
	$test =& new GroupTest('Tree tests');
	$test->addTestFile(dirname(__FILE__).'/TreeTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/TreeNodeTestCase.class.php');
	$test->attachObserver(new DoboTestHtmlDisplay());
	$test->run();

	
?>