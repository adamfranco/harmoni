<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableAssetIterator.class.php,v 1.1 2007/10/05 14:02:55 adamfranco Exp $
 */ 

/**
 * Iterate through a SelectQueryResult and return Assets
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableAssetIterator.class.php,v 1.1 2007/10/05 14:02:55 adamfranco Exp $
 */
class SimpleTableAssetIterator
	// implements AssetIterator
{
	/**
	 * @var object SimpleTableRepository $repository;  
	 * @access private
	 * @since 10/4/07
	 */
	private $repository;
	
	/**
	 * @var array $config;  
	 * @access private
	 * @since 10/4/07
	 */
	private $config;
	
	/**
	 * @var object SelectQueryResult $result;  
	 * @access private
	 * @since 10/4/07
	 */
	private $result;
		
	/**
	 * Constructor
	 * 
	 * @param object SimpleTableRepository $repository
	 * @param array $config
	 * @param SelectQueryResultInterface $result
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (SimpleTableRepository $repository, array $config, SelectQueryResultInterface $result) {
		$this->repository = $repository;
		$this->config = $config;
		$this->result = $result;
	}
	
	/**
	 * Destructor. Free our result.
	 * 
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __destruct () {
		if (isset($this->result))
			$this->result->free();
	}
	
	/**
	 * Answer true if there are more assets.
	 * 
	 * @return boolean
	 * @access public
	 * @since 10/4/07
	 */
	public function hasNext () {
		return $this->result->hasNext();
	}
	
	/**
	 * Answer the next Asset.
	 * 
	 * @return Asset $asset
	 * @access public
	 * @since 10/4/07
	 */
	public function next () {
		return new SimpleTableAsset($this->repository, $this->config, $this->result->next());
	}
	
	/**
	 * Skip the next element
	 * 
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function skipNext () {
		$this->result->advanceRow();
	}
	
	/**
	 * Answer the number of elements
	 * 
	 * @return integer
	 * @access public
	 * @since 10/4/07
	 */
	public function count () {
		return $this->result->getNumberOfRows();
	}
}

?>