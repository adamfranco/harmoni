<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRepositoryManager.class.php,v 1.2 2007/10/10 22:58:37 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/SimpleTableIdManager.class.php");
require_once(dirname(__FILE__)."/SimpleTableRepository.class.php");


/**
 * The SimpleTable Repository implementation provides a Repository provider that
 * reads from a single MySQL table.
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRepositoryManager.class.php,v 1.2 2007/10/10 22:58:37 adamfranco Exp $
 */
class SimpleTableRepositoryManager
	extends RepositoryManager
// 	implements RepositoryManager
{
	/**
	 * @var OsidContext $context;  
	 * @access private
	 * @since 10/4/07
	 */
	private $context;
	
	/**
	 * @var array $config;  
	 * @access private
	 * @since 10/4/07
	 */
	private $config = array();
	
	/**
	 * Constructor
	 * 
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct () {
		$this->idMgr = new SimpleTableIdManager();
		
		try {
			$this->dbc = Services::getService("DBHandler");
		} catch (Exception $e) {
			$context = new OsidContext;
			$configuration = new ConfigurationProperties;
			Services::startManagerAsService("DatabaseManager", $context, $configuration);
			
			$this->dbc = Services::getService("DBHandler");
		}
	}

	/**
	 * Return context of this OsidManager.
	 *  
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function getOsidContext () { 
		return $this->context;
	} 
	
	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *         messages defined in org.osid.OsidException:  {@link
	 *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( $context ) { 
		$this->context = $context;
	} 
	
	/**
	 * Assign the configuration of this OsidManager.
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *         messages defined in org.osid.OsidException:  {@link
	 *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *         {@link org.osid.OsidException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.OsidException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( $configuration ) {
		if (isset($this->repository))
			throw new ConfigurationErrorException('configuration already assigned.');
		
		try {
			switch($configuration->getProperty('db_type')) {
				case MYSQL:
					$this->config['db_type'] = MYSQL;
					break;
				case POSTGRESQL:
					$this->config['db_type'] = POSTGRESQL;
					break;
				default:
					throw new ConfigurationErrorException("Invalid db_type, '".$configuration->getProperty('db_type')."'.");
			}
			
			if (!preg_match('/^[a-z.]+$/i', $configuration->getProperty('host')))
				throw new ConfigurationErrorException("CONFIGURATION_ERROR: Invalid host, '$host'.");
			$this->config['host'] = $configuration->getProperty('host');
			
			if (!preg_match('/^[a-z_-]+$/i', $configuration->getProperty('db')))
				throw new ConfigurationErrorException("Invalid db, '$db'.");
			$this->config['db'] = $configuration->getProperty('db');
			
			if (!preg_match('/^[a-z_-]+$/i', $configuration->getProperty('table')))
				throw new ConfigurationErrorException("Invalid table, '$table'.");
			$this->config['table'] = $configuration->getProperty('table');
			
			if (!preg_match('/^[a-z_-]+$/i', $configuration->getProperty('user')))
				throw new ConfigurationErrorException("Invalid user, '$user'.");
			$this->config['user'] = $configuration->getProperty('user');
			
// 			if (!preg_match('/^[a-z_-]+$/i', $configuration->getProperty('password')))
// 				throw new ConfigurationErrorException('CONFIGURATION_ERROR');
			$this->config['password'] = $configuration->getProperty('password');
			
			if (!preg_match('/^[a-z_-]+$/i', $configuration->getProperty('id_column')))
				throw new ConfigurationErrorException("Invalid id_column, '$id_column'.");
			$this->config['id_column'] = $configuration->getProperty('id_column');
			
			if (!preg_match('/^[a-z_-]*$/i', $configuration->getProperty('order_column')))
				throw new ConfigurationErrorException("'$order_column'.");
			if ($configuration->getProperty('order_column'))
				$this->config['order_column'] = $configuration->getProperty('order_column');
			else
				$this->config['order_column'] = NULL;
			
			switch($configuration->getProperty('order_direction')) {
				case DESCENDING:
					$this->config['order_direction'] = DESCENDING;
					break;
				default:
					$this->config['order_direction'] = ASCENDING;
			}
			
			if (!is_array($configuration->getProperty('columns')))
				throw new ConfigurationErrorException('"columns" must be an array');
			
			if (!count($configuration->getProperty('columns')))
				throw new ConfigurationErrorException('"columns" must not be empty.');
			
			$columns = $configuration->getProperty('columns');
			array_walk($columns, array($this, 'checkColumns'));
			$this->config['columns'] = $configuration->getProperty('columns');
			
			if (!is_array($configuration->getProperty('dc_mapping')))
				throw new ConfigurationErrorException('"dc_mapping" must be an array');
			
			if (!count($configuration->getProperty('dc_mapping')))
				throw new ConfigurationErrorException('"dc_mapping" must not be empty.');
			
			$this->config['dc_mapping'] = array();
			foreach ($configuration->getProperty('dc_mapping') as $dcField => $string) {
				if (!preg_match('/^[a-z\.]+$/i', $dcField))
					throw new ConfigurationErrorException("Invalid dcField, '$dcField'.");
				
				$this->config['dc_mapping'][$dcField] = $this->decodeMapping($string);
			}
		} catch (Exception $e) {
			// Unset our configuration
			$this->config = array();
			
			throw $e;
		}
		
		$this->repositoryId = $this->idMgr->getId(
			$this->config['host'].".".$this->config['db'].".".$this->config['table']);
			
		$this->repository = new SimpleTableRepository($this->repositoryId, $this->config, $this->dbc, $this->idMgr);
		
// 		printpre($this->config);
	} 
	
	/**
	 * Check columns for validity
	 * 
	 * @param string $column
	 * @return void
	 * @access private
	 * @since 10/4/07
	 */
	private function checkColumns ($column) {
		if (!preg_match('/^[a-z_-]+$/i', $column))
			throw new ConfigurationErrorException("Invalid column, '$column'.");
	}
	
	/**
	 * Decode the Dublin Core mapping array
	 * 
	 * @param string $mappingString
	 * @return void
	 * @access private
	 * @since 10/4/07
	 */
	private function decodeMapping ($mappingString) {
		$parts = array();
		$current = '';
		$inString = false;
		$quoteType = "'";
		for ($i = 0; $i < strlen($mappingString); $i++) {
			$char = $mappingString[$i];
			
			if ($char == '+' && !$inString) {
				if (strlen(trim($current)))
					$parts[] = trim($current);
				$current = '';
			} else {
				$current .= $char;
				
				if (!$inString && ($char == "'" || $char == '"')) {
					$inString = true;
					$quoteType = $char;
				} else if ($inString && $char == $quoteType) {
					$inString = false;
				}
			}
		}
		
		if (strlen(trim($current)))
			$parts[] = trim($current);
		
		foreach ($parts as $part) {
			if (!preg_match('/^([a-z0-9_-]+|\'.+\'|".+")$/i', $part)) 
				throw new ConfigurationErrorException("Invalid mapping component, '$part'.");
		}
		
		return $parts;
	}

	/**
	 * Create a new Repository of the specified Type.  The implementation of
	 * this method sets the Id for the new object.
	 * 
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $repositoryType
	 *  
	 * @return object Repository
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *         UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function createRepository ( $displayName, $description, $repositoryType ) { 
		throw new UnimplementedException();
	}
	
	/**
	 * Delete a Repository.
	 * 
	 * @param object Id $repositoryId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteRepository ( $repositoryId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Repositories.  Iterators return a set, one at a time.
	 *  
	 * @return object RepositoryIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getRepositories () { 
		$repositories = array();
		$repositories[] = $this->repository;
		return new HarmoniIterator($repositories);
	} 
	
	/**
	 * Get all the Repositories of the specified Type.  Iterators return a set,
	 * one at a time.
	 * 
	 * @param object Type $repositoryType
	 *  
	 * @return object RepositoryIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *         UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getRepositoriesByType ( $repositoryType ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the Repository with the specified unique Id.
	 * 
	 * @param object Id $repositoryId
	 *  
	 * @return object Repository
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getRepository ( $repositoryId ) {
		if (!isset($this->repository))
			throw new ConfigurationErrorException("No configuration.");
			
		if (!$repositoryId->isEqual($this->repositoryId))
			throw new UnknownIdException("Unkown repositoryId, '$repositoryId'.");
		
		return $this->repository;
	} 
	
	/**
	 * Get the Asset with the specified unique Id.
	 * 
	 * @param object Id $assetId
	 *  
	 * @return object Asset
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function getAsset ( $assetId ) { 
		return $this->repository->getAsset($assetId);
	} 
	
	/**
	 * Get the Asset with the specified unique Id that is appropriate for the
	 * date specified.  The specified date allows a Repository implementation
	 * to support Asset versioning.
	 * 
	 * @param object Id $assetId
	 * @param int $date
	 *  
	 * @return object Asset
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#NO_OBJECT_WITH_THIS_DATE
	 *         NO_OBJECT_WITH_THIS_DATE}
	 * 
	 * @access public
	 */
	function getAssetByDate ( $assetId, $date ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the dates for the Asset with the specified unique Id.  These
	 * dates allows a Repository implementation to support Asset versioning.
	 * 
	 * @param object Id $assetId
	 *  
	 * @return object LongValueIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function getAssetDates ( $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Perform a search of the specified Type and get all the Assets that
	 * satisfy the SearchCriteria.  The search is performed for all specified
	 * Repositories.  Iterators return a set, one at a time.
	 * 
	 * @param object Repository[] $repositories
	 * @param object mixed $searchCriteria (original type: java.io.Serializable)
	 * @param object Type $searchType
	 * @param object Properties $searchProperties
	 *  
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *         UNKNOWN_TYPE}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_REPOSITORY
	 *         UNKNOWN_REPOSITORY}
	 * 
	 * @access public
	 */
	function getAssetsBySearch ( $repositories, $searchCriteria, $searchType, $searchProperties ) { 
		return $this->repository->getAssetsBySearch($searchCriteria, $searchType, $searchProperties);
	} 
	
	/**
	 * Create in a Repository a copy of an Asset.  The Id, AssetType, and
	 * Repository for the new Asset is set by the implementation.  All Records
	 * are similarly copied.
	 * 
	 * @param object Repository $repository
	 * @param object Id $assetId
	 *  
	 * @return object Id
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}, {@link
	 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *         NULL_ARGUMENT}, {@link
	 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function copyAsset ( $repository, $assetId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the RepositoryTypes in this RepositoryManager. RepositoryTypes
	 * are used to categorize Repositories.  Iterators return a set, one at a
	 * time.
	 *  
	 * @return object TypeIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *         the following messages defined in
	 *         org.osid.repository.RepositoryException may be thrown: {@link
	 *         org.osid.repository.RepositoryException#OPERATION_FAILED
	 *         OPERATION_FAILED}, {@link
	 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *         PERMISSION_DENIED}, {@link
	 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *         CONFIGURATION_ERROR}, {@link
	 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getRepositoryTypes () { 
		throw new UnimplementedException();
	} 
	
}

?>