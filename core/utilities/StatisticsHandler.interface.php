<?php

/**
 * An interface to calculate various statistical information.
 *
 * @version $Id: StatisticsHandler.interface.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @package harmoni.interfaces.utilities
 * @copyright 2003 
 */

class StatisticsHandlerInterface {

   /**
    * Create a Add a handler with given information.
    * @param object $data The object, which contains all the data. It should be provided with methods: next(), getNext() and getSize().
    * @return boolean Wheter all data is numeric.
    * @access public
    */	
	function statisticsHandler(& $data) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the mean value of the data.
    * @return float The mean value of the data.
    * @access public
    */
	function getMean() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the median value of the data.
    * @return float The median value of the data.
    * @access public
    */
	function getMedian() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the standard deviation of the data.
    * @return float The standard deviation of  the data.
    * @access public
    */
	function getStandardDeviation() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the modal (most frequent value) of the data.
    * @return float The modal (most frequent value) of the data.
    * @access public
    */
	function getModal() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the maximum value of the data.
    * @return float The maximum value of the data.
    * @access public
    */
	function getMax() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the minimum value of the data.
    * @return float The minimum value of the data.
    * @access public
    */
	function getMin() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the discrimination value of the data. Discrimination is the difference between 
    * the mean value of the top 27% and the mean value of the bottom 27% calculated separately. In the case of test results
    * the discrimination ranges from 0 to 100, so divide the result by 100 before printing.
    * @return float The discrimination value of the data.
    * @access public
    */
	function getDiscrimination() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Return the Discrimination of a different set in accordance to the base set.  
    * The function will take the results of the original, calculate who got the top 27% of them and see how these compare
    * to the results of the second data. The same will be done for the bottom 27%, after which the results will be substracted.
    * This should be used if the original data is the overall results of the test and the second set is the results of one particular question.
    * @param object $secondData The data to get the discrimination from. It should have the same number of elements as the original data and 
    * The values should be in the same order as the original.
    * Clearly $secondData should either be an array or also have next() and  hasNext().
    * @return float The discrimination of the second set in accordance with the first.
    * @access public
    */
	function getSecondaryDiscrimination(& $secondData) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

   /**
    * Check if all the data is numerically interpretable (only contains numbers and numeric strings)
    * @return boolean Whether all data is float interpretable.
    * @access private
    */
	function _checkdata() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}


?>
