<?php

/**
 * An interface to calculate various statistical information.
 *
 * @version $Id: StatisticsHandler.class.php,v 1.1 2003/07/10 22:12:08 movsjani Exp $
 * @package harmoni.utilities
 * @copyright 2003 
 */

class StatisticsHandlerInterface {

	var $_data;
	var $_sortedData;

	var $_mean, $_median, $_discrimination, $_standardDeviation;

 	/**
	 * Create a Add a handler with given information.
	 * @param object $data The object, which contains all the data. It can either be an array or should be provided with methods: next() and getNext().
	 * @access public
	 */	
	function statisticsHandler(& $data) { 
		if(isarray($data))
			$this->_data = $data;
		
		else{
			$this->_data = array();
			
			while($data->hasNext())
				$this->_data[] = $data->next();
		}
	}

	/**
     * Return the mean value of the data.
	 * @return integer The mean value of the data.
	 * @access public
	 */
	function getMean() { 
		if(!isset($this->_mean)){
			$sum = 0;
			foreach($this->_data as $value)
				$sum += $value;

			$sum = round($sum*1.0/$this->_data->getSize(),3);
			
			$this->_mean = $sum;
		}

		return $this->_mean;
	}

	/**
     * Return the median value of the data.
	 * @return integer The median value of the data.
	 * @access public
	 */
	function getMedian() { 
		if(!isset($this->_median)){
			if(!isset($this->_sortedData))
				$this->_sortedData = sort($this->_data);
			
			$this->_median = $this->_sortedData[count->($this->_sortedData)/2];
		}

		return $this->_median;
	}



	/**
     * Return the standard deviation of the data.
	 * @return integer The standard deviation of  the data.
	 * @access public
	 */
	function getStandardDeviation() { 
		if(!isset($this->_standardDeviation)) {
			$mean = $this->getMean();
			
			$variance = 0;
	
			foreach($this->_data as $value)
				$variance += ($mean-$value)*($mean-$value);

			$this->_standardDeviation = round(sqrt($variance),3);
		}

		return $this->_standardDeviation;
	}

	/**
     * Return the modal (most frequent value) of the data.
	 * @return integer The modal (most frequent value) of the data.
	 * @access public
	 */
	function getModal() { 
		if (!isset($this->_modal)) {
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
     * Return the discrimination value of the data. Discrimination is the difference between 
     * the mean value of the top 27% and the mean value of the bottom 27% calculated separately. In the case of test results.
     * the discrimination ranges from 0.0 to 1.0
	 * @return integer The discrimination value of the data.
	 * @access public
	 */
	function getDiscrimination() { 
		if(!isset($this->_discrimination)){
			if(!isset($this->_sortedData))
				$this->_sortedData = sort($this->_data);
			
			$sum1 = 0;
			$sum2 = 0;

			$dataSize = count($this->_data);
			$size = round(dataSize*27.0/100);

			for($ii=0;$ii<=size;$ii+){
				$sum1 += $this->_sortedData[$ii];
				$sum2 += $this->_sortedData[$dataSize-$ii-1];
			}

			$sum1 /= $sum2 /= $size*1.0;
			
			$this->_discrimination = round($sum2 - $sum1,3);
		}

		return $this->_discrimination;
	}

    /**
     * Return the Discrimination of a different set in accordance to the base set.  
     * The function will take the results of the original, calculate the top 27% of them and see how these compare
     * to the results of the second data. The same will be done for the bottom 27%, after which the results will be substracted.
     * This should be used if the original data is the overall results of the test and the second set is the results of one particular question.
     * @param object $secondData The data to get the discrimination from. The values should be in the same order as the original data. 
	 * Clearly $secondData should either be an array or also have next() and  hasNext().
	 * @return integer The discrimination of the second set in accordance with the first.
	 * @access public
	 */
	function getSecondaryDiscrimination(& $secondData) { 
		if (isarray($secondData))
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
		$size = round(dataSize*27.0/100);

		for($ii=0;$ii<=size;$ii+){
			$sum1 += $second[$ii];
			$sum2 += $second[$dataSize-$ii-1];
		}

		$sum1 /= $sum2 /= $size;	
			
		return round($sum2 - $sum1,3);
	}

	
}



?>
