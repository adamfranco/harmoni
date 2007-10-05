<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.federating_repository_manager
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FederatingRepositoryManager.class.php,v 1.1 2007/10/05 14:02:54 adamfranco Exp $
 */ 

/**
 * The Federating repository manager allows for the federating of several repository managers.
 * Each manager can is added already-configured to the Federating Manager.
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.federating_repository_manager
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FederatingRepositoryManager.class.php,v 1.1 2007/10/05 14:02:54 adamfranco Exp $
 */
class FederatingRepositoryManager
	// implements RepositoryManager
{
	
	/**
	 * @var object OsidContext $context;  
	 * @access private
	 * @since 10/4/07
	 */
	private $context;
	
	/**
	 * @var array $managers;  
	 * @access private
	 * @since 10/4/07
	 */
	private $managers = array();
	
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
		
		foreach ($this->managers as $manager)
			$manager->assignOsidContext($this->context);
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
	function assignConfiguration ( $configuration ) {} 
	
	/**
	 * Add a new Repository Manager
	 * 
	 * @param RepositoryManager $manager
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function addManager (RepositoryManager $manager) {
		if (isset($this->context))
			$manager->assignOsidContext($this->context);
		$this->managers[] = $manager;
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->createRepository($displayName, $description, $repositoryType);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('OPERATION_FAILED');
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->deleteRepository($repositoryId);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('OPERATION_FAILED');
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
		$repositories = new MultiIteratorIterator();
		foreach ($this->managers as $manager) {
			try {
				$repositories->addIterator($manager->getRepositories());
			} catch (Exception $e) {}
		}
		
		return $repositories;
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
		$repositories = new MultiIteratorIterator();
		foreach ($this->managers as $manager) {
			try {
				$repositories->addIterator($manager->getRepositoriesByType($repositoryType));
			} catch (Exception $e) {}
		}
		
		return $repositories;
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->getRepository($repositoryId);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('UNKNOWN_ID');
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->getAsset($assetId);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('UNKNOWN_ID');
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->getAssetByDate($assetId, $date);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('OPERATION_FAILED');
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
		foreach ($this->managers as $manager) {
			try {
				return $manager->getAssetDates($assetId);
			} catch (Exception $e) {}
		}		
				
		throw new Exception('OPERATION_FAILED');
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
		$assets = new MultiIteratorIterator();
		foreach ($this->managers as $manager) {
			try {
				$assets->addIterator($manager->getAssetsBySearch($repositories, $searchCriteria, $searchType, $searchProperties));
			} catch (Exception $e) {}
		}
		
		return $assets;
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
		throw new Exception('UNIMPLEMENTED');
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
		$types = new MultiIteratorIterator();
		foreach ($this->managers as $manager) {
			try {
				$types->addIterator($manager->getRepositoryTypes());
			} catch (Exception $e) {}
		}
		
		return $types;
	} 

	
}

?>