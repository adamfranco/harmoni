<?php
/**
 * @since 2/22/06
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StatusStars.class.php,v 1.2 2006/06/16 13:44:00 adamfranco Exp $
 */ 

/**
 * This lovely little class will print a semi-accurate series of asterisks as a 
 * status bar for anything you want(written for the importer system).  The idea
 * is that you give it a total number of objects and a level of detail, then 
 * make sure that you update statistics when one of your total is done, and it 
 * will print directly to the end user the status of the process.  Don't forget 
 * to use a javascript re-direct at the end of your process, otherwise you'll 
 * have header problems.
 * 
 * @since 2/22/06
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StatusStars.class.php,v 1.2 2006/06/16 13:44:00 adamfranco Exp $
 */
class StatusStars {
		
/*********************************************************
 * STATISTICS HANDLING
 *********************************************************/

	var $_total;	// assets being an appropriate granule
		
	var $_completed;	// right now only using assets
	
	var $_currentPercent;	// the percentage of assets that are completed
	
	var $_ob_data = array();
	
	var $_detail;	// an integer number of stars for the 100% complete bar
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @since 2/22/06
	 */
	function StatusStars ($label = '') {
		// nothing to do here
		$this->_label = $label;
	}

	/**
	 * Gathers the total number of granules for importer status
	 * 
	 * @param int $total the total number of items being statused
	 * @param int $detail the number
	 * @access public
	 * @since 2/17/06
	 */
	function initializeStatistics ($total, $detail = 100) {
		$this->_totalAssets = $total;
		$this->_completedAssets = 0;
		$this->_currentPercent = 0;
		$this->_detail = $detail;
		$this->_createStatusBar();
	}

	/**
	 * Updates the number of granules imported for importer status
	 * 
	 * @access public
	 * @since 2/17/06
	 */
	function updateStatistics () {
		$this->_completedAssets++;
		
		$pct = floor(
			$this->_detail * $this->_completedAssets
			/ $this->_totalAssets);
		
		$stars = $pct - $this->_currentPercent;
		$this->_currentPercent = $pct;
		$end = false;
		if ($pct == $this->_detail)
			$end = true;
		if ($stars > 0)
			$this->_updateStatusBar($stars, $end);
	}
	
	/**
	 * Prints the status bar to the user
	 * 
	 * @access private
	 * @since 2/20/06
	 */
	function _createStatusBar () {
		$this->_jump_obs();
		
		if ($this->_label) {
			print "<pre>".$this->_label."</pre>\n";
		}
		print "<pre>";
		print "0";
		$this->_addSpaces();
		print "25";
		$this->_addSpaces(1);
		print "50";
		$this->_addSpaces(1);
		print "75";
		$this->_addSpaces(2);
		print "100%\n";
		print "|";
		$this->_addDashes();
		print "|";
		$this->_addDashes();
		print "|";
		$this->_addDashes();
		print "|";
		$this->_addDashes();
		print "|\n";
//		print "*";
		
		$this->_land_obs();
	}
	
	/**
	 * Prints the right number of Spaces
	 * 
	 * @param int $mod the number of spaces to be taken away due to numbers
	 * @access private
	 * @since 2/22/06
	 */
	function _addSpaces ($mod = 0) {
		for ($count = floor((($this->_detail - 4) / 4) - $mod); $count > 0; $count--) {
			print " ";
		}
	}

	/**
	 * Prints the right number of dashes
	 * 
	 * @access private
	 * @since 2/22/06
	 */
	function _addDashes () {
		for ($count = floor((($this->_detail - 4) / 4)); $count > 0; $count--) {
			print "-";
		}
	}
	
	/**
	 * Updates the statys bar for the user
	 * 
	 * @param int $stars the number of asterisks that need to be printed
	 * @param bool $end whether or not we're done and should continue
	 * @access private
	 * @since 2/20/06
	 */
	function _updateStatusBar ($stars, $end) {
		$this->_jump_obs();
		
		for (; $stars > 0; $stars--)
			print "*";
		flush();
		if ($end)
			print "</pre>";
		$this->_land_obs();
	}
	
	/**
	 * Climbs down the ob ladder and saves the data to put back later
	 * 
	 * @access private
	 * @since 2/20/06
	 */
	function _jump_obs () {
		$level = ob_get_level();
		while ($level > 0) {
			$this->_ob_data[$level] = ob_get_clean();
			$level = ob_get_level();
		}
	}

	/**
	 * Climps back up the ob ladder adding back the data that was there
	 * 
	 * @access private
	 * @since 2/20/06
	 */
	function _land_obs() {
		foreach ($this->_ob_data as $level => $data) {
			ob_start();
			print $data;
			unset($this->_ob_data[$level]);
		}
	}
}

?>