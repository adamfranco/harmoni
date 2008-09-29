<?php

//require_once(HARMONI.'utilities/StatisticsHandler.interface.php');
/**
 * An interface to calculate various statistical information.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StatisticsHandler.class.php,v 1.4 2007/09/04 20:25:54 adamfranco Exp $
 */
class StatisticsHandler {

	var $_data;
	var $_sortedData;

	var $_mean, $_median, $_discrimination, $_standardDeviation, $_max, $_min;

   /**
    * Create a Add a handler with given information.
    * @param object $data The object, which contains all the data. It should be provided with methods: next(), getNext() and getSize().
    * @return boolean Wheter all data is numeric.
    * @access public
    */	

	function StatisticsHandler($data) { 
		if(is_array($data)){
			$this->_data = $data;
		}
		else{
			$this->_data = array();
			
			while($data->hasNext())
				$this->_data[] = $data->next();
		}
		return $this->_checkdata();
	}

   /**
    * Return the mean value of the data.
    * @return float The mean value of the data.
    * @access public
    */
	function getMean() { 
		if(!isset($this->_mean)){
			$sum = 0;
			foreach($this->_data as $value)
				$sum += $value;

			$sum = round($sum/count($this->_data),3);
			
			$this->_mean = $sum;
		}

		return $this->_mean;
	}

   /**
    * Return the median value of the data.
    * @return float The median value of the data.
    * @access public
    */
	function getMedian() { 
		if(!isset($this->_median)){
			if(!isset($this->_sortedData)){
				$this->_sortedData = $this->_data;
				sort($this->_sortedData);
			}
			
			$this->_median = $this->_sortedData[count($this->_sortedData)/2];
		}

		return $this->_median;
	}


   /**
    * Return the standard deviation of the data.
    * @return float The standard deviation of  the data.
    * @access public
    */
	function getStandardDeviation() { 
		if(!isset($this->_standardDeviation)) {
			$mean = $this->getMean();
			
			$variance = 0;
	
			foreach($this->_data as $value)
				$variance += ($mean-$value)*($mean-$value);

			$this->_standardDeviation = round(sqrt($variance/count($this->_data)),3);
		}

		return $this->_standardDeviation;
	}

   /**
    * Return the modal (most frequent value) of the data.
    * @return float The modal (most frequent value) of the data.
    * @access public
    */
	function getModal() { 
		if (!isset($this->_modal)) {
			$cf=0; $mf=0; $current = '';
			foreach ($this->_data as $value) {
				if ($value == $current)
					$cf++;
				else {
					if ($cf>$mf){
						$mf = $cf;
						$mv = $current;
					}
					$current = $value;
					$cf = 1;
				}
			}
			if ($cf>$mf)
				$mv = $cv;
			
			$this->_modal = $mv;
		}
		
		return $this->_modal;
	}

   /**
    * Return the maximum value of the data.
    * @return float The maximum value of the data.
    * @access public
    */
	function getMax() { 
		if(!isset($this->_max)){
			if(!isset($this->_sortedData)){
				$this->_sortedData = $this->_data;
				sort($this->_sortedData);
			}
			$this->_max = $this->_sortedData[count($this->_sortedData)-1];
			$this->_min = $this->_sortedData[0];
		}

		return $this->_max;
	}

   /**
    * Return the minimum value of the data.
    * @return float The minimum value of the data.
    * @access public
    */
	function getMin() { 
		if(!isset($this->_min)){
			if(!isset($this->_sortedData)){
				$this->_sortedData = $this->_data;
				sort($this->_sortedData);
			}
			$this->_max = $this->_sortedData[count($this->_sortedData)-1];
			$this->_min = $this->_sortedData[0];
		}

		return $this->_min;
	}

   /**
    * Return the discrimination value of the data. Discrimination is the difference between 
    * the mean value of the top 27% and the mean value of the bottom 27% calculated separately. In the case of test results
    * the discrimination ranges from 0 to 100, so divide the result by 100 before printing.
    * @return float The discrimination value of the data.
    * @access public
    */
	function getDiscrimination() { 
		if(!isset($this->_discrimination)){
			if(!isset($this->_sortedData)){
				$this->_sortedData = $this->_data;
				sort($this->_sortedData);
			}

			$sum1 = 0;
			$sum2 = 0;

			$dataSize = count($this->_data);
			$size = round($dataSize*27.0/100);

			for($ii=0;$ii<$size;$ii++){
				$sum1 += $this->_sortedData[$ii];
				$sum2 += $this->_sortedData[$dataSize-$ii-1];
			}
			
			$sum1 /= $size;	
			$sum2 /= $size;	

			$this->_discrimination = round($sum2 - $sum1,3);
		}

		return $this->_discrimination;
	}

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
	function getSecondaryDiscrimination($secondData) { 
		if (is_array($secondData))
			$second = $secondData;
		else {
			$second = array();
			while($secondData->hasNext())
				$second[] = $secondData->next();
		}

		$first = $this->_data;

		array_multisort($first,$second);

		$sum1 = 0;
		$sum2 = 0;

		$dataSize = count($second);
		$size = round($dataSize*27.0/100);

		for($ii=0;$ii<$size;$ii++){
			$sum1 += $second[$ii];
			$sum2 += $second[$dataSize-$ii-1];
		}

		$sum1 /= $size;
		$sum2 /= $size;	

		return round($sum2 - $sum1,3);
	}

   /**
    * Check if all the data is numerically interpretable (only contains numbers and numeric strings)
    * @return boolean Whether all data is float interpretable.
    * @access private
    */
	function _checkdata() {
		foreach ($this->_data as $value)
			if(!is_numeric($value))	
				return false;
		return true;
	}
}



