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
 * @version $Id: test.php,v 1.7 2005/05/13 13:50:10 adamfranco Exp $
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
	$test->addTestFile(dirname(__FILE__).'/DateTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/DateAndTimeTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/DurationTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/MonthTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/TimeTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/TimeStampTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/TimespanTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/YearTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/WeekTestCase.class.php');
	
	$test->attachObserver(new DoboTestHtmlDisplay());
	$test->run();

	
?>