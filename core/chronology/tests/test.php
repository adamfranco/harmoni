<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @since 5/3/05
 *
 * @package harmoni.osid_v2.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.2 2005/05/05 23:10:46 adamfranco Exp $
 */

	if (!defined('HARMONI')) {
		define('HARMONI', "../../../core/");
	}

	if (!defined('SIMPLE_TEST')) {
		define('SIMPLE_TEST', HARMONI.'simple_test/');
	}

	require_once(SIMPLE_TEST . 'simple_unit.php');
	require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
	$test =& new GroupTest('Chronology Tests');
	$test->addTestFile(dirname(__FILE__).'/DurationTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/DateAndTimeTestCase.class.php');
	
	$test->attachObserver(new DoboTestHtmlDisplay());
	$test->run();

	
?>